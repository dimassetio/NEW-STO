@extends('layouts.user')

@section('contents')
  <div class="container">
    <div class="card mt-4 shadow-lg">
      <div class="card-body p-4">
        <h5>PT Kyouraku Blowmolding Indonesia</h5>
        <p class="text-sm">PPIC Department / Warehouse Section</p>
        <div class="text-center">
          <h5>Inventory Card</h5>
        </div>
        <hr>
        <div class="mt-4">
          <form class="w-100" method="POST" action="{{ route('sto.store', $inventory->inventory_id) }}">
            @csrf
            <!-- Part Name -->
            <div class="mb-3 row">
              <label for="part-name" class="col-md-3 col-form-label">Part Name</label>
              <div class="col-md-9">
                <input type="text" id="part-name" name="part_name" class="form-control" placeholder="Enter part name"
                  value="{{ old('part_name', $inventory->part_name ?? '') }}">
              </div>
            </div>

            <!-- Part Number -->
            <div class="mb-3 row">
              <label for="part-number" class="col-md-3 col-form-label">Part Number</label>
              <div class="col-md-9">
                <input type="text" id="part-number" name="part_number" class="form-control"
                  placeholder="Enter part number" value="{{ old('part_number', $inventory->part_number ?? '') }}">
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">Inventory Code</label>
              <div class="col-md-9">
                <input required hidden type="text" id="inventory-code" name="id_inventory" class="form-control"
                  value="{{ old('id', $inventory->id ?? '') }}">
                <input required type="text" id="inventory-code" name="inventory_id" class="form-control"
                  placeholder="Enter inventory code" value="{{ old('inventory_id', $inventory->inventory_id ?? '') }}">
              </div>
            </div>

            <!-- Inventory Category -->
            <div class="mb-3 row">
              <label for="category" class="col-md-3 col-form-label">Category</label>
              <div class="col-md-9">
                <select class="form-control" id="category" name="category" required>
                  @foreach ($categories as $category)
                    <option value="{{ $category }}"
                      {{ old($category, $inventory->category) == $category ? 'selected' : '' }}>
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
                  $status = old('status', $inventory->status_product ?? '');
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
                    value="{{ old('qty_per_box', $inventory->qty_package ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box" name="qty_box" class="form-control" required
                    placeholder="Enter box quantity">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="total" class="col-form-label">Total</label>
                  <input type="number" id="total" name="total" class="form-control" placeholder="Total" readonly>
                </div>

                <div class="mb-3 col-md-3">
                  <label for="grand_total" class="col-form-label">Grand Total</label>
                  <input required type="number" id="grand_total" name="grand_total" class="form-control"
                    placeholder="Total" readonly>
                </div>
              </div>
              <!-- Second Value -->
              <div class="row">
                <div class="mb-3 col-md-3">
                  {{-- <label for="qty_per_box_2" class="col-form-label">Qty/Box</label> --}}
                  <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control"
                    placeholder="Enter quantity per box" value="{{ old('qty_per_box_2') }}">
                </div>
                <div class="mb-3 col-md-3">
                  {{-- <label for="qty_box_2" class="col-form-label">Qty Box</label> --}}
                  <input type="number" id="qty_box_2" name="qty_box_2" class="form-control"
                    value="{{ old('qty_per_box_2') }}">
                </div>
                <div class="mb-3 col-md-3">
                  {{-- <label for="total_2" class="col-form-label">Total</label> --}}
                  <input type="number" id="total_2" name="total_2" class="form-control" placeholder="Total"
                    value="{{ old('qty_per_box_2') }}" readonly>
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
                  value="{{ old('issued_date') }}">
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
                  value="{{ old('checked_by') }}">
              </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
              <button type="submit" class="btn btn-success w-100 rounded">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#category').on('change', function() {
        var category = $(this).val();
        var initialStatus = "{{ old('status', $inventory->status_product) }}";
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
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
  </script>
@endsection
