<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>


<main>
  <div class="bg-neutral-100 pt-24 min-h-screen">
    <div class="inner">
      <h2 class="text-2xl font-bold text-center mb-6">Attendance</h2>

      <!-- Attendance Form -->

      <div class="mt-6 mx-auto bg-white rounded-xl shadow-xl p-4 md:p-8 max-w-3xl">
        <form id="attendanceForm" class="space-y-4">
          <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4">
            <p class="1/2 md:w-1/4 font-medium">Employee ID:1</p>
            <p class="w-2/3 md:w-1/2">Name: John Doe</p>
          </div>

          
            <!--<div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" required>
          </div>-->
            <div class="flex items-center justify-between md:justify-start gap-2 md:gap-4">
              <label for="status" class="1/2 md:w-1/4 font-medium">Location Status</label>
              <select id="status" required class="w-2/3 md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Status</option>
                <option value="Present">Office</option>
                <option value="Absent">Home</option>
              </select>
            </div>
   

          <button type="submit" class="block mx-auto w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200">Submit Attendance</button>
        </form>
      </div>

      <!-- Attendance Table -->
      <table id="attendanceTable" class="mt-6">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="attendanceBody">
          <tr>
            <td>1</td>
            <td>Dummy</td>
            <td>2023-01-01</td>
            <td>Office</td>
            <td>Present</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Dummy</td>
            <td>2023-01-01</td>
            <td>Present</td>
            <td>Present</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Dummy</td>
            <td>2023-01-01</td>
            <td>Present</td>
            <td>Present</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</main>


<?php require base_path("views/partials/footer.php") ?>