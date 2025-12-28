
<?php
use Core\Database;

$db = new Database();

// Admin only
if (isset($_SESSION['user']) && $_SESSION['user']['role'] !== 'Admin') {
    header('Location: /');
    exit();
}
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$pending_requests = $db->query(
    "SELECT 
        lr.request_id,
        lr.request_type,
        lr.leave_date,
        lr.from_date,
        lr.to_date,
        lr.reason,
        lr.requested_at,
        e.name AS employee_name,
        lt.name AS leave_type_name
     FROM leave_requests lr
     JOIN employees e ON lr.employee_id = e.employee_id
     JOIN leave_types lt ON lr.leave_type_id = lt.leave_type_id
     WHERE lr.status = 'Pending'
     ORDER BY lr.requested_at DESC
     LIMIT $limit OFFSET $offset"
)->getAll();

// Get total count for pagination
$total = $db->query(
    "SELECT COUNT(*) as total
     FROM leave_requests lr
     WHERE lr.status = 'Pending'"
)->find()['total'] ?? 0;

$totalPages = $total > 0 ? ceil($total / $limit) : 1;

view('admin/notifications.view.php', [
    "heading"      => "Pending Leave Requests",
    "requests"     => $pending_requests,
    "currentPage"  => $page,
    "totalPages"   => $totalPages
]);