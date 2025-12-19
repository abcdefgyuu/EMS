
<?php
use Core\Database;

$db = new Database();

// Admin only
if (isset($_SESSION['user']) && $_SESSION['user']['role'] !== 'Admin') {
    header('Location: /');
    exit();
}

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
     ORDER BY lr.requested_at DESC"
)->getAll();

view('admin/notifications.view.php', [
    "heading" => "Pending Leave Requests",
    "requests" => $pending_requests
]);