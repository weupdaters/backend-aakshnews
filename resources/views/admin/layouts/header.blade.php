<!-- Header (Sticky Bar) -->
    <header class="header sticky-bar">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo">
                    <a href="http://localhost:3000/">
                        <img src="{{ asset('images/logo.png') }}" alt="Aaksh News Logo">
                        <span class="brand-logo-text">AAKSH <span>NEWS 24</span></span>
                    </a>
                </div>
                <span class="btn-grey-small ml-10">{{ $t['admin_area'] ?? 'Admin area' }}</span>
            </div>

            <div class="header-right">
                <!-- Tri-lingual Language selector -->
                <div class="lang-controls" style="display: flex; gap: 6px; margin-right: 15px; align-items: center;">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" style="background: #2e4ead; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'en' ? '1' : '0.5' }};">EN</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'hi']) }}" style="background: #e53e3e; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'hi' ? '1' : '0.5' }};">हिं</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'pb']) }}" style="background: #dd6b20; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; transition: opacity 0.2s; opacity: {{ $lang === 'pb' ? '1' : '0.5' }};">ਪੰ</a>
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
                                    <form action="/api/logout" method="POST" id="logout-form" style="display:none;">
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