<?php

use Core\Response;
use Core\Database;

function dd($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';

  die();
}


function urlIs($value)
{
  return $_SERVER['REQUEST_URI'] === $value;
}


function abort($code = 404)
{

  http_response_code($code);
  require base_path("views/{$code}.php");
  die();
}

function base_path($path)
{
  return BASE_PATH . $path;
}

function view($path, $attribute = [])
{
  extract($attribute);
  require base_path('views/' . $path);
}

function login($user)
{
  $_SESSION['user'] = [
    'id' => $user['id'],
    'username' => $user['username'],
    'emp_code' => $user['emp_code'],
    'role' => $user['role']
  ];
}

function logout()
{
  $_SESSION = [];
  session_destroy();
  header('Location: /');
  exit();
}

function pending_count()
{
  if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'Admin') {
    return 0;
  }

  $db = new Database();
  $row = $db->query("SELECT COUNT(*) AS count FROM leave_requests WHERE status = 'Pending'")
    ->find();

  return (int)($row['count'] ?? 0);
}
