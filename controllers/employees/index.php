<?php

use Core\Validator;
use Core\Database;

$db = new Database();

$page  = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Filters
$search     = $_GET['search'] ?? '';
$department = $_GET['department'] ?? '';
$position   = $_GET['position'] ?? '';

$where = [];
$params = [];

if ($search) {
    $where[] = "(name LIKE :search OR email LIKE :search)";
    $params['search'] = "%{$search}%";
}

if ($department) {
    $where[] = "department = :department";
    $params['department'] = $department;
}

if ($position) {
    $where[] = "position = :position";
    $params['position'] = $position;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

// --- MAIN QUERY ---
$query = "
    SELECT * FROM employees
    $whereSql
    LIMIT $limit OFFSET $offset
";

$employees = $db->query($query, $params)->getAll();

// --- COUNT QUERY ---
$countQuery = "
    SELECT COUNT(*) as count FROM employees
    $whereSql
";

$total = $db->query($countQuery, $params)->find()['count'];
$totalPages = ceil($total / $limit);

view('employees/index.view.php', [
    "heading"     => "Employees",
    "employees"   => $employees,
    "totalPages"  => $totalPages,
    "currentPage" => $page,
    "search"      => $search,
    "department"  => $department,
    "position"    => $position
]);
