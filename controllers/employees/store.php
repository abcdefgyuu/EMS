<?php

use Core\Validator;
use Core\Database;

$db = new Database();

$errors = [];

// Required fields
if (!Validator::string($_POST['name'])) {
  $errors['name'] = "Name is required";
}
if (!Validator::string($_POST['position'])) {
  $errors['position'] = "Position is required";
}
if (!Validator::string($_POST['department'])) {
  $errors['department'] = "Department is required";
}
if (!Validator::string($_POST['join_date'])) {
  $errors['join_date'] = "Join date is required";
}
if (!Validator::string($_POST['email'])) {
  $errors['email'] = "Email is required";
} elseif (!Validator::email($_POST['email'])) {
  $errors['email'] = "Please provide a valid email";
}
if (!Validator::string($_POST['graduate_university'])) {
  $errors['graduate_university'] = "Graduate university is required";
}
if (!Validator::string($_POST['graduate_degree'])) {
  $errors['graduate_degree'] = "Graduate degree is required";
}
if (!Validator::string($_POST['DOB'])) {
  $errors['DOB'] = "Date of birth is required";
}
if (!Validator::string($_POST['gender'])) {
  $errors['gender'] = "Gender is required";
}
if (!Validator::string($_POST['nrc_no'])) {
  $errors['nrc_no'] = "NRC No is required";
}
if (!Validator::string($_POST['address'])) {
  $errors['address'] = "Address is required";
}
if (!Validator::string($_POST['phone'])) {
  $errors['phone'] = "Phone is required";
}
if (!Validator::string($_POST['religion'])) {
  $errors['religion'] = "Religion is required";
}
// Normalize bank account: allow input with spaces (e.g. "1234 5678 9012 3456")
$bankRaw = $_POST['bank_account'] ?? '';
$bankDigits = str_replace(' ', '', $bankRaw);

if (!Validator::string($bankDigits, 16, 16)) {
  $errors['bank_account'] = "Bank account is required and must be 16 digits";
} elseif (!ctype_digit($bankDigits)) {
  $errors['bank_account'] = "Bank account must contain only digits";
} else {
  // Format for storage: group by 4 digits separated by -
  $bankFormatted = trim(chunk_split($bankDigits, 4, '-'));
}

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
    ':bank_account' => $bankFormatted ?? ($_POST['bank_account'] ?? null)
  ]
);

$lastEmployeeId = $db->lastInsertId();
$employee_code = 'E-' . str_pad($lastEmployeeId, 4, '0', STR_PAD_LEFT);

$db->query("UPDATE employees SET employee_code = :code WHERE employee_id = :id",[
 ':code' => $employee_code,
  ':id' => $lastEmployeeId
]);

$_SESSION['success'] = "Employee inserted successfully";
header('Location: /employees');
exit;


