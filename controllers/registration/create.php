<?php

use Core\Database;
$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_id=:employee_id",
  [
    'employee_id' => $_GET['id']
  ]
)->find();

view('registration/create.view.php', [
  "heading" => "Login Information",
  "employee_code" => $employee['employee_code'],
  "employee_email" => $employee['email'],
]);