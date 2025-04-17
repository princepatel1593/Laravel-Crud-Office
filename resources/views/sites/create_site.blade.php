<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($site) ? 'Edit Site' : 'Add Site' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <style>
        .error {
            color: red;
            font-size: 0.875rem; /* Optional: Smaller font size for error messages */
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Back Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('site.view') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <!-- Add/Edit Site Form -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-secondary">{{ isset($site) ? 'Edit Site' : 'Add New Site' }}</h5>
        </div>
        <div class="card-body">
            <form id="addSiteForm" method="POST" action="{{ isset($site) ? route('site.update', $site->id) : route('site.store') }}">
                @csrf
                @if(isset($site))
                    @method('PUT') <!-- For Update request -->
                @endif

                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control"
                           value="{{ $site->site_name ?? '' }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($site) ? 'Update Site' : 'Save Site' }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // jQuery validation for form
        $("#addSiteForm").validate({
            rules: {
                site_name: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                site_name: {
                    required: "Please enter the site name",
                    minlength: "Site name must be at least 3 characters long"
                }
            },
            submitHandler: function (form) {
                let isEdit = $(form).find('input[name="_method"]').val() === "PUT";
                let actionUrl = $(form).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST', // Laravel handles PUT/DELETE via _method
                    data: $(form).serialize(),
                    success: function(response) {
                        let message = isEdit ? 'Site updated successfully!' : 'Site saved successfully!';
                        alert(message);
                        window.location.href = "{{ route('site.view') }}"; // Redirect after success
                    },
                    error: function(xhr, status, error) {
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
