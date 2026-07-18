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

        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($username === '' || $fullname === '' || $email === '' || $password === '' || $confirmPassword === '') {
            $errors[] = 'All fields are required.';
        }

        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errors[] = 'Username must be 3-20 characters and contain only letters, numbers, and underscores.';
        }

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (empty($errors)) {
            $stmt = $db->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
            $stmt->execute([':username' => $username, ':email' => $email]);
            if ($stmt->fetch()) {
                $errors[] = 'Username or email already exists.';
            }
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO users (username, fullname, email, password, role, created_at) VALUES (:username, :fullname, :email, :password, :role, NOW())');
            $stmt->execute([
                ':username' => $username,
                ':fullname' => $fullname,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => 'user',
            ]);

            set_flash('success', 'Registration successful. Please log in.');
            redirect('login.php');
        }
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    } catch (PDOException $e) {
        $errors[] = 'Unable to complete registration right now.';
        error_log($e->getMessage());
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-2">Create an account</h2>
                <p class="text-muted mb-4">Join the Secure User Management and Contact System.</p>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= e($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required value="<?= e($_POST['username'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" required value="<?= e($_POST['fullname'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <div class="form-text" id="passwordStrength">Minimum 8 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
