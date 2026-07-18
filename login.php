<?php
require_once __DIR__ . '/config/database.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = get_db();
        verify_csrf();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $errors[] = 'Email and password are required.';
        }

        if (empty($errors)) {
            $stmt = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['last_activity'] = time();
                set_flash('success', 'Welcome back!');
                redirect('dashboard.php');
            } else {
                $errors[] = 'Invalid email or password.';
            }
        }
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    } catch (PDOException $e) {
        $errors[] = 'Unable to log in right now.';
        error_log($e->getMessage());
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-2">Welcome back</h2>
                <p class="text-muted mb-4">Sign in to your account.</p>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger"><?= e($errors[0]) ?></div>
                <?php endif; ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="register.php">Create account</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
