<?php

use Core\Response;

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
    'code' => $user['code'],
    'username' => $user['username'],
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
