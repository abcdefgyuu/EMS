<?php

use Core\Database;

$db = new Database();
$userId = $_SESSION['user']['id'];
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Admin';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');
$date = $_GET['date'] ?? '';

$where = [];
$params = [];

if ($isAdmin) {
  $where = [];
  $params = [];

  if ($search !== '') {
    $where[] = "COALESCE(employees.name, '') LIKE :search";
    $params['search'] = "%{$search}%";
  }

  if ($date !== '') {
    $where[] = "attendance.attendance_date = :date";
    $params['date'] = $date;
  }

  $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

  $query = "
        SELECT 
            attendance.*,
            COALESCE(employees.name, 'Unknown Employee') AS name
        FROM attendance
        LEFT JOIN employees ON attendance.employee_id = employees.employee_id
        $whereSql
        ORDER BY attendance.attendance_id DESC
        LIMIT $limit OFFSET $offset
    ";

  $attendances = $db->query($query, $params)->getAll();

  $countQuery = "
        SELECT COUNT(*) as total
        FROM attendance
        LEFT JOIN employees ON attendance.employee_id = employees.employee_id
        $whereSql
    ";
  $total = $db->query($countQuery, $params)->find()['total'] ?? 0;
} else {
  $where = [];
  $params = [];
  // Regular user sees only own
  if ($date !== '') {
    $where[] = "attendance_date = :date";
    $params['date'] = $date;
  }
  $where[] = "employee_id = :userId";
  $params['userId'] = $userId;

  $whereSql = "WHERE " . implode(" AND ", $where);
  
  $query = "
        SELECT 
            attendance.*,
            :username AS name
        FROM attendance
        $whereSql
        ORDER BY attendance.attendance_id DESC
        LIMIT $limit OFFSET $offset
    ";
  $params['username'] = $_SESSION['user']['username'];
  $attendances = $db->query($query, $params)->getAll();
  unset($params['username']);
  $countQuery = "SELECT COUNT(*) as total FROM attendance $whereSql";
  $total = $db->query($countQuery, $params)->find()['total'] ?? 0;
}
//dd($attendances); 
$totalPages = ceil($total / $limit);



view('attendance/index.view.php', [
  "heading" => "Attendance",
  "attendances" => $attendances,
  "currentPage" => $page,
  "totalPages" => $totalPages,
  "offset" => $offset,
  "search" => $search,
  "date" => $date
]);
