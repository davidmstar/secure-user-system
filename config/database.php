<?php
session_start();

const DB_HOST = '127.0.0.1';
const DB_NAME = 'secure_system';
const DB_USER = 'root';
const DB_PASS = '';

$pdo = null;

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    $_SESSION['error'] = 'Database connection failed. Please ensure MySQL is running and the database exists.';
    error_log('Database connection failed: ' . $e->getMessage());
}

function get_db(): PDO
{
    global $pdo;

    if (!($pdo instanceof PDO)) {
        throw new RuntimeException('Database connection unavailable. Please start MySQL and import the secure_system schema.');
    }

    return $pdo;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        throw new RuntimeException('Invalid CSRF token.');
    }
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function is_admin(): bool
{
    return ($_SESSION['role'] ?? '') === 'admin';
}

function require_login(): void
{
    if (!is_logged_in()) {
        $_SESSION['error'] = 'Please log in to access this page.';
        header('Location: login.php');
        exit;
    }

    $timeout = 1800;
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        session_unset();
        session_destroy();
        header('Location: login.php?expired=1');
        exit;
    }

    $_SESSION['last_activity'] = time();
}

function set_flash(string $type, string $message): void
{
    $_SESSION[$type] = $message;
}

function flash_messages(): void
{
    foreach (['success', 'error', 'warning', 'info'] as $type) {
        if (!empty($_SESSION[$type])) {
            $alertClass = $type === 'error' ? 'danger' : $type;
            echo '<div class="alert alert-' . $alertClass . ' alert-dismissible fade show" role="alert">' . e($_SESSION[$type]) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION[$type]);
        }
    }
}

function format_date(string $date): string
{
    $timestamp = strtotime($date);
    return $timestamp ? date('M d, Y H:i', $timestamp) : 'N/A';
}

function redirect(string $location): void
{
    header('Location: ' . $location);
    exit;
}
