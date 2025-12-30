<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>

<main class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
 <div class="inner">
   <div class="sm:mx-auto sm:w-full sm:max-w-md pt-10">
    <h2 class="text-xl text-center font-bold text-gray-800">
      Change Your Password
    </h2>
  </div>

  <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <form class="space-y-6" action="/reset-password" method="POST">

        <div>
          <label for="old_password" class="block text-sm font-medium text-gray-700">Old password</label>
          <div class="mt-1">
            <input id="old_password" name="old_password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <?php if (isset($errors['old_password'])): ?>
            <p class="text-xs text-red-600"><?= $errors['old_password'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
          <div class="mt-1">
            <input id="new_password" name="new_password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <?php if (isset($errors['new_password'])): ?>
            <p class="text-xs text-red-600"><?= $errors['new_password'] ?></p>
          <?php endif; ?>
        </div>

         <div>
          <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <div class="mt-1">
            <input id="confirm_password" name="confirm_password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <?php if (isset($errors['confirm_password'])): ?>
            <p class="text-xs text-red-600"><?= $errors['confirm_password'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Change Password
          </button>
        </div>
      </form>
    </div>
  </div>
 </div>
</main>

<?php require base_path("views/partials/footer.php") ?>