<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>

  <!-- Header -->
  @include('layouts.header')

  <!-- Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <!-- Main content here -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Date & Customer</h5>

              <!-- Add your select elements here -->
              <div class="row mb-3">
                <div class="col-md-3">
                  <label for="dateInput">Select Month</label>
                  {{-- <input type="date" id="dateInput" class="form-control"> --}}
                  <select id="monthSelect" class="form-control">
                    @foreach ($months as $month)
                      <option value="{{ $month->format('Y-m') }}">{{ $month->format('F Y') }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="custSelect">Select Customer</label>
                  <select id="custSelect" class="form-control">
                    @foreach ($customers as $customer)
                      <option value="{{ $customer->username }}">{{ $customer->username }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <!-- Line Chart -->
              <div id="reportsChart"></div>
            </div>
          </div>

          <!-- STO Report Card -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">STO Report</h5>
              <canvas id="reportSTOChart" style="min-height: 400px;" class=""></canvas>
            </div>
          </div>

          <!-- Inventory Report Card -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Report Daily Stock FG</h5>
              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      let reportSTOChart;

      document.addEventListener("DOMContentLoaded", () => {
        // Initialize stoChart
        let ctx = document.getElementById("reportSTOChart").getContext("2d");
        reportSTOChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: [],
            datasets: [{
              label: "Total Inventory",
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
              data: []
            }]
          }
        });

        // Fetch data when the dropdown changes
        $("#monthSelect").on("change", function() {
          updateChart()
        });

        $("#custSelect").on("change", function() {
          updateChart()
        });

        updateChart();

        function updateChart() {
          let selectedMonth = $("#monthSelect").val();
          let selectedCustomer = $("#custSelect").val();

          fetchReportData(selectedMonth, selectedCustomer);
        }

        // Function to fetch data and update the chart
        function fetchReportData(month, cust) {
          $.ajax({
            url: "/fetch-report-sto",
            type: "GET",
            data: {
              month: month,
              customer: cust,
            },
            success: function(response) {

              updateChartData(response);
            },
            error: function() {
              alert("Failed to fetch data.");
            }
          });
        }

        // Function to update the chart with new data
        function updateChartData(data) {
          let labels = data.map(item => item.inventory.part_name);
          let values = data.map(item => item.total);

          reportSTOChart.data.labels = labels;
          reportSTOChart.data.datasets[0].data = values;
          reportSTOChart.update();
        }
      });
    </script>
    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
  </main><!-- End #main -->

  <!-- End Main Content -->

  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>

  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if (session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
      });
    </script>
  @endif

</body>

</html>
