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
                  <p class="font-semibold text-gray-800"><?= $_SESSION['user']['code'] ?></p>
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

      <!-- Attendance History Table -->
      <div class="mt-10 overflow-hidden">
        <h2 class="text-lg font-semibold text-indigo-500 mb-3">Attendance History</h2>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">No.</th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Name</th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Location</th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php
                // Select source rows: admins see allAttendances, others see their own $attendances
                $source = (isset($_SESSION['user']['role']) && strtolower($_SESSION['user']['role']) === 'admin') ? ($allAttendances ?? []) : ($attendances ?? []);

                // Normalize $source into an array of rows (handle single row or none)
                $rows = [];
                if (!empty($source)) {
                  if (array_values($source) === $source) {
                    $rows = $source; // already indexed array
                  } else {
                    $rows = [$source];
                  }
                }

                if (empty($rows)) {
                  echo '<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No attendance history found.</td></tr>';
                } else {
                  $i = 1;
                  foreach ($rows as $row) {
                    $date = htmlspecialchars($row['attendance_date'] ?? $row['date'] ?? '');
                    // For admins show employee identifier, for others show logged-in username
                    if (isset($_SESSION['user']['role']) && strtolower($_SESSION['user']['role']) === 'admin') {
                      $name = htmlspecialchars($row['name']);
                    } else {
                      $name = htmlspecialchars($_SESSION['user']['username']);
                    }
                    $location = htmlspecialchars($row['status'] ?? $row['location'] ?? '—');
                    $type = $row['type'] ?? '';
                    $typeBadge = ($type === 'Late') ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"><i class="fas fa-exclamation-triangle mr-1"></i> Late</span>' : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i> Present</span>';
                    echo "<tr class=\"hover:bg-gray-50 transition\">";
                    echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-900\">{$i}</td>";
                    echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-900\">{$date}</td>";
                    echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900\">{$name}</td>";
                    echo "<td class=\"px-6 py-4 whitespace-nowrap\"><span class=\"px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800\">{$location}</span></td>";
                    echo "<td class=\"px-6 py-4 whitespace-nowrap\">{$typeBadge}</td>";
                    echo "</tr>";
                    $i++;
                  }
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <?php if (!empty($_SESSION["success"])): ?>
        <div class="toast-success"><?= $_SESSION["success"] ?></div>
        <?php unset($_SESSION["success"]); ?>
      <?php endif; ?>

    </div>
</main>


<?php require base_path("views/partials/footer.php") ?>