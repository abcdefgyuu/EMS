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

$allAttendances = $db->query(
  "SELECT attendance.*, employees.name
   FROM attendance
   LEFT JOIN employees ON attendance.employee_id = employees.employee_id
   ORDER BY attendance_date DESC"
)->getAll();


view('attendance/index.view.php',[
  "heading"=>"Attendance",
  "attendances"=>$attendances,
  "allAttendances"=>$allAttendances
]);