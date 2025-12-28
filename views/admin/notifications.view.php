<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<!-- Main Card -->
<div class="inner pt-24">


  <h2 class="text-xl font-semibold flex items-center mb-4">
    Pending Requests <span class="px-3 py-1 bg-white/20 rounded-full text-sm">(5)</span>
  </h2>


  <div>
    <!-- Empty State -->
    <!-- Uncomment this block if there are no requests -->
    <!--
        <div class="text-center py-12">
          <i class="fas fa-calendar-check text-6xl text-gray-300 mb-4"></i>
          <p class="text-xl text-gray-600">No pending leave requests.</p>
          <p class="text-gray-500 mt-2">All requests have been processed.</p>
        </div>
        -->

    <!-- Requests Table -->
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Employee</th>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Type</th>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Dates</th>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Reason</th>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Requested On</th>
            <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">

          <?php foreach ($requests as $req): ?>
            <tr class="hover:bg-gray-50 transition duration-200">
              <td class="px-6 py-5"><?= htmlspecialchars($req['employee_name']) ?></td>
              <td class="px-6 py-5"><?= htmlspecialchars($req['leave_type_name']) ?></td>
              <td class="px-6 py-5">
                <?php if ($req['request_type'] === 'Single'): ?>
                  <?= $req['leave_date'] ?>
                <?php else: ?>
                  <?= $req['from_date'] ?> to <?= $req['to_date'] ?>
                <?php endif; ?>
              </td>
              <td class="px-6 py-5"><?= htmlspecialchars($req['reason']) ?></td>
              <td class="px-6 py-5"><?= date('M d, Y', strtotime($req['requested_at'])) ?></td>
              <td class="px-6 py-5 text-center">
                <!-- Approve Button -->
                <form action="/leave/approve" method="POST" class="inline">
                  <input type="hidden" name="request_id" value="<?= $req['request_id'] ?>">
                  <button type="submit" name="action" value="approve"
                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transform hover:scale-105 transition duration-200 shadow-md inline-flex items-center">
                    <i class="fas fa-check mr-1"></i> Approve
                  </button>
                </form>

                <!-- Reject Button - Triggers Modal -->
                <button type="button"
                  onclick="openRejectModal(<?= $req['request_id'] ?>)"
                  class="ml-3 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transform hover:scale-105 transition duration-200 shadow-md inline-flex items-center">
                  <i class="fas fa-times mr-1"></i> Reject
                </button>
              </td>
            </tr>
          <?php endforeach; ?>

          <!-- Reject Modal -->
          <div id="rejectModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Leave Request</h3>
              <form action="/leave/approve" method="POST">
                <input type="hidden" name="request_id" id="reject_request_id">
                <input type="hidden" name="action" value="reject">

                <div class="mb-4">
                  <label for="admin_comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Admin Comment <span class="text-red-500">*</span>
                  </label>
                  <textarea name="admin_comment" id="admin_comment" rows="4" required
                    placeholder="Enter reason for rejection..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                  <button type="button" onclick="closeRejectModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                  </button>
                  <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Confirm Reject
                  </button>
                </div>
              </form>
            </div>
          </div>

        </tbody>
      </table>
    </div>

    <?php if (!empty($_SESSION["success"])): ?>
      <div class="toast-success"><?= $_SESSION["success"] ?></div>
      <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
      <?php pagination($currentPage, $totalPages, '/admin/notifications'); ?>
    <?php endif; ?>
  </div>

</div>

<script>
  function openRejectModal(requestId) {
    document.getElementById('reject_request_id').value = requestId;
    document.getElementById('admin_comment').value = '';
    document.getElementById('rejectModal').classList.remove('hidden');
  }

  function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
  }

  // Optional: Close modal when clicking outside
  document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
  });
</script>

<?php require base_path("views/partials/footer.php") ?>