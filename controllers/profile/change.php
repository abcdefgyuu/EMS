<?php

use Core\Validator;
use Core\Database;

$db = new Database();

$user_id = $_SESSION['user']['id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];


$user = $db->query(
  'SELECT * FROM users WHERE employee_id = :id',
  [
    'id' => $user_id
  ]
)->find();

if (password_verify($old_password, $user['password'])) {
  //validate new password
  $errors = [];

  if (!Validator::string($new_password, 8, 255)) {
    $errors['new_password'] = "Password must be between 8 and 255 characters.";
  }

  if ($new_password !== $confirm_password) {
    $errors['confirm_password'] = "Passwords do not match.";
  }

  if (!empty($errors)) {
    return view('profile/reset.view.php', [
      'errors' => $errors
    ]);
  }

  //update password
  $hashed_password = password_hash($confirm_password, PASSWORD_BCRYPT);

  $db->query(
    'UPDATE users SET password = :password WHERE employee_id = :id',
    [
      'password' => $hashed_password,
      'id' => $user_id
    ]
  );

  //redirect to profile with success message
  $_SESSION['success'] = "Change password successfully.";
  header('Location: /dashboard');
  exit();
} else {
  $errors['old_password'] = "Old password is incorrect.";
  return view('profile/reset.view.php', [
    'errors' => $errors
  ]);
}
