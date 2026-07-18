<?php
$activePage = basename($_SERVER['PHP_SELF']);
$userName = $_SESSION['fullname'] ?? 'Guest';
?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">SecureUserSystem</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?= $activePage === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'profile.php' ? 'active' : '' ?>" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'submissions.php' ? 'active' : '' ?>" href="submissions.php">Submissions</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'info.php' ? 'active' : '' ?>" href="info.php">Info Hub</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'register.php' ? 'active' : '' ?>" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'login.php' ? 'active' : '' ?>" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link <?= $activePage === 'info.php' ? 'active' : '' ?>" href="info.php">Info Hub</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (is_logged_in()): ?>
                    <li class="nav-item me-2">
                        <span class="navbar-text text-light">Welcome, <?= e($userName) ?>!</span>
                    </li>
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-light btn-sm" href="login.php">Get Started</a></li>
                <?php endif; ?>
                <li class="nav-item ms-2">
                    <button class="btn btn-outline-light btn-sm" id="themeToggle" type="button">🌙</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
