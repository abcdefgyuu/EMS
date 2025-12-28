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

function pagination($currentPage, $totalPages, $baseUrl = '')
{
    if ($totalPages <= 1) {
        return;
    }

    // Preserve existing GET params except 'page'
    $queryParams = $_GET;
    unset($queryParams['page']);

    // Build base URL with preserved filters
    $base = $baseUrl . (empty($queryParams) ? '' : '?' . http_build_query($queryParams));
    $base .= (empty($queryParams) ? '?' : '&');

    ?>
    <div class="mt-6 flex justify-center space-x-2">
        <!-- Previous -->
        <?php if ($currentPage > 1): ?>
            <a href="<?= $base ?>page=<?= $currentPage - 1 ?>"
               class="px-3 py-1 border rounded bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                ‹
            </a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php
        $start = max(1, $currentPage - 2);
        $end   = min($totalPages, $start + 4);

        if ($end - $start + 1 < 5) {
            $start = max(1, $end - 4);
        }

        // First page
        if ($start > 1): ?>
            <a href="<?= $base ?>page=1"
               class="px-3 py-1 border rounded bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white">
                1
            </a>
            <?php if ($start > 2): ?>
                <span class="px-3 py-2">...</span>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Visible pages -->
        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="<?= $base ?>page=<?= $i ?>"
               class="px-3 py-1 border rounded transition <?= $i === $currentPage ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Last page -->
        <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?>
                <span class="px-3 py-2">...</span>
            <?php endif; ?>
            <a href="<?= $base ?>page=<?= $totalPages ?>"
               class="px-3 py-1 border rounded bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white">
                <?= $totalPages ?>
            </a>
        <?php endif; ?>

        <!-- Next -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= $base ?>page=<?= $currentPage + 1 ?>"
               class="px-3 py-1 border rounded bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                ›
            </a>
        <?php endif; ?>
    </div>
    <?php
}
