@php
  $postsCount = \App\Models\UserPost::count();
  $viewsCount = \App\Models\UserPost::sum('views_count');
  $breakingCount = \App\Models\BreakingNews::count();
  $instagramCount = \App\Models\InstagramVideo::count();
  $galleryCount = \App\Models\PhotoGallery::count();
  $hiddenCount = \App\Models\UserPost::where('status', 'hidden')->count();
  $publishedCount = \App\Models\UserPost::where('status', 'published')->count();
  $authorsCount = \App\Models\UserPost::distinct('author_name')->count() ?: 1;
@endphp

@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['dashboard'] ?? 'Dashboard' }}</h3>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/">Aaksh News 24</a></li>
                <li><span>{{ $t['admin_panel'] ?? 'Admin Panel' }}</span></li>
            </ul>
        </div>
    </div>
</div>

<!-- 1. STATS CARDS GRID -->
<div class="row g-4 mb-4">
    <!-- Card 1: Total News Articles -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="file-text" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $postsCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['total_news_articles'] ?? 'Total News Articles' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Views -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="eye" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $viewsCount >= 1000 ? number_format($viewsCount / 1000, 1) . 'K' : $viewsCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['total_article_views'] ?? 'Total Article Views' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3: Breaking News -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="zap" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $breakingCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['breaking_news'] ?? 'Breaking News' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 4: Instagram Reels -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="instagram" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $instagramCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['instagram_reels'] ?? 'Instagram Reels' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 5: Photo Gallery -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="image" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $galleryCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['gallery'] ?? 'Photo Gallery' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 6: Hidden Articles -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="eye-off" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $hiddenCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['hidden_articles'] ?? 'Hidden Articles' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 7: Published Articles -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="check-circle" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $publishedCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['published_articles'] ?? 'Published Articles' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 8: Active Authors -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card-style-1 hover-up" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; transition: all 0.2s;">
            <div class="card-image" style="background-color: var(--badge-bg); color: var(--primary-color); width: 56px; height: 56px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-feather="users" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="card-info" style="min-width: 0;">
                <h3 style="font-size: 24px; font-weight: 800; color: var(--heading-color); margin: 0 0 4px 0;">{{ $authorsCount }}</h3>
                <p style="font-size: 13px; color: var(--text-color); margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t['active_authors'] ?? 'Active Authors' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- 2. RECENT BREAKING NEWS AND RECENT POSTS -->
<div class="row g-4 mt-2">
    <!-- Recent Breaking News Card -->
    <div class="col-xl-6 col-md-12">
        <div class="panel-white" style="border: 1px solid var(--border-color); border-radius: 12px; background: var(--card-bg); padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.01); height: 100%;">
            <div class="panel-head d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color); font-size: 16px;">
                    <i data-feather="zap" class="text-warning me-2" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle;"></i>{{ $t['active_breaking_news'] ?? 'Active Breaking News' }}
                </h5>
                <a href="/admin/breaking-news" class="btn-tag" style="background-color: var(--badge-bg); color: var(--badge-color); font-size: 11px; font-weight: 700; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-block;">{{ $t['manage_all'] ?? 'Manage All' }}</a>
            </div>
            <div class="panel-body">
                <div class="breaking-news-list">
                    @forelse($breakingNews->take(5) as $news)
                        <div class="card-style-2 d-flex align-items-center justify-content-between p-3 mb-3" style="background-color: var(--bg-color); border-radius: 10px; border: 1px solid var(--border-color); transition: all 0.2s;">
                            <div class="d-flex align-items-center gap-3" style="min-width: 0; flex: 1;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #FFF3CD; border: 1px solid #FFEBAA; flex-shrink: 0;">
                                    <i data-feather="zap" class="text-warning" style="width: 16px; height: 16px;"></i>
                                </div>
                                <div style="min-width: 0; flex: 1;">
                                    <h6 class="mb-1" style="font-size: 13px; font-weight: 700; color: var(--heading-color); line-height: 1.4; white-space: normal; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{ $news->title }}</h6>
                                    <span class="text-muted font-xxs" style="font-size: 11px;"><i data-feather="clock" style="width: 10px; height: 10px; margin-right: 3px; display: inline-block; vertical-align: middle;"></i>{{ $news->created_at ? $news->created_at->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-2">
                                @if($news->is_active)
                                    <span class="badge" style="background-color: #d1fae5; color: #065f46; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">{{ $t['active'] ?? 'Active' }}</span>
                                @else
                                    <span class="badge" style="background-color: #fee2e2; color: #991b1b; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">{{ $t['inactive'] ?? 'Inactive' }}</span>
                                @endif
                                <a href="/admin/breaking-news/{{ $news->id }}/edit" class="btn btn-sm" style="color: var(--primary-color); padding: 2px 6px;" title="Edit"><i data-feather="edit-2" style="width: 14px; height: 14px;"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="mb-2">
                                <i data-feather="zap" class="text-muted" style="width: 36px; height: 36px; opacity: 0.3;"></i>
                            </div>
                            <p class="font-sm mb-0">{{ $t['no_breaking_news_found'] ?? 'No active breaking news items found.' }}</p>
                            <a href="/admin/breaking-news/create" class="btn-tag mt-3 text-white text-decoration-none" style="background-color: var(--primary-color); padding: 6px 12px; font-size: 11px; border-radius: 4px; display: inline-block;">{{ $t['add_new_alert'] ?? 'Add New Alert' }}</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Articles Card -->
    <div class="col-xl-6 col-md-12">
        <div class="panel-white" style="border: 1px solid var(--border-color); border-radius: 12px; background: var(--card-bg); padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.01); height: 100%;">
            <div class="panel-head d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color); font-size: 16px;">
                    <i data-feather="file-text" class="text-primary me-2" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle;"></i>{{ $t['recent_news_articles'] ?? 'Recent News Articles' }}
                </h5>
                <a href="/admin/post" class="btn-tag" style="background-color: var(--badge-bg); color: var(--badge-color); font-size: 11px; font-weight: 700; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-block;">{{ $t['manage_all'] ?? 'Manage All' }}</a>
            </div>
            <div class="panel-body">
                <div class="posts-list">
                    @forelse($posts->take(5) as $post)
                        <div class="card-style-2 d-flex align-items-center justify-content-between p-3 mb-3" style="background-color: var(--bg-color); border-radius: 10px; border: 1px solid var(--border-color); transition: all 0.2s;">
                            <div class="d-flex align-items-center gap-3" style="min-width: 0; flex: 1;">
                                <div class="card-image" style="flex-shrink: 0;">
                                    @if($post->image_url)
                                        <img src="{{ $post->image_url }}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border: 1px solid var(--border-color);">
                                            <i data-feather="image" class="text-muted" style="width: 16px; height: 16px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div style="min-width: 0; flex: 1;">
                                    <h6 class="mb-1" style="font-size: 13px; font-weight: 700; color: var(--heading-color); line-height: 1.4; white-space: normal; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{ $post->title }}</h6>
                                    <div class="d-flex align-items-center gap-2 text-muted font-xxs" style="font-size: 11px;">
                                        <span class="badge bg-light text-dark px-2 py-0.5" style="border-radius: 4px; font-size: 9px; font-weight: 600;">{{ $post->category }}</span>
                                        <span>•</span>
                                        <span><i data-feather="eye" style="width: 10px; height: 10px; margin-right: 3px; display: inline-block; vertical-align: middle;"></i>{{ $post->views_count }} {{ $lang === 'en' ? 'views' : ($lang === 'pb' ? 'ਵਿਊਜ਼' : 'व्यूज') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-2">
                                @if($post->status === 'published')
                                    <span class="badge" style="background-color: #d1fae5; color: #065f46; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">{{ $t['published'] ?? 'Published' }}</span>
                                @elseif($post->status === 'pending')
                                    <span class="badge" style="background-color: #fef3c7; color: #92400e; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">{{ $t['pending'] ?? 'Pending' }}</span>
                                @else
                                    <span class="badge" style="background-color: #fee2e2; color: #991b1b; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 600;">{{ $post->status }}</span>
                                @endif
                                <a href="/admin/post/{{ $post->id }}/edit" class="btn btn-sm" style="color: var(--primary-color); padding: 2px 6px;" title="Edit"><i data-feather="edit-2" style="width: 14px; height: 14px;"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="mb-2">
                                <i data-feather="file-text" class="text-muted" style="width: 36px; height: 36px; opacity: 0.3;"></i>
                            </div>
                            <p class="font-sm mb-0">{{ $t['no_articles_found'] ?? 'No articles found.' }}</p>
                            <a href="/admin/post/create" class="btn-tag mt-3 text-white text-decoration-none" style="background-color: var(--primary-color); padding: 6px 12px; font-size: 11px; border-radius: 4px; display: inline-block;">{{ $t['publish_first_article'] ?? 'Publish First Article' }}</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-4">
    <div class="container-fluid px-0">
        <div class="box-footer">
            <div class="row">
                <div class="col-md-6 col-sm-12 text-center text-md-start">
                    <p class="font-sm color-text-paragraph-2">© {{ date('Y') }} - <a class="color-brand-2" href="/">Aaksh News 24 </a>{{ $t['admin_dashboard'] ?? 'Admin Dashboard' }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection