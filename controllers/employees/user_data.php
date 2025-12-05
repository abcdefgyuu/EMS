<?php

use Core\Database;
$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_code=:employee_code",
  [
    'employee_code' => $employee_code
  ]
)->find();

view('employees/user_data.view.php', [
  "heading" => "Login Information",
  "employee_code" => $employee['employee_code'],
  "employee_email" => $employee['email'],
]);