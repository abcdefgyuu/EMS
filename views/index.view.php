 <?php require("partials/head.php") ?>

  <main class="bg-gradient-to-br from-indigo-300 via-purple-300 to-pink-300 min-h-screen flex items-center justify-center">
    <div class="mx-auto bg-white rounded-xl shadow-xl p-8 w-[90%] max-w-sm md:max-w-lg transform transition-transform duration-300">
      <div class="text-center mb-6">
        <svg class="mx-auto h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 01-8 0m8 0a4 4 0 00-8 0m8 0v1a4 4 0 01-8 0v-1m8 0a4 4 0 00-8 0m8 0v1a4 4 0 01-8 0v-1" />
        </svg>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">Welcome Back</h2>
        <p class="text-sm text-gray-500">Please sign in to your account</p>
      </div>
      <form class="space-y-5">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="you@example.com" required />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="••••••••" required />
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200">Sign In</button>
      </form>
      <p class="mt-2 text-xs text-red-600">
        Don't have an account?
      </p>
    </div>
  </main>

 
 <?php require("partials/footer.php") ?>