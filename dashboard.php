<?php
require_once __DIR__ . '/includes/auth_check.php';

include __DIR__ . '/includes/header.php';

$pdo = get_db();

$totalUsers = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalMessages = $pdo->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
$userMessages = $pdo->query('SELECT COUNT(*) FROM contact_messages WHERE user_id = ' . (int) $_SESSION['user_id'])->fetchColumn();
$recentMessages = $pdo->query('SELECT cm.*, u.username FROM contact_messages cm LEFT JOIN users u ON u.id = cm.user_id ORDER BY cm.created_at DESC LIMIT 5')->fetchAll();
?>
<div class="hero-section p-5 rounded-4 shadow-sm mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">Welcome back, <?= e($_SESSION['fullname']) ?>!</h1>
            <p class="lead text-muted">Manage users, review contact submissions, and keep your account secure.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="contact.php" class="btn btn-primary btn-lg">Create New Message</a>
        </div>
    </div>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Users</h6>
                        <h3 class="fw-bold mb-0"><?= e($totalUsers) ?></h3>
                    </div>
                    <div class="stat-icon">👤</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Contact Messages</h6>
                        <h3 class="fw-bold mb-0"><?= e($totalMessages) ?></h3>
                    </div>
                    <div class="stat-icon">📬</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Your Messages</h6>
                        <h3 class="fw-bold mb-0"><?= e($userMessages) ?></h3>
                    </div>
                    <div class="stat-icon">✉️</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Recent Messages</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentMessages as $message): ?>
                                <tr>
                                    <td><?= e($message['name']) ?> <small class="text-muted">(<?= e($message['username'] ?? 'Guest') ?>)</small></td>
                                    <td><?= e($message['subject']) ?></td>
                                    <td><?= e(format_date($message['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <div class="d-grid gap-2">
                    <a href="profile.php" class="btn btn-outline-primary">Edit Profile</a>
                    <a href="contact.php" class="btn btn-outline-primary">Send Message</a>
                    <a href="submissions.php" class="btn btn-outline-primary">View Submissions</a>
                    <a href="info.php" class="btn btn-outline-primary">Security Info Hub</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
