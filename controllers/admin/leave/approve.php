<?php
use Core\Database;

$db = new Database();

// dd($_POST); // remove in production

$request_id = $_POST['request_id'] ?? null;
$action     = $_POST['action'] ?? null; // 'approve' or 'reject'

if (!$request_id || !in_array($action, ['approve', 'reject'])) {
    $_SESSION['error'] = "Invalid request.";
    header('Location: /admin/notifications');
    exit();
}

// --- 1. Fetch the leave request ---
$request = $db->query(
    "SELECT lr.*, lt.name AS leave_type_name, lt.total_days
     FROM leave_requests lr
     JOIN leave_types lt ON lr.leave_type_id = lt.leave_type_id
     WHERE lr.request_id = :request_id AND lr.status = 'Pending'",
    ['request_id' => $request_id]
)->find();

if (!$request) {
    $_SESSION['error'] = "Leave request not found or already processed.";
    header('Location: /admin/notifications');
    exit();
}

$employee_id   = $request['employee_id'];
$leave_type_id = $request['leave_type_id'];
$request_type  = $request['request_type'];

// --- Determine affected dates ---
$dates = [];
if ($request_type === 'Single') {
    $dates[] = $request['leave_date'];
} else {
    $start = new DateTime($request['from_date']);
    $end   = new DateTime($request['to_date']);
    $end->modify('+1 day');
    $period = new DatePeriod($start, new DateInterval('P1D'), $end);
    foreach ($period as $date) {
        $dates[] = $date->format('Y-m-d');
    }
}

$days_requested = count($dates);



// --- 2. Handle Rejection ---
if ($action === 'reject') {
    try {
        $db->query(
            "UPDATE leave_requests SET status = 'Rejected' WHERE request_id = :request_id",
            ['request_id' => $request_id]
        );

        $_SESSION['success'] = "Leave request rejected successfully.";
        header('Location: /admin/notifications');
        exit();

    } catch (Exception $e) {
        error_log("Reject Error: " . $e->getMessage());
        $_SESSION['error'] = "Failed to reject request.";
        header('Location: /admin/notifications');
        exit();
    }
}

// --- 3. Handle Approval ---
try {
    // Get current balance with fallback to full entitlement
    $balance = $db->query(
        "SELECT COALESCE(lb.remaining_days, lt.total_days) AS remaining_days
         FROM leave_types lt
         LEFT JOIN leave_balance lb 
            ON lt.leave_type_id = lb.leave_type_id 
           AND lb.employee_id = :employee_id
         WHERE lt.leave_type_id = :leave_type_id",
        [
            'employee_id'   => $employee_id,
            'leave_type_id' => $leave_type_id
        ]
    )->find();

    $remaining_days = $balance ? (int)$balance['remaining_days'] : 0;

    if ($remaining_days < $days_requested) {
        $_SESSION['error'] = "Insufficient leave balance for this type. " .
                             "Remaining: {$remaining_days} days, Requested: {$days_requested}.";
        header('Location: /admin/notifications');
        exit();
    }

    // Start transaction
    $db->beginTransaction();

    // Deduct from leave_balance
    // Calculate the new remaining balance for insert (entitlement / current balance minus requested days)
    $new_remaining = $remaining_days - $days_requested;
    if ($new_remaining < 0) {
        $new_remaining = 0;
    }

    dd($new_remaining);

    $db->query(
        "INSERT INTO leave_balance (employee_id, leave_type_id, remaining_days)
         VALUES (:employee_id, :leave_type_id, :new_remaining)
         ON DUPLICATE KEY UPDATE remaining_days = :new_remaining",
        [
            'employee_id'   => $employee_id,
            'leave_type_id' => $leave_type_id,
            'new_remaining' => $new_remaining
        ]
    );

    // Insert attendance records (using your existing query method)
    foreach ($dates as $date) {
        $db->query(
            "INSERT IGNORE INTO attendance 
             (employee_id, attendance_date, type, status, leave_request_id)
             VALUES (:employee_id, :attendance_date, 'Office', 'Leave', :request_id)",
            [
                'employee_id'     => $employee_id,
                'attendance_date' => $date,
                'request_id'      => $request_id
            ]
        );
    }

    // Update request status
    $db->query(
        "UPDATE leave_requests SET status = 'Approved' WHERE request_id = :request_id",
        ['request_id' => $request_id]
    );

    $db->commit();

    $_SESSION['success'] = "Leave request approved successfully. {$days_requested} day(s) deducted.";
    header('Location: /admin/notifications');
    exit();

} catch (Exception $e) {
    $db->rollBack();
    error_log("Approval Error: " . $e->getMessage());
    $_SESSION['error'] = "Failed to approve leave request.";
    header('Location: /admin/notifications');
    exit();
}