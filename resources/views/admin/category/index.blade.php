@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-35">Categories</h3>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="box-breadcrumb">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                    <li><span>Categories</span></li>
                </ul>
            </div>
        </div>
        <a href="/admin/category/create" class="submit-btn text-white text-decoration-none" style="background-color: var(--primary-color); padding: 10px 20px; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i data-feather="plus"></i> Add Category
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #047857; border-radius: 8px;">
    <i data-feather="check-circle" class="me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; color: #b91c1c; border-radius: 8px;">
    <i data-feather="alert-circle" class="me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="section-box">
            <div class="container">
                <div class="panel-white mb-30">
                    <div class="box-padding">
                        <div class="panel-head d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                            <h5>All Categories</h5>
                            <div class="box-search" style="width: 240px; margin: 0;">
                                <input type="text" id="category-search-input" placeholder="Search categories..." class="form-control py-1 px-3 border rounded-3 font-sm" style="height: 34px;">
                            </div>
                        </div>
                        <div class="row display-list" id="categories-list">
                            @forelse($categories as $category)
                            <div class="col-xl-3 col-lg-4 col-md-6 category-card-item mb-4">
                                <div class="card-style-2 hover-up" style="flex-direction: column; align-items: stretch; height: 100%; border: 1px solid var(--border-color); background-color: var(--card-bg); padding: 20px; border-radius: 12px;">
                                    <div class="card-head" style="align-items: center; gap: 14px; margin-bottom: 15px;">
                                        <div class="card-image">
                                            @if($category->image)
                                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border: 1px solid var(--border-color);">
                                                    <i data-feather="image" class="text-muted" style="width: 16px; height: 16px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-title">
                                            <h6 class="mb-1" style="font-size: 14px; font-weight: 700;">
                                                {{ $category->name }}
                                            </h6>
                                            <span class="font-monospace text-muted font-xs d-block">{{ $category->slug }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-block rounded-circle shadow-sm border border-2 border-white" style="width: 16px; height: 16px; background-color: {{ $category->color ?? '#000000' }};"></span>
                                            <span class="font-monospace text-muted font-xs">{{ strtoupper($category->color ?? '#000000') }}</span>
                                        </div>
                                        @if(($category->status ?? 'active') === 'active')
                                            <span class="badge" style="background-color: #d1fae5; color: #065f46; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Active</span>
                                        @else
                                            <span class="badge" style="background-color: #f3f4f6; color: #374151; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="mt-auto pt-2 border-top d-flex gap-2 justify-content-end align-items-center">
                                        <a href="/admin/category/{{ $category->id }}/edit" class="btn btn-sm btn-tag d-inline-flex align-items-center justify-content-center" style="background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; height: 28px; padding: 0 10px; font-size: 11px; font-weight: 600; border-radius: 4px; text-decoration: none;">
                                            <i data-feather="edit" style="width:12px; height:12px;"></i> Edit
                                        </a>
                                        <form action="/admin/category/{{ $category->id }}" method="POST" class="delete-category-form d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-tag d-inline-flex align-items-center justify-content-center" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; height: 28px; padding: 0 10px; font-size: 11px; font-weight: 600; border-radius: 4px;">
                                                <i data-feather="trash-2" style="width:12px; height:12px;"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <div class="mb-2"><i data-feather="folder" class="text-muted-light" style="opacity: 0.5; width: 48px; height: 48px;"></i></div>
                                <p class="mb-0">No categories found. Click "Add Category" to create one.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Confirmation before deleting a category
        $('.delete-category-form').on('submit', function(e) {
            if (!confirm('Are you sure you want to delete this category? All associated posts will lose this category reference.')) {
                e.preventDefault();
            }
        });

        // Search categories in card list
        $('#category-search-input').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#categories-list .category-card-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
