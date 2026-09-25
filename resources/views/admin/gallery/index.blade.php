@extends('admin.layouts.app')

@section('content')
<!-- PAGE HEADER -->
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-1" style="font-weight: 800; color: #0F172A; font-size: 24px;">Media Library</h3>
        <p class="text-muted mb-0 font-sm">Browse, preview, copy URLs, and manage all images stored in server storage & uploads.</p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <div class="box-breadcrumb me-2 d-none d-md-block">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                    <li><span>Media Library</span></li>
                </ul>
            </div>
        </div>
        <button type="button" class="btn text-white font-sm fw-bold d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#uploadMediaModal" style="background-color: #1769D2; padding: 10px 18px; border-radius: 10px; box-shadow: 0 4px 14px rgba(23, 105, 210, 0.3);">
            <i data-lucide="upload-cloud" style="width: 17px; height: 17px;"></i> Upload Images
        </button>
        <a href="/admin/gallery/create" class="btn btn-outline-secondary font-sm fw-semibold d-inline-flex align-items-center gap-1.5" style="border-radius: 10px; padding: 9px 15px; background: #FFFFFF;">
            <i data-lucide="plus" style="width: 15px; height: 15px;"></i> Add Slider Item
        </a>
    </div>
</div>

<!-- STATS SUMMARY CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted font-xs text-uppercase fw-bold">Total Media Files</span>
                <div class="rounded-circle p-1.5 bg-primary-subtle text-primary">
                    <i data-lucide="images" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
            <h4 class="mb-0 fw-bold text-dark">{{ number_format($totalCount) }}</h4>
            <span class="text-muted font-xxs mt-1 d-block">Indexed in storage & uploads</span>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted font-xs text-uppercase fw-bold">Disk Space Used</span>
                <div class="rounded-circle p-1.5 bg-success-subtle text-success">
                    <i data-lucide="hard-drive" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
            <h4 class="mb-0 fw-bold text-dark">{{ $totalSizeFormatted }}</h4>
            <span class="text-muted font-xxs mt-1 d-block">Optimized server footprint</span>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted font-xs text-uppercase fw-bold">Current Page</span>
                <div class="rounded-circle p-1.5 bg-warning-subtle text-warning">
                    <i data-lucide="layers" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
            <h4 class="mb-0 fw-bold text-dark">{{ $paginatedFiles->currentPage() }} / {{ $paginatedFiles->lastPage() ?: 1 }}</h4>
            <span class="text-muted font-xxs mt-1 d-block">{{ $paginatedFiles->count() }} items visible</span>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted font-xs text-uppercase fw-bold">Slider Curations</span>
                <div class="rounded-circle p-1.5 bg-purple-subtle text-purple" style="color: #7C3AED; background: #F3E8FF;">
                    <i data-lucide="gallery-thumbnails" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
            <h4 class="mb-0 fw-bold text-dark">{{ count($curatedPhotos) }}</h4>
            <span class="text-muted font-xxs mt-1 d-block">Public gallery items</span>
        </div>
    </div>
</div>

<!-- TABS & TOOLBAR -->
<div class="card border-0 shadow-xs rounded-4 mb-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <!-- Filter Pills -->
            <div class="d-flex flex-wrap gap-1.5 align-items-center">
                <a href="{{ request()->fullUrlWithQuery(['folder' => 'all', 'page' => 1]) }}" 
                   class="btn btn-sm px-3 py-1.5 rounded-pill font-xs fw-bold {{ $selectedFolder === 'all' ? 'btn-primary' : 'btn-light border text-muted' }}" 
                   style="{{ $selectedFolder === 'all' ? 'background-color: #1769D2;' : '' }}">
                    All Media ({{ $totalCount }})
                </a>
                @foreach($folders as $folderKey => $folderLabel)
                    @if($folderKey !== 'all')
                    <a href="{{ request()->fullUrlWithQuery(['folder' => strtolower($folderKey), 'page' => 1]) }}" 
                       class="btn btn-sm px-3 py-1.5 rounded-pill font-xs fw-bold {{ strtolower($selectedFolder) === strtolower($folderKey) ? 'btn-primary' : 'btn-light border text-muted' }}"
                       style="{{ strtolower($selectedFolder) === strtolower($folderKey) ? 'background-color: #1769D2;' : '' }}">
                        {{ $folderLabel }}
                    </a>
                    @endif
                @endforeach
            </div>

            <!-- Search Form -->
            <form action="{{ url('/admin/gallery') }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 320px; width: 100%;">
                @if(request('folder'))
                    <input type="hidden" name="folder" value="{{ request('folder') }}">
                @endif
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i data-lucide="search" style="width: 14px; height: 14px;"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 font-xs" placeholder="Search filename...">
                    @if(request('q'))
                        <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="btn btn-outline-secondary font-xs" title="Clear search">✕</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- BULK SELECTION FLOATING ACTION BAR -->
<div id="bulk-action-bar" class="card border-0 shadow-lg rounded-4 mb-4 d-none" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #FFFFFF; position: sticky; top: 12px; z-index: 1000; border: 1px solid #334155 !important;">
    <div class="card-body py-2.5 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" id="check-all-files" style="cursor: pointer;">
                <label class="form-check-label text-white font-sm fw-bold ms-1" for="check-all-files">Select All on Page</label>
            </div>
            <div class="vr bg-secondary opacity-50 my-1"></div>
            <span class="badge bg-primary font-xs px-2.5 py-1 fw-bold">
                <span id="selected-count">0</span> Selected
            </span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" id="btn-bulk-delete" class="btn btn-sm btn-danger font-xs fw-bold px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1.5 shadow-sm">
                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Delete Selected
            </button>
            <button type="button" id="btn-cancel-selection" class="btn btn-sm btn-outline-light font-xs px-2.5 py-1.5 rounded-pill">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- STORAGE MEDIA GRID -->
<div class="card border-0 shadow-xs rounded-4 mb-4 overflow-hidden" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 fw-bold" style="font-size: 15px; color: #0F172A;">
                Storage Image Catalog ({{ $paginatedFiles->total() }} items)
            </h5>
            @if(request('q'))
                <span class="badge bg-primary-subtle text-primary font-xxs">Filtered by: "{{ request('q') }}"</span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="form-check m-0 font-xs text-muted">
                <input class="form-check-input select-all-checkbox" type="checkbox" id="header-select-all" style="cursor: pointer;">
                <label class="form-check-label" for="header-select-all">Select All</label>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="row g-3" id="media-grid-container">
            @forelse($paginatedFiles as $file)
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 media-card-wrapper" id="file-card-{{ md5($file['token']) }}">
                <div class="card h-100 border rounded-3 position-relative overflow-hidden media-card-item shadow-2xs" style="border-color: #E2E8F0 !important; transition: all 0.2s ease;">
                    <!-- Checkbox for multi-delete -->
                    <div class="position-absolute top-0 start-0 m-2 z-2" style="background: rgba(255,255,255,0.9); border-radius: 6px; padding: 3px 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                        <input type="checkbox" class="form-check-input file-select-box" value="{{ $file['token'] }}" style="cursor: pointer;">
                    </div>

                    <!-- Folder Badge -->
                    <div class="position-absolute top-0 end-0 m-2 z-2">
                        <span class="badge bg-dark bg-opacity-75 text-white font-xxs rounded-pill px-2 py-0.5" style="font-size: 10px;">
                            {{ $file['folder'] }}
                        </span>
                    </div>

                    <!-- Image Preview Area -->
                    <div class="image-thumb-box position-relative" style="width: 100%; height: 140px; background-color: #F8FAFC; overflow: hidden; cursor: pointer;" 
                         onclick="openPreviewModal('{{ $file['url'] }}', '{{ addslashes($file['name']) }}', '{{ $file['size'] }}', '{{ $file['date'] }}', '{{ $file['token'] }}')">
                        <img src="{{ $file['url'] }}" 
                             alt="{{ $file['name'] }}" 
                             loading="lazy"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                             class="media-img-hover"
                             onerror="this.src='/images/image-placeholder.jpg'">
                        <div class="thumb-overlay position-absolute inset-0 d-flex align-items-center justify-content-center" style="background: rgba(15,23,42,0.3); opacity: 0; transition: opacity 0.2s ease;">
                            <span class="btn btn-sm btn-light rounded-pill px-2.5 py-1 font-xxs fw-bold shadow-sm">
                                <i data-lucide="zoom-in" style="width: 13px; height: 13px;" class="me-1"></i> View
                            </span>
                        </div>
                    </div>

                    <!-- Image Metadata -->
                    <div class="card-body p-2.5 d-flex flex-col justify-content-between">
                        <div>
                            <div class="fw-bold text-dark font-xs text-truncate mb-1" title="{{ $file['name'] }}">
                                {{ $file['name'] }}
                            </div>
                            <div class="d-flex justify-content-between text-muted font-xxs mb-2">
                                <span>{{ $file['size'] }}</span>
                                <span>{{ $file['date'] }}</span>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="pt-2 border-top d-flex gap-1 justify-content-between align-items-center mt-auto">
                            <button type="button" class="btn btn-sm btn-light border p-1 text-muted copy-url-btn" 
                                    data-url="{{ $file['url'] }}" 
                                    title="Copy Image URL">
                                <i data-lucide="copy" style="width: 13px; height: 13px;"></i>
                            </button>
                            <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-light border p-1 text-muted" title="Open in New Tab">
                                <i data-lucide="external-link" style="width: 13px; height: 13px;"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-light border p-1 text-danger delete-single-btn" 
                                    data-token="{{ $file['token'] }}" 
                                    data-name="{{ $file['name'] }}"
                                    title="Delete from Storage">
                                <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center text-muted">
                <div class="mb-3">
                    <i data-lucide="image-off" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                </div>
                <h6 class="fw-bold">No images found in storage.</h6>
                <p class="font-xs">Upload images using the button above or check your search criteria.</p>
            </div>
            @endforelse
        </div>
    </div>

    @if($paginatedFiles->hasPages())
    <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted font-xs">
            Showing {{ $paginatedFiles->firstItem() ?? 0 }} to {{ $paginatedFiles->lastItem() ?? 0 }} of {{ $paginatedFiles->total() }} images
        </span>
        <div>
            {{ $paginatedFiles->links() }}
        </div>
    </div>
    @endif
</div>

<!-- PHOTO GALLERY SLIDERS (LEGACY COMPATIBILITY) -->
@if(count($curatedPhotos) > 0)
<div class="card border-0 shadow-xs rounded-4 mb-4 overflow-hidden" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold" style="font-size: 15px; color: #0F172A;">
            Curated Photo Gallery Sliders ({{ count($curatedPhotos) }})
        </h5>
        <a href="/admin/gallery/create" class="btn btn-sm btn-outline-primary font-xs fw-bold">
            <i data-lucide="plus" style="width: 13px; height: 13px;"></i> Add Slider Item
        </a>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            @foreach($curatedPhotos as $photo)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border rounded-3 p-2.5" style="border-color: #E2E8F0 !important;">
                    <div style="height: 120px; overflow: hidden; border-radius: 6px; background: #F8FAFC;" class="mb-2">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="fw-bold text-dark font-xs text-truncate mb-1">{{ $photo->name }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                        <a href="/admin/gallery/{{ $photo->id }}/edit" class="btn btn-sm btn-light border py-0.5 px-2 font-xxs">Edit</a>
                        <form action="/admin/gallery/{{ $photo->id }}" method="POST" onsubmit="return confirm('Delete this gallery slider item?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger border py-0.5 px-2 font-xxs">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- UPLOAD MODAL -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-labelledby="uploadMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title fw-bold" id="uploadMediaModalLabel" style="color: #062B63;">
                    <i data-lucide="upload-cloud" class="me-2" style="width: 20px; height: 20px; color: #1769D2;"></i> Upload Images to Storage
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.gallery.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label font-xs fw-bold text-uppercase text-muted">Select Target Folder</label>
                        <select name="folder" class="form-select font-sm">
                            <option value="uploads" selected>public/uploads (General Media & Content)</option>
                            <option value="posts">storage/app/public/posts (News Post Attachments)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-xs fw-bold text-uppercase text-muted">Select Images (Multiple allowed)</label>
                        <input type="file" name="images[]" class="form-control font-sm" multiple accept="image/*" required>
                        <small class="text-muted font-xs mt-1 d-block">Supported formats: JPG, PNG, WebP, GIF, SVG. Max 15MB per file.</small>
                    </div>
                </div>
                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light font-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-sm fw-bold" style="background-color: #1769D2;">Start Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PREVIEW MODAL -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4">
                <h6 class="modal-title fw-bold text-truncate" id="modal-img-name" style="max-width: 80%;">Image Preview</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark d-flex align-items-center justify-content-center" style="min-height: 380px; max-height: 520px; overflow: hidden;">
                <img id="modal-img-src" src="" alt="Preview" style="max-width: 100%; max-height: 520px; object-fit: contain;">
            </div>
            <div class="modal-footer border-top py-2.5 px-4 d-flex justify-content-between align-items-center">
                <div class="text-muted font-xs text-start">
                    <div>Size: <strong id="modal-img-size"></strong> • Date: <span id="modal-img-date"></span></div>
                    <div class="text-truncate font-monospace" id="modal-img-url" style="max-width: 420px; font-size: 11px;"></div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-xs" id="modal-copy-btn">
                        <i data-lucide="copy" style="width: 14px; height: 14px;" class="me-1"></i> Copy URL
                    </button>
                    <button type="button" class="btn btn-sm btn-danger font-xs fw-bold" id="modal-delete-btn">
                        <i data-lucide="trash-2" style="width: 14px; height: 14px;" class="me-1"></i> Delete File
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
.media-card-item:hover {
    border-color: #1769D2 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08) !important;
}
.image-thumb-box:hover .thumb-overlay {
    opacity: 1 !important;
}
.image-thumb-box:hover .media-img-hover {
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const bulkBar = document.getElementById('bulk-action-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    const checkAllBoxes = [document.getElementById('check-all-files'), document.getElementById('header-select-all')];
    const fileBoxes = document.querySelectorAll('.file-select-box');

    // Update bulk action bar visibility and count
    function updateSelectionState() {
        const checked = document.querySelectorAll('.file-select-box:checked');
        const count = checked.length;
        if (selectedCountSpan) selectedCountSpan.textContent = count;

        if (count > 0) {
            bulkBar?.classList.remove('d-none');
        } else {
            bulkBar?.classList.add('d-none');
        }

        checkAllBoxes.forEach(ch => {
            if (ch) ch.checked = (count > 0 && count === fileBoxes.length);
        });
    }

    fileBoxes.forEach(box => {
        box.addEventListener('change', updateSelectionState);
    });

    checkAllBoxes.forEach(ch => {
        if (!ch) return;
        ch.addEventListener('change', function () {
            fileBoxes.forEach(b => b.checked = ch.checked);
            updateSelectionState();
        });
    });

    document.getElementById('btn-cancel-selection')?.addEventListener('click', function () {
        fileBoxes.forEach(b => b.checked = false);
        updateSelectionState();
    });

    // Bulk Delete Action
    document.getElementById('btn-bulk-delete')?.addEventListener('click', function () {
        const checkedBoxes = Array.from(document.querySelectorAll('.file-select-box:checked'));
        if (checkedBoxes.length === 0) return;

        const count = checkedBoxes.length;
        const tokens = checkedBoxes.map(b => b.value);

        Swal.fire({
            title: 'Delete ' + count + ' Images?',
            text: 'These files will be permanently deleted from the server storage. This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, permanently delete (' + count + ')'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting Files...',
                    text: 'Removing selected media from disk...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch('{{ route("admin.gallery.bulk-delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ tokens: tokens })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted Successfully!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete files.', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Server connection failed while deleting.', 'error');
                });
            }
        });
    });

    // Single Delete Action
    document.querySelectorAll('.delete-single-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const token = this.getAttribute('data-token');
            const name = this.getAttribute('data-name');

            Swal.fire({
                title: 'Delete Image?',
                text: 'Are you sure you want to permanently delete "' + name + '" from server storage?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.gallery.delete-file") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ token: token })
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            toastr.success(res.message);
                            btn.closest('.media-card-wrapper')?.remove();
                        } else {
                            toastr.error(res.message || 'Could not delete file.');
                        }
                    })
                    .catch(() => toastr.error('Server error deleting file.'));
                }
            });
        });
    });

    // Copy URL Action
    document.querySelectorAll('.copy-url-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const relUrl = this.getAttribute('data-url');
            const fullUrl = window.location.origin + relUrl;
            navigator.clipboard.writeText(fullUrl).then(() => {
                toastr.success('Image URL copied to clipboard: ' + relUrl);
            }).catch(() => {
                toastr.info('URL: ' + fullUrl);
            });
        });
    });

    // Preview Lightbox Modal
    const previewModalEl = document.getElementById('previewModal');
    const previewModal = new bootstrap.Modal(previewModalEl);
    let activePreviewToken = null;
    let activePreviewUrl = null;

    window.openPreviewModal = function (url, name, size, date, token) {
        activePreviewToken = token;
        activePreviewUrl = window.location.origin + url;
        document.getElementById('modal-img-src').src = url;
        document.getElementById('modal-img-name').textContent = name;
        document.getElementById('modal-img-size').textContent = size;
        document.getElementById('modal-img-date').textContent = date;
        document.getElementById('modal-img-url').textContent = activePreviewUrl;
        previewModal.show();
    };

    document.getElementById('modal-copy-btn')?.addEventListener('click', function () {
        if (activePreviewUrl) {
            navigator.clipboard.writeText(activePreviewUrl).then(() => {
                toastr.success('Image URL copied to clipboard!');
            });
        }
    });

    document.getElementById('modal-delete-btn')?.addEventListener('click', function () {
        if (!activePreviewToken) return;
        previewModal.hide();
        Swal.fire({
            title: 'Delete this file?',
            text: 'This image will be permanently removed from disk storage.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            confirmButtonText: 'Yes, delete file'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('{{ route("admin.gallery.delete-file") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ token: activePreviewToken })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                });
            }
        });
    });

    // Refresh Lucide Icons
    if (window.lucide) {
        window.lucide.createIcons();
    }
});
</script>
@endsection
