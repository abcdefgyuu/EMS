<?php

use Core\Database;
use Core\Validator;
$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_code=:code",
  [
    'code' => $_POST['code']
  ]
)->find();

if (!Validator::string($_POST['password'], 8, 255)) {
  $errors['password'] = "Password must be between 8 and 255 characters.";
}

if (!empty($errors)) {
  return view('employees/user_data.view.php', [
    'errors' => $errors,
    "employee_code" => $employee['employee_code'],
    "employee_email" => $employee['email'],
  ]);
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
$db->query(
  "UPDATE employees SET password = :password WHERE employee_code = :code",
  [
    ':password' => $hashedPassword,
    ':code' => $_POST['code']
  ]
);

$_SESSION['success'] = "Employee credential created successfully";
header('Location: /employees');