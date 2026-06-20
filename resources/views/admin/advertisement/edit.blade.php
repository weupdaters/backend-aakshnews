@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Edit Advertisement</h3>
        <p class="text-muted mb-0 font-sm">Modify advertisement banner image and status settings.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/advertisement">Advertisements</a></li>
                <li><span>Edit Advertisement</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10 mb-4">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/advertisement/{{ $advertisement->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Advertisement Name Select -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Advertisement Name <span class="text-danger">*</span></label>
                        <select name="name" class="form-control w-100 @error('name') is-invalid @enderror" style="height: 46px; border-radius: 8px;" required>
                            <option value="" disabled>-- Select --</option>
                            <option value="Sidebar Banner Ad (300x250)" {{ $advertisement->name == 'Sidebar Banner Ad (300x250)' ? 'selected' : '' }}>Sidebar Banner Ad (300x250)</option>
                            <option value="Header Horizontal Banner (728x90)" {{ $advertisement->name == 'Header Horizontal Banner (728x90)' ? 'selected' : '' }}>Header Horizontal Banner (728x90)</option>
                            <option value="Footer Horizontal Banner (728x90)" {{ $advertisement->name == 'Footer Horizontal Banner (728x90)' ? 'selected' : '' }}>Footer Horizontal Banner (728x90)</option>
                            <option value="In-Feed Banner Ad (600x150)" {{ $advertisement->name == 'In-Feed Banner Ad (600x150)' ? 'selected' : '' }}>In-Feed Banner Ad (600x150)</option>
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Banner Image -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Upload (Single Image)</label>
                        <div class="custom-file-upload border rounded-3 p-4 text-center bg-light" style="border: 2px dashed #cbd5e1 !important; cursor: pointer; position: relative;">
                            <input type="file" name="image" id="ad-image-input" class="form-control" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" accept="image/*">
                            
                            <div id="upload-placeholder" class="py-3 d-none">
                                <div class="d-flex justify-content-center align-items-center mb-3 position-relative" style="height: 100px;">
                                    <div class="position-absolute bg-white border rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 110px; height: 75px; transform: rotate(-8deg); z-index: 1; border-color: #e2e8f0;">
                                        <i data-feather="image" class="text-muted" style="font-size: 24px;"></i>
                                    </div>
                                    <div class="position-absolute bg-white border rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 110px; height: 75px; transform: rotate(5deg); z-index: 2; border-color: #e2e8f0; left: 50%; margin-left: -55px;">
                                        <div class="position-absolute" style="top: 8px; left: 8px; width: 10px; height: 10px; border-radius: 50%; background-color: #ef4444;"></div>
                                        <i class="far fa-image text-primary" style="font-size: 28px;"></i>
                                    </div>
                                </div>
                                <div class="text-muted font-sm">Choose file...</div>
                            </div>
                            
                            <div id="image-preview-container" class="py-2">
                                <img id="image-preview" src="{{ asset($advertisement->image_url) }}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: contain;">
                                <div class="mt-2 text-primary font-sm" style="font-weight: 600;">Click or drag to change image</div>
                            </div>
                        </div>
                        @error('image')
                            <div class="text-danger font-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Select -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Status Select</label>
                        <select name="status" class="form-control w-100" style="height: 46px; border-radius: 8px;">
                            <option value="active" {{ $advertisement->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $advertisement->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color: #8B5CF6; border-radius: 8px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2);">
                            Update Advertisement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('ad-image-input');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    placeholder.classList.add('d-none');
                    previewContainer.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
