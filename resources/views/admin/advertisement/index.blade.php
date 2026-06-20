@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-35">Advertisements</h3>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="box-breadcrumb">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                    <li><span>Advertisements</span></li>
                </ul>
            </div>
        </div>
        <a href="/admin/advertisement/create" class="submit-btn text-white text-decoration-none" style="background-color: var(--primary-color); padding: 10px 20px; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i data-feather="plus"></i> Add Advertisement
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
                            <h5>All Advertisements</h5>
                        </div>
                        <div class="row display-list" id="ads-list">
                            @forelse($advertisements as $ad)
                            <div class="col-xl-3 col-lg-4 col-md-6 ad-card-item mb-4">
                                <div class="card-style-2 hover-up" style="flex-direction: column; align-items: stretch; height: 100%; border: 1px solid var(--border-color); background-color: var(--card-bg); padding: 20px; border-radius: 12px;">
                                    <div style="width: 100%; height: 120px; overflow: hidden; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc; margin-bottom: 15px;">
                                        @if($ad->image_url)
                                            <img src="{{ asset($ad->image_url) }}" alt="{{ $ad->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                                <i data-feather="image" class="text-muted" style="width: 32px; height: 32px;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-head" style="align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                                        <div class="card-title">
                                            <h6 class="mb-1" style="font-size: 14px; font-weight: 700;">
                                                {{ $ad->name }}
                                            </h6>
                                            <span class="text-muted font-xs d-block">{{ $ad->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @if($ad->status === 'active')
                                            <span class="badge" style="background-color: #d1fae5; color: #065f46; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Active</span>
                                        @else
                                            <span class="badge" style="background-color: #fee2e2; color: #991b1b; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="mt-auto pt-2 border-top d-flex gap-2 justify-content-end align-items-center">
                                        <a href="/admin/advertisement/{{ $ad->id }}/edit" class="btn btn-sm btn-info text-white border-0 d-inline-flex align-items-center justify-content-center" style="padding: 0 10px; border-radius: 4px; font-weight: 600; font-size: 11px; height: 28px; background-color: var(--info-color, #0ea5e9); text-decoration: none;">
                                            <i data-feather="edit" style="width: 12px; height: 12px; margin-right: 4px;"></i> Edit
                                        </a>
                                        <form action="/admin/advertisement/{{ $ad->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this advertisement?');" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger border-0 d-inline-flex align-items-center justify-content-center" style="padding: 0 10px; border-radius: 4px; font-weight: 600; font-size: 11px; height: 28px; background-color: #ef4444;">
                                                <i data-feather="trash-2" style="width: 12px; height: 12px; margin-right: 4px;"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i data-feather="image" class="d-block mx-auto mb-2" style="width: 48px; height: 48px; color: #ccc;"></i>
                                <p class="mb-0 font-sm">No advertisements uploaded yet.</p>
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
