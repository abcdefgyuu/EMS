<?php

use Core\Validator;
use Core\Database;
use Core\EmployeeValidator;

$db = new Database();

$validationResult = EmployeeValidator::validate($_POST);

$errors = $validationResult['errors'];
$bankFormatted = $validationResult['bank_formatted']; 

if (!empty($errors)) {
  return view('employees/create.view.php', [
    'errors' => $errors
  ]);
}

$db->query(
  "INSERT INTO employees (
  name, position, department, join_date, email,
  graduate_university, graduate_degree, DOB, gender, nrc_no,
  address, phone, religion, bank_account
) VALUES (
  :name, :position, :department, :join_date, :email,
  :graduate_university, :graduate_degree, :DOB, :gender, :nrc_no,
  :address, :phone, :religion, :bank_account
)",
  [
    ':name' => $_POST['name'],
    ':position' => $_POST['position'],
    ':department' => $_POST['department'],
    ':join_date' => $_POST['join_date'],
    ':email' => $_POST['email'],
    ':graduate_university' => $_POST['graduate_university'],
    ':graduate_degree' => $_POST['graduate_degree'],
    ':DOB' => $_POST['DOB'],
    ':gender' => $_POST['gender'],
    ':nrc_no' => $_POST['nrc_no'],
    ':address' => $_POST['address'],
    ':phone' => $_POST['phone'],
    ':religion' => $_POST['religion'],
    ':bank_account' => $bankFormatted 
  ]
);

$lastEmployeeId = $db->lastInsertId();
$employee_code = 'E-' . str_pad($lastEmployeeId, 4, '0', STR_PAD_LEFT);

$db->query("UPDATE employees SET employee_code = :code WHERE employee_id = :id",[
 ':code' => $employee_code,
  ':id' => $lastEmployeeId
]);

$_SESSION['success'] = "Employee inserted successfully";
// header('Location: /employees/user_data?id=' . $lastEmployeeId);
view('employees/user_data.view.php', [
  "heading" => "Login Information",
  "employee_email" => $_POST['email'],
  "employee_code" => $employee_code,
]);
exit;


