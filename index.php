<?php
require_once __DIR__ . '/config/database.php';
include __DIR__ . '/includes/header.php';
?>
<div class="hero-section p-5 rounded-4 shadow-sm mb-4 text-center">
    <h1 class="display-5 fw-bold">Secure User Management and Contact System</h1>
    <p class="lead">Welcome to your secure portal.</p>
    <div class="d-flex gap-3 flex-wrap justify-content-center">
        <a href="register.php" class="btn btn-primary btn-lg">Register</a>
        <a href="login.php" class="btn btn-outline-primary btn-lg">Login</a>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
