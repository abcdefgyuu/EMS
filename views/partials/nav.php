  <header>
    <div class="flex justify-between items-center">
      <div class="flex items-center">
        <div class="menu-bar">
          <span class="line line-01"></span>
          <span class="line line-02"></span>
          <span class="line line-03"></span>
        </div>
        <div class="text-[1rem] md:text-xl font-bold">
          Employee Management System
        </div>
      </div>
      <div class="flex">
        <p><?= $_SESSION['user']['username'] ?></p>
        <!-- Profile dropdown -->
        <el-dropdown class="relative ml-3">
          <button class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Open user menu</span>
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
          </button>

          <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden">Your profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden">Settings</a>
            <form method="POST" action="/sessions">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 focus:bg-gray-100 focus:outline-none">Log Out</button>
            </form>
          </el-menu>
        </el-dropdown>
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