<?php

use Core\Validator;
use Core\Database;

$db = new Database();

//$employees = $db->query("SELECT * FROM employees")->getAll();

$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$getLimitEmployees = "SELECT * FROM employees LIMIT $limit OFFSET $offset";
$employees = $db->query($getLimitEmployees)->getAll();


$total = $db->query("SELECT COUNT(*) as count FROM employees")->find()['count'];
$totalPages = ceil($total / $limit);


view('employees/index.view.php',[
  "heading"=>"Employees",
  "employees" => $employees,
   'totalPages' => $totalPages,
  'currentPage' => $page
]);