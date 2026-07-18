<?php
require_once __DIR__ . '/config/database.php';
include __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">🔐</div>
                <h4 class="fw-bold">Sessions</h4>
                <p class="text-muted">Sessions keep authenticated users active across requests and are regenerated after login to reduce fixation risk.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">🍪</div>
                <h4 class="fw-bold">Cookies</h4>
                <p class="text-muted">Cookies can store simple state, but sensitive data should never be trusted without validation and proper security flags.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">🛡️</div>
                <h4 class="fw-bold">Password Hashing</h4>
                <p class="text-muted">Passwords are hashed using password_hash() and verified using password_verify() to protect stored credentials.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">🧱</div>
                <h4 class="fw-bold">SQL Injection</h4>
                <p class="text-muted">All database access uses PDO prepared statements to prevent injection attacks and ensure safe queries.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">🧼</div>
                <h4 class="fw-bold">XSS Prevention</h4>
                <p class="text-muted">Output is escaped using htmlspecialchars() to prevent malicious script injection in the browser.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <div class="display-6 mb-3">⚠️</div>
                <h4 class="fw-bold">CSRF</h4>
                <p class="text-muted">Cross-site request forgery is mitigated with CSRF tokens on state-changing forms.</p>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
