<!-- Header (Sticky Bar) -->
    <header class="header sticky-bar">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo">
                    <a href="/admin/dashboard" class="d-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('images/logo.png') }}" alt="Aaksh News Logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 6px rgba(6, 43, 99, 0.2);">
                        <span class="brand-logo-text" style="font-size: 1.25rem; font-weight: 800; color: var(--navy-deep); letter-spacing: -0.5px;">AAKSH <span style="color: var(--primary-color);">NEWS <span style="background-color: var(--cta-yellow); color: var(--navy-deep); padding: 1px 6px; border-radius: 4px; font-size: 0.95rem;">24</span></span></span>
                    </a>
                </div>
                <span class="btn-grey-small ml-10" style="background-color: var(--badge-bg); color: var(--primary-color); font-weight: 800;">{{ $t['admin_area'] ?? 'Admin area' }}</span>
            </div>

            <div class="header-right">
                <!-- Tri-lingual Language selector -->
                <div class="lang-controls" style="display: flex; gap: 6px; margin-right: 15px; align-items: center;">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" style="background: #1769D2; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'en' ? '1' : '0.45' }};">EN</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'hi']) }}" style="background: #E53935; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'hi' ? '1' : '0.45' }};">हिं</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'pb']) }}" style="background: #F59E0B; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'pb' ? '1' : '0.45' }};">ਪੰ</a>
                </div>

                <!-- Theme Toggle Button -->
                <button class="theme-toggle-btn" id="theme-btn">{{ $t['dark_mode'] ?? '🌙 Dark Mode' }}</button>
                
                <!-- Profile dropdown -->
                <div class="member-login">
                    <div class="user-avatar-circle">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="info-member">
                        <strong>{{ auth()->user()->name }}</strong>
                        <div class="dropdown">
                            <a class="dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $t['super_admin'] ?? 'Super Admin' }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownProfile">
                                <li><a class="dropdown-item" href="/admin/dashboard">{{ $t['dashboard'] ?? 'Dashboard' }}</a></li>
                                <li>
                                    <form action="/admin/logout" method="POST" id="logout-form" style="display:none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ $t['logout'] ?? 'Logout' }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>