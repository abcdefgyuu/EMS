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
        <?php

        // Only show notification bell for admin
        // if ($_SESSION['user']['role'] === 'Admin') { ?>
          <?php $pending_count = pending_count(); ?>
          <!-- Notification Bell (Tailwind-only SVG icon) -->
          <?php if ($_SESSION['user']['role'] === 'Admin') : ?>
          <a href="/admin/notifications"
            class="relative p-2 rounded-full hover:bg-gray-100 transition"
            title="Pending Leave Requests">

            <!-- SVG Bell Icon (pure Tailwind-styled) -->
            <svg xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-700"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            
            <?php if ($pending_count > 0): ?>
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full 
                  w-5 h-5 flex items-center justify-center shadow-md">
                <?= $pending_count ?>
              </span>
          
            <?php endif; ?>
          </a>
            <?php endif; ?>
        <?php //} ?>

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

            <a href="/reset-password"
              class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
              <i class="fas fa-user text-indigo-600"></i>
              Reset Password
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
       <?php if ($_SESSION['user']['role'] === 'Admin') : ?>
      <li><a href="/admin/notifications">Notifications</a></li>
      <?php endif; ?>
    </ul>
    <div class="muted">&copy; Company</div>
  </nav>