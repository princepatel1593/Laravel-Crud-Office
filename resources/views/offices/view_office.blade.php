<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Management Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        
    </style>
</head>
<body class="bg-light">
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Title and Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Office Management</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('site.view') }}" class="btn btn-outline-primary "> Sites</a>
            <a href="{{ route('block.view') }}" class="btn btn-outline-primary"> Blocks</a>
            <a href="{{ route('floor.view') }}" class="btn btn-outline-primary"> Floors</a>
            <a href="{{ route('office.create') }}" class="btn btn-primary "></i> Add Office</a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Office List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="officeTable" class="table table-bordered table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Site Name</th>
                            <th>Block Name</th>
                            <th>Floor Number</th>
                            <th>Office Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
    var table = $('#officeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('office.data') }}',
        columns: [
            { data: 'site_name', name: 'site_name' },
            { data: 'block_name', name: 'block_name' },
            { data: 'floor_name', name: 'floor_name' },
            { data: 'office_name', name: 'office_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    // Delete Office AJAX
    $(document).on('click', '.delete-btn', function () {
        var officeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this office?')) {
            $.ajax({
                url: '/offices/' + officeId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.success);
                    table.ajax.reload();
                },
                error: function () {
                    alert('An error occurred while deleting the office.');
                }
            });
        }
    });
});
</script>

</body>
</html>
