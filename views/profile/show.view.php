<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>

<main>
  <div class="bg-neutral-100 pt-20 pb-12 min-h-screen">
      <div class="inner">
        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-8">
          <div class="relative px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
              <div class="bg-white rounded-full p-2 shadow-xl">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-600 border-4 border-white rounded-full flex items-center justify-center text-4xl font-bold text-white shadow-lg">
                  <?php
                  $parts = explode(' ', $profile['name'] ?? '');
                  $firstInitial = strtoupper(substr($parts[0] ?? '', 0, 1));
                  $secondInitial = strtoupper(substr($parts[1] ?? '', 0, 1));
                  echo $firstInitial . $secondInitial;
                  ?>
                </div>
              </div>
              <div class="text-center sm:text-left">
                <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($profile['name']) ?></h1>
                <p class="text-xl text-gray-600 mt-1"><?= htmlspecialchars($profile['position']) ?></p>
                <div class="flex flex-wrap gap-4 mt-3 justify-center sm:justify-start text-sm text-gray-500">
                  <span class="inline-flex items-center gap-2">
                    <i class="fas fa-id-badge"></i> <?= htmlspecialchars($profile['employee_code']) ?>
                  </span>
                  <span class="inline-flex items-center gap-2">
                    <i class="fas fa-building"></i> <?= htmlspecialchars($profile['department']) ?>
                  </span>
                  <span class="inline-flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> Joined <?= date('M d, Y', strtotime($profile['join_date'])) ?>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Details Grid -->
        <div class="mt-8 grid gap-6 md:grid-cols-2">

          <!-- Left Column: Personal Information -->
          <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 flex items-center gap-2">
              <i class="fas fa-user text-blue-600"></i> Personal Information
            </h2>

            <div class="mt-6 space-y-4 text-sm">
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Full Name</span>
                <span class="text-gray-900"><?= htmlspecialchars($profile['name']) ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Date of Birth</span>
                <span class="text-gray-900"><?= $profile['DOB'] ? date('F d, Y', strtotime($profile['DOB'])) : '—' ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Gender</span>
                <span class="text-gray-900"><?= htmlspecialchars($profile['gender'] ?? 'Not specified') ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Religion</span>
                <span class="text-gray-900"><?= htmlspecialchars($profile['religion'] ?? '—') ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">NRC Number</span>
                <span class="text-gray-900 font-mono"><?= htmlspecialchars($profile['nrc_no'] ?? '—') ?></span>
              </div>
              <div class="flex justify-between py-3">
                <span class="font-medium text-gray-600">Address</span>
                <span class="text-gray-900 text-right max-w-xs"><?= htmlspecialchars($profile['address'] ?? '—') ?></span>
              </div>
            </div>
          </div>

          <!-- Right Column: Professional & Contact Info -->
          <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 flex items-center gap-2">
              <i class="fas fa-briefcase text-blue-600"></i> Professional & Contact Info
            </h2>

            <div class="mt-6 space-y-4 text-sm">
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Employee ID</span>
                <span class="text-gray-900 font-mono">#<?= $profile['employee_id'] ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Employee Code</span>
                <span class="text-gray-900 font-mono"><?= htmlspecialchars($profile['employee_code']) ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Position</span>
                <span>
                  <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                    <?= htmlspecialchars($profile['position']) ?>
                  </span>
                </span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Department</span>
                <span>
                  <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                    <?= htmlspecialchars($profile['department']) ?>
                  </span>
                </span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Email</span>
                <span class="text-gray-900 break-all"><?= htmlspecialchars($profile['email']) ?></span>
              </div>
              <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="font-medium text-gray-600">Phone</span>
                <span class="text-gray-900"><?= htmlspecialchars($profile['phone'] ?? '—') ?></span>
              </div>
              <div class="flex justify-between py-3">
                <span class="font-medium text-gray-600">Bank Account</span>
                <span class="text-gray-900 font-mono"><?= htmlspecialchars($profile['bank_account'] ?? '—') ?></span>
              </div>
            </div>
          </div>

          <!-- Education Background (Full Width) -->
          <div class="bg-white rounded-xl shadow-md p-6 md:col-span-2">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 flex items-center gap-2">
              <i class="fas fa-graduation-cap text-blue-600"></i> Education Background
            </h2>
            <div class="grid md:grid-cols-3 gap-8 mt-6 text-sm">
              <div>
                <div class="flex justify-between py-3 border-b border-gray-100">
                  <span class="font-medium text-gray-600">University</span>
                  <span class="text-gray-900"><?= htmlspecialchars($profile['graduate_university'] ?? '—') ?></span>
                </div>
                <div class="flex justify-between py-3">
                  <span class="font-medium text-gray-600">Degree</span>
                  <span class="text-gray-900"><?= htmlspecialchars($profile['graduate_degree'] ?? '—') ?></span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
  </div>
</main>


<?php require base_path("views/partials/footer.php") ?>