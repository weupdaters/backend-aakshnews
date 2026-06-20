@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Add Photo to Gallery</h3>
        <p class="text-muted mb-0 font-sm">Upload or link an image to display in the main website slider.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/gallery">Photo Gallery</a></li>
                <li><span>Add Photo</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 mb-4">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/gallery" method="POST">
                    @csrf
                    
                    <!-- Photo Name Input -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Photo Name / Caption <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control w-100 @error('name') is-invalid @enderror" placeholder="Enter photo caption or short title..." style="height: 46px; border-radius: 8px;" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Image Upload / Link <span class="text-danger">*</span></label>
                        <div class="border rounded p-3 mb-3 text-center" style="background:#f8fafc; min-height: 200px; display:flex; align-items:center; justify-content:center; flex-direction:column; border-color:#cbd5e1 !important;">
                            <img id="image-preview" src="{{ asset('assets/imgs/page/dashboard/img3.png') }}" alt="Preview" style="max-height: 160px; max-width: 100%; object-fit: contain; border-radius: 6px;">
                            <span id="upload-status" class="font-xs text-muted mt-2 d-none">Uploading...</span>
                        </div>
                        
                        <div class="d-flex gap-2 mb-3">
                            <label class="btn btn-outline-secondary btn-sm flex-grow-1 mb-0 d-flex align-items-center justify-content-center" style="cursor: pointer; font-weight:700; height: 38px;">
                                <i data-feather="upload" class="me-2"></i> Choose Local Image
                                <input type="file" id="gallery-image-file" accept="image/*" class="d-none">
                            </label>
                        </div>

                        <div class="input-group d-block">
                            <input type="url" name="image_url" id="gallery-image-url" class="form-control w-100 @error('image_url') is-invalid @enderror" placeholder="Or paste image URL (https://...)" style="height: 46px; border-radius: 8px;" value="{{ old('image_url') }}" required>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color: #3182ce; border-radius: 8px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(49, 130, 206, 0.2);">
                            Save Photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 1. File Upload Handler
        $('#gallery-image-file').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            var formData = new FormData();
            formData.append('image', file);

            var $status = $('#upload-status');
            $status.removeClass('d-none');
            var $inputLabel = $(this).parent();
            $inputLabel.addClass('disabled').css('pointer-events', 'none');

            $.ajax({
                url: '/api/admin/upload-image',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.success) {
                        $('#gallery-image-url').val(res.url);
                        $('#image-preview').attr('src', res.url);
                    } else {
                        alert('Upload error: ' + res.message);
                    }
                },
                error: function() {
                    alert('Failed to upload file.');
                },
                complete: function() {
                    $status.addClass('d-none');
                    $inputLabel.removeClass('disabled').css('pointer-events', 'auto');
                }
            });
        });

        // Image URL Manual Input Preview
        $('#gallery-image-url').on('input', function() {
            var val = $(this).val();
            if (val) {
                $('#image-preview').attr('src', val);
            } else {
                $('#image-preview').attr('src', '{{ asset('assets/imgs/page/dashboard/img3.png') }}');
            }
        });
    });
</script>
@endsection
