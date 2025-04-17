<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Block</title>

    <!--  Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!--  jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--  Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!--  DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
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
        <a href="{{ route('block.create') }}" class="btn btn-outline-success me-2">Add Block</a>
        <a href="{{ route('office.view') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <h3 class="mb-4 text-secondary">All Blocks</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="blockTable" class="table table-striped table-bordered table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Site Name</th>
                            <th>Block Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable will populate rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- DataTable & Alert Script -->
<script>
    $(document).ready(function () {
        const table = $('#blockTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('block.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'site.site_name', name: 'site.site_name' },
                { data: 'block_name', name: 'block_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6 text-end"p>>',
            language: {
                searchPlaceholder: "Search blocks..."
            }
        });

        // Auto-dismiss success alert
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);

        // Delete block via AJAX
        $(document).on('click', '.delete-block', function () {
            let blockId = $(this).data('id');
            if (confirm('Are you sure you want to delete this block?')) {
                $.ajax({
                    url: `/blocks/${blockId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        table.ajax.reload();
                        alert("Block deleted successfully.");
                    },
                    error: function () {
                        alert("Error deleting block.");
                    }
                });
            }
        });
    });
</script>

</body>
</html>
