<?php

use Core\Validator;
use Core\Database;

$db = new Database();
$code = $_POST['code'];
$password = $_POST['password'];

$errors = [];

//validate the input
// if (!Validator::email($email)) {
//   $errors['email'] = "Please provide a valid email";
// }

// if (!Validator::string($password)) {
//   $errors['password'] = "Please provide a valid password";
// }

// if (!empty($errors)) {
//   return view('index.view.php', [
//     'errors' => $errors
//   ]);
// }

//match the credentials
$user = $db->query('SELECT * FROM users WHERE employee_code = :code', [
  'code' => $code
])->find();

$user_info = $db->query('SELECT * FROM employees WHERE employee_code = :code', [
  'code' => $code
])->find();


if ($user) {
  if (password_verify($password, $user['password'])) {
    
    login([
      'id' => $user_info['employee_id'],
      'username' => $user_info['name'],
      'role' => $user['role']
    ]);

    header('location: /dashboard');
    exit();
  }
  else {
    $errors['login'] = "Wrong password.";
    view('index.view.php', [
      'errors' => $errors
    ]);
  }
}
else {
  $errors['login'] = "User not found";
  view('index.view.php', [
    'errors' => $errors
  ]);
}