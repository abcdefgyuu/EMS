<?php
use Core\Database;

$db = new Database();

$employee_id = $_SESSION['user']['id'];

// --- Setup Variables from POST ---
$leave_type_input = $_POST['leave_type'] ?? ''; // 'single' or 'long-term'
$single_date      = trim($_POST['single_date'] ?? '');
$start_date       = trim($_POST['start_date'] ?? '');
$end_date         = trim($_POST['end_date'] ?? '');
$reason           = trim($_POST['reason'] ?? '');

// Map frontend value to database enum
$request_type = ($leave_type_input === 'long-term') ? 'Long Term' : 'Single';

// --- Validation ---
$errors = [];

// Reason is required
if (empty($reason)) {
    $errors['reason'] = "Reason is required.";
}

// Date validation based on type
if ($request_type === 'Single') {
    if (empty($single_date)) {
        $errors['single_date'] = "Leave date is required for single day leave.";
    }
} else { // Long Term
    if (empty($start_date)) {
        $errors['start_date'] = "Start date is required for long-term leave.";
    }
    if (empty($end_date)) {
        $errors['end_date'] = "End date is required for long-term leave.";
    }

    if (!empty($start_date) && !empty($end_date)) {
        if (strtotime($start_date) > strtotime($end_date)) {
            $errors['end_date'] = "End date cannot be earlier than start date.";
        }
    }
}

// If there are validation errors, show them
if (!empty($errors)) {
    view('leave/index.view.php', [
        "heading" => "Request Leave",
        "errors"  => $errors
    ]);
    exit();
}

// --- Determine dates to store ---
$leave_date = null;
$from_date  = null;
$to_date    = null;

if ($request_type === 'Single') {
    $leave_date = $single_date;
} else {
    $from_date = $start_date;
    $to_date   = $end_date;
}

// --- Calculate number of days requested ---
$dates = [];
if ($request_type === 'Single') {
    $dates[] = $leave_date;
} else {
    $start = new DateTime($from_date);
    $end   = new DateTime($to_date);
    $end->modify('+1 day'); // Include end date
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end);
    foreach ($period as $dt) {
        $dates[] = $dt->format('Y-m-d');
    }
}
$days_requested = count($dates);

// --- FIXED: Automatic leave_type_id selection (Casual first, then Annual) ---
// Safely handles employees with NO rows in leave_balance (new employees get full days)
$leave_type_id = null;
$selected_type_name = null;
$casual_remaining = 0;
$annual_remaining = 0;

try {
    $balances = $db->query(
        "SELECT 
            lt.leave_type_id,
            lt.name,
            COALESCE(lb.remaining_days, lt.total_days) AS remaining_days
         FROM leave_types lt
         LEFT JOIN leave_balance lb 
            ON lt.leave_type_id = lb.leave_type_id 
           AND lb.employee_id = :employee_id
         WHERE lt.name IN ('Casual', 'Annual')
         ORDER BY 
            CASE lt.name 
                WHEN 'Casual' THEN 1 
                WHEN 'Annual' THEN 2 
            END",
        ['employee_id' => $employee_id]
    )->getAll();

    // Extract remaining days
    foreach ($balances as $bal) {
        if ($bal['name'] === 'Casual') {
            $casual_remaining = (int)$bal['remaining_days'];
        } elseif ($bal['name'] === 'Annual') {
            $annual_remaining = (int)$bal['remaining_days'];
        }
    }

    // Priority: Use Casual first
    if ($casual_remaining >= $days_requested) {
        $leave_type_id = 3; // Casual Leave ID
        $selected_type_name = 'Casual';
    } elseif ($annual_remaining >= $days_requested) {
        $leave_type_id = 1; // Annual Leave ID
        $selected_type_name = 'Annual';
    } else {
        $errors['leave_type'] = "Insufficient leave balance. " .
            "You have {$casual_remaining} Casual and {$annual_remaining} Annual days remaining. " .
            "Requested: {$days_requested} day(s).";
    }

} catch (Exception $e) {
    error_log("Leave Balance Check Error: " . $e->getMessage());
    echo "A system error occurred. Please try again later.";
    exit();
}

if (!$leave_type_id) {
    view('leave/index.view.php', [
        "heading" => "Request Leave",
        "errors"  => $errors
    ]);
    exit();
}

// --- INSERT Leave Request (Status: Pending) ---
try {
    $db->query(
        "INSERT INTO leave_requests 
         (employee_id, leave_type_id, request_type, leave_date, from_date, to_date, reason, status)
         VALUES (:employee_id, :leave_type_id, :request_type, :leave_date, :from_date, :to_date, :reason, 'Pending')",
        [
            'employee_id'   => $employee_id,
            'leave_type_id' => $leave_type_id,
            'request_type'  => $request_type,
            'leave_date'    => $leave_date,
            'from_date'     => $from_date,
            'to_date'       => $to_date,
            'reason'        => $reason
        ]
    );

    $_SESSION['success'] = "Leave request submitted successfully using your {$selected_type_name} leave. Awaiting admin approval.";
    header('Location: /leave');
    exit();

} catch (Exception $e) {
    error_log("Leave Request INSERT Error: " . $e->getMessage());
    echo "A serious database error occurred during submission. Please try again later.";
}