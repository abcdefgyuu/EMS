<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>

<?php
$search = $_GET['search'] ?? '';
$department = $_GET['department'] ?? '';
$position = $_GET['position'] ?? '';
?>

<main>
  <div class="bg-neutral-100 pt-24 min-h-screen">
    <div class="inner">
      <h2 class="text-2xl font-bold text-center mb-6">Employee List</h2>
      <input type="text" id="searchEmployee" class="w-64 md:w-1/3 mb-3 md:mb-8 mx-auto block px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Search by name or email..." />
      <div class="mb-4 md:flex justify-between items-center">
        <div class="w-full md:w-2/3">
          <select id="departmentFilter" class="w-40 md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="" <?= $department === "" ? "selected" : "" ?>>All Departments</option>
            <option value="HR" <?= $department === "HR" ? "selected" : "" ?>>HR</option>
            <option value="Dev-01" <?= $department === "Dev-01" ? "selected" : "" ?>>Dev-01</option>
            <option value="Dev-02" <?= $department === "Dev-02" ? "selected" : "" ?>>Dev-02</option>
            <option value="Dev-03" <?= $department === "Dev-03" ? "selected" : "" ?>>Dev-03</option>
          </select>

          <select id="positionFilter" class="w-28 md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="" <?= $position === "" ? "selected" : "" ?>>All Roles</option>
            <option value="Manager" <?= $position === "Manager" ? "selected" : "" ?>>Manager</option>
            <option value="Developer" <?= $position === "Developer" ? "selected" : "" ?>>Developer</option>
          </select>

          <button id="resetBtn" class="w-24 ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">Reset</button>
        </div>
        <div class="text-right mt-8 md:mt-4"><a href="/employees/create" class="w-40 bg-sky-600 text-white text-center inline-block px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">+ Add Employee</a></div>
      </div>

      <table id="employeeTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Role</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($employees as $employee) : ?>
            <tr>
              <td data-label="Employee Code"><?= $employee['employee_code'] ?></td>
              <td data-label="Name"><?= $employee['name'] ?></td>
              <td data-label="Department"><?= $employee['department'] ?></td>
              <td data-label="Position"><?= $employee['position'] ?></td>
              <td data-label="Email"><?= $employee['email'] ?></td>
              <td class="flex items-center justify-center">
                <a href="/employees/edit?id=<?= $employee['employee_id'] ?>" class="btn btn-edit mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                  </svg>
                </a>
                <form action="" method="POST" class="inline-block delete-form">
                  <input type="hidden" name="_method" value="DELETE">
                   <input type="hidden" name="id" value="<?= $employee['employee_id'] ?>">
                  <button type="button" class="btn btn-delete delete-btn" data-employee-name="<?= $employee['name'] ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <!--<div class="pagination" id="pagination"></div>-->
      <!-- pagination -->
      <div class="m-4 flex justify-center space-x-2">
        <!-- Previous Button -->
        <?php if ($currentPage > 1): ?>
          <a href="/employees?page=<?= $currentPage - 1 ?>" class="px-3 py-1 border rounded bg-white text-indigo-600 duration-400 hover:bg-indigo-600 hover:text-white">‹</a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php
        $maxVisible = 3;
        for ($i = 1; $i <= $totalPages; $i++) {
          if (
            $i == 1 ||
            $i == $totalPages ||
            ($i >= $currentPage - 1 && $i <= $currentPage + 1)
          ) {
            echo '<a href="/employees?page=' . $i . '" class="px-3 py-1 border rounded duration-400 ' . ($i == $currentPage ? 'bg-indigo-600 text-white' : 'bg-white text-indigo-600 hover:bg-indigo-600 hover:text-white') . '">' . $i . '</a>';
          } elseif ($i == 2 && $currentPage > 4) {
            echo '<span class="px-3 py-1">...</span>';
          } elseif ($i == $totalPages - 1 && $currentPage < $totalPages - 3) {
            echo '<span class="px-3 py-1">...</span>';
          }
        }
        ?>

        <!-- Next Button -->
        <?php if ($currentPage < $totalPages): ?>
          <a href="/employees?page=<?= $currentPage + 1 ?>" class="px-3 py-1 border rounded bg-white text-indigo-600 duration-400 hover:bg-indigo-600 hover:text-white">›</a>
        <?php endif; ?>
      </div>

    </div>

    <?php if (!empty($_SESSION["success"])): ?>
      <div class="toast-success"><?= $_SESSION["success"] ?></div>
      <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

  </div>
  </div>
</main>


<script>
function applyFilters() {
    const search = document.getElementById('searchEmployee').value;
    const dept   = document.getElementById('departmentFilter').value;
    const pos    = document.getElementById('positionFilter').value;

    const params = new URLSearchParams();

    if (search !== "") params.set("search", search);
    if (dept !== "") params.set("department", dept);
    if (pos !== "") params.set("position", pos);

    params.set("page", 1);

    window.location = "?" + params.toString();
}

function resetFilters() {
    document.getElementById('searchEmployee').value = '';
    document.getElementById('departmentFilter').value = '';
    document.getElementById('positionFilter').value = '';
    window.location = '/employees';
}

// --- SEARCH ONLY ON ENTER ---
document.getElementById('searchEmployee').addEventListener('keyup', (e) => {
    if (e.key === "Enter") {
        applyFilters();
    }
});

// --- FILTERS APPLY IMMEDIATELY ---
document.getElementById('departmentFilter').addEventListener('change', applyFilters);
document.getElementById('positionFilter').addEventListener('change', applyFilters);

// --- RESET BUTTON ---
document.getElementById('resetBtn').addEventListener('click', resetFilters);

// --- DELETE CONFIRMATION ---
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const employeeName = btn.getAttribute('data-employee-name');
        if (confirm(`Are you sure you want to delete "${employeeName}"?`)) {
            btn.closest('.delete-form').submit();
        }
    });
});
</script>





<?php require base_path("views/partials/footer.php") ?>