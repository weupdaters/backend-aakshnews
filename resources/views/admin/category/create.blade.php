@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Add Category</h3>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/category">Categories</a></li>
                <li><span>Add Category</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/category" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Category Name -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="category-name" class="form-control w-100" required placeholder="Enter category name">
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="category-slug" class="form-control w-100" required placeholder="Enter category slug">
                            </div>
                        </div>

                        <!-- Meta Title -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control w-100" placeholder="Enter meta title">
                            </div>
                        </div>

                        <!-- Meta Desc -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta Desc</label>
                                <textarea name="meta_desc" class="form-control w-100" rows="3" placeholder="Enter meta description"></textarea>
                            </div>
                        </div>

                        <!-- Meta keywords -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta keywords</label>
                                <input type="text" name="meta_keywords" class="form-control w-100" placeholder="Enter meta keywords">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block mb-3">
                                <label class="font-sm color-text-mutted mb-2">Upload (Single Image)</label>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control" placeholder="Choose file..." readonly id="file-name-text" style="background-color: var(--bg-color);">
                                    <label class="btn btn-primary d-flex align-items-center justify-content-center px-4" style="background-color: #3b82f6; border-color: #3b82f6; cursor: pointer; border-radius: 8px; font-size: 13px; font-weight: 700; height: 46px; color: white;">
                                        Browse
                                        <input type="file" name="image" id="category-image-file" accept="image/*" class="d-none">
                                    </label>
                                </div>
                            </div>

                            <!-- Image preview box -->
                            <div class="text-center p-4 border border-dashed rounded-3 bg-light" id="preview-box" style="border-color: #cbd5e1 !important; background-color: #f8fafc !important;">
                                <div id="placeholder-graphics" class="py-3">
                                    <div class="position-relative d-inline-block" style="width: 200px; height: 120px;">
                                        <!-- Mockup image cards stack -->
                                        <div class="position-absolute bg-white border rounded shadow-sm" style="top: 10px; left: 40px; width: 120px; height: 80px; opacity: 0.4; z-index: 1; border-color: #e2e8f0 !important;"></div>
                                        <div class="position-absolute bg-white border rounded shadow-sm" style="top: 5px; left: 20px; width: 120px; height: 80px; opacity: 0.7; z-index: 2; border-color: #e2e8f0 !important;"></div>
                                        <div class="position-absolute bg-white border rounded shadow-sm d-flex flex-column align-items-center justify-content-center" style="top: 0; left: 0; width: 120px; height: 80px; z-index: 3; border-color: #cbd5e1 !important;">
                                            <div style="width: 8px; height: 8px; border-radius: 50%; background-color: #ef4444; position: absolute; top: 8px; left: 8px;"></div>
                                            <svg viewBox="0 0 100 60" width="60" height="36" style="margin-top: 8px;">
                                                <polygon points="10,60 40,25 70,60" fill="#3b82f6" />
                                                <polygon points="40,60 65,35 90,60" fill="#3b82f6" opacity="0.8" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0 font-sm">No image uploaded yet</p>
                                </div>
                                <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded d-none" style="max-height: 180px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                            </div>
                        </div>

                        <!-- Color -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Color <span class="text-danger">*</span></label>
                                <input type="color" name="color" id="category-color" class="form-control form-control-color w-100 p-0 border-0" style="height: 50px; cursor: pointer; border-radius: 8px;" value="#000000" required>
                            </div>
                        </div>

                        <!-- Status Select -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Status Select</label>
                                <select name="status" class="form-control w-100" style="height: 46px;">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="submit-btn" style="background-color: var(--primary-color); border: none; padding: 12px 28px; border-radius: 8px; font-weight: 700; color: white;">
                            Add Category
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
        // Automatically generate slug from category name
        $('#category-name').on('input', function() {
            let name = $(this).val();
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // remove invalid chars
                .replace(/\s+/g, '-')         // collapse whitespace and replace by -
                .replace(/-+/g, '-');        // collapse dashes
            $('#category-slug').val(slug);
        });

        // Handle file change
        $('#category-image-file').on('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : '';
            $('#file-name-text').val(fileName);
            
            if (e.target.files && e.target.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#placeholder-graphics').addClass('d-none');
                    $('#image-preview').attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });
</script>
@endsection
