@extends('layouts.user')

@section('contents')
  <div class="container">

    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Packing -->
      <form action="{{ route('sto.scan') }}" method="POST" id="stoForm">
        @csrf
        <div class=" mb-2">
          <label for="inventory_id" class="form-label" style="font-size: 1.1rem;">Inventory ID
            (Scan QR)</label>
          <div class="input-group my-2 my-md-3">
            <input type="text" name="inventory_id" class="form-control" id="inventory_id" required autofocus>
            <button class="btn btn-secondary" type="button" id="scanPart" onclick="toggleScanner()">
              <i class="bi bi-camera"></i>
            </button>
          </div>
          <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmit">Show</button>
          <div class="text-center">
            <button class="btn btn-link mt-2 text-white" type="button" id="showFormBtn">
              ID Inventory Kosong? Buat Inventory Baru
            </button>
          </div>
        </div>
        <input type="hidden" name="action" value="show" id="actionField">
        <div class="camera-wrapper mt-3 d-flex flex-col justify-content-center ">
          <div id="reader" style="display: none; max-width: 600px;"></div>
        </div>
      </form>
    </div>

    {{-- STO Form --}}
    <div id="stoFormCard" class="card mt-4 shadow-lg" @if (!isset($report)) style="display: none;" @endif>
      <div class="card-body p-4">
        <h5>PT Kyouraku Blowmolding Indonesia</h5>
        <p class="text-sm">PPIC Department / Warehouse Section</p>
        <div class="text-center">
          <h5>Inventory Card</h5>
        </div>
        <hr>
        <div class="mt-4">
          <form class="w-100" method="POST" action="{{ route('sto.storeNew') }}">
            @csrf
            <!-- Part Name -->
            <div class="mb-3 row">
              <label for="part-name" class="col-md-3 col-form-label">Part Name</label>
              <div class="col-md-9">
                <input type="text" id="part-name" name="part_name" class="form-control" placeholder="Enter part name"
                  value="{{ isset($report) ? $report->inventory->part_name : old('part_name') }}">
              </div>
            </div>

            <!-- Part Number -->
            <div class="mb-3 row">
              <label for="part-number" class="col-md-3 col-form-label">Part Number</label>
              <div class="col-md-9">
                <input type="text" id="part-number" name="part_number" class="form-control"
                  placeholder="Enter part number"
                  value="{{ isset($report) ? $report->inventory->part_number : old('part_number') }}">
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">Inventory Code</label>
              <div class="col-md-9">
                <input type="text" id="inventory-code" name="inventory_code" class="form-control"
                  placeholder="Enter inventory code"
                  value="{{ isset($report) ? $report->inventory_id : old('inventory_code') }}">
              </div>
            </div>

            <!-- Inventory Category -->
            <div class="mb-3 row">
              <label for="category" class="col-md-3 col-form-label">Category</label>
              <div class="col-md-9">
                <select class="form-control" id="category" name="category" required>
                  @foreach ($categories as $category)
                    <option value="{{ $category }}"
                      {{ (isset($report) ? $report->inventory->category : old('category') == $category) ? 'selected' : '' }}>
                      {{ $category }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Status (Radio Buttons) -->
            <div class="mb-3 row">
              <label class="col-md-3 col-form-label">Status</label>
              <div class="col-md-9 d-flex align-items-center status-container">
                @php
                  $status = isset($report) ? $report->status : old('status');
                @endphp
                <!-- Initial status options will be populated by AJAX -->
              </div>
            </div>

            <!-- Qty Detail -->
            <div class="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center">Quantity Details</h6>
              <div class="row">
                <div class="mb-3 col-md-3">
                  <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                  <input type="number" id="qty_per_box" name="qty_per_box" class="form-control"
                    placeholder="Enter quantity per box" required
                    value="{{ isset($report) ? $report->qty_per_box : old('qty_per_box') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box" name="qty_box" class="form-control" required
                    placeholder="Enter box quantity" value="{{ isset($report) ? $report->qty_box : old('qty_box') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="total" class="col-form-label">Total</label>
                  <input type="number" id="total" name="total" class="form-control" placeholder="Total"
                    readonly value="{{ isset($report) ? $report->total : old('total') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="grand_total" class="col-form-label">Grand Total</label>
                  <input required type="number" id="grand_total" name="grand_total" class="form-control"
                    placeholder="Total" readonly
                    value="{{ isset($report) ? $report->grand_total : old('grand_total ') }}">
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-md-3">
                  {{-- <label for="qty_per_box_2" class="col-form-label">Qty/Box</label> --}}
                  <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control"
                    placeholder="Enter quantity per box"
                    value="{{ isset($report) ? $report->qty_per_box_2 : old('qty_per_box_2') }}">
                </div>
                <div class="mb-3 col-md-3">
                  {{-- <label for="qty_box_2" class="col-form-label">Qty Box</label> --}}
                  <input type="number" id="qty_box_2" name="qty_box_2" class="form-control"
                    placeholder="Enter box quantity"
                    value="{{ isset($report) ? $report->qty_box_2 : old('qty_box_2') }}">
                </div>
                <div class="mb-3 col-md-3">
                  {{-- <label for="total_2" class="col-form-label">Total</label> --}}
                  <input type="number" id="total_2" name="total_2" class="form-control" placeholder="Total"
                    value="{{ isset($report) ? $report->total_2 : old('total_2') }}" readonly>
                </div>
                <div class="mb-3 col-md-3">
                  <div class="text-center text-danger p-2">
                    <small>Item Kecil Jika Ada</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex row">
              <!-- Issued Date -->
              <div class="mb-3 col-md-4">
                <label for="issued_date" class="col-form-label">Issued Date</label>
                <input required type="date" id="issued_date" name="issued_date" class="form-control"
                  value="{{ isset($report) ? $report->issued_date->format('Y-m-d') : old('issued_date') }}">
              </div>

              <!-- Prepared By -->
              <div class="mb-3 col-md-4">
                <label for="prepared_by_name" class="col-form-label">Prepared By</label>
                <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
                  value="{{ auth()->id() }}">
                <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
                  placeholder="Enter name" value="{{ Auth::user()->username }}">
              </div>

              <!-- Checked By -->
              <div class="mb-3 col-md-4">
                <label for="checked_by" class="col-form-label">Checked By</label>
                <input type="text" id="checked_by" name="checked_by" class="form-control" placeholder="Enter name"
                  value="{{ isset($report) ? $report->checked_by : old('checked_by') }}">
              </div>
            </div>

            <!-- Submit Button -->
            @if (isset($report))
              <div class="text-center">
                <a href="{{ route('reports.print', $report->id) }}" class="btn btn-success w-100 rounded">Print
                  PDF
                </a>
              </div>
            @else
              <div class="text-center">
                <button type="submit" class="btn btn-success w-100 rounded">Submit</button>
              </div>
            @endif
          </form>
        </div>
      </div>
    </div>

  </div>
@endsection

@section('script')
  <script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 24,
        qrbox: {
          width: 250,
          height: 250
        }
      },
      false
    );

    function toggleScanner() {
      const reader = document.getElementById('reader');
      if (reader.style.display === 'none') {
        reader.style.display = 'block';
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
      } else {
        reader.style.display = 'none';
        html5QrcodeScanner.clear();
      }
    }


    function showLoading() {
      let submitButton = document.querySelector('#btnSubmit');
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Logging in...`;
      submitButton.disabled = true;
    }

    function onScanFailure(error) {
      // console.log(`Code scan error: ${error}`);
    }

    function onScanSuccess(decodedText) {
      let match = decodedText.match(/^(\d+)[A-Za-z]/);
      let extractedNumber = match ? match[1] : decodedText;
      // Set the scanned text to the input field
      document.getElementById('inventory_id').value = extractedNumber;
      // Send the scanned ID card number to the server for validation
      document.getElementById('stoForm').submit();
      showLoading();
    }

    function showLoading() {
      let submitButton = document.querySelector('#btnSubmit');
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Checking Inventory...`;
      submitButton.disabled = true;
    }

    document.getElementById('showFormBtn').addEventListener('click', function() {
      document.getElementById('stoFormCard').style.display = 'block';
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Auto-focus pada input ketika halaman dimuat
      const inventory_id = document.getElementById('inventory_id');
      const form = document.getElementById('autoSubmitForm');

      function calculateTotals() {
        let QtyPerBox2 = parseFloat(document.getElementById("qty_per_box_2").value) || 0;
        let QtyBox2 = parseFloat(document.getElementById("qty_box_2").value) || 0;
        let qtyPerBox = parseFloat(document.getElementById("qty_per_box").value) || 0;
        let qtyBox = parseFloat(document.getElementById("qty_box").value) || 0;

        // Calculate totals
        let Total2 = QtyPerBox2 * QtyBox2;
        let total = qtyPerBox * qtyBox;
        let grandTotal = Total2 + total;

        // Update the input fields
        document.getElementById("total_2").value = Total2;
        document.getElementById("total").value = total;
        document.getElementById("grand_total").value = grandTotal;
      }

      // Attach event listeners to inputs
      let inputs = document.querySelectorAll("#qty_per_box_2, #qty_box_2, #qty_per_box, #qty_box");
      inputs.forEach(input => {
        input.addEventListener("input", calculateTotals);
      });
    });
    // Keep session alive setiap 10 menit
    let sessionAlive = true; // Kendalikan secara global
    setInterval(() => {
      if (!sessionAlive) return;
      fetch('/keep-session-alive').catch(() => sessionAlive = false);
    }, 10 * 60 * 1000);

    $(document).ready(function() {
      $('#category').on('change', function() {
        var category = $(this).val();
        var initialStatus = "{{ isset($report) ? $report->status : old('status ') }}";
        $.ajax({
          url: "{{ url('/get-status') }}/" + encodeURIComponent(category),
          type: 'GET',
          success: function(response) {
            var statusContainer = $('.status-container');
            statusContainer.empty(); // Clear previous options

            if (response.length > 0) {
              response.forEach(function(status) {
                var checked = (status === initialStatus) ? 'checked' : '';
                var radioInput = `
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="status" id="${status}" value="${status}" ${checked}>
                                    <label class="form-check-label" for="${status}">${status}</label>
                                </div>
                            `;
                statusContainer.append(radioInput);
              });
            } else {
              statusContainer.append('<p>No status options available</p>');
            }
          }
        });
      });

      // Trigger change event to load initial status when the page loads
      $('#category').trigger('change');
    });
  </script>
@endsection
