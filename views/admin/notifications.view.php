<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<!-- Main Card -->
<div class="inner">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-rose-600 to-pink-600 px-6 py-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-envelope-open-text mr-3"></i>
                Pending Requests <span class="ml-2 px-3 py-1 bg-white/20 rounded-full text-sm">(5)</span>
            </h2>
        </div>

        <div class="p-6 md:p-8">
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
                                <td class="px-6 py-5">  <?= htmlspecialchars($req['employee_name']) ?>  </td>
                                <td class="px-6 py-5">  <?= htmlspecialchars($req['leave_type_name']) ?>  </td>
                                <td class="px-6 py-5">
                                    <?php if ($req['request_type'] === 'Single'): ?>
                                        <?= $req['leave_date'] ?>
                                    <?php else: ?>
                                        <?= $req['from_date'] ?> to <?= $req['to_date'] ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">  <?= htmlspecialchars($req['reason']) ?>  </td>
                                <td class="px-6 py-5">  <?= date('M d, Y', strtotime($req['requested_at'])) ?>  </td>
                                <td class="px-6 py-5 text-center">
                                    <form action="/admin/leave/approve" method="POST" class="inline">
                                        <input type="hidden" name="request_id" value="<?= $req['request_id'] ?>">
                                        <button type="submit" name="action" value="approve" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transform hover:scale-105 transition duration-200 shadow-md inline-flex items-center">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                    </form>
                                    <form action="/admin/leave/approve" method="POST" class="inline ml-2">
                                        <input type="hidden" name="request_id" value="<?= $req['request_id'] ?>">
                                        <button type="submit" name="action" value="reject" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transform hover:scale-105 transition duration-200 shadow-md inline-flex items-center">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Add more rows as needed -->

                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="mt-6 flex items-center justify-between text-sm text-gray-600">
                <p>Showing 1 to 5 of 12 requests</p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100">Previous</button>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require base_path("views/partials/footer.php") ?>