 <?php require("partials/head.php") ?>
 <?php require("partials/nav.php") ?>
 <main>
   <div class="min-h-screen bg-neutral-100 flex items-center justify-center pt-20 md:pt-0">
     <div class="inner">
       <section class="overview">
         <div class="card">
           <h2 class="text-lg md:text-xl font-bold">Overview</h2>
           <p class="muted">Quick snapshot of employee stats</p>
           <div class="md:flex md:justify-between md:flex-wrap">
             <div class="card card-md mt-4">
               <strong>1,248</strong>
               <span class="muted">Total employees</span>
             </div>
             <div class="card card-md mt-4">
               <strong>12</strong>
               <span class="muted">Absent Today</span>
             </div>
             <div class="card card-md mt-4">
               <strong>1</strong>
               <span class="muted">New this Month</span>
             </div>
           </div>
         </div>
       </section>

       <div class="flex flex-wrap items-stretch mt-8">
         <div class="card-sm">
           <a href="/employees" class="card h-full" style="background: linear-gradient(45deg, #38bdf8 0%, #3b82f6 100%);">
             <h3 class="text-lg md:text-xl font-bold text-center text-white mb-1 md:mb-3">Employees</h3>
             <p class="muted text-center text-white">Get to know your colleaugues.</p>
           </a>
         </div>
         <div class="card-sm">
           <a href="/attendance" class="card h-full" style="background: linear-gradient(160deg, #38bdf8 0%, #3b82f6 100%);">
             <h3 class="text-lg md:text-xl font-bold text-center text-white mb-1 md:mb-3">Attendance</h3>
             <p class="muted text-center text-white">Report that you are working.</p>
           </a>
         </div>
         <div class="card-sm">
           <a href="/leave" class="card h-full" style="background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);">
             <h3 class="text-lg md:text-xl font-bold text-center text-white mb-1 md:mb-3">Leave</h3>
             <p class="muted text-center text-white">Apply for leave and track status.</p>
           </a>
         </div>
         <div class="card-sm">
           <a href="#" class="card h-full" style="background: linear-gradient(45deg, #38bdf8 0%, #3b82f6 100%);">
             <h3 class="text-lg md:text-xl font-bold text-center text-white mb-1 md:mb-3">Payroll</h3>
             <p class="muted text-center text-white">This is what you've been waiting for.</p>
           </a>
         </div>
       </div>
       <?php if (!empty($_SESSION["success"])): ?>
         <div class="toast-success"><?= $_SESSION["success"] ?></div>
         <?php unset($_SESSION["success"]); ?>
       <?php endif; ?>
     </div>
   </div>
 </main>


 <?php require("partials/footer.php") ?>