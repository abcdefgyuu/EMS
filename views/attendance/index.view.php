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
                  $type = htmlspecialchars($row['type'] ?? '');
                  if ($type === 'Late') {
                    $typeBadge = '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"><i class="fas fa-exclamation-triangle mr-1"></i> Late</span>';
                  } elseif ($type === 'Absent') {
                    $typeBadge = '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-user-times mr-1"></i> Absent</span>';
                  } elseif ($type === 'Leave') {
                    $typeBadge = '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-user-times mr-1"></i> Leave</span>';
                  } else {
                    $typeBadge = '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i> Present</span>';
                  }
                  echo "<tr class=\"hover:bg-gray-50 transition\">";
                  echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-900\">{$i}</td>";
                  echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-900\">{$date}</td>";
                  echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900\">{$name}</td>";
                  echo "<td class=\"px-6 py-4 whitespace-nowrap\"><span class=\"px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800\">{$location}</span></td>";
                  echo "<td class=\"px-6 py-4 whitespace-nowrap\">{$typeBadge}</td>";
                  echo "</tr>";
                  $i++;
                }
              ?>
                <tr id="paginationRow">
                  <td colspan="5" class="px-6 py-4 text-center">
                    <div id="paginationControls" class="inline-flex items-center space-x-2"></div>
                  </td>
                </tr>

                <script>
                  (function() {
                    function initPagination() {
                      var perPage = 10;
                      var $table = $('table').last();
                      var $rows = $table.find('tbody tr').not('#paginationRow');
                      var totalRows = $rows.length;
                      var totalPages = Math.ceil(totalRows / perPage);
                      var $controls = $('#paginationControls');

                      if (totalPages <= 1) {
                        $('#paginationRow').hide();
                        return;
                      }

                      $controls.empty();
                      $controls.append('<button id="pagPrev" class="px-3 py-1 border rounded disabled:opacity-50">Prev</button>');

                      setTimeout(function() {
                        function renderCondensed(cur) {
                          cur = parseInt(cur || $controls.find('.pagPage.active').data('page') || 1, 10);
                          if (totalPages <= 7) {
                            $controls.find('.ellipsis').remove();
                            $controls.find('.pagPage').show();
                            $controls.find('.pagPage').removeClass('active bg-indigo-600 text-white').attr('aria-pressed', 'false');
                            $controls.find('.pagPage[data-page="' + cur + '"]').addClass('active bg-indigo-600 text-white').attr('aria-pressed', 'true');
                            $('#pagPrev').prop('disabled', cur === 1);
                            $('#pagNext').prop('disabled', cur === totalPages);
                            return;
                          }

                          // decide pages to display
                          var pages = [];
                          if (cur <= 4) {
                            pages = [1,2,3,4,5,'...', totalPages];
                          } else if (cur >= totalPages - 3) {
                            pages = [1,'...', totalPages-4, totalPages-3, totalPages-2, totalPages-1, totalPages];
                          } else {
                            pages = [1,'...', cur-1, cur, cur+1, '...', totalPages];
                          }

                          // hide all page buttons then show needed ones and insert ellipses
                          $controls.find('.pagPage').hide();
                          $controls.find('.ellipsis').remove();

                          var lastAfter = $controls.find('#pagPrev');
                          pages.forEach(function(p) {
                            if (p === '...') {
                              $('<span class="ellipsis px-3 py-1 text-sm text-gray-500">...</span>').insertAfter(lastAfter);
                              lastAfter = lastAfter.next();
                            } else {
                              var $btn = $controls.find('.pagPage[data-page="' + p + '"]');
                              if ($btn.length) {
                                $btn.insertAfter(lastAfter).show();
                                lastAfter = $btn;
                              }
                            }
                          });

                          $controls.find('.pagPage').removeClass('active bg-indigo-600 text-white').attr('aria-pressed', 'false');
                          $controls.find('.pagPage[data-page="' + cur + '"]').addClass('active bg-indigo-600 text-white').attr('aria-pressed', 'true').show();
                          $('#pagPrev').prop('disabled', cur === 1);
                          $('#pagNext').prop('disabled', cur === totalPages);
                        }

                        // initial condensed render (page 1)
                        renderCondensed(1);

                        // keep condensed state in sync when users click controls
                        $controls.on('click', '.pagPage', function() {
                          var p = parseInt($(this).data('page'), 10);
                          // allow other handlers (row show) to run first
                          setTimeout(function() { renderCondensed(p); }, 0);
                        });
                        $controls.on('click', '#pagPrev', function() {
                          var cur = parseInt($controls.find('.pagPage.active').data('page') || 1, 10);
                          var next = Math.max(1, cur - 1);
                          setTimeout(function() { renderCondensed(next); }, 0);
                        });
                        $controls.on('click', '#pagNext', function() {
                          var cur = parseInt($controls.find('.pagPage.active').data('page') || 1, 10);
                          var next = Math.min(totalPages, cur + 1);
                          setTimeout(function() { renderCondensed(next); }, 0);
                        });
                      }, 0);
                      for (var p = 1; p <= totalPages; p++) {
                        $controls.append('<button class="pagPage px-3 py-1 border rounded" data-page="' + p + '">' + p + '</button>');
                      }
                      $controls.append('<button id="pagNext" class="px-3 py-1 border rounded">Next</button>');

                      function showPage(page) {
                        var start = (page - 1) * perPage;
                        $rows.hide().slice(start, start + perPage).show();
                        $controls.find('.pagPage').removeClass('active bg-indigo-600 text-white').attr('aria-pressed', 'false');
                        $controls.find('.pagPage[data-page="' + page + '"]').addClass('active bg-indigo-600 text-white').attr('aria-pressed', 'true');
                        $('#pagPrev').prop('disabled', page === 1);
                        $('#pagNext').prop('disabled', page === totalPages);
                      }

                      $controls.on('click', '.pagPage', function() {
                        showPage(parseInt($(this).data('page'), 10));
                      });
                      $controls.on('click', '#pagPrev', function() {
                        var cur = parseInt($controls.find('.pagPage.active').data('page') || 1, 10);
                        if (cur > 1) showPage(cur - 1);
                      });
                      $controls.on('click', '#pagNext', function() {
                        var cur = parseInt($controls.find('.pagPage.active').data('page') || 1, 10);
                        if (cur < totalPages) showPage(cur + 1);
                      });

                      showPage(1);
                    }


                    jQuery(initPagination);

                  })();
                </script>
              <?php
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