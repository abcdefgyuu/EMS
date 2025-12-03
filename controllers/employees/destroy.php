<?php

use Core\Database;
use Core\Response;

$db = new Database();

  //first find the user is belong with the note
//   $note = $db->query(
//     "SELECT * FROM employees where employee_id=:id",
//     [
//       'id' => $_POST['id']
//     ]
//   )->findOrFail();

//   //if not abort
//   if ($note['user_id'] !== "1") {
//     abort(Response::FORBIDDEN);
//   }

  //if the user is match delete the note
  $db->query(
    "DELETE FROM employees where employee_id=:id",
    [
      'id' => $_POST['id']
    ]
  );

  header('location: /employees');