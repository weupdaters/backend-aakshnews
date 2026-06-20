@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-35">Instagram Reels & Videos</h3>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="box-breadcrumb">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                    <li><span>Instagram Reels</span></li>
                </ul>
            </div>
        </div>
        <a href="/admin/instagram/create" class="submit-btn text-white text-decoration-none d-inline-flex align-items-center gap-2" style="background-color: #E1306C; padding: 10px 20px; border-radius: 8px; font-weight: 700; box-shadow: 0 4px 6px -1px rgba(225, 48, 108, 0.2);">
            <i data-feather="instagram" class="me-1"></i> Add Instagram Reel
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 8px; font-weight: 600;">
        <i data-feather="check-circle" class="me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 8px; font-weight: 600;">
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
                        <div class="row display-list" id="reels-list">
                            @forelse($reels as $reel)
                            <div class="col-xl-3 col-lg-4 col-md-6 reel-card-item mb-4">
                                <div class="card-style-2 hover-up" style="flex-direction: column; align-items: stretch; height: 100%; border: 1px solid var(--border-color); background-color: var(--card-bg); padding: 20px; border-radius: 12px;">
                                    <div style="width: 100%; height: 160px; overflow: hidden; border-radius: 8px; border: 1px solid #cbd5e1; background: #000; margin-bottom: 15px;">
                                        <iframe src="{{ $reel->embed_url }}" class="w-100 h-100" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
                                    </div>
                                    <div class="card-head" style="align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                                        <div class="card-title">
                                            <h6 class="mb-1" style="font-size: 14px; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; white-space: normal;">
                                                {{ $reel->title ?: 'Untitled Reel' }}
                                            </h6>
                                            <span class="text-muted font-xs d-block">{{ $reel->created_at ? $reel->created_at->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ $reel->url }}" target="_blank" class="text-primary text-break font-xs" style="font-weight: 500; text-decoration: none;">
                                            <i data-feather="external-link" style="width:12px; height:12px; vertical-align:middle; margin-right:4px;"></i> View on Instagram
                                        </a>
                                    </div>
                                    <div class="mt-auto pt-2 border-top d-flex gap-2 justify-content-end align-items-center">
                                        <a href="/admin/instagram/{{ $reel->id }}/edit" class="btn btn-sm btn-tag d-inline-flex align-items-center justify-content-center" style="background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; height: 28px; padding: 0 10px; font-size: 11px; font-weight: 600; border-radius: 4px; text-decoration: none;">
                                            <i data-feather="edit" style="width:12px; height:12px;"></i> Edit
                                        </a>
                                        <form action="/admin/instagram/{{ $reel->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Instagram reel embed?');" class="d-inline">
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
                                <div class="mb-3">
                                    <i data-feather="instagram" class="text-muted" style="width: 48px; height: 48px; opacity: 0.4;"></i>
                                </div>
                                <p class="mb-0 font-sm">No Instagram reels found. Click "Add Instagram Reel" to create one.</p>
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
