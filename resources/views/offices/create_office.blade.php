<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($office) ? 'Edit Office' : 'Add Office' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-secondary">{{ isset($office) ? 'Edit Office' : 'Add Office' }}</h3>

    <!-- Back Button -->
    <button type="button" id="backButton" class="btn btn-outline-secondary mb-3 float-end">Back</button>


    <form id="addOfficeForm" method="POST" action="{{ isset($office) ? route('office.update', $office->id) : route('office.store') }}">
        @csrf
        @isset($office)
            @method('PUT')  <!-- Add this for the update method -->
        @endisset
    
        <!-- Site Dropdown -->
        <div class="mb-3">
            <label for="site_id" class="form-label">Site</label>
            <select name="site_id" id="site_id" class="form-select" required>
                <option value="">-- Select Site --</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ isset($office) && $office->floor->block->site->id == $site->id ? 'selected' : '' }}>{{ $site->site_name }}</option>
                @endforeach
            </select>
        </div>
    
        <!-- Block Dropdown -->
        <div class="mb-3">
            <label for="block_id" class="form-label">Block</label>
            <select name="block_id" id="block_id" class="form-select" required>
                <option value="">-- Select Block --</option>
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}" {{ isset($office) && $office->floor->block_id == $block->id ? 'selected' : '' }}>{{ $block->block_name }}</option>
                @endforeach
            </select>
        </div>
    
        <!-- Floor Dropdown -->
        <div class="mb-3">
            <label for="floor_id" class="form-label">Floor</label>
            <select name="floor_id" id="floor_id" class="form-select" required>
                <option value="">-- Select Floor --</option>
                @foreach($floors as $floor)
                    <option value="{{ $floor->id }}" {{ isset($office) && $office->floor_id == $floor->id ? 'selected' : '' }}>{{ $floor->floor_name }}</option>
                @endforeach
            </select>
        </div>
    
        <!-- Office Name -->
        <div class="mb-3">
            <label for="office_name" class="form-label">Office Name</label>
            <input type="text" class="form-control" id="office_name" name="office_name" value="{{ old('office_name', isset($office) ? $office->office_name : '') }}" required>
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">{{ isset($office) ? 'Update' : 'Submit' }}</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Load Blocks on Site Change
        $('#site_id').change(function () {
            let siteId = $(this).val();
            $('#block_id').empty().append('<option value="">-- Select Block --</option>');
            $('#floor_id').empty().append('<option value="">-- Select Floor --</option>');
            if (siteId) {
                $.get('/get-blocks/' + siteId, function (data) {
                    $.each(data.blocks, function (i, block) {
                        $('#block_id').append('<option value="' + block.id + '">' + block.block_name + '</option>');
                    });
                });
            }
        });

        // Load Floors on Block Change
        $('#block_id').change(function () {
            let blockId = $(this).val();
            $('#floor_id').empty().append('<option value="">-- Select Floor --</option>');
            if (blockId) {
                $.get('/get-floors/' + blockId, function (data) {
                    $.each(data.floors, function (i, floor) {
                        $('#floor_id').append('<option value="' + floor.id + '">' + floor.floor_name + '</option>');
                    });
                });
            }
        });

        // Handle Back Button
        $('#backButton').click(function() {
            window.history.back();
        });
        

        // Handle Form Submission via AJAX
        $('#addOfficeForm').submit(function (e) {
            e.preventDefault();  // Prevent the default form submission

            // Clear previous messages
            $('#successMessage').hide();
            $('#errorMessage').hide();

            var formData = $(this).serialize();  // Serialize the form data
            var actionUrl = $(this).attr('action');  // Get the action URL to determine if it's an update or create

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function (response) {
                    
                    var successMessage = actionUrl.includes('update') ? 'Details updated successfully!' : 'Office added successfully!';
                    
                    /
                    $('#successMessage').text(successMessage).show();

                    // Custom success message and redirect
                    alert(successMessage);
                    
            
                    window.location.href = '{{ route('office.view', ['office' => $office->id ?? 0]) }}';  // Adjust the route as needed
                },
                error: function (xhr, status, error) {
                   
                    $('#errorMessage').show();
                }
            });
        });
    });
</script>

</body>
</html>
