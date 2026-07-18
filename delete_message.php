<?php
require_once __DIR__ . '/includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf();
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = get_db()->prepare('DELETE FROM contact_messages WHERE id = :id');
            $stmt->execute([':id' => $id]);
            set_flash('success', 'Message deleted successfully.');
        }
    } catch (PDOException $e) {
        set_flash('error', 'Unable to delete message.');
    }
}

redirect('submissions.php');
