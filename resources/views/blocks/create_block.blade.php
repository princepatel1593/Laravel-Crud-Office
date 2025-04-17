<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($block) ? 'Edit Block' : 'Add Block' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery & jQuery Validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        .error {
            color: red;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">

    <!-- Back Button (AJAX) -->
    <div class="d-flex justify-content-end mb-4">
        <button id="ajaxBackBtn" class="btn btn-outline-secondary">Back</button>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-secondary">{{ isset($block) ? 'Edit Block' : 'Add New Block' }}</h5>
        </div>
        <div class="card-body">
            <form id="blockForm">
                @csrf
                @if(isset($block))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $block->id }}">
                @endif

                <!-- Site Dropdown -->
                <div class="mb-3">
                    <label for="site_id" class="form-label">Site</label>
                    <select name="site_id" id="site_id" class="form-select" required>
                        <option value="">-- Select Site --</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ (isset($block) && $block->site_id == $site->id) ? 'selected' : '' }}>
                                {{ $site->site_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Block Name -->
                <div class="mb-3">
                    <label for="block_name" class="form-label">Block Name</label>
                    <input type="text" name="block_name" id="block_name" class="form-control" required
                           value="{{ isset($block) ? $block->block_name : '' }}">
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($block) ? 'Update Block' : 'Save Block' }}
                </button>
            </form>
        </div>
    </div>

</div>

<!--  AJAX & Validation Logic -->
<script>
    $(document).ready(function () {
        // Form Validation & AJAX Submit
        $("#blockForm").validate({
            rules: {
                site_id: { required: true },
                block_name: { required: true, minlength: 2 }
            },
            messages: {
                site_id: "Please select a site",
                block_name: {
                    required: "Please enter a block name",
                    minlength: "Block name must be at least 2 characters"
                }
            },
            submitHandler: function (form) {
                const isEdit = {{ isset($block) ? 'true' : 'false' }};
                const url = isEdit
                    ? "{{ route('block.update', $block->id ?? 0) }}"
                    : "{{ route('block.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(form).serialize(),
                    success: function () {
                        alert(isEdit ? 'Block updated successfully!' : 'Block saved successfully!');
                        window.location.href = "{{ route('block.view') }}"; // Optional fallback
                    },
                    error: function () {
                        alert('Error saving block. Please try again.');
                    }
                });
            }
        });

        // Back button using AJAX
        $('#ajaxBackBtn').click(function () {
            $.ajax({
                url: "{{ route('block.view') }}",
                type: 'GET',
                success: function (response) {
                    $('body').html(response); // Inject response to whole page
                },
                error: function () {
                    alert('Failed to go back.');
                }
            });
        });
    });
</script>

</body>
</html>
