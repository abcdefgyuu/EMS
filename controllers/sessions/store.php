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

// match the credentials (single joined query for users + employees)
$user = $db->query(
  'SELECT u.*, e.employee_id, e.name AS employee_name
   FROM users u
   JOIN employees e ON u.employee_code = e.employee_code
   WHERE u.employee_code = :code',
  [
    'code' => $code
  ]
)->find();

// pending_count removed from here; use pending_count() helper in views/partials/nav.php

if ($user) {
  if (password_verify($password, $user['password'])) {

    login([
      'id' => $user['employee_id'],
      'username' => $user['employee_name'],
      'emp_code' => $user['employee_code'],
      'role' => $user['role']
    ]);

    header('location: /dashboard');
    exit();
  } else {
    $errors['login'] = "Wrong password.";
    view('index.view.php', [
      'errors' => $errors
    ]);
  }
} else {
  $errors['login'] = "User not found";
  view('index.view.php', [
    'errors' => $errors
  ]);
}
