<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>


<main>
  <div class="bg-neutral-100 pt-24 min-h-screen">
    <div class="inner">

      <form method="POST" action="/employees" class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Employee</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Column 1 -->
          <div class="space-y-4">
            <!-- Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
              <?php if (!empty($errors['name'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['name'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Position -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Position</label>
              <input type="text" name="position" value="<?= htmlspecialchars($_POST['position'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['position'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['position'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Department -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Department</label>
              <input type="text" name="department" value="<?= htmlspecialchars($_POST['department'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['department'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['department'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Join Date -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Join Date</label>
              <input type="date" name="join_date" value="<?= htmlspecialchars($_POST['join_date'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['join_date'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['join_date'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['email'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['email'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Graduate University -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Graduate University</label>
              <input type="text" name="graduate_university" value="<?= htmlspecialchars($_POST['graduate_university'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['graduate_university'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['graduate_university'] ?></p>
              <?php endif; ?>
            </div>

             <!-- Graduate Degree -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Graduate Degree</label>
              <input type="text" name="graduate_degree" value="<?= htmlspecialchars($_POST['graduate_degree'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['graduate_degree'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['graduate_degree'] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <!-- Column 2 -->
          <div class="space-y-4">
           

            <!-- DOB -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
              <input type="date" name="DOB" value="<?= htmlspecialchars($_POST['DOB'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['DOB'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['DOB'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Gender -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Gender</label>
              <input type="text" name="gender" value="<?= htmlspecialchars($_POST['gender'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['gender'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['gender'] ?></p>
              <?php endif; ?>
            </div>

            <!-- NRC No -->
            <div>
              <label class="block text-sm font-medium text-gray-700">NRC No</label>
              <input type="text" name="nrc_no" value="<?= htmlspecialchars($_POST['nrc_no'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['nrc_no'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['nrc_no'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Address -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Address</label>
              <textarea name="address"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
              <?php if (!empty($errors['address'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['address'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Phone</label>
              <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['phone'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['phone'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Religion -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Religion</label>
              <input type="text" name="religion" value="<?= htmlspecialchars($_POST['religion'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['religion'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['religion'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Bank Account -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Bank Account</label>
              <input type="text" name="bank_account" value="<?= htmlspecialchars($_POST['bank_account'] ?? '') ?>"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:outline-none">
              <?php if (!empty($errors['bank_account'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= $errors['bank_account'] ?></p>
              <?php endif; ?>
            </div>

          </div>
        </div>
        <button type="submit" class="w-1/2 mx-auto mt-8 block bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200">Register</button>
      </form>

    </div>
  </div>
</main>

<?php require base_path("views/partials/footer.php") ?>