<?php
require_once __DIR__ . '/includes/auth_check.php';

include __DIR__ . '/includes/header.php';

$pdo = get_db();
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$search = trim($_GET['search'] ?? '');

$query = 'SELECT cm.id, cm.name, cm.email, cm.subject, cm.message, cm.created_at FROM contact_messages cm WHERE 1=1';
$params = [];
if ($search !== '') {
    $query .= ' AND (cm.name LIKE :search OR cm.email LIKE :search OR cm.subject LIKE :search OR cm.message LIKE :search)';
    $params[':search'] = '%' . $search . '%';
}

$query .= ' ORDER BY cm.created_at DESC';
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$allMessages = $stmt->fetchAll();

$total = count($allMessages);
$pages = max(1, (int) ceil($total / $perPage));
$page = min($page, $pages);
$offset = ($page - 1) * $perPage;

$query .= ' LIMIT :offset, :perPage';
$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();
$messages = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    try {
        verify_csrf();
        $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = :id');
        $stmt->execute([':id' => (int) $_POST['delete_id']]);
        set_flash('success', 'Message deleted successfully.');
        redirect('submissions.php');
    } catch (PDOException $e) {
        set_flash('error', 'Unable to delete message.');
        error_log($e->getMessage());
    }
}
?>
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-0">Submissions</h2>
            <form method="get" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search messages" value="<?= e($search) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?= e($message['id']) ?></td>
                            <td><?= e($message['name']) ?></td>
                            <td><?= e($message['email']) ?></td>
                            <td><?= e($message['subject']) ?></td>
                            <td><?= e(substr($message['message'], 0, 80)) ?><?= strlen($message['message']) > 80 ? '...' : '' ?></td>
                            <td><?= e(format_date($message['created_at'])) ?></td>
                            <td>
                                <form method="post" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                    <input type="hidden" name="delete_id" value="<?= e($message['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <nav class="mt-3">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="submissions.php?page=<?= e($i) ?>&search=<?= e(urlencode($search)) ?>"><?= e($i) ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
