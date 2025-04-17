{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Management Main Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        .card-header {
            background-color: #f0f0f0;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f9f9f9;
            color: #333;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Title and Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Office Management</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('site.view') }}" class="btn btn-outline-secondary">View Sites</a>
            <a href="{{ route('block.view') }}" class="btn btn-outline-secondary">View Blocks</a>
            <a href="{{ route('floor.view') }}" class="btn btn-outline-secondary">View Floors</a>
            <a href="{{ route('office.create') }}" class="btn btn-outline-secondary">Add Office</a>
        </div>
    </div>

    <!-- Card with Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Office List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="officeTable" class="table table-bordered text-center align-middle m-0 bg-white">
                    <thead>
                        <tr>
                            <th>Site Name</th>
                            <th>Block Name</th>
                            <th>Floor Number</th>
                            <th>Office Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Scripts -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#officeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('office.data') }}',
            columns: [
                { data: 'site_name', name: 'site_name' },
                { data: 'block_name', name: 'block_name' },
                { data: 'floor_name', name: 'floor_name' },
                { data: 'office_name', name: 'office_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.edit-office', function () {
            var officeId = $(this).data('id');

            $.ajax({
                url: '/offices/' + officeId + '/edit',
                type: 'GET',
                success: function (response) {
                    // Replace main content with the edit form
                    $('#mainContent').html(response);
                },
                error: function () {
                    alert('Failed to load office edit form.');
                }
            });
        });

        // Optional: You can handle Edit/Delete button actions here
        // $('.edit-office').on('click', function() { ... });
    });
</script>
</body>
</html> --}}
