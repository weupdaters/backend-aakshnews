@php
    $today = new DateTime();
    if ($lang === 'en') {
        $dateString = $today->format('l, F j, Y');
    } elseif ($lang === 'pb') {
        $days = ['ਐਤਵਾਰ', 'ਸੋਮਵਾਰ', 'ਮੰਗਲਵਾਰ', 'ਬੁੱਧਵਾਰ', 'ਵੀਰਵਾਰ', 'ਸ਼ੁੱਕਰਵਾਰ', 'ਸ਼ਨੀਵਾਰ'];
        $months = ['', 'ਜਨਵਰੀ', 'ਫ਼ਰਵਰੀ', 'ਮਾਰਚ', 'ਅਪ੍ਰੈਲ', 'ਮਈ', 'ਜੂਨ', 'ਜੁਲਾਈ', 'ਅਗਸਤ', 'ਸਤੰਬਰ', 'ਅਕਤੂਬਰ', 'ਨਵੰਬਰ', 'ਦਸੰਬਰ'];
        $dateString = $days[$today->format('w')] . ', ' . $today->format('j') . ' ' . $months[$today->format('n')] . ' ' . $today->format('Y');
    } else {
        $days = ['रविवार', 'सोमवार', 'मंगलवार', 'बुधवार', 'गुरुवार', 'शुक्रवार', 'शनिवार'];
        $months = ['', 'जनवरी', 'फरवरी', 'मार्च', 'अप्रैल', 'मई', 'जून', 'जुलाई', 'अगस्त', 'सितंबर', 'अक्टूबर', 'नवंबर', 'दिसंबर'];
        $dateString = $days[$today->format('w')] . ', ' . $today->format('j') . ' ' . $months[$today->format('n')] . ' ' . $today->format('Y');
    }
@endphp

<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $lang === 'en' ? 'Aakash News 24 - Always Ahead. English News Portal.' : ($lang === 'pb' ? 'ਆਕਾਸ਼ ਨਿਊਜ਼ 24 - ਹਮੇਸ਼ਾ ਅੱਗੇ. ਪੰਜਾਬੀ ਖ਼ਬਰਾਂ।' : 'Aakash News 24 - Always Ahead। हिंदी न्यूज़ पोर्टल।') }}">
    <title>Aakash News 24 | Always Ahead | {{ $lang === 'en' ? 'English News Portal' : ($lang === 'pb' ? 'ਪੰਜਾਬੀ ਖ਼ਬਰ ਪੋਰਟਲ' : 'हिंदी न्यूज़ पोर्टल') }}</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Google AdSense Auto-Ads (Replace ca-pub-XXXXXXXXXXXXXXX with your actual AdSense Publisher ID) -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXX" crossorigin="anonymous"></script>

    <style>
        /* Modern Scrollbar for scrollable feeds */
        .user-posts-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .user-posts-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 10px;
        }
        .user-posts-scroll::-webkit-scrollbar-thumb {
            background: rgba(229, 62, 62, 0.2);
            border-radius: 10px;
            transition: background 0.3s;
        }
        .user-posts-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(229, 62, 62, 0.5);
        }

        /* Pulsating green animation for verified badge */
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .badge-verified-pulse {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            animation: pulse-green 2.5s infinite;
            border-radius: 20px;
        }

        /* Animated Post Cards */
        .user-post-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01) !important;
        }
        .user-post-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
            border-color: rgba(229, 62, 62, 0.25) !important;
        }

        /* Sleek Ads layout styling */
        .premium-ads-banner {
            background: linear-gradient(135deg, rgba(66, 133, 244, 0.02) 0%, rgba(244, 180, 0, 0.02) 100%);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        .premium-ads-banner:hover {
            border-color: rgba(66, 133, 244, 0.2);
            box-shadow: 0 8px 25px rgba(66, 133, 244, 0.04);
        }

        /* Left vertical nav enhancements */
        .vertical-nav-links li a {
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease !important;
        }
        .vertical-nav-links li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--primary-color);
            transform: scaleY(0);
            transition: transform 0.25s ease;
            transform-origin: bottom;
        }
        .vertical-nav-links li a:hover::after,
        .vertical-nav-links li.active a::after {
            transform: scaleY(1);
        }
        .vertical-nav-links li a i {
            transition: transform 0.3s ease;
        }
        .vertical-nav-links li a:hover i {
            transform: scale(1.12) rotate(3deg);
        }
    </style>
</head>
<body>

    <!-- 1. Top Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div class="top-bar-left">
                <span><i data-feather="calendar"></i> {{ $dateString }}</span>
                <span class="weather"><i data-feather="sun" style="color: #f6ad55;"></i> {{ $lang === 'en' ? '32°C New Delhi' : ($lang === 'pb' ? '32°C ਨਵੀਂ ਦਿੱਲੀ' : '32°C नई दिल्ली') }}</span>
            </div>
            
            <div class="top-bar-ticker">
                <span class="ticker-badge">Breaking</span>
                <div class="ticker-text-wrapper">
                    <span class="ticker-text">
                        {!! implode(" &nbsp;&nbsp;•&nbsp;&nbsp; ", $breakingNews) !!}
                    </span>
                </div>
            </div>

            <div class="top-bar-right">
                <div class="font-controls">
                    <button class="font-btn" id="font-minus" title="फ़ॉन्ट छोटा करें">A-</button>
                    <button class="font-btn" id="font-reset" title="फ़ॉन्ट रीसेट करें">A</button>
                    <button class="font-btn" id="font-plus" title="फ़ॉन्ट बड़ा करें">A+</button>
                </div>
                <button class="theme-toggle" id="notification-bell-btn" title="{{ $lang === 'en' ? 'Get Notifications' : ($lang === 'pb' ? 'ਨੋਟੀਫਿਕੇਸ਼ਨ ਪ੍ਰਾਪਤ ਕਰੋ' : 'नोटिफिकेशन प्राप्त करें') }}" style="margin-right: 5px;">
                    <i data-feather="bell"></i>
                </button>
                <button class="theme-toggle" id="theme-toggle-btn" title="थीम बदलें">
                    <i data-feather="moon"></i>
                </button>
                
                <div class="lang-controls" style="display: flex; gap: 6px; margin: 0 5px;">
                    <a href="/?lang=en" style="background: #2e4ead; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 55px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">English</a>
                    <a href="/?lang=hi" style="background: #e53e3e; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">हिंदी</a>
                    <a href="/?lang=pb" style="background: #dd6b20; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">ਪੰਜਾਬੀ</a>
                </div>

                @auth
                    <div id="auth-user-container" style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 600; color: var(--text-main);">
                        <span style="color: var(--border-color);">|</span>
                        <span><i data-feather="user"></i> {{ auth()->user()->name }}</span>
                        <span style="color: var(--border-color);">|</span>
                        <a href="/admin/dashboard" style="color: var(--primary-color);">डैशबोर्ड</a>
                        <span style="color: var(--border-color);">|</span>
                        <a href="#" id="laravel-logout-btn">लॉगआउट</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- 2. Main Header -->
    <header class="main-header">
        <div class="container header-grid">
            <div class="logo-area">
                <a href="/" class="logo" style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Aakash News 24 Logo" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.08); flex-shrink: 0;">
                    <div style="display: flex; flex-direction: column; line-height: 1.1;">
                        <div style="display: flex; align-items: center;">
                            <span style="color: #1a2b4c; font-weight: 900; font-size: 1.45rem; letter-spacing: 0.5px;">AAKASH</span>
                            <span style="color: #e53e3e; font-weight: 900; font-size: 1.45rem; letter-spacing: 0.5px; margin-left: 6px;">NEWS 24</span>
                        </div>
                        <span class="tagline" style="font-size: 0.72rem; font-weight: 800; color: var(--text-muted); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 2px;">Always Ahead</span>
                    </div>
                </a>
            </div>

            <div class="search-bar">
                <input type="text" class="search-input" placeholder="{{ $t['search'] }}" id="search-input" style="border-radius: 8px; background: #f0f4f8; border: 1px solid #d2dbe5; padding: 10px 18px;">
                <i data-feather="search" class="search-icon" id="search-btn" style="color: #4a5568;"></i>
            </div>

            <div class="header-actions" style="gap: 25px;">
                <div class="header-action-item">
                    <i data-feather="file-text" style="font-size: 1.4rem;"></i>
                    <span style="font-size: 0.8rem; font-weight: 700; margin-top: 4px;">{{ $t['epaper'] }}</span>
                </div>
                <div class="header-action-item">
                    <i data-feather="tv" style="font-size: 1.4rem;"></i>
                    <span style="font-size: 0.8rem; font-weight: 700; margin-top: 4px;">{{ $lang === 'en' ? 'Live TV' : ($lang === 'pb' ? 'ਲਾਈਵ ਟੀਵੀ' : 'लाइव टीवी') }}</span>
                </div>
                <div class="header-action-item">
                    <i data-feather="smartphone" style="font-size: 1.4rem;"></i>
                    <span style="font-size: 0.8rem; font-weight: 700; margin-top: 4px;">{{ $lang === 'en' ? 'App Download' : ($lang === 'pb' ? 'ਐਪ ਡਾਊਨਲੋਡ' : 'एप डाउनलोड') }}</span>
                </div>
                @guest
                    <button class="bookmark-btn" id="laravel-login-btn" style="background-color: #e53e3e; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(229,62,62,0.2);">
                        <i data-feather="user"></i>
                        <span>{{ $lang === 'en' ? 'Login / Register' : ($lang === 'pb' ? 'ਲੌਗਇਨ / ਰਜਿਸਟ੍ਰੇਸ਼ਨ' : 'लॉगिन / रजिस्ट्रेशन') }}</span>
                    </button>
                @else
                    <button class="bookmark-btn" onclick="window.location.href='/admin/dashboard'" style="background-color: #3182ce; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(49,130,206,0.2);">
                        <i data-feather="columns"></i>
                        <span>{{ $lang === 'en' ? 'Dashboard' : ($lang === 'pb' ? 'ਡੈਸ਼ਬੋਰਡ' : 'डैशबोर्ड') }}</span>
                    </button>
                @endguest
            </div>
        </div>
    </header>

    <!-- 3. Navigation Bar -->
    <nav class="nav-bar">
        <div class="container nav-container">
            <button class="hamburger-btn" id="hamburger-btn" title="मेन्यू खोलें">
                <i data-feather="menu"></i>
            </button>
            <ul class="nav-links">
                <li class="nav-item {{ !isset($selectedCategory) || !$selectedCategory ? 'active' : '' }}"><a href="/?lang={{ $lang }}">{{ $t['home'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'national' ? 'active' : '' }}"><a href="/?category=national&lang={{ $lang }}">{{ $t['national'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'state' ? 'active' : '' }}"><a href="/?category=state&lang={{ $lang }}">{{ $t['state'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'politics' ? 'active' : '' }}"><a href="/?category=politics&lang={{ $lang }}">{{ $t['politics'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'sports' ? 'active' : '' }}"><a href="/?category=sports&lang={{ $lang }}">{{ $t['sports'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'business' ? 'active' : '' }}"><a href="/?category=business&lang={{ $lang }}">{{ $t['business'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'technology' ? 'active' : '' }}"><a href="/?category=technology&lang={{ $lang }}">{{ $t['technology'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'entertainment' ? 'active' : '' }}"><a href="/?category=entertainment&lang={{ $lang }}">{{ $t['entertainment'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'lifestyle' ? 'active' : '' }}"><a href="/?category=lifestyle&lang={{ $lang }}">{{ $t['lifestyle'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'education' ? 'active' : '' }}"><a href="/?category=education&lang={{ $lang }}">{{ $t['education'] }}</a></li>
                <li class="nav-item {{ isset($selectedCategory) && $selectedCategory === 'world' ? 'active' : '' }}"><a href="/?category=world&lang={{ $lang }}">{{ $t['world'] }}</a></li>
                <li class="nav-item dropdown {{ isset($selectedCategory) && $selectedCategory === 'gallery' ? 'active' : '' }}">
                    <a href="#">{{ $t['more'] }} <i data-feather="chevron-down" style="font-size: 0.8rem; margin-left: 2px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ $t['career'] }}</a></li>
                        <li><a href="#">{{ $t['religion'] }}</a></li>
                        <li><a href="/?category=gallery&lang={{ $lang }}">{{ $t['gallery'] }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Sidebar Drawer -->
    <div class="mobile-sidebar" id="mobile-sidebar">
        <div class="mobile-sidebar-header">
            <a href="/" class="logo" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Aakash News 24" style="height: 36px; width: 36px; border-radius: 50%;" />
                <span style="color: var(--text-main); font-weight: 900; font-size: 1.25rem;">AAKASH <span style="color: #e53e3e;">NEWS 24</span></span>
            </a>
            <button class="mobile-sidebar-close" id="sidebar-close">&times;</button>
        </div>
        <ul class="mobile-nav-links">
            <li class="{{ !isset($selectedCategory) || !$selectedCategory ? 'active' : '' }}"><a href="/?lang={{ $lang }}">{{ $t['home'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'national' ? 'active' : '' }}"><a href="/?category=national&lang={{ $lang }}">{{ $t['national'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'state' ? 'active' : '' }}"><a href="/?category=state&lang={{ $lang }}">{{ $t['state'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'politics' ? 'active' : '' }}"><a href="/?category=politics&lang={{ $lang }}">{{ $t['politics'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'sports' ? 'active' : '' }}"><a href="/?category=sports&lang={{ $lang }}">{{ $t['sports'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'business' ? 'active' : '' }}"><a href="/?category=business&lang={{ $lang }}">{{ $t['business'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'technology' ? 'active' : '' }}"><a href="/?category=technology&lang={{ $lang }}">{{ $t['technology'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'entertainment' ? 'active' : '' }}"><a href="/?category=entertainment&lang={{ $lang }}">{{ $t['entertainment'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'lifestyle' ? 'active' : '' }}"><a href="/?category=lifestyle&lang={{ $lang }}">{{ $t['lifestyle'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'education' ? 'active' : '' }}"><a href="/?category=education&lang={{ $lang }}">{{ $t['education'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'world' ? 'active' : '' }}"><a href="/?category=world&lang={{ $lang }}">{{ $t['world'] }}</a></li>
            <li class="{{ isset($selectedCategory) && $selectedCategory === 'gallery' ? 'active' : '' }}"><a href="/?category=gallery&lang={{ $lang }}">{{ $t['gallery'] }}</a></li>
        </ul>
    </div>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- 4. Breaking News Sub-Ticker -->
    <div class="breaking-ticker-bar">
        <div class="container breaking-container">
            <span class="breaking-label"><i data-feather="zap"></i> {{ $lang === 'en' ? 'Breaking News' : ($lang === 'pb' ? 'ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ' : 'ब्रेकिंग न्यूज़') }}</span>
            <div class="breaking-slider-wrapper">
                @foreach ($breakingNews as $idx => $news)
                    <div class="breaking-slide {{ $idx === 0 ? 'active' : '' }}">
                        • {{ $news }}
                    </div>
                @endforeach
            </div>
            <div class="breaking-nav-btns">
                <button class="breaking-nav-btn" id="breaking-prev"><i data-feather="chevron-left"></i></button>
                <button class="breaking-nav-btn" id="breaking-next"><i data-feather="chevron-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Today's Horoscope Section -->
    <div class="horoscope-section" style="background: var(--bg-card); border-bottom: 1px solid var(--border-color); padding: 15px 0; margin-bottom: 15px;">
        <div class="container">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <span style="font-size: 1.15rem; font-weight: 850; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
                    🔮 {{ $lang === 'en' ? "Today's Horoscope" : ($lang === 'pb' ? "ਅੱਜ ਦਾ ਰਾਸ਼ੀਫਲ" : "आज का राशिफल") }}
                </span>
                <span style="font-size: 0.68rem; background: rgba(229, 62, 62, 0.1); color: var(--primary-color); padding: 2px 8px; border-radius: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $lang === 'en' ? 'Daily' : ($lang === 'pb' ? 'ਰੋਜ਼ਾਨਾ' : 'दैनिक') }}
                </span>
            </div>
            
            <div class="horoscope-scroll" style="display: flex; gap: 12px; overflow-x: auto; padding: 5px 2px; scrollbar-width: none; -ms-overflow-style: none;">
                @php
                    $zodiacSigns = [
                        ['id' => 'aries', 'emoji' => '♈', 'en' => 'Aries', 'hi' => 'मेष', 'pb' => 'ਮੇਖ'],
                        ['id' => 'taurus', 'emoji' => '♉', 'en' => 'Taurus', 'hi' => 'वृषभ', 'pb' => 'ਬ੍ਰਿਖ'],
                        ['id' => 'gemini', 'emoji' => '♊', 'en' => 'Gemini', 'hi' => 'मिथुन', 'pb' => 'ਮਿਥੁਨ'],
                        ['id' => 'cancer', 'emoji' => '♋', 'en' => 'Cancer', 'hi' => 'कर्क', 'pb' => 'ਕਰਕ'],
                        ['id' => 'leo', 'emoji' => '♌', 'en' => 'Leo', 'hi' => 'सिंह', 'pb' => 'ਸਿੰਘ'],
                        ['id' => 'virgo', 'emoji' => '♍', 'en' => 'Virgo', 'hi' => 'कन्या', 'pb' => 'ਕੰਨਿਆ'],
                        ['id' => 'libra', 'emoji' => '♎', 'en' => 'Libra', 'hi' => 'तुला', 'pb' => 'ਤੁਲਾ'],
                        ['id' => 'scorpio', 'emoji' => '♏', 'en' => 'Scorpio', 'hi' => 'वृश्चिक', 'pb' => 'ਬ੍ਰਿਸ਼ਚਕ'],
                        ['id' => 'sagittarius', 'emoji' => '♐', 'en' => 'Sagittarius', 'hi' => 'धनु', 'pb' => 'ਧਨੁ'],
                        ['id' => 'capricorn', 'emoji' => '♑', 'en' => 'Capricorn', 'hi' => 'मकर', 'pb' => 'ਮਕਰ'],
                        ['id' => 'aquarius', 'emoji' => '♒', 'en' => 'Aquarius', 'hi' => 'कुंभ', 'pb' => 'ਕੁੰਭ'],
                        ['id' => 'pisces', 'emoji' => '♓', 'en' => 'Pisces', 'hi' => 'मीन', 'pb' => 'ਮੀਨ']
                    ];
                @endphp
                @foreach($zodiacSigns as $sign)
                    <div class="horoscope-card" data-sign="{{ $sign['id'] }}" style="flex: 0 0 auto; display: flex; align-items: center; gap: 8px; background: var(--bg-main); border: 1px solid var(--border-color); padding: 8px 18px; border-radius: 30px; cursor: pointer; transition: all 0.25s ease;">
                        <span style="font-size: 1.35rem;">{{ $sign['emoji'] }}</span>
                        <div style="display: flex; flex-direction: column; line-height: 1.2;">
                            <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-main);">{{ $sign[$lang] }}</span>
                            <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 500;">{{ $sign['en'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Portal Main 3-Column Layout Wrapper -->
    <div class="portal-main-layout">
        
        <!-- Left Sidebar Sticky Navigation Menu -->
        <aside class="portal-left-col">
            <div class="vertical-nav-menu">
                <ul class="vertical-nav-links">
                    <li class="{{ !isset($selectedCategory) || !$selectedCategory ? 'active' : '' }}"><a href="/?lang={{ $lang }}"><i data-feather="home"></i> <span>{{ $t['home'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'national' ? 'active' : '' }}"><a href="/?category=national&lang={{ $lang }}"><i data-feather="flag"></i> <span>{{ $t['national'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'state' ? 'active' : '' }}"><a href="/?category=state&lang={{ $lang }}"><i data-feather="map-pin"></i> <span>{{ $t['state'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'politics' ? 'active' : '' }}"><a href="/?category=politics&lang={{ $lang }}"><i data-feather="grid"></i> <span>{{ $t['politics'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'sports' ? 'active' : '' }}"><a href="/?category=sports&lang={{ $lang }}"><i data-feather="activity"></i> <span>{{ $t['sports'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'business' ? 'active' : '' }}"><a href="/?category=business&lang={{ $lang }}"><i data-feather="briefcase"></i> <span>{{ $t['business'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'technology' ? 'active' : '' }}"><a href="/?category=technology&lang={{ $lang }}"><i data-feather="cpu"></i> <span>{{ $t['technology'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'entertainment' ? 'active' : '' }}"><a href="/?category=entertainment&lang={{ $lang }}"><i data-feather="film"></i> <span>{{ $t['entertainment'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'lifestyle' ? 'active' : '' }}"><a href="/?category=lifestyle&lang={{ $lang }}"><i data-feather="heart"></i> <span>{{ $t['lifestyle'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'education' ? 'active' : '' }}"><a href="/?category=education&lang={{ $lang }}"><i data-feather="book-open"></i> <span>{{ $t['education'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'world' ? 'active' : '' }}"><a href="/?category=world&lang={{ $lang }}"><i data-feather="globe"></i> <span>{{ $t['world'] }}</span></a></li>
                    <li class="{{ isset($selectedCategory) && $selectedCategory === 'gallery' ? 'active' : '' }}"><a href="/?category=gallery&lang={{ $lang }}"><i data-feather="image"></i> <span>{{ $t['gallery'] }}</span></a></li>
                </ul>
            </div>
        </aside>

        <!-- Middle Column: Scrollable Content Feed -->
        <div class="portal-middle-col">
            @if(isset($selectedArticle) && $selectedArticle !== null)
                <!-- Stunning Article Detail View -->
                <div class="article-detail-container" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <!-- Breadcrumbs & Back button -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                        <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: 700; letter-spacing: 1px;">
                            {{ $selectedArticle['category'] }}
                        </span>
                        <a href="/?lang={{ $lang }}" style="background: var(--border-color); color: var(--text-main); text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
                            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> {{ $lang === 'en' ? 'Back' : ($lang === 'pb' ? 'ਵਾਪਸ' : 'वापस') }}
                        </a>
                    </div>

                    <!-- Article Title -->
                    <h1 style="font-size: 2rem; font-weight: 900; color: var(--text-main); line-height: 1.3; margin: 0 0 15px 0;">
                        {{ $selectedArticle['title'] }}
                    </h1>

                    <!-- Article Meta -->
                    <div style="display: flex; align-items: center; gap: 15px; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 20px; flex-wrap: wrap;">
                        <span><i data-feather="user" style="width: 13px; height: 13px; vertical-align: middle; margin-right: 4px;"></i> {{ $selectedArticle['author'] }}</span>
                        <span><i data-feather="clock" style="width: 13px; height: 13px; vertical-align: middle; margin-right: 4px;"></i> {{ $selectedArticle['time'] }}</span>
                        <span><i data-feather="eye" style="width: 13px; height: 13px; vertical-align: middle; margin-right: 4px;"></i> {{ $selectedArticle['views'] }}</span>
                        <button class="bookmark-icon-btn" style="margin-left: auto; background: none; border: none; color: var(--text-muted); cursor: pointer;"><i data-feather="bookmark"></i></button>
                    </div>

                    <!-- Primary Image -->
                    <div style="border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); aspect-ratio: 16/9; max-height: 400px; width: 100%;">
                        <img src="{{ $selectedArticle['image'] }}" alt="{{ $selectedArticle['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <!-- Article Content (First half) -->
                    @php
                        $content = $selectedArticle['content'];
                        $paras = explode("\n", $content);
                        $half = ceil(count($paras) / 2);
                        $firstHalf = array_slice($paras, 0, $half);
                        $secondHalf = array_slice($paras, $half);
                    @endphp

                    <div class="article-body-text" style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); font-weight: 400; text-align: justify; margin-bottom: 25px;">
                        @foreach($firstHalf as $p)
                            @if(trim($p))
                                <p style="margin: 0 0 15px 0; text-indent: 20px;">{{ trim($p) }}</p>
                            @endif
                        @endforeach
                    </div>

                    <!-- Premium Secondary Image (WOW Factor) -->
                    @if(isset($selectedArticle['secondary_image']))
                        <div style="border-radius: 8px; overflow: hidden; margin: 25px 0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); aspect-ratio: 16/9; max-height: 350px; width: 100%;">
                            <img src="{{ $selectedArticle['secondary_image'] }}" alt="Secondary Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="background: rgba(0,0,0,0.03); padding: 8px 12px; font-size: 0.78rem; color: var(--text-muted); border-top: 1px solid var(--border-color); font-style: italic;">
                                {{ $lang === 'en' ? 'Secondary Photograph: Visual report from the field.' : ($lang === 'pb' ? 'ਸੈਕੰਡਰੀ ਤਸਵੀਰ: ਘਟਨਾ ਸਥਾਨ ਤੋਂ ਵਿਜ਼ੂਅਲ ਰਿਪੋਰਟ।' : 'सहायक चित्र: घटनास्थल से विज़ुअल रिपोर्ट।') }}
                            </div>
                        </div>
                    @endif

                    <!-- Article Content (Second half) -->
                    <div class="article-body-text" style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); font-weight: 400; text-align: justify; margin-bottom: 25px;">
                        @foreach($secondHalf as $p)
                            @if(trim($p))
                                <p style="margin: 0 0 15px 0; text-indent: 20px;">{{ trim($p) }}</p>
                            @endif
                        @endforeach
                    </div>

                    <!-- Share Buttons -->
                    <div style="display: flex; gap: 10px; align-items: center; border-top: 1px solid var(--border-color); padding-top: 20px; margin-top: 20px; flex-wrap: wrap;">
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">{{ $lang === 'en' ? 'Share this article:' : ($lang === 'pb' ? 'ਇਸ ਲੇਖ ਨੂੰ ਸਾਂਝਾ ਕਰੋ:' : 'इस लेख को साझा करें:') }}</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($selectedArticle['title'] . ' ' . url()->current()) }}" target="_blank" style="background: #25D366; color: #fff; text-decoration: none; padding: 6px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                            <i data-feather="share-2" style="width: 14px; height: 14px;"></i> WhatsApp
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); createToast('{{ $lang === 'en' ? 'Link copied!' : ($lang === 'pb' ? 'ਲਿੰਕ ਕਾਪੀ ਕੀਤਾ!' : 'लिंक कॉपी किया गया!') }}')" style="background: var(--border-color); color: var(--text-main); border: none; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; cursor: pointer;">
                            <i data-feather="copy" style="width: 14px; height: 14px;"></i> {{ $lang === 'en' ? 'Copy Link' : ($lang === 'pb' ? 'ਲਿੰਕ ਕਾਪੀ ਕਰੋ' : 'लिंक कॉपी करें') }}
                        </button>
                    </div>
                </div>
            @elseif(isset($filteredPosts) && $filteredPosts !== null)
                <!-- Category Filter Header -->
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: 700; letter-spacing: 1px;">
                            {{ $lang === 'en' ? 'Category Feed' : ($lang === 'pb' ? 'ਸ਼੍ਰੇਣੀ ਫੀਡ' : 'श्रेणी फ़ीड') }}
                        </span>
                        <h2 style="margin: 5px 0 0 0; font-size: 1.6rem; font-weight: 900; color: var(--text-main);">
                            @php
                                $categoryNames = [
                                    'national' => $t['national'],
                                    'state' => $t['state'],
                                    'politics' => $t['politics'],
                                    'sports' => $t['sports'],
                                    'business' => $t['business'],
                                    'technology' => $t['technology'],
                                    'entertainment' => $t['entertainment'],
                                    'lifestyle' => $t['lifestyle'],
                                    'education' => $t['education'],
                                    'world' => $t['world'],
                                    'gallery' => $t['gallery']
                                ];
                                echo $categoryNames[strtolower($selectedCategory)] ?? ucfirst($selectedCategory);
                            @endphp
                        </h2>
                    </div>
                    <a href="/?lang={{ $lang }}" style="background: var(--border-color); color: var(--text-main); text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
                        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> {{ $lang === 'en' ? 'Back to Home' : ($lang === 'pb' ? 'ਮੁੱਖ ਪੰਨਾ' : 'मुख्य पृष्ठ') }}
                    </a>
                </div>

                <!-- Category Posts List -->
                @if(count($filteredPosts) > 0)
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                        @foreach ($filteredPosts as $post)
                            <div class="news-card" data-id="{{ $post['id'] ?? '' }}" style="cursor: pointer; display: flex; flex-direction: column; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                                <div class="news-card-img" style="position: relative; width: 100%; height: 180px; overflow: hidden;">
                                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                    <span class="tag tag-{{ strtolower($selectedCategory) }}" style="position: absolute; top: 12px; left: 12px; background: var(--primary-color); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">
                                        {{ $post['category'] }}
                                    </span>
                                </div>
                                <div class="news-card-body" style="padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <h4 class="news-card-title" style="margin: 0 0 10px 0; font-size: 1rem; font-weight: 800; color: var(--text-main); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $post['title'] }}
                                        </h4>
                                        <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin: 0 0 15px 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $post['description'] }}
                                        </p>
                                    </div>
                                    <div class="news-card-footer" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 10px; font-size: 0.75rem; color: var(--text-muted);">
                                        <span><i data-feather="clock" style="width: 12px; height: 12px; vertical-align: middle; margin-right: 4px;"></i>{{ $post['time'] }}</span>
                                        @if($post['views'])
                                            <span><i data-feather="eye" style="width: 12px; height: 12px; vertical-align: middle; margin-right: 4px;"></i>{{ $post['views'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 50px 20px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; color: var(--text-muted);">
                        <i data-feather="file-text" style="width: 48px; height: 48px; stroke-width: 1; color: var(--text-muted); margin-bottom: 15px;"></i>
                        <h4 style="margin: 0 0 5px 0; font-weight: 700; color: var(--text-main);">{{ $lang === 'en' ? 'No Articles Found' : ($lang === 'pb' ? 'ਕੋਈ ਲੇਖ ਨਹੀਂ ਮਿਲਿਆ' : 'कोई लेख नहीं मिला') }}</h4>
                        <p style="font-size: 0.85rem; margin: 0;">{{ $lang === 'en' ? 'No news articles have been published in this category yet.' : ($lang === 'pb' ? 'ਇਸ ਸ਼੍ਰੇਣੀ ਵਿੱਚ ਅਜੇ ਤੱਕ ਕੋਈ ਖ਼ਬਰ ਲੇਖ ਪ੍ਰਕਾਸ਼ਿਤ ਨਹੀਂ ਹੋਇਆ ਹੈ।' : 'इस श्रेणी में अभी तक कोई समाचार लेख प्रकाशित नहीं हुआ है।') }}</p>
                    </div>
                @endif
            @else
                <!-- Original Homepage Content -->
                <!-- 5. Hero Section (Grid Layout) -->
                <section class="hero-section hero-grid">
                
                <!-- Left Large Card -->
                <div class="hero-large-card" data-id="{{ $heroMain['id'] ?? '' }}" style="cursor: pointer;">
                    <div class="card-img-wrapper">
                        <img src="{{ $heroMain['image'] }}" alt="{{ $heroMain['title'] }}" loading="lazy">
                    </div>
                    <div class="hero-large-content">
                        <span class="tag tag-देश">{{ $heroMain['category'] }}</span>
                        <h2 class="hero-large-title">{{ $heroMain['title'] }}</h2>
                        <p class="hero-large-desc">{{ $heroMain['description'] }}</p>
                        <div class="hero-card-footer">
                            <div class="hero-card-meta">
                                <span><i data-feather="clock"></i> {{ $heroMain['time'] }}</span>
                                <span><i data-feather="eye"></i> {{ $heroMain['views'] }}</span>
                            </div>
                            <button class="bookmark-icon-btn"><i data-feather="bookmark"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Middle Stack -->
                <div class="hero-middle-stack">
                    @foreach ($heroMiddleStack as $card)
                        <div class="middle-stack-card" data-id="{{ $card['id'] ?? '' }}" style="cursor: pointer;">
                            <div class="middle-stack-img">
                                <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy">
                            </div>
                            <div class="middle-stack-content">
                                <span class="tag tag-{{ $card['category'] }}">{{ $card['category'] }}</span>
                                <h3 class="middle-stack-title">{{ $card['title'] }}</h3>
                                <span class="middle-stack-time"><i data-feather="clock"></i> {{ $card['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Regional & User Post Desks Row -->
            <section class="regional-desks-row">
                <!-- Card 1: English News -->
                <div onclick="window.location.href='/?lang=en'" style="display: flex; align-items: center; gap: 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #2e4ead; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(46,78,173,0.2);">
                        EN
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1px;">
                        <h4 style="margin: 0; font-size: 0.88rem; font-weight: 800; color: #1a2b4c;">ENGLISH NEWS</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'en' ? 'Daily updates' : ($lang === 'pb' ? 'ਰੋਜ਼ਾਨਾ ਅੱਪਡੇਟ' : 'दैनिक अपडेट') }}</span>
                        <span style="font-size: 0.72rem; color: #2e4ead; font-weight: 700; text-decoration: underline; margin-top: 2px;">{{ $lang === 'en' ? 'Read Now' : ($lang === 'pb' ? 'ਹੁਣੇ ਪੜ੍ਹੋ' : 'अभी पढ़ें') }} &raquo;</span>
                    </div>
                </div>

                <!-- Card 2: Hindi News -->
                <div onclick="window.location.href='/?lang=hi'" style="display: flex; align-items: center; gap: 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #e53e3e; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.95rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(229,62,62,0.2);">
                        HN
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1px;">
                        <h4 style="margin: 0; font-size: 0.88rem; font-weight: 800; color: #1a2b4c;">{{ $lang === 'en' ? 'HINDI NEWS' : ($lang === 'pb' ? 'ਹਿੰਦੀ ਖ਼ਬਰਾਂ' : 'हिंदी समाचार') }}</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'en' ? 'Daily updates' : ($lang === 'pb' ? 'ਰੋਜ਼ਾਨਾ ਅੱਪਡੇਟ' : 'दैनिक अपडेट') }}</span>
                        <span style="font-size: 0.72rem; color: #e53e3e; font-weight: 700; text-decoration: underline; margin-top: 2px;">{{ $lang === 'en' ? 'Read Now' : ($lang === 'pb' ? 'ਹੁਣੇ ਪੜ੍ਹੋ' : 'अभी पढ़ें') }} &raquo;</span>
                    </div>
                </div>

                <!-- Card 3: Punjabi News -->
                <div onclick="window.location.href='/?lang=pb'" style="display: flex; align-items: center; gap: 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #dd6b20; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(221,107,32,0.2);">
                        PB
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1px;">
                        <h4 style="margin: 0; font-size: 0.88rem; font-weight: 800; color: #1a2b4c;">{{ $lang === 'en' ? 'PUNJABI NEWS' : ($lang === 'pb' ? 'ਪੰਜਾਬੀ ਖ਼ਬਰਾਂ' : 'पंजाबी समाचार') }}</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'en' ? 'Daily updates' : ($lang === 'pb' ? 'ਰੋਜ਼ਾਨਾ ਅੱਪਡੇਟ' : 'दैनिक अपडेट') }}</span>
                        <span style="font-size: 0.72rem; color: #dd6b20; font-weight: 700; text-decoration: underline; margin-top: 2px;">{{ $lang === 'en' ? 'Read Now' : ($lang === 'pb' ? 'ਹੁਣੇ ਪੜ੍ਹੋ' : 'अभी पढ़ें') }} &raquo;</span>
                    </div>
                </div>

                <!-- Card 4: Reader's Corner / User Post -->
                <div onclick="window.location.href='/reader-corner'" style="display: flex; align-items: center; gap: 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #8B5CF6; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(139,92,246,0.2);">
                        RC
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1px;">
                        <h4 style="margin: 0; font-size: 0.88rem; font-weight: 800; color: #1a2b4c;">{{ $lang === 'en' ? 'READER\'S CORNER' : ($lang === 'pb' ? 'ਪਾਠਕ ਕੋਨਾ' : 'रीडर्स कॉर्नर') }}</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'en' ? 'Share your updates' : ($lang === 'pb' ? 'ਆਪਣੀ ਖ਼ਬਰ ਸਾਂਝੀ ਕਰੋ' : 'अपनी खबर साझा करें') }}</span>
                        <span style="font-size: 0.72rem; color: #8B5CF6; font-weight: 700; text-decoration: underline; margin-top: 2px;">{{ $lang === 'en' ? 'Submit Post' : ($lang === 'pb' ? 'ਪੋਸਟ ਭੇਜੋ' : 'पोस्ट भेजें') }} &raquo;</span>
                    </div>
                </div>
            </section>

            <!-- 6. Section "ताजा खबरें" -->
            <section class="section-wrapper">
                <div class="section-title-bar">
                    <h3 class="section-title">{{ $t['latest_news'] }}</h3>
                    <a href="#" class="section-view-all">View All <i data-feather="chevron-right" style="font-size: 0.75rem;"></i></a>
                </div>
                
                <div class="latest-grid">
                    @foreach ($latestNews as $news)
                        <div class="news-card" data-id="{{ $news['id'] ?? '' }}" style="cursor: pointer;">
                            <div class="news-card-img">
                                <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" loading="lazy">
                                <span class="tag tag-{{ $news['category'] }}">{{ $news['category'] }}</span>
                            </div>
                            <div class="news-card-body">
                                <h4 class="news-card-title">{{ $news['title'] }}</h4>
                                <div class="news-card-footer">
                                    <span><i data-feather="clock"></i> {{ $news['time'] }}</span>
                                    <i data-feather="bookmark" style="cursor: pointer;"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- 7. Section "वीडियो न्यूज़" -->
            <section class="section-wrapper">
                <div class="section-title-bar">
                    <h3 class="section-title">{{ $t['video_news'] }}</h3>
                    <a href="#" class="section-view-all">View All <i data-feather="chevron-right" style="font-size: 0.75rem;"></i></a>
                </div>

                <div class="video-grid">
                    @foreach ($videoNews as $video)
                        <div class="video-card news-video-trigger" data-idx="{{ $loop->index }}" data-embed="{{ $video['embed_url'] }}" data-title="{{ $video['title'] }}" data-url="{{ $video['url'] }}" data-time="{{ $video['time'] }}" data-category="{{ $video['category'] }}" style="cursor: pointer;">
                            <div class="video-card-thumb">
                                <img src="{{ $video['image'] }}" alt="{{ $video['title'] }}" loading="lazy">
                                <div class="video-overlay">
                                    <div class="play-icon">
                                        <i data-feather="play"></i>
                                    </div>
                                </div>
                                <span class="video-duration">{{ $video['duration'] }}</span>
                            </div>
                            <h4 class="video-title">{{ $video['title'] }}</h4>
                            <div class="video-meta" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <span><i data-feather="clock"></i> {{ $video['time'] }}</span>
                                    <span><i data-feather="eye"></i> {{ $video['views'] }}</span>
                                </div>
                                <button class="card-share-btn" data-url="{{ $video['url'] }}" data-title="{{ $video['title'] }}" style="background: none; border: none; padding: 4px; cursor: pointer; color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; transition: color 0.2s;" title="Share Video">
                                    <i data-feather="share-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Instagram Videos Section -->
            <section class="section-wrapper">
                <div class="section-title-bar">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i data-feather="instagram" style="font-size: 1.8rem; color: #e1306c;"></i>
                        <h3 class="section-title" style="margin-bottom: 0;">{{ $lang === 'en' ? 'Instagram Videos & Reels' : ($lang === 'pb' ? 'ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ ਅਤੇ ਰੀਲਾਂ' : 'इंस्टाग्राम वीडियो & रील्स') }}</h3>
                    </div>
                </div>

                <div class="instagram-grid" id="instagram-videos-container">
                    @forelse ($instagramVideos as $video)
                        <div class="instagram-card" data-idx="{{ $loop->index }}" data-embed="{{ $video->embed_url }}" data-title="{{ $video->title ?? ($lang === 'en' ? 'Instagram Video' : ($lang === 'pb' ? 'ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ' : 'Instagram Video')) }}" data-url="{{ $video->url }}" data-category="मनोरंजन" style="background: #ffffff; border: 1px solid #dbdbdb; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                            
                            <!-- Instagram Header -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-bottom: 1px solid #efefef; background: #fff;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; padding: 2px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('images/logo.png') }}" alt="aakashnews24" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: #262626;">aakashnews24</span>
                                        <span style="font-size: 0.72rem; color: #8e8e8e;">Instagram Reels</span>
                                    </div>
                                </div>
                                <button style="background: #0095f6; color: #fff; border: none; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">View Profile</button>
                            </div>

                            <!-- Instagram Post Content wrapper -->
                            <div style="position: relative; width: 100%; padding-top: 125%; background: #000;">
                                <!-- Click interceptor overlay with play button -->
                                <div class="instagram-card-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.15); transition: background 0.3s;">
                                    <div class="play-btn-overlay" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.4rem; backdrop-filter: blur(2px); transition: all 0.2s;">
                                        <i data-feather="play" style="margin-left: 4px;"></i>
                                    </div>
                                </div>
                                <iframe src="{{ $video->embed_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                            </div>

                            <!-- Instagram Footer Info -->
                            <div style="padding: 12px 14px; background: #fff; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; border-top: 1px solid #efefef;">
                                <div style="margin-bottom: 8px;">
                                    <!-- Action Icons Mockup -->
                                    <div style="display: flex; gap: 12px; font-size: 1.15rem; color: #262626; margin-bottom: 8px; align-items: center;">
                                        <i data-feather="heart" style="cursor: pointer;"></i>
                                        <i data-feather="message-circle" style="cursor: pointer;"></i>
                                        <span class="card-share-btn" data-url="{{ $video->url }}" data-title="{{ $video->title ?? ($lang === 'en' ? 'Instagram Video' : ($lang === 'pb' ? 'ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ' : 'Instagram Video')) }}" style="cursor: pointer; display: inline-flex; align-items: center;" title="Share Video">
                                            <i data-feather="send"></i>
                                        </span>
                                    </div>
                                    <h4 style="font-size: 0.82rem; font-weight: 500; color: #262626; line-height: 1.4; margin: 0; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <strong style="font-weight: 700; margin-right: 5px;">aakashnews24</strong>{{ $video->title ?? ($lang === 'en' ? 'Instagram Video' : ($lang === 'pb' ? 'ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ' : 'Instagram Video')) }}
                                    </h4>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.72rem; color: #8e8e8e;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px;"><i data-feather="clock"></i> {{ $video->created_at->diffForHumans() }}</span>
                                    <span style="color: #0095f6; font-weight: 700;">#aakashnews24</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="no-instagram-videos" style="grid-column: 1 / -1; text-align: center; padding: 40px; background: var(--bg-card); border-radius: 12px; color: var(--text-muted);">
                            <i data-feather="instagram" style="font-size: 3rem; color: #ddd; margin-bottom: 10px; display: block;"></i>
                            <span>{{ $lang === 'en' ? 'No Instagram videos added yet.' : ($lang === 'pb' ? 'ਅਜੇ ਤੱਕ ਕੋਈ ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ ਨਹੀਂ ਜੋੜਿਆ ਗਿਆ।' : 'अभी तक कोई इंस्टाग्राम वीडियो नहीं जोड़ा गया है।') }}</span>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Facebook Videos Section -->
            <section class="section-wrapper">
                <div class="section-title-bar">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i data-feather="facebook" style="font-size: 1.8rem; color: #1877f2;"></i>
                        <h3 class="section-title" style="margin-bottom: 0;">{{ $lang === 'en' ? 'Facebook Videos' : ($lang === 'pb' ? 'ਫੇਸਬੁੱਕ ਵੀਡੀਓ' : 'फेसबुक वीडियो') }}</h3>
                    </div>
                </div>

                <div class="facebook-grid" id="facebook-videos-container">
                    @forelse ($facebookVideos as $video)
                        <div class="facebook-card" data-idx="{{ $loop->index }}" data-embed="{{ $video['embed_url'] }}" data-title="{{ $video['title'] }}" data-url="{{ $video['url'] }}" data-category="{{ $video['category'] }}" data-time="{{ $video['time'] }}" data-duration="{{ $video['duration'] }}" style="background: #ffffff; border: 1px solid #e4e6eb; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                            
                            <!-- Facebook Header -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-bottom: 1px solid #e4e6eb; background: #fff;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; padding: 2px; background: #1877f2; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('images/logo.png') }}" alt="Aakash News 24" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: #050505;">Aakash News 24</span>
                                        <span style="font-size: 0.72rem; color: #65676b;">Facebook Video</span>
                                    </div>
                                </div>
                                <button style="background: #e4e6eb; color: #050505; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer;">Watch</button>
                            </div>

                            <!-- Facebook Post Content wrapper -->
                            <div style="position: relative; width: 100%; padding-top: 56.25%; background: #000;">
                                <!-- Click interceptor overlay with play button -->
                                <div class="facebook-card-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.15); transition: background 0.3s;">
                                    <div class="play-btn-overlay" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(24, 119, 242, 0.9); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.4rem; backdrop-filter: blur(2px); transition: all 0.2s;">
                                        <i data-feather="play" style="margin-left: 4px;"></i>
                                    </div>
                                </div>
                                <iframe src="{{ $video['embed_url'] }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                            </div>

                            <!-- Facebook Footer Info -->
                            <div style="padding: 12px 14px; background: #fff; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; border-top: 1px solid #e4e6eb;">
                                <div style="margin-bottom: 8px;">
                                    <h4 style="font-size: 0.82rem; font-weight: 500; color: #050505; line-height: 1.4; margin: 0; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $video['title'] }}
                                    </h4>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.72rem; color: #65676b;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px;"><i data-feather="clock"></i> {{ $video['time'] }}</span>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="color: #1877f2; font-weight: 700;">#aakashnews24</span>
                                        <button class="card-share-btn" data-url="{{ $video['url'] }}" data-title="{{ $video['title'] }}" style="background: none; border: none; padding: 2px; cursor: pointer; color: #65676b; display: inline-flex; align-items: center; justify-content: center; transition: color 0.2s;" title="Share Video">
                                            <i data-feather="share-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="no-facebook-videos" style="grid-column: 1 / -1; text-align: center; padding: 40px; background: var(--bg-card); border-radius: 12px; color: var(--text-muted);">
                            <i data-feather="facebook" style="font-size: 3rem; color: #ddd; margin-bottom: 10px; display: block;"></i>
                            <span>No Facebook videos added yet.</span>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- 8. Section "खबरें श्रेणी अनुसार" -->
            <section class="section-wrapper">
                <div class="section-title-bar">
                    <h3 class="section-title">News By Category</h3>
                    <a href="#" class="section-view-all">View All <i data-feather="chevron-right" style="font-size: 0.75rem;"></i></a>
                </div>

                <div class="category-grid">
                    @foreach ($categoriesNews as $cat)
                        <div class="category-card {{ $cat['class'] }}">
                            <div class="category-card-header">
                                <div class="category-icon">
                                    <i data-feather="{{ $cat['icon'] == 'fa-landmark' ? 'grid' : ($cat['icon'] == 'fa-running' ? 'activity' : ($cat['icon'] == 'fa-briefcase' ? 'briefcase' : ($cat['icon'] == 'fa-microchip' ? 'cpu' : ($cat['icon'] == 'fa-globe' ? 'globe' : 'file-text')))) }}"></i>
                                </div>
                                <span>{{ $cat['name'] }}</span>
                            </div>
                            <div class="category-card-img">
                                <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" loading="lazy">
                            </div>
                            <ul class="category-news-list">
                                @foreach ($cat['items'] as $idx => $item)
                                    <li class="category-news-item" data-id="{{ $item['id'] }}" style="cursor: pointer;">
                                        <span class="category-bullet">{{ $idx + 1 }}</span>
                                        <span>{{ $item['title'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="panel-more-btn">View More</button>
                        </div>
                    @endforeach
                </div>
            </section>



            <!-- Google Ads Horizontal Banner -->
            @php
                $headerAd = \App\Models\Advertisement::where('status', 'active')
                    ->where('name', 'Header Horizontal Banner (728x90)')
                    ->latest()
                    ->first();
            @endphp
            @if($headerAd)
                <div class="premium-ads-banner" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 10px; margin: 25px 0; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.03); overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <span style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; font-weight: 700; display: block; margin-bottom: 5px;">Advertisement</span>
                    <img src="{{ asset($headerAd->image_url) }}" alt="{{ $headerAd->name }}" style="max-width: 100%; height: auto; border-radius: 8px; object-fit: contain; max-height: 120px;">
                </div>
            @else
                <div class="premium-ads-banner" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px 20px; margin: 25px 0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: relative;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg viewBox="0 0 40 40" width="24" height="24" style="flex-shrink: 0;">
                                <polygon points="5,25 25,5 35,15 15,35" fill="#4285f4" />
                                <polygon points="5,25 15,35 5,35" fill="#34a853" />
                                <polygon points="25,5 35,15 35,5" fill="#fabc05" />
                            </svg>
                            <span style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; font-weight: 700;">Advertisement</span>
                        </div>
                        <div style="width: 1px; height: 25px; background: var(--border-color);"></div>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">Reach Your Target Audience</span>
                            <span style="font-size: 0.78rem; color: var(--text-muted);">Grow your business with Google Ads. Start advertising today!</span>
                        </div>
                    </div>
                    <a 
                        href="https://ads.google.com" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        style="background: #4285f4; color: #fff; text-decoration: none; padding: 8px 18px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 5px;"
                        onmouseenter="this.style.backgroundColor='#357ae8'"
                        onmouseleave="this.style.backgroundColor='#4285f4'"
                    >
                        Learn More <i data-feather="external-link" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            @endif


            <!-- 9. Section "फोटो गैलरी" -->
            <section class="section-wrapper" style="position: relative; margin-bottom: 20px;">
                <div class="section-title-bar">
                    <h3 class="section-title">{{ $t['gallery'] }}</h3>
                    <a href="#" class="section-view-all">View All <i data-feather="chevron-right" style="font-size: 0.75rem;"></i></a>
                </div>

                <div class="gallery-carousel-wrapper">
                    <button class="gallery-control-btn gallery-control-prev" id="gallery-prev">
                        <i data-feather="chevron-left"></i>
                    </button>
                    <div class="gallery-carousel" id="gallery-carousel">
                        @foreach ($photoGallery as $photo)
                            <div class="gallery-item">
                                <img src="{{ $photo['image'] }}" alt="{{ $photo['name'] }}" loading="lazy">
                                <div class="gallery-overlay">{{ $photo['name'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <button class="gallery-control-btn gallery-control-next" id="gallery-next">
                        <i data-feather="chevron-right"></i>
                    </button>
                </div>
            </section>

            <!-- Author Card (visible on mobile/tablet only) -->
            <div class="author-card middle-col-author-card">
                <div class="author-content">
                    <div class="author-avatar-container">
                        <img src="/images/author_avatar.png" alt="Jasbir Singh" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 class="author-name">Jasbir Singh</h4>
                    <span class="author-designation">(Chief Editor)</span>
                    <div class="author-divider">
                        <div class="line-long"></div>
                        <div class="line-short"></div>
                    </div>
                    <div class="author-phone">9815529139</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column Sticky Sidebar -->
        <aside class="portal-right-col">
            <!-- Google Ads Vertical Sidebar Banner -->
            @php
                $sidebarAd = \App\Models\Advertisement::where('status', 'active')
                    ->where('name', 'Sidebar Banner Ad (300x250)')
                    ->latest()
                    ->first();
            @endphp
            @if($sidebarAd)
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <span style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; font-weight: 600; display: block; margin-bottom: 8px;">Advertisement</span>
                    <img src="{{ asset($sidebarAd->image_url) }}" alt="{{ $sidebarAd->name }}" style="width: 100%; height: auto; border-radius: 8px; object-fit: contain; max-height: 250px;">
                </div>
            @else
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: relative;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 12px;">
                        <svg viewBox="0 0 40 40" width="20" height="20" style="flex-shrink: 0;">
                            <polygon points="5,25 25,5 35,15 15,35" fill="#4285f4" />
                            <polygon points="5,25 15,35 5,35" fill="#34a853" />
                            <polygon points="25,5 35,15 35,5" fill="#fabc05" />
                        </svg>
                        <span style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; font-weight: 600;">Advertisement</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                        <div style="width: 100%; height: 150px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <svg viewBox="0 0 100 100" style="width: 100px; height: 100px;">
                                <circle cx="50" cy="50" r="45" fill="#e8f0fe" />
                                <circle cx="50" cy="50" r="35" fill="none" stroke="#4285f4" stroke-width="6" />
                                <circle cx="50" cy="50" r="25" fill="none" stroke="#ea4335" stroke-width="6" />
                                <circle cx="50" cy="50" r="15" fill="none" stroke="#fabc05" stroke-width="6" />
                                <circle cx="50" cy="50" r="5" fill="#34a853" />
                                <line x1="85" y1="15" x2="55" y2="45" stroke="#333" stroke-width="4" stroke-linecap="round" />
                                <polygon points="52,48 50,42 58,40" fill="#333" />
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0 0 5px 0; color: var(--text-main);">Grow Your Business</h4>
                            <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0;">Advertise with Google Ads</p>
                        </div>
                        <a 
                            href="https://ads.google.com" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            style="display: inline-block; width: 100%; background: #4285f4; color: #fff; text-decoration: none; padding: 10px 0; border-radius: 6px; font-size: 0.85rem; font-weight: 700; transition: background-color 0.2s;"
                            onmouseenter="this.style.backgroundColor='#357ae8'"
                            onmouseleave="this.style.backgroundColor='#4285f4'"
                        >
                            Learn More
                        </a>
                    </div>
                </div>
            @endif

            <!-- Short Video (Reels) Widget -->
            <div class="sidebar-panel short-video-widget" style="margin-bottom: 20px;">
                <div class="panel-header" style="border-bottom: none; margin-bottom: 10px;">
                    <i data-feather="video" class="video-icon" style="color: #e1306c;"></i>
                    <span>{{ $lang === 'en' ? 'Short Video' : ($lang === 'pb' ? 'ਸ਼ਾਰਟ ਵੀਡੀਓ' : 'शॉर्ट वीडियो') }}</span>
                </div>
                @php
                    $sidebarShort = !empty($videoNews) ? $videoNews[0] : [
                        'embed_url' => 'https://www.youtube.com/embed/5K1yN9tG4C0?enablejsapi=1',
                        'title' => 'Waterlogging in Delhi due to rain',
                        'url' => 'https://www.youtube.com/shorts/5K1yN9tG4C0',
                        'time' => '1 hour ago',
                        'category' => 'Delhi',
                        'image' => '/images/video_delhi_rain.png',
                        'views' => '12K views'
                    ];
                @endphp
                <div class="short-video-card news-video-trigger" data-idx="0" data-embed="{{ $sidebarShort['embed_url'] }}" data-title="{{ $sidebarShort['title'] }}" data-url="{{ $sidebarShort['url'] }}" data-time="{{ $sidebarShort['time'] }}" data-category="{{ $sidebarShort['category'] }}" style="position: relative; width: 100%; border-radius: 12px; overflow: hidden; background: #000; cursor: pointer; aspect-ratio: 9/16; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <img src="{{ $sidebarShort['image'] }}" alt="Short Video" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%); display: flex; flex-direction: column; justify-content: space-between; padding: 15px;">
                        <div style="align-self: flex-end; background: rgba(225, 48, 108, 0.9); color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
                            LIVE
                        </div>
                        <div>
                            <h4 style="color: #fff; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; line-height: 1.4; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">{{ $sidebarShort['title'] }}</h4>
                            <div style="display: flex; align-items: center; justify-content: space-between; color: #ccc; font-size: 0.8rem; width: 100%;">
                                <span><i data-feather="eye"></i> {{ $sidebarShort['views'] }}</span>
                                <button class="card-share-btn" data-url="{{ $sidebarShort['url'] }}" data-title="{{ $sidebarShort['title'] }}" style="background: none; border: none; padding: 4px; cursor: pointer; color: #fff; display: inline-flex; align-items: center; justify-content: center; z-index: 20;" title="Share Video">
                                    <i data-feather="share-2" style="width: 15px; height: 15px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50px; height: 50px; border-radius: 50%; background: rgba(225,48,108,0.9); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                        <i data-feather="play" style="margin-left: 4px;"></i>
                    </div>
                </div>
            </div>

            <!-- Author Card -->
            <div class="author-card" style="margin-bottom: 20px;">
                <div class="author-content">
                    <div class="author-avatar-container">
                        <img src="/images/author_avatar.png" alt="Jasbir Singh" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 class="author-name">Jasbir Singh</h4>
                    <span class="author-designation">(Chief Editor)</span>
                    <div class="author-divider">
                        <div class="line-long"></div>
                        <div class="line-short"></div>
                    </div>
                    <div class="author-phone">9815529139</div>
                </div>
            </div>

            <!-- Panel 1: Trending News -->
            <div class="sidebar-panel">
                <div class="panel-header">
                    <i data-feather="trending-up" class="trending-icon"></i>
                    <span>{{ $t['trending'] }}</span>
                </div>
                <ul class="panel-list">
                    @foreach ($trendingNews as $idx => $news)
                        <li class="panel-item" data-id="{{ $news['id'] ?? '' }}" style="cursor: pointer;">
                            <span class="panel-number" style="background-color: #e53e3e;">{{ $idx + 1 }}</span>
                            <div class="panel-item-content">
                                <h4 class="panel-item-title">{{ $news['title'] }}</h4>
                                <span class="panel-item-meta">{{ $news['time'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button class="panel-more-btn">View More</button>
            </div>

            <!-- Panel 2: Most Read -->
            <div class="sidebar-panel" style="margin-top: 20px;">
                <div class="panel-header">
                    <i data-feather="zap" class="read-icon"></i>
                    <span>{{ $t['most_read'] }}</span>
                </div>
                <ul class="panel-list">
                    @foreach ($mostRead as $idx => $news)
                        <li class="panel-item" data-id="{{ $news['id'] ?? '' }}" style="cursor: pointer;">
                            <span class="panel-number" style="background-color: #dd6b20;">{{ $idx + 1 }}</span>
                            <div class="panel-item-content">
                                <h4 class="panel-item-title">{{ $news['title'] }}</h4>
                                <span class="panel-item-meta">{{ $news['views'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button class="panel-more-btn">View More</button>
            </div>

            <!-- Premium Support Ad Panel -->
            <div class="sidebar-ad-card" style="margin-top: 20px; background: linear-gradient(135deg, #f53d3d, #c92222); padding: 25px; border-radius: 12px; color: #fff; text-align: center; box-shadow: 0 4px 15px rgba(229,62,62,0.2);">
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">AAKASH NEWS 24 Premium</h4>
                <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 15px; line-height: 1.4;">Support independent journalism. Subscribe today.</p>
                <button style="background: #fff; color: #e53e3e; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 700; cursor: pointer; transition: transform 0.2s;">Subscribe Now</button>
            </div>

            <!-- Google AdSense Sidebar Advertisement -->
            <div class="sidebar-ad-card" style="margin-top: 20px; background: var(--bg-card); border: 1px solid var(--border-color); padding: 15px; border-radius: 12px; text-align: center; box-shadow: var(--box-shadow);">
                <span style="font-size: 0.72rem; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 10px; font-weight: 700; letter-spacing: 1px;">Advertisement</span>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXX"
                     data-ad-slot="1234567890"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </aside>
    </div>

    <!-- 10. Newsletter Subscription Bar -->
    <section class="newsletter-bar">
        <div class="container newsletter-container">
            <div class="newsletter-left">
                <div class="newsletter-icon-wrapper">
                    <i data-feather="mail"></i>
                </div>
                <div class="newsletter-text">
                    <h3>{{ $t['newsletter'] }}</h3>
                </div>
            </div>
            <form class="newsletter-form" id="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email address" required>
                <button type="submit" class="newsletter-submit">{{ $t['subscribe_btn'] }}</button>
            </form>
        </div>
    </section>

    <!-- Custom Dialog/Modal for success notification -->
    <div class="subscribed-modal" id="subscribed-modal">
        <div class="modal-icon">
            <i data-feather="check-circle"></i>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 10px; font-weight: 700;">{{ $lang === 'en' ? 'Success!' : ($lang === 'pb' ? 'ਸਫਲਤਾ!' : 'सफलता!') }}</h3>
        <p id="subscribed-modal-message" style="font-size: 0.95rem; color: var(--text-muted);"></p>
        <button class="modal-close-btn" id="subscribed-modal-close">OK</button>
    </div>

    <!-- Auth Modal (Login & Register) -->
    <div class="subscribed-modal" id="auth-modal" style="max-width: 440px; text-align: left; padding: 25px; z-index: 1000;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 10px;">
            <h3 id="auth-modal-title" style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin: 0;">Login</h3>
            <button id="auth-modal-close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted); line-height: 1;">&times;</button>
        </div>

        <div id="auth-error" style="display: none; background-color: rgba(229, 62, 62, 0.1); color: #e53e3e; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px; border-left: 3px solid #e53e3e;"></div>

        <form id="auth-form">
            <!-- Name Field (Only visible in Register mode) -->
            <div id="auth-name-group" style="display: none; margin-bottom: 15px;">
                <label for="auth-name" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Name</label>
                <input type="text" id="auth-name" placeholder="Enter your name" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="auth-email" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Email Address</label>
                <input type="email" id="auth-email" placeholder="Enter your email" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="auth-password" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Password</label>
                <input type="password" id="auth-password" placeholder="Enter password" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);" required>
            </div>

            <!-- Password Confirmation Field (Only visible in Register mode) -->
            <div id="auth-confirm-group" style="display: none; margin-bottom: 20px;">
                <label for="auth-password-confirm" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Confirm Password</label>
                <input type="password" id="auth-password-confirm" placeholder="Re-type password" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);">
            </div>

            <button type="submit" id="auth-submit-btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background: var(--primary-color); color: #fff; cursor: pointer; font-size: 1rem; font-weight: 600; margin-bottom: 15px;">Login</button>
            
            <div style="text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                <span id="auth-switch-prompt">Don't have an account?</span> 
                <span id="auth-switch-btn" style="color: var(--primary-color); cursor: pointer; font-weight: 600;">Register Now</span>
            </div>
        </form>
    </div>

    <!-- 11. Footer (ABP News Styled - English) -->
    <style>
        .abp-footer {
            width: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #ffffff;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .abp-footer-top-bar {
            background-color: #1e3a8a;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .abp-footer-top-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .abp-footer-logo {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .abp-footer-logo-img {
            height: 38px;
            width: 38px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            object-fit: cover;
        }
        .abp-footer-logo-text {
            color: #ffffff;
            font-weight: 900;
            font-size: 1.45rem;
            letter-spacing: 0.5px;
        }
        .abp-footer-logo-text span {
            background-color: #ffffff;
            color: #1e3a8a;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 5px;
            font-weight: 900;
        }
        .abp-footer-lang-select {
            background-color: rgba(255,255,255,0.15);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.25);
            padding: 6px 15px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.85rem;
            outline: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .abp-footer-lang-select:hover {
            background-color: rgba(255,255,255,0.25);
        }
        .abp-footer-lang-select option {
            color: #333333;
        }
        .abp-footer-links-section {
            background-color: #0f172a;
            padding: 40px 0 30px 0;
        }
        .abp-footer-links-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 25px;
        }
        .abp-footer-column h5 {
            color: #ffd700;
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #ffd700;
            padding-bottom: 5px;
            display: inline-block;
        }
        .abp-footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .abp-footer-column ul li {
            margin-bottom: 8px;
        }
        .abp-footer-column ul li a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s, padding-left 0.2s;
            display: inline-block;
        }
        .abp-footer-column ul li a:hover {
            color: #ffd700;
            padding-left: 2px;
        }
        .abp-footer-bottom-section {
            background-color: #0b0f19;
            padding: 30px 0;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .abp-footer-bottom-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .abp-footer-nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 15px;
        }
        .abp-footer-nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: color 0.2s;
        }
        .abp-footer-nav-links a:hover {
            color: #ffd700;
        }
        .abp-footer-group-title {
            color: #ffd700;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .abp-footer-group-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 18px;
        }
        .abp-footer-group-links a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.2s;
        }
        .abp-footer-group-links a:hover {
            color: #ffffff;
        }
        .abp-footer-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .abp-footer-info-text {
            color: rgba(255,255,255,0.45);
            font-size: 0.78rem;
            line-height: 1.6;
        }
        .abp-footer-info-text a {
            color: rgba(255,255,255,0.6);
            text-decoration: underline;
        }
        .abp-footer-info-text a:hover {
            color: #ffffff;
        }
        .abp-footer-social {
            display: flex;
            gap: 10px;
        }
        .abp-footer-social-btn {
            height: 34px;
            width: 34px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
        }
        .abp-footer-social-btn:hover {
            background-color: #ffd700;
            color: #111111;
            transform: translateY(-2px);
        }
        .abp-footer-social-btn i {
            font-size: 0.95rem;
        }
        @media (max-width: 768px) {
            .abp-footer-top-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .abp-footer-info-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <footer class="abp-footer">
        <!-- Red Top Bar -->
        <div class="abp-footer-top-bar">
            <div class="abp-footer-top-container">
                <a href="/" class="abp-footer-logo">
                    <img src="/images/logo.png" alt="Aakash News 24 Logo" class="abp-footer-logo-img">
                    <span class="abp-footer-logo-text">AAKASH <span>NEWS 24</span></span>
                </a>
                <div>
                    <select class="abp-footer-lang-select" onchange="window.location.href='/?lang=' + this.value">
                        <option value="en" {{ $lang === 'en' ? 'selected' : '' }}>English</option>
                        <option value="hi" {{ $lang === 'hi' ? 'selected' : '' }}>Hindi (English)</option>
                        <option value="pb" {{ $lang === 'pb' ? 'selected' : '' }}>Punjabi (ਪੰਜਾਬੀ)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Maroon Links Grid -->
        <div class="abp-footer-links-section">
            <div class="abp-footer-links-container">
                <!-- Column 1 -->
                <div class="abp-footer-column">
                    <h5>Latest News</h5>
                    <ul>
                        <li><a href="/?category=state">State News</a></li>
                        <li><a href="/?category=national">India News</a></li>
                        <li><a href="/?category=gallery">Photo Gallery</a></li>
                        <li><a href="/?category=world">World News</a></li>
                        <li><a href="/?category=technology">Technology</a></li>
                        <li><a href="/?category=business">Auto News</a></li>
                        <li><a href="/reader-corner">Podcasts</a></li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div class="abp-footer-column">
                    <h5>Entertainment</h5>
                    <ul>
                        <li><a href="/?category=entertainment">Visual Stories</a></li>
                        <li><a href="/?category=entertainment">Bollywood</a></li>
                        <li><a href="/?category=entertainment">TV News</a></li>
                        <li><a href="/?category=entertainment">OTT News</a></li>
                        <li><a href="/?category=entertainment">Bhojpuri Cinema</a></li>
                        <li><a href="/?category=entertainment">Movie Reviews</a></li>
                        <li><a href="/?category=entertainment">Tamil Cinema</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div class="abp-footer-column">
                    <h5>Sports News</h5>
                    <ul>
                        <li><a href="/?category=sports">Cricket News</a></li>
                        <li><a href="/?category=sports">IPL 2026</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div class="abp-footer-column">
                    <h5>Astro</h5>
                    <ul>
                        <li><a href="/?category=lifestyle">Horoscope</a></li>
                        <li><a href="/?category=lifestyle">Astrology</a></li>
                        <li><a href="/?category=lifestyle">Religion</a></li>
                        <li><a href="/?category=lifestyle">Hindu Calendar</a></li>
                        <li><a href="/?category=lifestyle">Planet Transits</a></li>
                    </ul>
                </div>

                <!-- Column 5 -->
                <div class="abp-footer-column">
                    <h5>Weather</h5>
                    <ul>
                        <li><a href="/?category=state">Mumbai Weather</a></li>
                        <li><a href="/?category=state">Jaipur Weather</a></li>
                        <li><a href="/?category=national">Delhi Weather</a></li>
                        <li><a href="/?category=state">Lucknow Weather</a></li>
                        <li><a href="/?category=state">Noida Weather</a></li>
                    </ul>
                </div>

                <!-- Column 6 -->
                <div class="abp-footer-column">
                    <h5>Lifestyle</h5>
                    <ul>
                        <li><a href="/?category=lifestyle">Utility News</a></li>
                        <li><a href="/?category=lifestyle">Travel</a></li>
                        <li><a href="/?category=lifestyle">General Knowledge</a></li>
                        <li><a href="/?category=lifestyle">Health & Fitness</a></li>
                        <li><a href="/?category=lifestyle">Fashion Trends</a></li>
                        <li><a href="/?category=lifestyle">Agriculture</a></li>
                    </ul>
                </div>

                <!-- Column 7 -->
                <div class="abp-footer-column">
                    <h5>Gold Price</h5>
                    <ul>
                        <li><a href="/?category=business">24K Gold Price</a></li>
                        <li><a href="/?category=business">22K Gold Price</a></li>
                        <li><a href="/?category=business">Gold Rate Today</a></li>
                    </ul>
                </div>

                <!-- Column 8 -->
                <div class="abp-footer-column">
                    <h5>Silver Price</h5>
                    <ul>
                        <li><a href="/?category=business">Silver Rate Today</a></li>
                        <li><a href="/?category=business">Silver Coin Price</a></li>
                        <li><a href="/?category=business">Silver Bar Rate</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Black Bottom Section -->
        <div class="abp-footer-bottom-section">
            <div class="abp-footer-bottom-container">
                <!-- Nav Links -->
                <div class="abp-footer-nav-links">
                    <a href="/reader-corner">About Us</a>
                    <a href="/reader-corner">Feedback</a>
                    <a href="/reader-corner">Careers</a>
                    <a href="/reader-corner">Advertise With Us</a>
                    <a href="/?category=gallery">Sitemap</a>
                    <a href="/reader-corner">Disclaimer</a>
                    <a href="/reader-corner">Privacy Policy</a>
                    <a href="/reader-corner">Contact Us</a>
                </div>

                <!-- Group websites -->
                <div class="abp-footer-group-title">Aakash News Group Websites</div>
                <div class="abp-footer-group-links">
                    <a href="/?lang=en">Aakash Network</a>
                    <a href="/?lang=en">Aakash Live</a>
                    <a href="/?lang=en">Aakash English</a>
                    <a href="/?lang=hi">Aakash Hindi</a>
                    <a href="/?lang=pb">Aakash Punjabi</a>
                    <a href="/?lang=hi">Aakash Bangla</a>
                    <a href="/?lang=hi">Aakash Marathi</a>
                    <a href="/?lang=hi">Aakash Gujarati</a>
                    <a href="/?lang=en">Aakash Tamil</a>
                    <a href="/?lang=en">Aakash Kannada</a>
                </div>

                <!-- Info and Social row -->
                <div class="abp-footer-info-row">
                    <div class="abp-footer-info-text">
                        This website follows the <a href="https://www.dnpa.india/" target="_blank">DNPA Code of Ethics</a>. <br>
                        Copyright &copy; 2026 Aakash News 24. All rights reserved.
                    </div>
                    <div class="abp-footer-social">
                        <a href="https://twitter.com" target="_blank" class="abp-footer-social-btn" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://facebook.com" target="_blank" class="abp-footer-social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" class="abp-footer-social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://youtube.com" target="_blank" class="abp-footer-social-btn" aria-label="Youtube"><i class="fab fa-youtube"></i></a>
                        <a href="https://telegram.org" target="_blank" class="abp-footer-social-btn" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                        <a href="https://whatsapp.com" target="_blank" class="abp-footer-social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://pinterest.com" target="_blank" class="abp-footer-social-btn" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Reels Viewer Overlay (Dainik Bhaskar Style) -->
    <div id="reels-viewer-overlay" class="reels-viewer-overlay" style="display: none;">
        <button id="reels-close-btn" class="reels-close-btn" title="Close">
            &times;
        </button>
        
        <div class="reels-container-wrapper">
            <!-- Previous Button -->
            <button id="reels-nav-prev" class="reels-nav-arrow prev" title="Previous Video (Arrow Up)">
                <i data-feather="chevron-up"></i>
            </button>

            <!-- Central Reels Scroll Viewport -->
            <div id="reels-scroll-container" class="reels-scroll-container"></div>

            <!-- Next Button -->
            <button id="reels-nav-next" class="reels-nav-arrow next" title="Next Video (Arrow Down)">
                <i data-feather="chevron-down"></i>
            </button>

            <!-- Floating Share Actions on the Right -->
            <div class="reels-sidebar-actions">
                <a id="reels-share-wa" href="#" target="_blank" rel="noopener noreferrer" class="reels-action-circle whatsapp" title="{{ $lang === 'en' ? 'Share on WhatsApp' : ($lang === 'pb' ? 'à¨µà¨Ÿà¨¸à¨à¨ª à¨¤à©‡ à¨¸à¨¼à©‡à¨…à¨° à¨•à¨°à©‹' : 'à¤µà¥à¤¹à¤¾à¤Ÿà¥à¤¸à¤à¤ª à¤ªà¤° à¤¶à¥‡à¤¯à¤° à¤•à¤°à¥‡à¤‚') }}" style="background-color: #25D366; color: #fff;">
                    <i class="fab fa-whatsapp" style="font-size: 1.25rem;"></i>
                    <span>{{ $lang === 'en' ? 'WhatsApp' : ($lang === 'pb' ? 'à¨µà¨Ÿà¨¸à¨à¨ª' : 'à¤µà¥à¤¹à¤¾à¤Ÿà¥à¤¸à¤à¤ª') }}</span>
                </a>
                <a id="reels-share-fb" href="#" target="_blank" rel="noopener noreferrer" class="reels-action-circle facebook" title="{{ $lang === 'en' ? 'Share on Facebook' : ($lang === 'pb' ? 'à¨«à©‡à¨¸à¨¬à©à©±à¨• à¨¤à©‡ à¨¸à¨¼à©‡à¨…à¨° à¨•à¨°à©‹' : 'à¤«à¥‡à¤¸à¤¬à¥à¤• à¤ªà¤° à¤¶à¥‡à¤¯à¤° à¤•à¤°à¥‡à¤‚') }}">
                    <i data-feather="facebook"></i>
                    <span>{{ $lang === 'en' ? 'Facebook' : ($lang === 'pb' ? 'à¨«à©‡à¨¸à¨¬à©à©±à¨•' : 'à¤«à¥‡à¤¸à¤¬à¥à¤•') }}</span>
                </a>
                <a id="reels-share-tw" href="#" target="_blank" rel="noopener noreferrer" class="reels-action-circle twitter" title="{{ $lang === 'en' ? 'Share on Twitter' : ($lang === 'pb' ? 'à¨Ÿà¨µà¨¿à©±à¨Ÿà¨° à¨¤à©‡ à¨¸à¨¼à©‡à¨…à¨° à¨•à¨°à©‹' : 'à¤Ÿà¥à¤µà¤¿à¤Ÿà¤° à¤ªà¤° à¤¶à¥‡à¤¯à¤° à¤•à¤°à¥‡à¤‚') }}">
                    <i data-feather="twitter"></i>
                    <span>{{ $lang === 'en' ? 'Twitter' : ($lang === 'pb' ? 'à¨Ÿà¨µà¨¿à©±à¨Ÿà¨°' : 'à¤Ÿà¥à¤µà¤¿à¤Ÿà¤°') }}</span>
                </a>
                <button id="reels-share-anywhere" class="reels-action-circle share-anywhere" title="{{ $lang === 'en' ? 'Share Anywhere' : ($lang === 'pb' ? 'à¨•à¨¿à¨¤à©‡ à¨µà©€ à¨¸à¨¼à©‡à¨…à¨° à¨•à¨°à©‹' : 'à¤•à¤¹à¥€à¤‚ à¤­à¥€ à¤¶à¥‡à¤¯à¤° à¤•à¤°à¥‡à¤‚') }}" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: #fff; border: none; cursor: pointer;">
                    <i data-feather="share-2"></i>
                    <span>{{ $lang === 'en' ? 'Share' : ($lang === 'pb' ? 'à¨¸à¨¼à©‡à¨…à¨°' : 'à¤¶à¥‡à¤¯à¤°') }}</span>
                </button>
                <button id="reels-copy-btn" class="reels-action-circle copy-link" title="{{ $lang === 'en' ? 'Copy Link' : ($lang === 'pb' ? 'à¨²à¨¿à©°à¨• à¨•à¨¾à¨ªà©€ à¨•à¨°à©‹' : 'à¤²à¤¿à¤‚à¤• à¤•à¥‰à¤ªà¥€ à¤•à¤°à¥‡à¤‚') }}">
                    <i data-feather="link"></i>
                    <span>{{ $lang === 'en' ? 'Copy Link' : ($lang === 'pb' ? 'à¨²à¨¿à©°à¨• à¨•à¨¾à¨ªà©€ à¨•à¨°à©‹' : 'à¤•à¥‰à¤ªà¥€ à¤²à¤¿à¤‚à¤•') }}</span>
                </button>
            </div>
        </div>
        
        <!-- Bottom Caption matching Bhaskar.com design -->
        <div id="reels-bottom-caption" class="reels-bottom-caption-bar">
            <span class="reels-caption-highlight">Video: </span>
            <span id="reels-active-caption-text">Instagram Video</span>
        </div>
    </div>

    <!-- Reels Viewer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('reels-viewer-overlay');
            const closeBtn = document.getElementById('reels-close-btn');
            const scrollContainer = document.getElementById('reels-scroll-container');
            const prevBtn = document.getElementById('reels-nav-prev');
            const nextBtn = document.getElementById('reels-nav-next');
            const shareFb = document.getElementById('reels-share-fb');
            const shareTw = document.getElementById('reels-share-tw');
            const shareWa = document.getElementById('reels-share-wa');
            const shareAnywhereBtn = document.getElementById('reels-share-anywhere');
            const copyBtn = document.getElementById('reels-copy-btn');
            const captionText = document.getElementById('reels-active-caption-text');
            
            const instagramCards = document.querySelectorAll('.instagram-card');
            const videoNewsCards = document.querySelectorAll('.news-video-trigger');
            const facebookCards = document.querySelectorAll('.facebook-card');
            
            let instagramDataset = [];
            let videoNewsDataset = [];
            let facebookDataset = [];
            
            // Extract Instagram dataset
            instagramCards.forEach(card => {
                const clockIcon = card.querySelector('.far.fa-clock');
                const timeText = clockIcon ? clockIcon.parentNode.textContent.trim() : 'Just now';
                instagramDataset.push({
                    embed_url: card.getAttribute('data-embed'),
                    title: card.getAttribute('data-title'),
                    url: card.getAttribute('data-url'),
                    time: timeText,
                    category: card.getAttribute('data-category') || 'Entertainment'
                });
            });
            
            // Extract Video News dataset
            videoNewsCards.forEach(card => {
                videoNewsDataset.push({
                    embed_url: card.getAttribute('data-embed'),
                    title: card.getAttribute('data-title'),
                    url: card.getAttribute('data-url'),
                    time: card.getAttribute('data-time') || 'Just now',
                    category: card.getAttribute('data-category') || 'News'
                });
            });

            // Extract Facebook dataset
            facebookCards.forEach(card => {
                facebookDataset.push({
                    embed_url: card.getAttribute('data-embed'),
                    title: card.getAttribute('data-title'),
                    url: card.getAttribute('data-url'),
                    time: card.getAttribute('data-time') || 'Just now',
                    category: card.getAttribute('data-category') || 'Entertainment'
                });
            });
            
            let activeDataset = [];
            let activeIdx = 0;
            let isOpened = false;

            let currentTime = 4;
            let duration = 57;
            let isPlaying = true;
            let isMuted = false;
            let playbackSpeed = 1;
            let timerInterval = null;

            function formatTime(secs) {
                const m = Math.floor(secs / 60).toString().padStart(2, '0');
                const s = Math.floor(secs % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            }

            function renderSlides() {
                let html = '';
                activeDataset.forEach((video, idx) => {
                    html += `
                        <div class="reel-slide" data-idx="${idx}" data-title="${video.title.replace(/"/g, '&quot;')}" data-url="${video.url}">
                            <div class="reel-iframe-wrapper">
                                <iframe data-src="${video.embed_url}" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                            </div>
                            
                            <!-- Category Pill Badge -->
                            <span class="reel-category-pill">
                                ${video.category} &gt;
                            </span>

                            <!-- Custom Player Controls Bar -->
                            <div class="reel-controls-bar">
                                <div class="reel-timeline-container">
                                    <span class="reel-current-time">00:04</span>
                                    <input type="range" class="reel-timeline-slider" min="0" max="57" value="4">
                                    <span class="reel-duration">00:57</span>
                                </div>
                                <div class="reel-buttons-row">
                                    <div class="reel-left-controls">
                                        <button class="reel-speed-btn">1x</button>
                                    </div>
                                    <div class="reel-center-controls" style="gap: 10px;">
                                        <button class="reel-control-btn rewind-btn" title="5 सेकंड पीछे">
                                            <i data-feather="rotate-ccw"></i>
                                        </button>
                                        <button class="reel-control-btn play-pause-btn" title="पॉज़" style="font-size: 1.4rem;">
                                            <i data-feather="pause"></i>
                                        </button>
                                        <button class="reel-control-btn forward-btn" title="5 सेकंड आगे">
                                            <i data-feather="rotate-cw"></i>
                                        </button>
                                    </div>
                                    <div class="reel-right-controls">
                                        <button class="reel-control-btn mute-btn" title="म्यूट">
                                            <i data-feather="volume-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="reel-info-overlay" style="padding-bottom: 90px;">
                                <div class="reel-brand-header" style="display: flex; align-items: center; gap: 8px;">
                                    <img src="/images/logo.png" alt="Aakash News 24" style="height: 24px; width: 24px; border-radius: 50%;" />
                                    <span class="reel-brand-logo" style="font-size: 0.9rem; font-weight: 800;">AAKASH NEWS 24</span>
                                    <span class="reel-read-news-btn">खबर पढ़ें</span>
                                </div>
                                <h4 class="reel-title">${video.title}</h4>
                                <div class="reel-meta-info">
                                    <span><i data-feather="clock"></i> ${video.time}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                scrollContainer.innerHTML = html;
                setupControlsListeners();
            }

            function setupControlsListeners() {
                const slides = scrollContainer.querySelectorAll('.reel-slide');
                slides.forEach(slide => {
                    const speedBtn = slide.querySelector('.reel-speed-btn');
                    const playPauseBtn = slide.querySelector('.play-pause-btn');
                    const muteBtn = slide.querySelector('.mute-btn');
                    const rewindBtn = slide.querySelector('.rewind-btn');
                    const forwardBtn = slide.querySelector('.forward-btn');
                    const slider = slide.querySelector('.reel-timeline-slider');
                    
                    if (speedBtn) {
                        speedBtn.addEventListener('click', function() {
                            toggleActiveSpeed(slide);
                        });
                    }
                    if (playPauseBtn) {
                        playPauseBtn.addEventListener('click', function() {
                            toggleActivePlayPause(slide);
                        });
                    }
                    if (muteBtn) {
                        muteBtn.addEventListener('click', function() {
                            toggleActiveMute(slide);
                        });
                    }
                    if (rewindBtn) {
                        rewindBtn.addEventListener('click', function() {
                            skipActiveTime(slide, -5);
                        });
                    }
                    if (forwardBtn) {
                        forwardBtn.addEventListener('click', function() {
                            skipActiveTime(slide, 5);
                        });
                    }
                    if (slider) {
                        slider.addEventListener('input', function() {
                            seekActiveTime(slide, parseFloat(slider.value));
                        });
                    }
                });
            }

            function toggleActiveSpeed(slide) {
                if (playbackSpeed === 1) playbackSpeed = 1.5;
                else if (playbackSpeed === 1.5) playbackSpeed = 2;
                else if (playbackSpeed === 2) playbackSpeed = 0.5;
                else playbackSpeed = 1;
                
                const speedBtn = slide.querySelector('.reel-speed-btn');
                if (speedBtn) speedBtn.textContent = playbackSpeed + 'x';
                
                const iframe = slide.querySelector('iframe');
                if (iframe && iframe.src.includes('youtube.com')) {
                    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'setPlaybackRate', args: [playbackSpeed] }), '*');
                }
            }

            function toggleActivePlayPause(slide) {
                isPlaying = !isPlaying;
                const icon = slide.querySelector('.play-pause-btn i');
                if (icon) {
                    icon.className = isPlaying ? 'fas fa-pause' : 'fas fa-play';
                }
                
                const iframe = slide.querySelector('iframe');
                if (iframe && iframe.src.includes('youtube.com')) {
                    const command = isPlaying ? 'playVideo' : 'pauseVideo';
                    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: command, args: [] }), '*');
                }
            }

            function toggleActiveMute(slide) {
                isMuted = !isMuted;
                const icon = slide.querySelector('.mute-btn i');
                if (icon) {
                    icon.className = isMuted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
                }
                
                const iframe = slide.querySelector('iframe');
                if (iframe && iframe.src.includes('youtube.com')) {
                    const command = isMuted ? 'mute' : 'unMute';
                    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: command, args: [] }), '*');
                }
            }

            function skipActiveTime(slide, seconds) {
                currentTime = Math.max(0, Math.min(duration, currentTime + seconds));
                const slider = slide.querySelector('.reel-timeline-slider');
                const timeText = slide.querySelector('.reel-current-time');
                if (slider) slider.value = currentTime;
                if (timeText) timeText.textContent = formatTime(currentTime);
                
                const iframe = slide.querySelector('iframe');
                if (iframe && iframe.src.includes('youtube.com')) {
                    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'seekTo', args: [currentTime, true] }), '*');
                }
            }

            function seekActiveTime(slide, value) {
                currentTime = value;
                const timeText = slide.querySelector('.reel-current-time');
                if (timeText) timeText.textContent = formatTime(currentTime);
                
                const iframe = slide.querySelector('iframe');
                if (iframe && iframe.src.includes('youtube.com')) {
                    iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'seekTo', args: [value, true] }), '*');
                }
            }

            function startTimer() {
                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    if (isOpened && isPlaying) {
                        currentTime++;
                        if (currentTime >= duration) {
                            currentTime = duration;
                            isPlaying = false;
                            const activeSlide = scrollContainer.querySelectorAll('.reel-slide')[activeIdx];
                            if (activeSlide) {
                                const icon = activeSlide.querySelector('.play-pause-btn i');
                                if (icon) icon.className = 'fas fa-play';
                            }
                        }
                        // Update current slide UI
                        const activeSlide = scrollContainer.querySelectorAll('.reel-slide')[activeIdx];
                        if (activeSlide) {
                            const slider = activeSlide.querySelector('.reel-timeline-slider');
                            const timeText = activeSlide.querySelector('.reel-current-time');
                            if (slider) slider.value = currentTime;
                            if (timeText) timeText.textContent = formatTime(currentTime);
                        }
                    }
                }, 1000);
            }

            function stopTimer() {
                clearInterval(timerInterval);
            }

            function loadIframes() {
                const slides = scrollContainer.querySelectorAll('.reel-slide');
                slides.forEach((slide, idx) => {
                    const iframe = slide.querySelector('iframe');
                    if (iframe) {
                        if (idx === activeIdx) {
                            if (!iframe.src) {
                                iframe.src = iframe.getAttribute('data-src');
                            }
                        } else {
                            iframe.src = '';
                        }
                    }
                });
            }

            function unloadIframes() {
                const slides = scrollContainer.querySelectorAll('.reel-slide');
                slides.forEach(slide => {
                    const iframe = slide.querySelector('iframe');
                    if (iframe) {
                        iframe.src = '';
                    }
                });
                scrollContainer.innerHTML = ''; // Clear DOM to reclaim memory
            }

            function updateActiveReel(index) {
                if (index < 0 || index >= activeDataset.length) return;
                activeIdx = index;

                // Scroll to index
                const slideHeight = scrollContainer.clientHeight;
                scrollContainer.scrollTo({
                    top: activeIdx * slideHeight,
                    behavior: 'smooth'
                });

                // Update UI state
                prevBtn.disabled = (activeIdx === 0);
                nextBtn.disabled = (activeIdx === activeDataset.length - 1);

                // Update text/sharing links
                const video = activeDataset[activeIdx];
                if (!video) return;

                captionText.textContent = video.title || 'Instagram Video';
                if (shareFb) shareFb.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(video.url)}`;
                if (shareTw) shareTw.href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(video.url)}`;
                if (shareWa) shareWa.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(video.title + ' ' + video.url)}`;

                // Reset timeline state for this video
                currentTime = 0;
                duration = 57; // default
                isPlaying = true;
                isMuted = false;
                playbackSpeed = 1;
                
                // If the news video card has duration e.g. "02:40", parse it
                let videoCards = instagramCards;
                if (activeDataset === videoNewsDataset) {
                    videoCards = videoNewsCards;
                } else if (activeDataset === facebookDataset) {
                    videoCards = facebookCards;
                }
                const activeCard = videoCards[activeIdx];
                if (activeCard) {
                    const dur = activeCard.getAttribute('data-duration') || '00:57';
                    const parts = dur.split(':');
                    if (parts.length === 2) {
                        duration = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
                    }
                }
                
                // Update slider min/max on the active slide element
                const activeSlide = scrollContainer.querySelectorAll('.reel-slide')[activeIdx];
                if (activeSlide) {
                    const slider = activeSlide.querySelector('.reel-timeline-slider');
                    const durText = activeSlide.querySelector('.reel-duration');
                    const curText = activeSlide.querySelector('.reel-current-time');
                    const speedBtn = activeSlide.querySelector('.reel-speed-btn');
                    const playPauseIcon = activeSlide.querySelector('.play-pause-btn i');
                    const muteIcon = activeSlide.querySelector('.mute-btn i');

                    if (slider) {
                        slider.max = duration;
                        slider.value = 0;
                    }
                    if (durText) durText.textContent = formatTime(duration);
                    if (curText) curText.textContent = "00:00";
                    if (speedBtn) speedBtn.textContent = "1x";
                    if (playPauseIcon) playPauseIcon.className = "fas fa-pause";
                    if (muteIcon) muteIcon.className = "fas fa-volume-up";
                }

                // Sync iframe playback (load active with autoplay, clear non-active ones)
                const slides = scrollContainer.querySelectorAll('.reel-slide');
                slides.forEach((slide, idx) => {
                    const iframe = slide.querySelector('iframe');
                    if (!iframe) return;
                    
                    if (idx === activeIdx) {
                        const dataSrc = iframe.getAttribute('data-src');
                        if (dataSrc) {
                            let playSrc = dataSrc;
                            if (playSrc.includes('youtube.com')) {
                                if (!playSrc.includes('autoplay=1')) {
                                    playSrc += (playSrc.includes('?') ? '&' : '?') + 'autoplay=1&mute=0';
                                }
                            } else if (playSrc.includes('facebook.com')) {
                                if (!playSrc.includes('autoplay=true')) {
                                    playSrc += (playSrc.includes('?') ? '&' : '?') + 'autoplay=true';
                                }
                            } else if (playSrc.includes('instagram.com')) {
                                if (!playSrc.includes('autoplay=1')) {
                                    playSrc += (playSrc.includes('?') ? '&' : '?') + 'autoplay=1';
                                }
                            }
                            
                            if (iframe.src !== playSrc) {
                                iframe.src = playSrc;
                            }
                            
                            // Send play command if YouTube
                            if (playSrc.includes('youtube.com')) {
                                setTimeout(() => {
                                    try {
                                        iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'playVideo', args: [] }), '*');
                                    } catch (e) {}
                                }, 500);
                            }
                        }
                    } else {
                        if (iframe.src && iframe.src !== 'about:blank' && iframe.src !== '') {
                            iframe.src = '';
                        }
                    }
                });

                startTimer();
            }

            // Open overlay when clicking Instagram card
            instagramCards.forEach((card, idx) => {
                card.addEventListener('click', function() {
                    activeDataset = instagramDataset;
                    renderSlides();
                    overlay.style.display = 'flex';
                    isOpened = true;
                    loadIframes();
                    setTimeout(() => {
                        updateActiveReel(idx);
                    }, 50);
                });
            });

            // Open overlay when clicking Video News card
            videoNewsCards.forEach((card, idx) => {
                card.addEventListener('click', function() {
                    activeDataset = videoNewsDataset;
                    renderSlides();
                    overlay.style.display = 'flex';
                    isOpened = true;
                    loadIframes();
                    setTimeout(() => {
                        updateActiveReel(idx);
                    }, 50);
                });
            });

            // Open overlay when clicking Facebook card
            facebookCards.forEach((card, idx) => {
                card.addEventListener('click', function() {
                    activeDataset = facebookDataset;
                    renderSlides();
                    overlay.style.display = 'flex';
                    isOpened = true;
                    loadIframes();
                    setTimeout(() => {
                        updateActiveReel(idx);
                    }, 50);
                });
            });


            // Close overlay
            closeBtn.addEventListener('click', function() {
                overlay.style.display = 'none';
                isOpened = false;
                stopTimer();
                unloadIframes();
            });

            // Nav buttons
            prevBtn.addEventListener('click', function() {
                updateActiveReel(activeIdx - 1);
            });

            nextBtn.addEventListener('click', function() {
                updateActiveReel(activeIdx + 1);
            });

            // Keyboard navigation
            window.addEventListener('keydown', function(e) {
                if (!isOpened) return;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    updateActiveReel(activeIdx + 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    updateActiveReel(activeIdx - 1);
                } else if (e.key === 'Escape') {
                    overlay.style.display = 'none';
                    isOpened = false;
                    stopTimer();
                    unloadIframes();
                }
            });

            // Scroll listener to sync activeIdx when swiping/scrolling manually
            let scrollTimeout;
            scrollContainer.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    const scrollPosition = scrollContainer.scrollTop;
                    const slideHeight = scrollContainer.clientHeight;
                    if (slideHeight <= 0) return;
                    const index = Math.round(scrollPosition / slideHeight);
                    if (index !== activeIdx && index >= 0 && index < activeDataset.length) {
                        updateActiveReel(index);
                    }
                }, 100);
            });

            // Copy Link button
            if (copyBtn) {
                copyBtn.addEventListener('click', function() {
                    const video = activeDataset[activeIdx];
                    if (video) {
                        navigator.clipboard.writeText(video.url).then(function() {
                            alert(typeof lang !== 'undefined' ? (lang === 'en' ? 'Link copied to clipboard!' : (lang === 'pb' ? 'ਲਿੰਕ ਕਾਪੀ ਹੋ ਗਿਆ!' : 'Link copied to clipboard!')) : 'Link copied to clipboard!');
                        });
                    }
                });
            }

            // Share Anywhere button
            if (shareAnywhereBtn) {
                shareAnywhereBtn.addEventListener('click', function() {
                    const video = activeDataset[activeIdx];
                    if (!video) return;
                    if (navigator.share) {
                        navigator.share({
                            title: video.title,
                            text: video.title,
                            url: video.url
                        }).catch(err => console.log('Error sharing:', err));
                    } else {
                        // Fallback: Copy link and alert the user
                        navigator.clipboard.writeText(video.url).then(function() {
                            alert(typeof lang !== 'undefined' ? (lang === 'en' ? 'Share link copied to clipboard!' : (lang === 'pb' ? 'ਲਿੰਕ ਕਾਪੀ ਹੋ ਗਿਆ!' : 'Share link copied to clipboard!')) : 'Share link copied to clipboard!');
                        });
                    }
                });
            }
        });
    </script>

   

    <!-- Main JS file -->
    <script src="/js/main.js"></script>
    <!-- Feather Icons replacement script -->
    <script>
        if (typeof feather !== "undefined") {
            feather.replace();
        // Re-run feather.replace whenever dyn content is loaded/updated
        const originalFetch = window.fetch;
        if (originalFetch) {
            window.fetch = async function(...args) {
                const response = await originalFetch(...args);
                setTimeout(() => {
                    if (typeof feather !== "undefined") {
                        feather.replace();
                    }
                }, 500);
                return response;
            };
        }
        }
    </script>
</body>
</html>