<?php
use Core\Database;
use Core\Response;

$db = new Database();

$employee = $db->query(
  "SELECT * FROM employees where employee_id=:id",
  [
    'id' => $_GET['id']
  ]
)->findOrFail();

function unformat_bank_account(string $formattedString): string
{
    return str_replace(['-', ' '], '', $formattedString);
}

$bank_acc=unformat_bank_account($employee['bank_account']);
$employee['bank_account']=$bank_acc;

view('employees/edit.view.php', [
  "heading" => "Edit Employee",
  "employee" => $employee,
  "errors" => []
]);