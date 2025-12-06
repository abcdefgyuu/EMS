<?php

use Core\Database;
use Core\Validator;
$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_id=:id",
  [
    'id' => $_POST['id']
  ]
)->find();



if (!Validator::string($_POST['password'], 8, 255)) {
  $errors['password'] = "Password must be between 8 and 255 characters.";
}

if (!empty($errors)) {
  // Persist validation errors to the session and redirect back to the form.
  // Avoid continuing execution so the insert does not run when there are errors.
  $_SESSION['errors'] = $errors;
  header('Location: /employees/registration?id=' . urlencode($_POST['id']));
  exit();
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
$db->query(
  "INSERT INTO users (employee_id, employee_code, password, role) VALUES (:employee_id, :employee_code, :password, :role)",
  [
    ':employee_id' => $employee['employee_id'],
    ':employee_code' => $employee['employee_code'],
    ':password' => $hashedPassword,
    ':role' => 'Employee'
  ]
);

$_SESSION['success'] = "Employee credential created successfully";
header('Location: /employees');