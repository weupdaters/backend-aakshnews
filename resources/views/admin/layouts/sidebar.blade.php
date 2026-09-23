<div class="nav-sidebar">
    <nav class="nav-main-menu">
        <ul class="main-menu">
            <li>
                <a href="/admin/dashboard" class="sidebar-btn {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="sidebar-icon icon-animate"></i> 
                    <span class="name">{{ $t['dashboard'] ?? 'Dashboard' }}</span>
                </a>
            </li>

            <!-- SECTION: CONTENT -->
            <li class="sidebar-section-title px-3 pt-3 pb-1 text-uppercase font-xxs text-muted" style="font-weight: 800; letter-spacing: 0.08em; font-size: 11px;">
                CONTENT
            </li>
            <li>
                <a href="/admin/post" class="sidebar-btn {{ request()->is('admin/post*') ? 'active' : '' }}">
                    <i data-lucide="file-text" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">{{ $t['news_articles'] ?? 'News Articles' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/category" class="sidebar-btn {{ request()->is('admin/category*') ? 'active' : '' }}">
                    <i data-lucide="folder" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">{{ $t['categories'] ?? 'Categories' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/gallery" class="sidebar-btn {{ request()->is('admin/gallery*') ? 'active' : '' }}">
                    <i data-lucide="image" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">Media Library</span>
                </a>
            </li>
            <li>
                <a href="/admin/breaking-news" class="sidebar-btn {{ request()->is('admin/breaking-news*') ? 'active' : '' }}">
                    <i data-lucide="flame" class="sidebar-icon icon-animate icon-wiggle-hover"></i> 
                    <span class="name">{{ $t['breaking_news'] ?? 'Breaking News' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/instagram" class="sidebar-btn {{ request()->is('admin/instagram*') ? 'active' : '' }}">
                    <i data-lucide="film" class="sidebar-icon icon-animate icon-spin-hover"></i> 
                    <span class="name">{{ $t['reels'] ?? 'Instagram Reels' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/gallery" class="sidebar-btn">
                    <i data-lucide="camera" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">{{ $t['gallery'] ?? 'Photo Gallery' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/advertisement" class="sidebar-btn {{ request()->is('admin/advertisement*') ? 'active' : '' }}">
                    <i data-lucide="tv" class="sidebar-icon icon-animate icon-spin-hover"></i> 
                    <span class="name">{{ $t['advertisements'] ?? 'Advertisements' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/messages" class="sidebar-btn {{ request()->is('admin/messages*') ? 'active' : '' }}">
                    <i data-lucide="message-square" class="sidebar-icon icon-animate icon-wiggle-hover"></i> 
                    <span class="name">Comments</span>
                </a>
            </li>
            <li>
                <a href="/admin/subscribers" class="sidebar-btn {{ request()->is('admin/subscribers*') ? 'active' : '' }}">
                    <i data-lucide="mail" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">{{ $t['subscribers'] ?? 'Subscribers' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/subscribers" class="sidebar-btn">
                    <i data-lucide="send" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">Newsletter</span>
                </a>
            </li>
            <li>
                <a href="/admin/push" class="sidebar-btn {{ request()->is('admin/push*') ? 'active' : '' }}">
                    <i data-lucide="bell" class="sidebar-icon icon-animate icon-wiggle-hover" style="color: #F59E0B;"></i> 
                    <span class="name">Push Notifications</span>
                    <span class="badge ms-auto" style="background-color: #EF4444; color: white; font-size: 9px; font-weight: 800; border-radius: 9999px; padding: 2px 6px;">Live</span>
                </a>
            </li>
            <li>
                <a href="http://localhost:3000/live-tv" target="_blank" class="sidebar-btn">
                    <i data-lucide="radio" class="sidebar-icon icon-animate icon-spin-hover text-danger"></i> 
                    <span class="name">Live TV</span>
                </a>
            </li>
            <li>
                <a href="/admin/instagram" class="sidebar-btn">
                    <i data-lucide="layers" class="sidebar-icon icon-animate"></i> 
                    <span class="name">Web Stories</span>
                </a>
            </li>

            <!-- SECTION: AI TOOLS matching media_1790110704755.png -->
            <li class="sidebar-section-title px-3 pt-3 pb-1 text-uppercase font-xxs" style="color: #8EA5C8 !important; font-weight: 800; letter-spacing: 0.08em; font-size: 11px;">
                AI TOOLS
            </li>
            <li>
                <a href="/admin/post/create" class="sidebar-btn d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center">
                        <i data-lucide="sparkles" class="sidebar-icon icon-animate" style="color: #FFC400;"></i> 
                        <span class="name">AI Article Writer</span>
                    </span>
                    <span class="badge" style="background-color: #1769D2; color: #FFFFFF; font-size: 10px; font-weight: 800; border-radius: 9999px; padding: 2px 7px;">AI</span>
                </a>
            </li>
            <li>
                <a href="/admin/post/create#btn-ai-image" class="sidebar-btn d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center">
                        <i data-lucide="image-plus" class="sidebar-icon icon-animate" style="color: #FFC400;"></i> 
                        <span class="name">AI Image Generator</span>
                    </span>
                    <span class="badge" style="background-color: #1769D2; color: #FFFFFF; font-size: 10px; font-weight: 800; border-radius: 9999px; padding: 2px 7px;">AI</span>
                </a>
            </li>
            <li>
                <a href="/admin/post/create#btn-auto-translate" class="sidebar-btn d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center">
                        <i data-lucide="languages" class="sidebar-icon icon-animate" style="color: #FFC400;"></i> 
                        <span class="name">Translation</span>
                    </span>
                    <span class="badge" style="background-color: #1769D2; color: #FFFFFF; font-size: 10px; font-weight: 800; border-radius: 9999px; padding: 2px 7px;">AI</span>
                </a>
            </li>

            <!-- SECTION: SETTINGS -->
            <li class="sidebar-section-title px-3 pt-3 pb-1 text-uppercase font-xxs" style="color: #8EA5C8 !important; font-weight: 800; letter-spacing: 0.08em; font-size: 11px;">
                SETTINGS
            </li>
            <li>
                <a href="/admin/settings" class="sidebar-btn {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i data-lucide="settings" class="sidebar-icon icon-animate icon-spin-hover"></i> 
                    <span class="name">{{ $t['settings'] ?? 'General Settings' }}</span>
                </a>
            </li>
            <li>
                <a href="/admin/reader-corner" class="sidebar-btn">
                    <i data-lucide="users" class="sidebar-icon icon-animate icon-hover-bounce"></i> 
                    <span class="name">Users & Roles</span>
                </a>
            </li>
            <li>
                <a href="/admin/settings" class="sidebar-btn">
                    <i data-lucide="sliders" class="sidebar-icon icon-animate"></i> 
                    <span class="name">Website Settings</span>
                </a>
            </li>

            <li class="border-top my-2 pt-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <a href="http://localhost:3000" target="_blank" class="sidebar-btn" style="color: #FFC400; font-weight: 700;">
                    <i data-lucide="external-link" class="sidebar-icon icon-animate icon-hover-bounce" style="color: #FFC400;"></i> 
                    <span class="name">{{ $t['view_website'] ?? 'View Live Website' }}</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="sidebar-btn text-danger">
                    <i data-lucide="log-out" class="sidebar-icon icon-animate icon-wiggle-hover" style="color: #E53935;"></i> 
                    <span class="name" style="color: #FCA5A5;">{{ $t['logout'] ?? 'Logout' }}</span>
                </a>
                <form id="sidebar-logout-form" action="/admin/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Upgrade to Pro Card matching media_1790110704755.png -->
    <div class="card p-3 my-3 border-0 shadow-xs" style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border: 1px solid #FDE68A !important; border-radius: 16px;">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span style="font-size: 18px;">👑</span>
            <span style="font-weight: 800; color: #92400E; font-size: 13px;">Upgrade to Pro</span>
        </div>
        <p class="font-xxs text-muted mb-2" style="font-size: 11px; color: #B45309 !important;">
            Get advanced AI tools, media storage and detailed analytics.
        </p>
        <button class="btn btn-sm w-100 font-xs btn-cta-yellow" style="background-color: #FFC400; color: #062B63; border-radius: 10px; font-weight: 800; padding: 7px 12px; border: none; box-shadow: 0 2px 8px rgba(245, 169, 0, 0.3);">
            Upgrade Now
        </button>
    </div>

    <!-- Live Now Widget matching media_1790110704755.png -->
    <div class="card p-3 border-0 text-white" style="background-color: #041D44; border: 1px solid rgba(255, 255, 255, 0.08) !important; border-radius: 16px;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="d-flex align-items-center gap-1 font-xxs text-uppercase text-danger font-weight-bold" style="font-size: 10px; color: #E53935 !important;">
                <span class="spinner-grow spinner-grow-sm text-danger" style="width: 8px; height: 8px; background-color: #E53935;" role="status"></span>
                LIVE NOW
            </span>
            <span class="badge" style="background-color: #E53935; font-size: 9px; padding: 2px 6px;">LIVE</span>
        </div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span style="font-weight: 800; font-size: 12px; color: #F1F5F9;">AAKSH NEWS 24x7</span>
        </div>
        <p class="font-xxs text-muted mb-2" style="font-size: 10px; color: #8EA5C8 !important;">
            24x7 Punjabi News Channel
        </p>
        <a href="http://localhost:3000/live-tv" target="_blank" class="btn btn-sm btn-outline-light w-100 font-xxs d-flex align-items-center justify-content-center gap-1" style="border-radius: 8px; font-size: 11px; border-color: rgba(255, 255, 255, 0.2);">
            <span>Watch Live TV</span>
            <i data-lucide="arrow-right" style="width: 12px; height: 12px;"></i>
        </a>
    </div>
</div>