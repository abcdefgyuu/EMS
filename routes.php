<?php

$router->get('/', 'controllers/index.php');
$router->get('/dashboard', 'controllers/dashboard.php')->only('auth');
$router->get('/employees', 'controllers/employees/index.php')->only('auth');
$router->get('/attendance', 'controllers/attendance/index.php');
$router->get('/leave', 'controllers/leave/index.php');
//$router->get('/about', 'controllers/about.php');
//$router->get('/contact', 'controllers/contact.php');
//
//$router->get('/notes', 'controllers/notes/index.php')->only('auth');
//$router->get('/note', 'controllers/notes/show.php');
//$router->delete('/note', 'controllers/notes/destroy.php');
//
$router->get('/employees/create', 'controllers/employees/create.php');
$router->get('/employees/registration', 'controllers/registration/create.php');
$router->post('/employees', 'controllers/employees/store.php');
$router->post('/employees/registration', 'controllers/registration/store.php');
$router->get('/employees/edit', 'controllers/employees/edit.php');
$router->patch('/employees', 'controllers/employees/update.php');
$router->delete('/employees', 'controllers/employees/destroy.php');
//
//$router->get('/notes/edit', 'controllers/notes/edit.php');
//$router->patch('/note', 'controllers/notes/update.php');
//
//
//$router->get('/register', 'controllers/registration/create.php')->only('guest');
//$router->post('/register', 'controllers/registration/store.php')->only('guest');
//
//
//$router->get('/login', 'controllers/sessions/create.php')->only('guest');
//$router->post('/sessions', 'controllers/sessions/store.php')->only('guest');
//$router->delete('/sessions', 'controllers/sessions/destroy.php')->only('auth');

$router->post('/', 'controllers/sessions/store.php');
$router->delete('/sessions', 'controllers/sessions/destroy.php')->only('auth');

$router->get('/profile', 'controllers/profile/show.php')->only('auth');