<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>


<main>
  <div class="bg-neutral-100 pt-24 min-h-screen pb-20">
    <div class="inner">
      <h2 class="text-2xl font-bold text-center mb-6">Attendance</h2>
      <?php if (!empty($errors['duplicate_attendance'])): ?>
        <p class="text-red-600 text-sm mt-1 text-right pr-2 mb-4 dup-att"><?= $errors['duplicate_attendance'] ?></p>
      <?php endif; ?>
      <!-- Attendance Form Card -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Submit Today's Attendance</h2>
        </div>

        <div class="p-6 md:p-8">
          <form action="/attendance" id="attendanceForm" class="space-y-6" method="POST">
            <!-- Employee Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 rounded-xl p-5">
              <div class="flex items-center space-x-3">
                <i class="fas fa-id-badge text-indigo-600 text-xl"></i>
                <div>
                  <p class="text-sm text-gray-500">Employee Code</p>
                  <p class="font-semibold text-gray-800"><?= $_SESSION['user']['emp_code'] ?></p>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <i class="fas fa-user text-indigo-600 text-xl"></i>
                <div>
                  <p class="text-sm text-gray-500">Name</p>
                  <p class="font-semibold text-gray-800"><?= $_SESSION['user']['username'] ?></p>
                </div>
              </div>
            </div>

            <!-- Location Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
              <label for="status" class="md:text-right font-medium text-gray-700">
                <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                Location Status <span class="text-red-500">*</span>
              </label>
              <div class="md:col-span-2">
                <select id="status" required name="location"
                  class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition duration-200 text-gray-700">
                  <option value="">-- Select Location --</option>
                  <option value="Office">Office</option>
                  <option value="Home">Work from Home</option>
                </select>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
              <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300 shadow-lg">
                <i class="fas fa-check-circle mr-2"></i>
                Submit Attendance
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Attendance History Section -->
      <div class="mt-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-4">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Attendance History</h2>

          <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <!-- Search Input -->
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <input
                type="text"
                id="searchName"
                value="<?= htmlspecialchars($search ?? '') ?>"
                class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                placeholder="Search by name..." />
            </div>

            <!-- Date Filter -->
            <input
              type="date"
              id="dateFilter"
              value="<?= htmlspecialchars($date ?? '') ?>"
              class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />

            <!-- Reset Button -->
            <button id="resetFilters" class="px-4 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
              Reset
            </button>
          </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
              <tr>
                <th class="py-4 text-center text-xs font-medium text-white uppercase tracking-wider">No.</th>
                <th class="py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Date</th>
                <th class="py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Name</th>
                <th class="py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Status</th>
                <th class="py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Location</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <?php if (empty($attendances)): ?>
                <tr>
                  <td colspan="5" class="px-6 py-8 text-center text-gray-500">No attendance records found.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($attendances as $index => $row): ?>
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300"><?= $offset + $index + 1 ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300"><?= htmlspecialchars($row['attendance_date']) ?></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300"><?= htmlspecialchars($row['name']) ?></td>
                    <td class="px-6 py-4">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <?= htmlspecialchars($row['status'] ?? '—') ?>
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <?php
                      $status = $row['type'] ?? 'Present';
                      $badgeClass = match ($status) {
                        'Late' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        'Absent', 'Leave' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        default => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                      };
                      $icon = match ($status) {
                        'Late' => 'fa-exclamation-triangle',
                        'Absent', 'Leave' => 'fa-user-times',
                        default => 'fa-check'
                      };
                      ?>
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $badgeClass ?>">
                        <i class="fas <?= $icon ?> mr-1"></i>
                        <?= ucfirst($status) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

       <?php pagination($currentPage, $totalPages, '/attendance'); ?>
      </div>

      <script>
        // Shared filter application function (same logic as Employees page)
        function applyAttendanceFilters() {
          const search = document.getElementById('searchName').value.trim();
          const date = document.getElementById('dateFilter').value;

          const params = new URLSearchParams();
          if (search) params.set('search', search);
          if (date) params.set('date', date);
          params.set('page', '1');

          window.location = '/attendance?' + params.toString();
        }

        function resetAttendanceFilters() {
          window.location = '/attendance';
        }

        // Event Listeners
        document.getElementById('searchName').addEventListener('keyup', (e) => {
          if (e.key === 'Enter') applyAttendanceFilters();
        });

        document.getElementById('dateFilter').addEventListener('change', applyAttendanceFilters);
        document.getElementById('resetFilters').addEventListener('click', resetAttendanceFilters);
      </script>

      <?php if (!empty($_SESSION["success"])): ?>
        <div class="toast-success"><?= $_SESSION["success"] ?></div>
        <?php unset($_SESSION["success"]); ?>
      <?php endif; ?>

    </div>
</main>


<?php require base_path("views/partials/footer.php") ?>