<?php
require_once __DIR__ . '/includes/auth_check.php';

include __DIR__ . '/includes/header.php';

$pdo = get_db();
$stmt = $pdo->prepare('SELECT id, username, fullname, email, role, created_at FROM users WHERE id = :id');
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    set_flash('error', 'User profile not found.');
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf();
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($fullname === '' || $email === '') {
            set_flash('error', 'Full name and email are required.');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            set_flash('error', 'Please enter a valid email address.');
        } else {
            $stmt = $pdo->prepare('UPDATE users SET fullname = :fullname, email = :email WHERE id = :id');
            $stmt->execute([':fullname' => $fullname, ':email' => $email, ':id' => $_SESSION['user_id']]);
            $_SESSION['fullname'] = $fullname;
            set_flash('success', 'Profile updated successfully.');
            redirect('profile.php');
        }
    } catch (PDOException $e) {
        set_flash('error', 'Unable to update profile.');
        error_log($e->getMessage());
    }
}
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">Your Profile</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="border rounded-4 p-4">
                            <h5 class="fw-bold">Account Details</h5>
                            <p class="mb-2"><strong>Username:</strong> <?= e($user['username']) ?></p>
                            <p class="mb-2"><strong>Full Name:</strong> <?= e($user['fullname']) ?></p>
                            <p class="mb-2"><strong>Email:</strong> <?= e($user['email']) ?></p>
                            <p class="mb-2"><strong>Role:</strong> <?= e($user['role']) ?></p>
                            <p class="mb-0"><strong>Joined:</strong> <?= e(format_date($user['created_at'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form method="post">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input class="form-control" value="<?= e($user['username']) ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" value="<?= e($user['fullname']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= e($user['email']) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
