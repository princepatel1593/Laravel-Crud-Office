<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($floor) ? 'Edit Floor' : 'Add Floor' }}</title>

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
            <h5 class="mb-0 text-secondary">{{ isset($floor) ? 'Edit Floor' : 'Add New Floor' }}</h5>
        </div>
        <div class="card-body">
            <form id="floorForm">
                @csrf
                @if(isset($floor))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $floor->id }}">
                @endif

                <!-- Site Dropdown -->
                <div class="mb-3">
                    <label for="site_id" class="form-label">Site</label>
                    <select name="site_id" id="site_id" class="form-select" required>
                        <option value="">-- Select Site --</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ (isset($siteId) && $siteId == $site->id) ? 'selected' : '' }}>
                                {{ $site->site_name }}
                            </option>
                        @endforeach
                    </select>                    
                </div>

                <!-- Block Dropdown -->
              <!-- Block Dropdown -->
                <div class="mb-3">
                    <label for="block_id" class="form-label">Block</label>
                    <select name="block_id" id="block_id" class="form-select" required>
                        <option value="">-- Select Block --</option>
                        @if(isset($floor))
                            @foreach ($blocks as $block)
                                <option value="{{ $block->id }}" {{ (old('block_id', $floor->block_id ?? '') == $block->id) ? 'selected' : '' }}>
                                    {{ $block->block_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>


                <!-- Floor Name -->
                <div class="mb-3">
                    <label for="floor_name" class="form-label">Floor Name</label>
                    <input type="text" name="floor_name" id="floor_name" class="form-control" required
                           value="{{ old('floor_name', $floor->floor_name ?? '') }}">
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($floor) ? 'Update Floor' : 'Save Floor' }}
                </button>
            </form>
        </div>
    </div>

</div>

<!--  AJAX & Validation Logic -->
<script>
    $(document).ready(function () {
        // Fetch blocks when site is selected
        $('#site_id').change(function () {
            var siteId = $(this).val();
            if (siteId) {
                $.ajax({
                    url: '/get-blocks/' + siteId,
                    type: 'GET',
                    success: function (data) {
                        $('#block_id').empty();
                        $('#block_id').append('<option value="">-- Select Block --</option>');
                        $.each(data.blocks, function (index, block) {
                            $('#block_id').append('<option value="' + block.id + '">' + block.block_name + '</option>');
                        });
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                        alert('Failed to fetch blocks.');
                    }
                });
            } else {
                $('#block_id').empty();
                $('#block_id').append('<option value="">-- Select Block --</option>');
            }
        });

        // Back button
        $('#ajaxBackBtn').click(function () {
            window.history.back();
        });

        // Form validation & submit
        $("#floorForm").validate({
            rules: {
                site_id: { required: true },
                block_id: { required: true },
                floor_name: { required: true, minlength: 2 }
            },
            messages: {
                site_id: "Please select a site",
                block_id: "Please select a block",
                floor_name: {
                    required: "Please enter a floor name",
                    minlength: "Floor name must be at least 2 characters"
                }
            },
            submitHandler: function (form) {
                const isEdit = {{ isset($floor) ? 'true' : 'false' }};
                const url = isEdit
                    ? "{{ route('floor.update', $floor->id ?? 0) }}"
                    : "{{ route('floor.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(form).serialize(),
                    success: function () {
                        alert(isEdit ? 'Floor updated successfully!' : 'Floor saved successfully!');
                        window.location.href = "{{ route('floor.view') }}";
                    },
                    error: function () {
                        alert('Error saving floor. Please try again.');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
