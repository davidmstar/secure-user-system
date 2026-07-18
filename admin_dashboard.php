<?php
require_once __DIR__ . '/includes/auth_check.php';

if (!is_admin()) {
    set_flash('error', 'Admin access is required.');
    redirect('dashboard.php');
}

include __DIR__ . '/includes/header.php';

$pdo = get_db();
$totalUsers = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalMessages = $pdo->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
$latestUsers = $pdo->query('SELECT username, email, created_at FROM users ORDER BY created_at DESC LIMIT 5')->fetchAll();
?>
<div class="hero-section p-5 rounded-4 shadow-sm mb-4">
    <h1 class="display-6 fw-bold">Administrator Dashboard</h1>
    <p class="lead text-muted">Review system activity and manage the secure user platform.</p>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold">Platform Statistics</h5>
                <p class="mb-1"><strong>Total Users:</strong> <?= e($totalUsers) ?></p>
                <p class="mb-0"><strong>Total Messages:</strong> <?= e($totalMessages) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold">Recently Registered Users</h5>
                <ul class="mb-0">
                    <?php foreach ($latestUsers as $user): ?>
                        <li><?= e($user['username']) ?> — <?= e($user['email']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
