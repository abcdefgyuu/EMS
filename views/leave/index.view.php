<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>

<main>
    <div class="bg-neutral-100 pt-24 pb-8 min-h-screen">
      <div class="inner">
        <h2 class="text-2xl font-bold text-center mb-6">Leave Application</h2>

        <!-- Leave Balance Display -->
        <p class="font-medium mb-2">Leave Balance</p>
        <div class="flex gap-3">
          <div class="flex-1 bg-indigo-100 border border-indigo-300 p-2 rounded-md text-center">
            <span class="text-sm block">Annual</span>
            <strong class="text-lg">10</strong>
          </div>
          <div class="flex-1 bg-indigo-100 border border-indigo-300 p-2 rounded-md text-center">
            <span class="text-sm block">Sick</span>
            <strong class="text-lg">30</strong>
          </div>
          <div class="flex-1 bg-indigo-100 border border-indigo-300 p-2 rounded-md text-center">
            <span class="text-sm block">Casual</span>
            <strong class="text-lg">6</strong>
          </div>
        </div>


        <!-- Leave Request Form -->
        <div class="mt-6 mx-auto bg-white rounded-xl shadow-xl p-4 md:p-8 max-w-3xl">
          <form class="space-y-6">

            <!-- Leave Type -->
            <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4">
              <label for="leaveType" class="1/2 md:w-1/4 font-medium">Type of Leave</label>
              <select id="leaveType"
                class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="" selected disabled>Select Type</option>
                <option value="single">Single</option>
                <option value="long-term">Long Term</option>
              </select>
            </div>

            <!-- Single Date Picker -->
            <div id="singleDate" class="flex items-center justify-between md:justify-start gap-2 md:gap-4 hidden">
              <label for="date" class="1/2 md:w-1/4 font-medium">Date</label>
              <input type="date" id="date"
                class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>

            <!-- Long Term Date Picker -->
            <div id="longTermDates" class="hidden">
              <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4">
                <label class="1/2 md:w-1/4 font-medium">Start Date</label>
                <input type="date" id="startDate"
                  class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              </div>
              <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4 mt-4">
                <label class="1/2 md:w-1/4 font-medium">End Date</label>
                <input type="date" id="endDate"
                  class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              </div>
            </div>

            <!-- Reason -->
            <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4">
              <label for="reason" class="1/2 md:w-1/4 font-medium">Reason</label>
              <textarea id="reason" rows="3"
                class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
              <button type="submit"
                class="w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Request Leave
              </button>
            </div>

          </form>
        </div>


        <!-- Leave History Table -->
        <!--<h3>Leave History</h3>
        <table>
          <thead>
            <tr>
              <th>Type</th>
              <th>Date / Duration</th>
              <th>Reason</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Annual</td>
              <td>2025-09-01</td>
              <td>Family trip</td>
              <td>Approved</td>
            </tr>
            <tr>
              <td>Sick</td>
              <td>2025-08-22</td>
              <td>Fever</td>
              <td>Pending</td>
            </tr>
          </tbody>
        </table>-->
      </div>
    </div>
  </main>

  <script>
 $(document).ready(function () {
  $("#leaveType").on("change", function () {
    const type = $(this).val();

    if (type === "single") {
      $("#singleDate").removeClass("hidden");
      $("#longTermDates").addClass("hidden");
    } else if (type === "long-term") {
      $("#singleDate").addClass("hidden");
      $("#longTermDates").removeClass("hidden");
    } else {
      $("#singleDate, #longTermDates").addClass("hidden");
    }
  });
});

  </script>


<?php require base_path("views/partials/footer.php") ?>