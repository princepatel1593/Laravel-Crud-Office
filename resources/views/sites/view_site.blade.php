<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Sites</title>

    <!--  Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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

    <!--  Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!--  Header Buttons -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('site.create') }}" class="btn btn-outline-success me-2">Add Site</a>
        <a href="{{ route('office.view') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <h3 class="mb-4 text-secondary">All Sites</h3>

    <!--  DataTable Inside Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="siteTable" class="table table-bordered table-striped table-hover align-middle text-center w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Site Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!--  DataTables Init Script -->
<script>
    $(document).ready(function () {
        const table = $('#siteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('site.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'site_name', name: 'site_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Auto dismiss success alert
        setTimeout(() => {
            let alert = document.getElementById('success-alert');
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);

        // AJAX Delete
        $(document).on('click', '.deleteBtn', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this site?')) {
                $.ajax({
                    url: `/sites/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        table.ajax.reload();
                        alert("Site deleted successfully.");
                    },
                    error: function () {
                        alert("Error deleting site.");
                    }
                });
            }
        });
    });
</script>

</body>
</html>
