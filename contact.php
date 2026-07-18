<?php
require_once __DIR__ . '/includes/auth_check.php';

include __DIR__ . '/includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name === '' || $email === '' || $subject === '' || $message === '') {
            $errors[] = 'All fields are required.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email.';
        }

        if (empty($errors)) {
            $stmt = get_db()->prepare('INSERT INTO contact_messages (user_id, name, email, subject, message, created_at) VALUES (:user_id, :name, :email, :subject, :message, NOW())');
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message,
            ]);
            set_flash('success', 'Your message was submitted successfully.');
            redirect('contact.php');
        }
    } catch (PDOException $e) {
        $errors[] = 'Unable to submit your message.';
        error_log($e->getMessage());
    }
}
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-2">Contact Us</h2>
                <p class="text-muted mb-4">Share your feedback, questions, or concerns securely.</p>
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required value="<?= e($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required value="<?= e($_POST['subject'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control" required><?= e($_POST['message'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Submit Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
