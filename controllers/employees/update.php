<?php

use Core\Validator;
use Core\Database;
use Core\EmployeeValidator;

$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_id=:id",
  [
    'id' => $_POST['id']
  ]
)->findOrFail();

//authorize that the user belongs to the note
// if ($note['user_id'] !== "1") {
//   abort(Response::FORBIDDEN);
// }

//validate form
$validationResult = EmployeeValidator::validate($_POST);

$errors = $validationResult['errors'];
$bankFormatted = $validationResult['bank_formatted']; 

//if there is error return to view
if(count($errors)){
  return view('employees/edit.view.php',[
    "heading" => "Edit Employee",
    "employee" => $employee,
    "errors" => $errors
  ]);
}

//update in db
$db->query("
        UPDATE employees SET
            name = :name,
            position = :position,
            department = :department,
            join_date = :join_date,
            email = :email,
            graduate_university = :graduate_university,
            graduate_degree = :graduate_degree,
            DOB = :DOB,
            gender = :gender,
            nrc_no = :nrc_no,
            address = :address,
            phone = :phone,
            religion = :religion,
            bank_account = :bank_account
        WHERE employee_id = :id
    ", [
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
        
        // Use the validated and formatted bank account number
        ':bank_account' => $bankFormatted, 
        
        // The unique identifier for the WHERE clause
        ':id' => $_POST['id'] 
    ]);

//redirect
header("location: /employees");