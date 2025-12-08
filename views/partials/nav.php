  <header>
    <div class="flex justify-between items-center">
      <div class="flex items-center">
        <div class="menu-bar">
          <span class="line line-01"></span>
          <span class="line line-02"></span>
          <span class="line line-03"></span>
        </div>
        <h1 class="hidden sm:block ml-3 text-lg md:text-xl font-bold text-gray-900">
          Employee Management System
        </h1>
        <span class="sm:hidden ml-2 text-lg font-bold text-gray-900">EMS</span>
      </div>
      
      <div class="flex items-center gap-3">
        <span class="hidden md:block text-sm font-medium text-gray-700">
          <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </span>

        <!-- Profile Dropdown -->
        <div class="relative group">
          <button type="button"
            class="flex items-center focus:outline-none focus:ring-4 focus:ring-indigo-100 rounded-full p-1 transition hover:bg-gray-100">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
              alt="User avatar"
              class="w-9 h-9 rounded-full ring-2 ring-white shadow-md object-cover">

            <!-- Chevron icon -->
            <svg class="w-4 h-4 ml-1 text-gray-600 group-hover:text-gray-900"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 
                opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                focus-within:opacity-100 focus-within:visible 
                transition-all duration-200 ease-out translate-y-1 group-hover:translate-y-0 z-50">

            <!-- User Info Header -->
            <div class="px-4 py-3 border-b border-gray-100">
              <p class="text-sm font-semibold text-gray-900">
                <?= htmlspecialchars($_SESSION['user']['username']) ?>
              </p>
              <p class="text-xs text-gray-500">Employee</p>
            </div>

            <!-- Menu Items -->
            <a href="/profile"
              class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
              <i class="fas fa-user text-indigo-600"></i>
              Your Profile
            </a>

            <form method="POST" action="/sessions" class="w-full">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-left text-red-600 hover:bg-red-50 transition">
                <i class="fas fa-sign-out-alt"></i>
                Log Out
              </button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </header>
  <nav class="sidebar bg-indigo-50">
    <ul class="nav-list">
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/employees">Employees</a></li>
      <li><a href="/attendance">Attendance</a></li>
      <li><a href="/leave">Leave</a></li>
      <li><a href="#settings">Settings</a></li>
    </ul>
    <div class="muted">&copy; Company</div>
  </nav>