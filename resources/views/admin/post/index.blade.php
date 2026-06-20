@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-35">News Articles</h3>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="box-breadcrumb">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                    <li><span>News Articles</span></li>
                </ul>
            </div>
        </div>
        <a href="/admin/post/create" class="submit-btn text-white text-decoration-none" style="background-color: var(--primary-color); padding: 10px 20px; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i data-feather="plus"></i> Publish News
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
                            <h5>All Articles</h5>
                            <div class="box-search" style="width: 280px; margin: 0;">
                                <input type="text" id="post-search-input" placeholder="Search articles..." class="form-control py-1 px-3 border rounded-3 font-sm" style="height: 34px;">
                            </div>
                        </div>
                        <div class="row display-list" id="posts-list">
                            @forelse($posts as $post)
                            <div class="col-xl-3 col-lg-4 col-md-6 post-card-item mb-4">
                                <div class="card-style-2 hover-up" style="flex-direction: column; align-items: stretch; height: 100%; border: 1px solid var(--border-color); background-color: var(--card-bg); padding: 20px; border-radius: 12px;">
                                    <div class="card-head" style="align-items: flex-start; gap: 14px; margin-bottom: 15px;">
                                        <div class="card-image">
                                            @if($post->image_url)
                                                <img src="{{ asset($post->image_url) }}" alt="{{ $post->title }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border: 1px solid var(--border-color);">
                                                    <i data-feather="image" class="text-muted" style="width: 20px; height: 20px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-title">
                                            <h6 class="mb-1" style="font-size: 14px; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; white-space: normal;" title="{{ $post->title }}">
                                                {{ $post->title }}
                                            </h6>
                                            <span class="text-muted font-xs d-block mb-1">By {{ $post->author_name }}</span>
                                            <span class="text-muted font-xs d-block">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex flex-wrap gap-1 align-items-center">
                                        <span class="badge" style="background-color: var(--badge-bg); color: var(--badge-color); font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">
                                            {{ $post->category }}
                                        </span>
                                        @if($post->status === 'published')
                                            <span class="badge" style="background-color: #d1fae5; color: #065f46; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Published</span>
                                        @elseif($post->status === 'pending')
                                            <span class="badge" style="background-color: #fef3c7; color: #92400e; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Pending</span>
                                        @elseif($post->status === 'rejected')
                                            <span class="badge" style="background-color: #fee2e2; color: #991b1b; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Rejected</span>
                                        @else
                                            <span class="badge" style="background-color: #f3f4f6; color: #374151; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">Hidden</span>
                                        @endif
                                        
                                        @if($post->is_hero)
                                            <span class="badge" style="background-color: #fef2f2; color: #b91c1c; font-size: 10px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">Hero</span>
                                        @endif
                                        @if($post->is_middle_stack)
                                            <span class="badge" style="background-color: #fffbeb; color: #b45309; font-size: 10px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">Middle Stack</span>
                                        @endif
                                    </div>
                                    <div class="card-progress mb-3 font-xs text-muted d-flex align-items-center">
                                        <i data-feather="eye" class="me-1" style="width: 14px; height: 14px;"></i> {{ number_format($post->views_count) }} views
                                    </div>
                                    <div class="mt-auto pt-2 border-top d-flex flex-column gap-2">
                                        <div class="d-flex gap-2 w-100">
                                            <button class="btn btn-sm approve-post-btn d-inline-flex align-items-center justify-content-center flex-grow-1" data-id="{{ $post->id }}" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; height: 28px; padding: 0 8px; font-size: 11px; font-weight: 600; border-radius: 4px;" title="Approve Post">
                                                <i data-feather="check" style="width:12px; height:12px; margin-right: 3px;"></i> Approve
                                            </button>
                                            <button class="btn btn-sm reject-post-btn d-inline-flex align-items-center justify-content-center flex-grow-1" data-id="{{ $post->id }}" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; height: 28px; padding: 0 8px; font-size: 11px; font-weight: 600; border-radius: 4px;" title="Reject Post">
                                                <i data-feather="x" style="width:12px; height:12px; margin-right: 3px;"></i> Reject
                                            </button>
                                        </div>
                                        <div class="d-flex gap-2 w-100">
                                            <a href="/admin/post/{{ $post->id }}/edit" class="btn btn-sm btn-tag d-inline-flex align-items-center justify-content-center flex-grow-1" style="background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; height: 28px; padding: 0 10px; font-size: 11px; font-weight: 600; border-radius: 4px; text-decoration: none;">
                                                <i data-feather="edit" style="width:12px; height:12px; margin-right: 3px;"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-tag d-inline-flex align-items-center justify-content-center delete-post-btn flex-grow-1" data-id="{{ $post->id }}" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; height: 28px; padding: 0 10px; font-size: 11px; font-weight: 600; border-radius: 4px;">
                                                <i data-feather="trash-2" style="width:12px; height:12px; margin-right: 3px;"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <div class="mb-2"><i data-feather="file-text" class="text-muted-light" style="width: 48px; height: 48px; opacity: 0.5;"></i></div>
                                <p class="mb-0">No news articles found. Click "Publish News" to create one.</p>
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
        // CSRF Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Approve Post Handler
        $('.approve-post-btn').on('click', function() {
            var id = $(this).data('id');
            var card = $(this).closest('.post-card-item');
            if (confirm('Are you sure you want to approve this article?')) {
                $.ajax({
                    url: '/api/posts/' + id + '/approve',
                    type: 'POST',
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            location.reload();
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function() {
                        alert('Failed to approve the article.');
                    }
                });
            }
        });

        // Reject Post Handler
        $('.reject-post-btn').on('click', function() {
            var id = $(this).data('id');
            var card = $(this).closest('.post-card-item');
            if (confirm('Are you sure you want to reject this article?')) {
                $.ajax({
                    url: '/api/posts/' + id + '/reject',
                    type: 'POST',
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            location.reload();
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function() {
                        alert('Failed to reject the article.');
                    }
                });
            }
        });

        // Delete Post Handler
        $('.delete-post-btn').on('click', function() {
            var id = $(this).data('id');
            var card = $(this).closest('.post-card-item');
            if (confirm('Are you sure you want to delete this article?')) {
                $.ajax({
                    url: '/api/posts/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            card.fadeOut(500, function() {
                                $(this).remove();
                                if ($('#posts-list .post-card-item').length === 0) {
                                    location.reload();
                                }
                            });
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function() {
                        alert('Failed to delete the article.');
                    }
                });
            }
        });

        // Search articles in card list
        $('#post-search-input').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#posts-list .post-card-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
