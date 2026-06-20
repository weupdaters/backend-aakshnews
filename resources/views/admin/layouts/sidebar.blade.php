<div class="nav-sidebar">
    <div class="mb-4">
        <small class="text-uppercase text-muted font-monospace fw-bold" style="font-size: 10px; letter-spacing: 1px;">{{ $lang === 'hi' ? 'मुख्य' : ($lang === 'pb' ? 'ਮੁੱਖ' : 'Main') }}</small>
    </div>
    <nav class="nav-main-menu">
        <ul class="main-menu">
            <li>
                <a href="/admin/dashboard" class="sidebar-btn {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i data-feather="grid"></i> <span class="name">{{ $t['dashboard'] ?? 'Dashboard' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/category" class="sidebar-btn {{ request()->is('admin/category*') ? 'active' : '' }}">
                    <i data-feather="folder"></i> <span class="name">{{ $t['categories'] ?? 'Categories' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/post" class="sidebar-btn {{ request()->is('admin/post*') ? 'active' : '' }}">
                    <i data-feather="file-text"></i> <span class="name">{{ $t['news_articles'] ?? 'News Articles' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/advertisement" class="sidebar-btn {{ request()->is('admin/advertisement*') ? 'active' : '' }}">
                    <i data-feather="tv"></i> <span class="name">{{ $t['advertisements'] ?? 'Advertisements' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/breaking-news" class="sidebar-btn {{ request()->is('admin/breaking-news*') ? 'active' : '' }}">
                    <i data-feather="zap"></i> <span class="name">{{ $t['breaking_news'] ?? 'Breaking News' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/instagram" class="sidebar-btn {{ request()->is('admin/instagram*') ? 'active' : '' }}">
                    <i data-feather="instagram"></i> <span class="name">{{ $t['instagram_reels'] ?? 'Instagram Reels' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/gallery" class="sidebar-btn {{ request()->is('admin/gallery*') ? 'active' : '' }}">
                    <i data-feather="image"></i> <span class="name">{{ $t['gallery'] ?? 'Photo Gallery' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/dashboard#subscribers-tab" class="sidebar-btn">
                    <i data-feather="mail"></i> <span class="name">{{ $t['subscribers'] ?? 'Subscribers' }}</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="sidebar-btn text-danger">
                    <i data-feather="log-out"></i> <span class="name">{{ $t['logout'] ?? 'Logout' }}</span>
                </a>
                <form id="sidebar-logout-form" action="/api/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Profile Completed Widget -->
    <div class="box-profile-completed mt-4">
        <h6>{{ $t['ai_moderation_status'] ?? 'AI Moderation Status' }}</h6>
        <p class="mb-0">{{ $t['ai_moderation_desc'] ?? 'Status: 100% Active. All posts scanned and processed.' }}</p>
    </div>

    <!-- Banner Card -->
    <div class="sidebar-border-bg mt-auto">
        <span class="text-grey">{{ $t['live_broadcast'] ?? 'LIVE BROADCAST' }}</span>
        <span class="text-hiring">{{ $t['aakash_news'] ?? 'AAKASH NEWS' }}</span>
        <p>{{ $t['broadcast_desc'] ?? 'Always ahead. Live coverage of national and local breaking news 24/7.' }}</p>
        <a href="/" class="btn-paragraph-2">{{ $t['view_live_tv'] ?? 'View Live TV' }}</a>
    </div>
</div>