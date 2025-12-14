<?php
use Core\Database;

$db = new Database();
$id = $_SESSION['user']['id'];
// $attendances = $db->query(
//   "SELECT * FROM attendance where employee_id=:id",
//   [
//     'id' => $id
//   ]
// )->findOrFail();

// dd($attendances);

view('attendance/index.view.php',[
  "heading"=>"Attendance"
]);