<?php

use Core\Database;
use Core\Response;

$db = new Database();

$code = $_SESSION['user']['code'];

$user = $db->query('SELECT * FROM users WHERE employee_code = :code', [
  'code' => $code
])->findOrFail();


if (!$user) {
  abort(Response::FORBIDDEN);
}

$user_profile = $db->query(
  "SELECT * FROM employees where employee_id=:id",
  [
    'id' => $user['employee_id']
  ]
)->findOrFail();


view('profile/show.view.php', [
  "heading" => "Profile",
  "profile" => $user_profile
]);
