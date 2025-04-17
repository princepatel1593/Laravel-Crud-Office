<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Floors</title>

    <!--  Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* Custom styling for the DataTable search and length filters */
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            display: inline-block;
            width: auto;
        }
        .dataTables_wrapper .dataTables_length select {
            width: auto;
            display: inline-block;
        }

        /* Styling for the table row hover effect */
        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Custom success alert box */
        .alert-success {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Buttons on the right side -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('floor.create') }}" class="btn btn-outline-success me-2">Add Floor</a>
        <a href="{{ route('office.view') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <h3 class="mb-4 text-secondary">All Floors</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="floorsTable" class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Site Name</th>
                            <th>Block Name</th>
                            <th>Floor Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#floorsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('floor.data') }}", // This will fetch the data using the route defined
            columns: [
                { data: 'id', name: 'id' },
                { data: 'site_name', name: 'site_name' },
                { data: 'block_name', name: 'block_name' },
                { data: 'floor_name', name: 'floor_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                searchPlaceholder: ""
            }
        });

        // Edit button click handler
        $(document).on('click', '.edit-btn', function () {
            var floorId = $(this).data('id');
            window.location.href = '/floors/' + floorId + '/edit'; // Redirect to edit page
        });

        // Delete button click handler
        $(document).on('click', '.delete-btn', function () {
            var floorId = $(this).data('id');
            if (confirm('Are you sure you want to delete this floor?')) {
                $.ajax({
                    url: '/floors/' + floorId,  // URL to delete floor
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert('Floor deleted successfully!');
                        table.ajax.reload();  // Reload the table data after deletion
                    },
                    error: function () {
                        alert('Failed to delete the floor.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
