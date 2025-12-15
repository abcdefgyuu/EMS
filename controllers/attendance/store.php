<?php
use Core\Database;

$db = new Database();

$id = $_SESSION['user']['id'];
$attendances = $db->query(
  "SELECT * FROM attendance where employee_id=:id",
  [
    'id' => $id
  ]
)->getAll();

// --- Setup Variables ---
// Current time in H:i:s format (e.g., '08:06:30')
$current_time = date('H:i:s');
// Current date in Y-m-d format (e.g., '2025-12-15')
$current_date = date('Y-m-d');
$employee_id = $_SESSION['user']['id'];

// Define the late cut-off time
$cutoff_time = '08:05:00'; 

// Determine the Attendance Type (Late or Present)
if ($current_time > $cutoff_time) {
    $attendance_type = 'Late';
} else {
    $attendance_type = 'Present';
}

// --- 1. PRE-CHECK FOR DUPLICATE ENTRY ---
// Use a SELECT query to see if a record already exists for this employee and date
try {
    $sql_check = "SELECT COUNT(*) AS total_count FROM attendance 
                  WHERE employee_id = :employee_id AND attendance_date = :attendance_date";

    $result = $db->query($sql_check, [
        'employee_id' => $employee_id,
        'attendance_date' => $current_date
    ]);

    $row = $result->find();
    $count = intval($row['total_count'] ?? $row['COUNT(*)'] ?? 0);

    if ($count > 0) {
       $errors['duplicate_attendance'] = "Attendance for today has already been recorded.";
       view('attendance/index.view.php', [
           "heading" => "Attendance",
           "attendances"=>$attendances,
           "errors" => $errors
       ]);
       exit();
    }

} catch (Exception $e) {
    error_log("Pre-Check Error: " . $e->getMessage());
    exit();
}


// --- 2. EXECUTE INSERT (Only runs if the count was 0) ---
try {
    $db->query(
        "INSERT INTO attendance (employee_id, attendance_date, submitted_time, type, status) 
         VALUES (:employee_id, :attendance_date, :submitted_time, :type, :status)",
        [
            'employee_id'     => $employee_id,
            'attendance_date' => $current_date,
            'submitted_time'  => $current_time,
            'type'            => $attendance_type, // Calculated type ('Late' or 'Present')
            'status'          => $_POST['location']
        ]
    );

    $_SESSION['success'] = "Attendance submitted successfully.";
    header('Location: /attendance');
    exit();

} catch (Exception $e) {
    // This catches *other* database errors (like permission issues, server down, etc.)
    error_log("Final INSERT Error: " . $e->getMessage());
    echo "A serious database error occurred during submission. Debug Info: " . $e->getMessage();
}