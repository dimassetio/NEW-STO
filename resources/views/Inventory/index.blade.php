@extends('layouts.app')

@section('title', 'Data Inventory')

@section('content')
  <div class="pagetitle">
    <h1>Inventory</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active"> Data Inventory</li>
      </ol>
    </nav>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('errorRows'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Some rows failed to import:</strong>
      <ul>
        @foreach (session('errorRows') as $errorRow)
          <li>
            Row: {{ json_encode($errorRow['row']) }}<br>
            Errors: {{ implode(', ', $errorRow['errors']) }}
          </li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Inventory List</h5>

        <div class="row">
          <div class="col-md-6">
            <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">
              <i class="fas fa-plus"></i> Create New Inventory
            </a>

            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
              <i class="fas fa-file-excel"></i> Import Excel Inventory
            </button>
          </div>

          <div class="col-md-3 ">
          </div>

          <div class="col-md-3 ">
            <select class="form-control" id="category" name="category" required>
              @foreach ($categories as $category)
                <option value="{{ $category }}" {{ old($category) == $category ? 'selected' : '' }}>
                  {{ $category }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle datatable">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Inventory ID</th>
                <th>Part Name</th>
                <th>Part Number</th>
                <th>Type Package</th>
                <th>Qty/Box</th>
                <th>Status Product</th> <!-- Moved Status Product column -->
                <th>Project</th>
                <th>Customer</th>
                <th>Detail Lokasi</th>
                <th>Unit</th>
                <th>Stok Awal</th>
                <th>Plant</th>
                <th>Actions</th> <!-- Added Actions column -->
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Inventory from Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="importForm" action="{{ route('inventory.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="file" class="form-label">Upload Excel File</label>
              <input type="file" name="file" class="form-control" id="file" required accept=".xls,.xlsx">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Import</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmDelete(id) {
      if (confirm('Are you sure you want to delete this item?')) {
        document.getElementById('delete-form-' + id).submit();
      }
    }
  </script>
@endsection


@section('script')
  <script>
    $(document).ready(function() {
      function loadTableData(category) {
        $.ajax({
          url: "{{ route('inventory.data') }}", // Define this route in web.php
          type: 'GET',
          data: {
            category: category
          },
          success: function(data) {
            var tbody = $('.datatable tbody');
            tbody.empty(); // Clear existing data

            if (data.length > 0) {
              $.each(data, function(index, item) {
                tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.inventory_id}</td>
                                <td>${item.part_name}</td>
                                <td>${item.part_number}</td>
                                <td>${item.type_package}</td>
                                <td>${item.qty_package}</td>
                                <td>${item.status_product}</td>
                                <td>${item.project}</td>
                                <td>${item.customer}</td>
                                <td>${item.detail_lokasi}</td>
                                <td>${item.satuan}</td>
                                <td>${item.stok_awal}</td>
                                <td>${item.plant}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/inventory/${item.id}/edit" class="btn btn-primary me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="/inventory/destroy/${item.id}" method="POST"
                                            id="delete-form-${item.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(${item.id})" class="btn btn-danger">
                                                <i class="bi bi-trash3"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `);
              });
            } else {
              tbody.append(`<tr><td colspan="14" class="text-center">No data available</td></tr>`);
            }
          }
        });
      }

      // Trigger table reload on category change
      $('#category').change(function() {
        var selectedCategory = $(this).val();
        loadTableData(selectedCategory);
      });

      // Load initial table data based on the preselected category
      var initialCategory = $('#category').val();
      loadTableData(initialCategory);
      console.log(initialCategory);
    });
  </script>
@endsection
