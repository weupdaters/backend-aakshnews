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
    <meta name="description" content="{{ $lang === 'en' ? 'Aakash News 24 - Always Ahead. Reader\'s Corner.' : ($lang === 'pb' ? 'ਆਕਾਸ਼ ਨਿਊਜ਼ 24 - ਪਾਠਕ ਕੋਨਾ।' : 'Aakash News 24 - Always Ahead। पाठक कोना - आपके विचार।') }}">
    <title>{{ $lang === 'en' ? 'Reader\'s Corner - Your Thoughts' : ($lang === 'pb' ? 'ਪਾਠਕ ਕੋਨਾ - ਤੁਹਾਡੇ ਵਿਚਾਰ' : 'पाठक कोना - आपके विचार') }} | Aakash News 24</title>
    <!-- FontAwesome for Premium Icons -->
    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
    
    <!-- Google AdSense Auto-Ads (Replace ca-pub-XXXXXXXXXXXXXXX with your actual AdSense Publisher ID) -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXX" crossorigin="anonymous"></script>

    <style>
        /* Modern Scrollbar for user posts */
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

        /* Premium Form Controls */
        .post-form-card {
            border-top: 4px solid var(--primary-color) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease !important;
        }
        .post-form-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
        }
        .post-form-card input, 
        .post-form-card select, 
        .post-form-card textarea {
            border: 1px solid var(--border-color) !important;
            background: var(--bg-body) !important;
            color: var(--text-main) !important;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease !important;
        }
        .post-form-card input:focus, 
        .post-form-card select:focus, 
        .post-form-card textarea:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.12) !important;
            background-color: var(--bg-card) !important;
            outline: none;
        }

        /* Submit Button premium style */
        #post-submit-btn {
            background: linear-gradient(135deg, var(--primary-color), #c53030) !important;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.2) !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }
        #post-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.35) !important;
        }
        #post-submit-btn:active {
            transform: translateY(1px);
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
                <span class="weather"><i data-feather="sun" style="color: #f6ad55;"></i> 32°C {{ $lang === 'en' ? 'New Delhi' : ($lang === 'pb' ? 'ਨਵੀਂ ਦਿੱਲੀ' : 'नई दिल्ली') }}</span>
            </div>
            
            <div class="top-bar-ticker">
                <span class="ticker-badge">{{ $lang === 'en' ? 'Breaking' : ($lang === 'pb' ? 'ਬ੍ਰੇਕਿੰਗ' : 'ब्रेकिंग') }}</span>
                <div class="ticker-text-wrapper">
                    <span class="ticker-text">
                        {!! implode(" &nbsp;&nbsp;•&nbsp;&nbsp; ", $breakingNews) !!}
                    </span>
                </div>
            </div>

            <div class="top-bar-right">
                <div class="font-controls">
                    <button class="font-btn" id="font-minus" title="{{ $lang === 'en' ? 'Decrease Font Size' : ($lang === 'pb' ? 'ਫੌਂਟ ਛੋਟਾ ਕਰੋ' : 'फ़ॉन्ट छोटा करें') }}">A-</button>
                    <button class="font-btn" id="font-reset" title="{{ $lang === 'en' ? 'Reset Font Size' : ($lang === 'pb' ? 'ਫੌਂਟ ਰੀਸੈਟ ਕਰੋ' : 'फ़ॉन्ट रीसेट करें') }}">A</button>
                    <button class="font-btn" id="font-plus" title="{{ $lang === 'en' ? 'Increase Font Size' : ($lang === 'pb' ? 'ਫੌਂਟ ਵੱਡਾ ਕਰੋ' : 'फ़ॉन्ट बड़ा करें') }}">A+</button>
                </div>
                <button class="theme-toggle" id="notification-bell-btn" title="{{ $lang === 'en' ? 'Get Notifications' : ($lang === 'pb' ? 'ਨੋਟੀਫਿਕੇਸ਼ਨ ਪ੍ਰਾਪਤ ਕਰੋ' : 'नोटिफिकेशन प्राप्त करें') }}" style="margin-right: 5px;">
                    <i data-feather="bell"></i>
                </button>
                <button class="theme-toggle" id="theme-toggle-btn" title="{{ $lang === 'en' ? 'Toggle Theme' : ($lang === 'pb' ? 'ਥੀਮ ਬਦਲੋ' : 'थीम बदलें') }}">
                    <i data-feather="moon"></i>
                </button>
                <div class="lang-controls" style="display: flex; gap: 6px; margin: 0 5px;">
                    <a href="/reader-corner?lang=en" style="background: #2e4ead; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 55px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">English</a>
                    <a href="/reader-corner?lang=hi" style="background: #e53e3e; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">हिंदी</a>
                    <a href="/reader-corner?lang=pb" style="background: #dd6b20; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; min-width: 50px; border: 1px solid transparent; transition: all 0.2s;" onmouseenter="this.style.opacity='0.85'" onmouseleave="this.style.opacity='1'">ਪੰਜਾਬੀ</a>
                </div>
                <div id="auth-user-container" style="display: flex; align-items: center; gap: 10px;">
                    @auth
                        <span style="color: var(--text-main); font-size: 0.9rem; font-weight: 600;">
                            <i data-feather="user" style="margin-right: 5px;"></i> {{ auth()->user()->name }}
                        </span>
                        <span style="color: var(--border-color);">|</span>
                        <a href="/admin/dashboard" class="login-link" style="font-size: 0.9rem; color: var(--primary-color); font-weight: bold;">{{ $lang === 'en' ? 'Dashboard' : ($lang === 'pb' ? 'ਡੈਸ਼ਬੋਰਡ' : 'डैशबोर्ड') }}</a>
                        <span style="color: var(--border-color);">|</span>
                        <a href="#" id="laravel-logout-btn" class="login-link" style="font-size: 0.9rem;">{{ $lang === 'en' ? 'Logout' : ($lang === 'pb' ? 'ਲੌਗਆਉਟ' : 'लॉगआउट') }}</a>
                    @else
                        <a href="#" id="laravel-login-btn" class="login-link"><i data-feather="user"></i> {{ $lang === 'en' ? 'Login / Signup' : ($lang === 'pb' ? 'ਲੌਗਇਨ / ਸਾਈਨਅਪ' : 'लॉगिन / साइनअप') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Header -->
    <header class="main-header">
        <div class="container header-grid">
            <div class="logo-area">
                <a href="/" class="logo" style="display: flex; align-items: center; gap: 10px;">
                    <img src="/images/logo.png" alt="Aakash News 24" style="height: 48px; width: 48px; border-radius: 50%; object-fit: cover;" />
                    <div style="display: flex; flex-direction: column; line-height: 1.1;">
                        <div style="display: flex; align-items: center;">
                            <span style="color: var(--text-main); font-weight: 900; font-size: 1.4rem; letter-spacing: 0.5px;">AAKASH</span>
                            <span style="color: #e53e3e; font-weight: 900; font-size: 1.4rem; letter-spacing: 0.5px; margin-left: 6px;">NEWS 24</span>
                        </div>
                        <span class="tagline" style="font-size: 0.72rem; font-weight: 700; color: var(--text-muted); letter-spacing: 0.5px; margin-top: 2px;">Always Ahead</span>
                    </div>
                </a>
            </div>

            <div class="search-bar">
                <input type="text" class="search-input" placeholder="{{ $t['search'] }}" id="search-input">
                <i data-feather="search" class="search-icon" id="search-btn"></i>
            </div>

            <div class="header-actions">
                <div class="header-action-item">
                    <i data-feather="file-text"></i>
                    <span>{{ $t['epaper'] }}</span>
                </div>
                <div class="header-action-item">
                    <i data-feather="video"></i>
                    <span>{{ $t['video'] }}</span>
                </div>
                <div class="header-action-item">
                    <i data-feather="settings"></i>
                    <span>{{ $t['settings'] }}</span>
                </div>
                <button class="bookmark-btn" id="header-subscribe-btn">
                    <i data-feather="bell"></i>
                    <span>{{ $t['subscribe'] }}</span>
                </button>
            </div>
        </div>
    </header>

    <!-- 3. Navigation Bar -->
    <nav class="nav-bar">
        <div class="container nav-container">
            <button class="hamburger-btn" id="hamburger-btn" title="{{ $lang === 'en' ? 'Open Menu' : ($lang === 'pb' ? 'ਮੇਨੂ ਖੋਲ੍ਹੋ' : 'मेन्यू खोलें') }}">
                <i data-feather="menu"></i>
            </button>
            <ul class="nav-links">
                <li class="nav-item"><a href="/">{{ $t['home'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['national'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['state'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['politics'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['sports'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['business'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['technology'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['entertainment'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['lifestyle'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['education'] }}</a></li>
                <li class="nav-item"><a href="#">{{ $t['world'] }}</a></li>
                <li class="nav-item dropdown">
                    <a href="#">{{ $t['more'] }} <i data-feather="chevron-down" style="font-size: 0.8rem; margin-left: 2px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ $t['career'] }}</a></li>
                        <li><a href="#">{{ $t['religion'] }}</a></li>
                        <li><a href="#">{{ $t['gallery'] }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Sidebar Drawer -->
    <div class="mobile-sidebar" id="mobile-sidebar">
        <div class="mobile-sidebar-header">
            <a href="/" class="logo" style="display: flex; align-items: center; gap: 8px;">
                <img src="/images/logo.png" alt="Aakash News 24" style="height: 36px; width: 36px; border-radius: 50%;" />
                <span style="color: var(--text-main); font-weight: 900; font-size: 1.25rem;">AAKASH <span style="color: #e53e3e;">NEWS 24</span></span>
            </a>
            <button class="mobile-sidebar-close" id="sidebar-close">&times;</button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="/">{{ $t['home'] }}</a></li>
            <li><a href="#">{{ $t['national'] }}</a></li>
            <li><a href="#">{{ $t['state'] }}</a></li>
            <li><a href="#">{{ $t['politics'] }}</a></li>
            <li><a href="#">{{ $t['sports'] }}</a></li>
            <li><a href="#">{{ $t['business'] }}</a></li>
            <li><a href="#">{{ $t['technology'] }}</a></li>
            <li><a href="#">{{ $t['entertainment'] }}</a></li>
            <li><a href="#">{{ $t['lifestyle'] }}</a></li>
            <li><a href="#">{{ $t['education'] }}</a></li>
            <li><a href="#">{{ $t['world'] }}</a></li>
            <li><a href="#">{{ $t['gallery'] }}</a></li>
        </ul>
    </div>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

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
                    <li><a href="/"><i data-feather="home"></i> <span>{{ $t['home'] }}</span></a></li>
                    <li><a href="#"><i data-feather="flag"></i> <span>{{ $t['national'] }}</span></a></li>
                    <li><a href="#"><i data-feather="map-pin"></i> <span>{{ $t['state'] }}</span></a></li>
                    <li><a href="#"><i data-feather="grid"></i> <span>{{ $t['politics'] }}</span></a></li>
                    <li><a href="#"><i data-feather="activity"></i> <span>{{ $t['sports'] }}</span></a></li>
                    <li><a href="#"><i data-feather="briefcase"></i> <span>{{ $t['business'] }}</span></a></li>
                    <li><a href="#"><i data-feather="cpu"></i> <span>{{ $t['technology'] }}</span></a></li>
                    <li><a href="#"><i data-feather="film"></i> <span>{{ $t['entertainment'] }}</span></a></li>
                    <li><a href="#"><i data-feather="heart"></i> <span>{{ $t['lifestyle'] }}</span></a></li>
                    <li><a href="#"><i data-feather="book-open"></i> <span>{{ $t['education'] }}</span></a></li>
                    <li><a href="#"><i data-feather="globe"></i> <span>{{ $t['world'] }}</span></a></li>
                    <li><a href="#"><i data-feather="image"></i> <span>{{ $t['gallery'] }}</span></a></li>
                </ul>
            </div>
        </aside>

        <!-- Middle Column: Scrollable Content Feed -->
        <div class="portal-middle-col">
            
            <!-- Breadcrumbs -->
            <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 15px; display: flex; align-items: center; gap: 5px;">
                <a href="/" style="color: var(--text-muted); text-decoration: none;">{{ $t['home'] }}</a>
                <i data-feather="chevron-right" style="font-size: 0.65rem;"></i>
                <span style="color: var(--primary-color); font-weight: 600;">{{ $lang === 'en' ? "Reader's Corner" : ($lang === 'pb' ? "ਪਾਠਕ ਕੋਨਾ" : "पाठक कोना") }}</span>
            </div>

            <!-- Reader's Corner - User Posts -->
            <section class="section-wrapper" id="reader-corner" style="margin-bottom: 35px;">
                <div class="section-title-bar" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 8px;">
                    <h3 class="section-title" style="margin: 0; font-size: 1.4rem; font-weight: 800;">{{ $lang === 'en' ? "Reader's Corner - Your Thoughts" : ($lang === 'pb' ? "ਪਾਠਕ ਕੋਨਾ - ਤੁਹਾਡੇ ਵਿਚਾਰ" : "पाठक कोना - आपके विचार") }}</h3>
                    <span style="font-size: 0.82rem; color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 5px;">
                        <i data-feather="users"></i> {{ $lang === 'en' ? "Readers' Voice" : ($lang === 'pb' ? "ਪਾਠਕਾਂ ਦੀ ਆਵਾਜ਼" : "पाठकों की आवाज़") }}
                    </span>
                </div>

                <div class="reader-corner-container" style="margin-top: 20px;">
                    <!-- Form Column -->
                    <div class="post-form-card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 15px;">
                        <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin: 0;">
                            <i data-feather="edit-2" style="color: var(--primary-color); font-size: 1rem;"></i>
                            {{ $lang === 'en' ? "Share your news/thoughts" : ($lang === 'pb' ? "ਆਪਣੀ ਖ਼ਬਰ/ਵਿਚਾਰ ਸਾਂਝੇ ਕਰੋ" : "अपनी खबर/विचार साझा करें") }}
                        </h4>

                        <form id="reader-post-form" style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Your Name' : ($lang === 'pb' ? 'ਤੁਹਾਡਾ ਨਾਮ' : 'आपका नाम') }}</label>
                                <input 
                                    type="text" 
                                    id="post-author-name"
                                    placeholder="{{ $lang === 'en' ? 'Write Anonymous or your name' : ($lang === 'pb' ? 'ਅਗਿਆਤ ਜਾਂ ਆਪਣਾ ਨਾਮ ਲਿਖੋ' : 'अनाम (Anonymous) या अपना नाम लिखें') }}" 
                                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); font-size: 0.9rem; transition: border-color 0.2s;"
                                />
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Title' : ($lang === 'pb' ? 'ਸਿਰਲੇਖ' : 'शीर्षक') }} (Title) <span style="color: #e53e3e;">*</span></label>
                                <input 
                                    type="text" 
                                    id="post-title"
                                    placeholder="{{ $lang === 'en' ? 'Write the main title of the news...' : ($lang === 'pb' ? 'ਖ਼ਬਰ ਦਾ ਮੁੱਖ ਸਿਰਲੇਖ ਲਿਖੋ...' : 'खबर का मुख्य शीर्षक लिखें...') }}" 
                                    required
                                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); font-size: 0.9rem; transition: border-color 0.2s;"
                                />
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Category' : ($lang === 'pb' ? 'ਸ਼੍ਰੇਣੀ' : 'श्रेणी') }} (Category)</label>
                                <select 
                                    id="post-category"
                                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-main); font-size: 0.9rem; transition: border-color 0.2s;"
                                >
                                    <option value="তাਜ਼ਾ ਖ਼ਬਰ">{{ $lang === 'en' ? 'Latest News' : ($lang === 'pb' ? 'ਤਾਜ਼ਾ ਖ਼ਬਰ' : 'ताजा खबर') }}</option>
                                    <option value="देश">{{ $t['national'] }}</option>
                                    <option value="राजनीति">{{ $t['politics'] }}</option>
                                    <option value="खेल">{{ $t['sports'] }}</option>
                                    <option value="बिजनेस">{{ $t['business'] }}</option>
                                    <option value="टेक्नोलॉजी">{{ $t['technology'] }}</option>
                                    <option value="मनोरंजन">{{ $t['entertainment'] }}</option>
                                    <option value="दुनिया">{{ $t['world'] }}</option>
                                </select>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Content' : ($lang === 'pb' ? 'ਸਮੱਗਰੀ' : 'सामग्री') }} (Content) <span style="color: #e53e3e;">*</span></label>
                                <textarea 
                                    id="post-content"
                                    placeholder="{{ $lang === 'en' ? 'Write your news or thoughts in detail...' : ($lang === 'pb' ? 'ਆਪਣੀ ਖ਼ਬਰ ਜਾਂ ਵਿਚਾਰ ਵਿਸਥਾਰ ਵਿੱਚ ਲਿਖੋ...' : 'अपनी खबर या विचार विस्तार से लिखें...') }}" 
                                    rows="5"
                                    required
                                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); font-size: 0.9rem; resize: vertical; transition: border-color 0.2s;"
                                ></textarea>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Video Link' : ($lang === 'pb' ? 'ਵੀਡੀਓ ਲਿੰਕ' : 'वीडियो लिंक') }} (YouTube/Instagram Link) <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 400;">{{ $lang === 'en' ? '(Optional)' : ($lang === 'pb' ? '(ਵੈਕਲਪਿਕ)' : '(वैकल्पिक)') }}</span></label>
                                <input 
                                    type="url" 
                                    id="post-video-url"
                                    placeholder="{{ $lang === 'en' ? 'Paste YouTube, Shorts, or Instagram video link...' : ($lang === 'pb' ? 'ਯੂਟਿਊਬ, ਸ਼ਾਰਟਸ, ਜਾਂ ਇੰਸਟਾਗ੍ਰਾਮ ਵੀਡੀਓ ਦਾ ਲਿੰਕ ਪੇਸਟ ਕਰੋ...' : 'YouTube, Shorts, या Instagram वीडियो का लिंक पेस्ट करें...') }}" 
                                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); font-size: 0.9rem; transition: border-color 0.2s;"
                                />
                            </div>

                            <button 
                                type="submit" 
                                id="post-submit-btn"
                                style="width: 100%; padding: 12px; border-radius: 8px; border: none; background: var(--primary-color); color: #fff; font-size: 0.95rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background-color 0.2s, transform 0.1s;"
                            >
                                <i data-feather="send"></i> {{ $lang === 'en' ? 'Publish' : ($lang === 'pb' ? 'ਪ੍ਰਕਾਸ਼ਿਤ ਕਰੋ' : 'प्रकाशित करें') }}
                            </button>
                        </form>

                        <!-- Moderation Feedback Result -->
                        <div id="post-submit-feedback" style="display: none; padding: 14px; border-radius: 8px; font-size: 0.88rem;">
                        </div>
                    </div>

                    <!-- Feed Column -->
                    <div style="display: flex; flex-direction: column; gap: 15px; max-height: 700px; overflow-y: auto; padding-right: 5px;" class="user-posts-scroll" id="laravel-user-posts-container">
                        <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i data-feather="message-square" style="color: var(--primary-color);"></i>
                            {{ $lang === 'en' ? 'Recent Posts by Readers' : ($lang === 'pb' ? 'ਪਾਠਕਾਂ ਦੁਆਰਾ ਹਾਲੀਆ ਪੋਸਟਾਂ' : 'पाठकों द्वारा हालिया पोस्ट्स') }}
                        </h4>
                        <!-- Posts list will be rendered dynamically -->
                    </div>
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
        </div>

        <!-- Right Column Sticky Sidebar -->
        <aside class="portal-right-col">
            <!-- Google Ads Vertical Sidebar Banner -->
            <div class="premium-ads-banner" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: relative;">
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

            <!-- Short Video (Reels) Widget -->
            <div class="sidebar-panel short-video-widget" style="margin-bottom: 20px;">
                <div class="panel-header" style="border-bottom: none; margin-bottom: 10px;">
                    <i data-feather="video" class="video-icon" style="color: #e1306c;"></i>
                    <span>{{ $lang === 'en' ? 'Short Videos' : ($lang === 'pb' ? 'ਸ਼ਾਰਟ ਵੀਡੀਓ' : 'शॉर्ट वीडियो') }}</span>
                </div>
                <div class="short-video-card news-video-trigger" data-idx="0" data-embed="https://www.youtube.com/embed/5K1yN9tG4C0?enablejsapi=1" data-title="{{ $lang === 'en' ? 'Waterlogging due to rain in Delhi' : ($lang === 'pb' ? 'ਦਿੱਲੀ ਵਿੱਚ ਮੀਂਹ ਕਾਰਨ ਪਾਣੀ ਭਰਿਆ' : 'दिल्ली में बारिश से जलभराव') }}" data-url="https://www.youtube.com/shorts/5K1yN9tG4C0" data-time="{{ $lang === 'en' ? '1 hour ago' : ($lang === 'pb' ? '1 ਘੰਟਾ ਪਹਿਲਾਂ' : '1 घंटे पहले') }}" data-category="{{ $lang === 'en' ? 'Delhi' : ($lang === 'pb' ? 'ਦਿੱਲੀ' : 'दिल्ली') }}" style="position: relative; width: 100%; border-radius: 12px; overflow: hidden; background: #000; cursor: pointer; aspect-ratio: 9/16; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <img src="/images/video_delhi_rain.png" alt="Short Video" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%); display: flex; flex-direction: column; justify-content: space-between; padding: 15px;">
                        <div style="align-self: flex-end; background: rgba(225, 48, 108, 0.9); color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
                            LIVE
                        </div>
                        <div>
                            <h4 style="color: #fff; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; line-height: 1.4; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">{{ $lang === 'en' ? 'Waterlogging due to rain in Delhi - Short Video' : ($lang === 'pb' ? 'ਦਿੱਲੀ ਵਿੱਚ ਮੀਂਹ ਕਾਰਨ ਪਾਣੀ ਭਰਿਆ - ਸ਼ਾਰਟ ਵੀਡੀਓ' : 'दिल्ली में बारिश से जलभराव - शॉर्ट वीडियो') }}</h4>
                            <div style="display: flex; align-items: center; justify-content: space-between; color: #ccc; font-size: 0.8rem; width: 100%;">
                                <span><i data-feather="eye"></i> {{ $lang === 'en' ? '12K Views' : ($lang === 'pb' ? '12K ਵਿਊਜ਼' : '12K व्यूज') }}</span>
                                <button class="card-share-btn" data-url="https://www.youtube.com/shorts/5K1yN9tG4C0" data-title="{{ $lang === 'en' ? 'Waterlogging due to rain in Delhi' : ($lang === 'pb' ? 'ਦਿੱਲੀ ਵਿੱਚ ਮੀਂਹ ਕਾਰਨ ਪਾਣੀ ਭਰਿਆ' : 'दिल्ली में बारिश से जलभराव') }}" style="background: none; border: none; padding: 4px; cursor: pointer; color: #fff; display: inline-flex; align-items: center; justify-content: center; z-index: 20;" title="Share Video">
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
                        <li class="panel-item">
                            <span class="panel-number">{{ $idx + 1 }}</span>
                            <div class="panel-item-content">
                                <h4 class="panel-item-title">{{ $news['title'] }}</h4>
                                <span class="panel-item-meta">{{ $news['time'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button class="panel-more-btn">{{ $lang === 'en' ? 'View More' : ($lang === 'pb' ? 'ਹੋਰ ਦੇਖੋ' : 'और देखें') }}</button>
            </div>

            <!-- Panel 2: Most Read -->
            <div class="sidebar-panel" style="margin-top: 20px;">
                <div class="panel-header">
                    <i data-feather="zap" class="read-icon"></i>
                    <span>{{ $t['most_read'] }}</span>
                </div>
                <ul class="panel-list">
                    @foreach ($mostRead as $idx => $news)
                        <li class="panel-item">
                            <span class="panel-number">{{ $idx + 1 }}</span>
                            <div class="panel-item-content">
                                <h4 class="panel-item-title">{{ $news['title'] }}</h4>
                                <span class="panel-item-meta">{{ $news['views'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button class="panel-more-btn">{{ $lang === 'en' ? 'View More' : ($lang === 'pb' ? 'ਹੋਰ ਦੇਖੋ' : 'और देखें') }}</button>
            </div>

            <!-- Premium Support Ad Panel -->
            <div class="sidebar-ad-card" style="margin-top: 20px; background: linear-gradient(135deg, #f53d3d, #c92222); padding: 25px; border-radius: 12px; color: #fff; text-align: center; box-shadow: 0 4px 15px rgba(229,62,62,0.2);">
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">{{ $lang === 'en' ? 'AAKASH NEWS 24 Premium' : ($lang === 'pb' ? 'ਆਕਾਸ਼ ਨਿਊਜ਼ 24 ਪ੍ਰੀਮੀਅਮ' : 'आकाश न्यूज़ 24 प्रीमियम') }}</h4>
                <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 15px; line-height: 1.4;">{{ $lang === 'en' ? 'Support independent journalism. Subscribe today.' : ($lang === 'pb' ? 'ਨਿਰਪੱਖ ਪੱਤਰਕਾਰੀ ਦਾ ਸਮਰਥਨ ਕਰੋ। ਅੱਜ ਹੀ ਸਬਸਕ੍ਰਾਈਬ ਕਰੋ।' : 'निष्पक्ष पत्रकारिता का समर्थन करें। आज ही सदस्यता लें।') }}</p>
                <button style="background: #fff; color: #e53e3e; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 700; cursor: pointer; transition: transform 0.2s;">{{ $lang === 'en' ? 'Subscribe Now' : ($lang === 'pb' ? 'ਹੁਣੇ ਸਬਸਕ੍ਰਾਈਬ ਕਰੋ' : 'अभी सदस्यता लें') }}</button>
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
                <input type="email" class="newsletter-input" placeholder="{{ $lang === 'en' ? 'Enter your email address' : ($lang === 'pb' ? 'ਆਪਣਾ ਈਮੇਲ ਪਤਾ ਲਿਖੋ' : 'अपना ईमेल पता लिखें') }}" required>
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
        <button class="modal-close-btn" id="subscribed-modal-close">{{ $lang === 'en' ? 'OK' : ($lang === 'pb' ? 'ਠੀਕ ਹੈ' : 'ठीक है') }}</button>
    </div>

    <!-- Auth Modal (Login & Register) -->
    <div class="subscribed-modal" id="auth-modal" style="max-width: 440px; text-align: left; padding: 25px; z-index: 1000;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 10px;">
            <h3 id="auth-modal-title" style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin: 0;">{{ $lang === 'en' ? 'Login' : ($lang === 'pb' ? 'ਲੌਗਇਨ ਕਰੋ' : 'लॉगिन करें') }}</h3>
            <button id="auth-modal-close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted); line-height: 1;">&times;</button>
        </div>

        <div id="auth-error" style="display: none; background-color: rgba(229, 62, 62, 0.1); color: #e53e3e; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px; border-left: 3px solid #e53e3e;"></div>

        <form id="auth-form">
            <!-- Name Field (Only visible in Register mode) -->
            <div id="auth-name-group" style="display: none; margin-bottom: 15px;">
                <label for="auth-name" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Name' : ($lang === 'pb' ? 'ਨਾਮ' : 'नाम') }}</label>
                <input type="text" id="auth-name" placeholder="{{ $lang === 'en' ? 'Enter your name' : ($lang === 'pb' ? 'ਆਪਣਾ ਨਾਮ ਲਿਖੋ' : 'अपना नाम लिखें') }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="auth-email" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Email Address' : ($lang === 'pb' ? 'ਈਮੇਲ ਪਤਾ' : 'ईमेल पता') }}</label>
                <input type="email" id="auth-email" placeholder="{{ $lang === 'en' ? 'Enter your email' : ($lang === 'pb' ? 'ਆਪਣਾ ਈਮੇਲ ਲਿਖੋ' : 'अपना ईमेल लिखें') }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="auth-password" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Password' : ($lang === 'pb' ? 'ਪਾਸਵਰਡ' : 'पासवर्ड') }}</label>
                <input type="password" id="auth-password" placeholder="{{ $lang === 'en' ? 'Enter password' : ($lang === 'pb' ? 'ਪਾਸਵਰਡ ਲਿਖੋ' : 'पासवर्ड लिखें') }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);" required>
            </div>

            <!-- Password Confirmation Field (Only visible in Register mode) -->
            <div id="auth-confirm-group" style="display: none; margin-bottom: 20px;">
                <label for="auth-password-confirm" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">{{ $lang === 'en' ? 'Confirm Password' : ($lang === 'pb' ? 'ਪਾਸਵਰਡ ਦੀ ਪੁਸ਼ਟੀ ਕਰੋ' : 'पासवर्ड की पुष्टि करें') }}</label>
                <input type="password" id="auth-password-confirm" placeholder="{{ $lang === 'en' ? 'Re-type password' : ($lang === 'pb' ? 'ਪਾਸਵਰਡ ਦੁਬਾਰਾ ਲਿਖੋ' : 'पासवर्ड पुनः लिखें') }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: var(--bg-card); color: var(--text-main);">
            </div>

            <button type="submit" id="auth-submit-btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background: var(--primary-color); color: #fff; cursor: pointer; font-size: 1rem; font-weight: 600; margin-bottom: 15px;">{{ $lang === 'en' ? 'Login' : ($lang === 'pb' ? 'ਲੌਗਇਨ ਕਰੋ' : 'लॉगिन करें') }}</button>
            
            <div style="text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                <span id="auth-switch-prompt">{{ $lang === 'en' ? "Don't have an account?" : ($lang === 'pb' ? 'ਖਾਤਾ ਨਹੀਂ ਹੈ?' : 'खाता नहीं है?') }}</span> 
                <span id="auth-switch-btn" style="color: var(--primary-color); cursor: pointer; font-weight: 600;">{{ $lang === 'en' ? 'Register Now' : ($lang === 'pb' ? 'ਰਜਿਸਟਰ ਕਰੋ' : 'रजिस्टर करें') }}</span>
            </div>
        </form>
    </div>

    <!-- 11. Footer -->
    <footer>
        <div class="container footer-grid">
            <div class="footer-logo-col">
                <a href="/" class="footer-logo" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <img src="/images/logo.png" alt="Aakash News 24" style="height: 40px; width: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2);" />
                    <span style="color: #fff; font-weight: 900; font-size: 1.35rem;">AAKASH <span style="color: #e53e3e;">NEWS 24</span></span>
                </a>
                <p>{{ $t['footer_tagline'] }}</p>
                <div class="social-links">
                    <a href="#" class="social-btn" aria-label="Facebook"><i data-feather="facebook"></i></a>
                    <a href="#" class="social-btn" aria-label="Twitter"><i data-feather="twitter"></i></a>
                    <a href="#" class="social-btn" aria-label="Instagram"><i data-feather="instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="Youtube"><i data-feather="youtube"></i></a>
                </div>
            </div>

            <div class="footer-links-col">
                <h4>{{ $lang === 'en' ? 'Explore' : ($lang === 'pb' ? 'ਐਕਸਪਲੋਰ ਕਰੋ' : 'एक्सप्लोर') }}</h4>
                <ul class="footer-links">
                    <li><a href="#">{{ $t['home'] }}</a></li>
                    <li><a href="#">{{ $t['national'] }}</a></li>
                    <li><a href="#">{{ $t['state'] }}</a></li>
                    <li><a href="#">{{ $t['world'] }}</a></li>
                    <li><a href="#">{{ $t['video'] }}</a></li>
                    <li><a href="#">{{ $t['gallery'] }}</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4>{{ $lang === 'en' ? 'Categories' : ($lang === 'pb' ? 'ਸ਼੍ਰੇਣੀਆਂ' : 'कैटेगरी') }}</h4>
                <ul class="footer-links">
                    <li><a href="#">{{ $t['politics'] }}</a></li>
                    <li><a href="#">{{ $t['sports'] }}</a></li>
                    <li><a href="#">{{ $t['business'] }}</a></li>
                    <li><a href="#">{{ $t['technology'] }}</a></li>
                    <li><a href="#">{{ $t['entertainment'] }}</a></li>
                    <li><a href="#">{{ $t['lifestyle'] }}</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4>{{ $lang === 'en' ? 'Help & Support' : ($lang === 'pb' ? 'ਮਦਦ' : 'सहायता') }}</h4>
                <ul class="footer-links">
                    <li><a href="#">{{ $lang === 'en' ? 'About Us' : ($lang === 'pb' ? 'ਸਾਡੇ ਬਾਰੇ' : 'हमारे बारे में') }}</a></li>
                    <li><a href="#">{{ $lang === 'en' ? 'Contact Us' : ($lang === 'pb' ? 'ਸੰਪਰਕ ਕਰੋ' : 'संपर्क करें') }}</a></li>
                    <li><a href="#">{{ $lang === 'en' ? 'Privacy Policy' : ($lang === 'pb' ? 'ਪ੍ਰਾਈਵੇਸੀ ਪਾਲਿਸੀ' : 'गोपनीयता नीति') }}</a></li>
                    <li><a href="#">{{ $lang === 'en' ? 'Terms & Conditions' : ($lang === 'pb' ? 'ਨਿਯਮ ਅਤੇ ਸ਼ਰਤਾਂ' : 'नियम & शर्तें') }}</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-app-col">
                <h4>{{ $lang === 'en' ? 'Download Mobile App' : ($lang === 'pb' ? 'ਮੋਬਾਈਲ ਐਪ ਡਾਊਨਲੋਡ ਕਰੋ' : 'मोबाइल ऐप डाउनलोड करें') }}</h4>
                <div class="app-badges">
                    <div class="app-badge-btn">
                        <i data-feather="play"></i>
                        <div>
                            <span>GET IT ON</span>
                            <strong>Google Play</strong>
                        </div>
                    </div>
                    <div class="app-badge-btn">
                        <i data-feather="smartphone"></i>
                        <div>
                            <span>Download on the</span>
                            <strong>App Store</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-bar">
            &copy; 2026 Aakash News 24. {{ $lang === 'en' ? 'All rights reserved.' : ($lang === 'pb' ? 'ਸਾਰੇ ਹੱਕ ਰਾਖਵੇਂ ਹਨ।' : 'सभी अधिकार सुरक्षित।') }}
        </div>
    </footer>
    <div class="sidebar-overlay" id="auth-modal-overlay" style="z-index: 999;"></div>

    <!-- Reader's Corner JS (AI Moderation) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentLang = '{{ $lang }}';
            const postsContainer = document.getElementById('laravel-user-posts-container');
            const postForm = document.getElementById('reader-post-form');
            const submitFeedback = document.getElementById('post-submit-feedback');
            const submitBtn = document.getElementById('post-submit-btn');

            function renderPostVideo(url) {
                if (!url) return '';
                url = url.trim();
                
                // YouTube
                let youtubeReg = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
                let youtubeMatch = url.match(youtubeReg);
                if (youtubeMatch && youtubeMatch[1]) {
                    const videoId = youtubeMatch[1];
                    return `
                        <div class="post-video-wrapper" style="position: relative; width: 100%; padding-top: 56.25%; margin-top: 12px; border-radius: 8px; overflow: hidden; background: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                            <iframe src="https://www.youtube.com/embed/${videoId}" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    `;
                }

                // YouTube Shorts
                let ytShortsReg = /youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/i;
                let ytShortsMatch = url.match(ytShortsReg);
                if (ytShortsMatch && ytShortsMatch[1]) {
                    const videoId = ytShortsMatch[1];
                    return `
                        <div class="post-video-wrapper" style="position: relative; width: 100%; max-width: 320px; aspect-ratio: 9/16; margin: 12px auto 0 auto; border-radius: 8px; overflow: hidden; background: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                            <iframe src="https://www.youtube.com/embed/${videoId}" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    `;
                }

                // Instagram
                let instaReg = /instagram\.com\/(?:p|reel|tv)\/([a-zA-Z0-9_\-]+)/i;
                let instaMatch = url.match(instaReg);
                if (instaMatch && instaMatch[1]) {
                    const code = instaMatch[1];
                    return `
                        <div class="post-video-wrapper" style="position: relative; width: 100%; max-width: 320px; aspect-ratio: 9/16; margin: 12px auto 0 auto; border-radius: 8px; overflow: hidden; background: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                            <iframe src="https://www.instagram.com/reel/${code}/embed/" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                        </div>
                    `;
                }

                // Direct video link
                if (/\.(mp4|webm|ogg)(?:$|\?)/i.test(url)) {
                    return `
                        <div class="post-video-wrapper" style="position: relative; width: 100%; margin-top: 12px; border-radius: 8px; overflow: hidden; background: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                            <video src="${url}" controls style="width: 100%; display: block; max-height: 400px; object-fit: contain;"></video>
                        </div>
                    `;
                }

                // Fallback Link Card
                return `
                    <div style="margin-top: 12px; background: rgba(229, 62, 62, 0.04); border: 1px dashed rgba(229, 62, 62, 0.2); border-radius: 8px; padding: 12px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(229, 62, 62, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                                <i data-feather="play"></i>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 700; font-size: 0.85rem; color: var(--text-main);">संलग्न वीडियो लिंक</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted); word-break: break-all; max-width: 320px;">${url}</div>
                            </div>
                        </div>
                        <a href="${url}" target="_blank" rel="noopener noreferrer" style="background: var(--primary-color); color: #fff; text-decoration: none; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; flex-shrink: 0;">
                            देखें <i data-feather="external-link" style="font-size: 0.65rem;"></i>
                        </a>
                    </div>
                `;
            }

            // Fetch and render posts
            function fetchUserPosts() {
                fetch('/api/posts')
                    .then(res => res.json())
                    .then(posts => {
                        // Keep header, clear old posts
                        const header = postsContainer.querySelector('h4');
                        postsContainer.innerHTML = '';
                        postsContainer.appendChild(header);

                        if (posts.length === 0) {
                            postsContainer.innerHTML += `
                                <div style="text-align: center; padding: 45px 20px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; color: var(--text-muted);">
                                    <i data-feather="edit" style="font-size: 2.5rem; margin-bottom: 10px; color: var(--border-color);"></i>
                                    <div>अभी तक कोई पोस्ट नहीं है। पहली पोस्ट लिखें!</div>
                                </div>
                            `;
                            return;
                        }

                        function getCategoryBadgeStyle(category) {
                            switch(category) {
                                case 'देश':
                                    return 'background: rgba(49, 151, 149, 0.08); color: #319795; border: 1px solid rgba(49, 151, 149, 0.15);';
                                case 'राजनीति':
                                    return 'background: rgba(229, 62, 62, 0.08); color: #e53e3e; border: 1px solid rgba(229, 62, 62, 0.15);';
                                case 'खेल':
                                    return 'background: rgba(221, 107, 32, 0.08); color: #dd6b20; border: 1px solid rgba(221, 107, 32, 0.15);';
                                case 'बिजनेस':
                                    return 'background: rgba(56, 161, 105, 0.08); color: #38a169; border: 1px solid rgba(56, 161, 105, 0.15);';
                                case 'टेक्नोलॉजी':
                                    return 'background: rgba(66, 153, 225, 0.08); color: #4299e1; border: 1px solid rgba(66, 153, 225, 0.15);';
                                case 'मनोरंजन':
                                    return 'background: rgba(159, 122, 234, 0.08); color: #9f7aea; border: 1px solid rgba(159, 122, 234, 0.15);';
                                case 'दुनिया':
                                    return 'background: rgba(237, 100, 166, 0.08); color: #ed64a6; border: 1px solid rgba(237, 100, 166, 0.15);';
                                default:
                                    return 'background: rgba(225, 48, 108, 0.08); color: var(--primary-color); border: 1px solid rgba(225, 48, 108, 0.15);';
                            }
                        }

                        posts.forEach(post => {
                            const formattedDate = new Date(post.created_at).toLocaleDateString('hi-IN', {
                                day: 'numeric',
                                month: 'short',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            const postCard = document.createElement('div');
                            postCard.className = 'user-post-card';
                            postCard.style.cssText = 'background: var(--bg-card); border-left: 4px solid var(--primary-color) !important; border-radius: 12px; padding: 18px; position: relative; margin-top: 15px; text-align: left;';
                            
                            const badgeStyle = getCategoryBadgeStyle(post.category);
                            const videoHtml = renderPostVideo(post.video_url);
                            const imageHtml = post.image_url 
                                ? `<div class="post-image-wrapper" style="margin-top: 12px; border-radius: 8px; overflow: hidden; background: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                     <img src="${post.image_url}" style="width: 100%; display: block; max-height: 400px; object-fit: contain;">
                                   </div>`
                                : '';

                            // Dynamically select localized title and content based on current active language
                            let displayTitle = post.title;
                            let displayContent = post.content;
                            const categoryMap = {
                                'hi': {
                                    'देश': 'देश', 'राज्य': 'राज्य', 'राजनीति': 'राजनीति', 'खेल': 'खेल', 'बिजनेस': 'बिजनेस', 'टेक्नोलॉजी': 'टेक्नोलॉजी', 'मनोरंजन': 'मनोरंजन', 'लाइफस्टाइल': 'लाइफस्टाइल', 'एजुकेशन': 'एजुकेशन', 'दुनिया': 'दुनिया', 'फोटो गैलरी': 'फोटो गैलरी', 'ताजा खबर': 'ताजा खबर'
                                },
                                'en': {
                                    'देश': 'National', 'राज्य': 'State', 'राजनीति': 'Politics', 'खेल': 'Sports', 'बिजनेस': 'Business', 'टेक्नोलॉजी': 'Technology', 'मनोरंजन': 'Entertainment', 'लाइफस्टाइल': 'Lifestyle', 'एजुकेशन': 'Education', 'दुनिया': 'World', 'फोटो गैलरी': 'Photo Gallery', 'ताजा खबर': 'Breaking News'
                                },
                                'pb': {
                                    'देश': 'ਦੇਸ਼', 'राज्य': 'ਰਾਜ', 'राजनीति': 'ਰਾਜਨੀਤੀ', 'खेल': 'ਖੇਡਾਂ', 'बिजनेस': 'ਵਪਾਰ', 'टेक्नोलॉजी': 'ਤਕਨਾਲੋਜੀ', 'मनोरंजन': 'ਮਨੋਰੰਜਨ', 'लाइफस्टाइल': 'ਜੀਵਨ ਸ਼ੈਲੀ', 'एजुकेशन': 'ਸਿੱਖਿਆ', 'दुनिया': 'ਦੁਨੀਆ', 'ਫੋਟੋ ਗੈਲਰੀ': 'ਫੋਟੋ ਗੈਲਰੀ', 'ताजा खबर': 'ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ'
                                }
                            };
                            const verifiedMap = {
                                'hi': 'सत्यापित',
                                'en': 'Verified',
                                'pb': 'ਤਸਦੀਕਸ਼ੁਦਾ'
                            };

                            let displayCategory = (categoryMap[currentLang] && categoryMap[currentLang][post.category]) || post.category;
                            let displayVerified = verifiedMap[currentLang] || 'सत्यापित';

                            displayTitle = post.title;
                            displayContent = post.content;
                            
                            postCard.innerHTML = `
                                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 10px;">
                                    <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; ${badgeStyle}">${displayCategory}</span>
                                    
                                    <span class="badge-verified-pulse" style="font-size: 0.72rem; font-weight: 700; background: rgba(16, 185, 129, 0.08); color: #10b981; padding: 4px 10px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid rgba(16, 185, 129, 0.15);">
                                        <i data-feather="check-circle" style="font-size: 0.75rem;"></i> ${displayVerified}
                                    </span>
                                </div>

                                <h5 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin-bottom: 8px; line-height: 1.45;">${displayTitle}</h5>

                                <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 14px; white-space: pre-wrap;">${displayContent}</p>

                                ${imageHtml}

                                ${videoHtml}

                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: var(--text-muted); border-top: 1px solid rgba(0,0,0,0.05); padding-top: 10px; margin-top: 10px;">
                                    <span style="font-weight: 600;">
                                        <i data-feather="user" style="margin-right: 5px;"></i> ${post.author_name}
                                    </span>
                                    <span>
                                        <i data-feather="clock" style="margin-right: 5px;"></i> ${formattedDate}
                                    </span>
                                </div>
                            `;
                            postsContainer.appendChild(postCard);
                        });
                    })
                    .catch(err => console.error('Error fetching posts:', err));
            }

            // Submit post
            postForm.addEventListener('submit', function (e) {
                e.preventDefault();
                
                submitBtn.disabled = true;
                let reviewText = 'Reviewing...';
                if (currentLang === 'hi') reviewText = 'समीक्षा की जा रही है...';
                else if (currentLang === 'pb') reviewText = 'ਸਮੀਖਿਆ ਕੀਤੀ ਜਾ ਰਹੀ ਹੈ...';
                submitBtn.innerHTML = '<i data-feather="loader" class="feather-spin"></i> ' + reviewText;
                submitFeedback.style.display = 'none';

                const payload = {
                    title: document.getElementById('post-title').value,
                    content: document.getElementById('post-content').value,
                    category: document.getElementById('post-category').value,
                    author_name: document.getElementById('post-author-name').value,
                    video_url: document.getElementById('post-video-url').value
                };

                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const headers = {
                    'Content-Type': 'application/json'
                };
                if (csrfMeta) {
                    headers['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content');
                }

                fetch('/api/posts', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false;
                    let publishText = 'Publish';
                    if (currentLang === 'hi') publishText = 'प्रकाशित करें';
                    else if (currentLang === 'pb') publishText = 'ਪ੍ਰਕਾਸ਼ਿਤ ਕਰੋ';
                    submitBtn.innerHTML = '<i data-feather="send"></i> ' + publishText;

                    submitFeedback.style.display = 'block';
                    if (data.success) {
                        submitFeedback.style.border = '1px solid #10b981';
                        submitFeedback.style.background = 'rgba(16, 185, 129, 0.06)';
                        submitFeedback.style.color = 'var(--text-main)';
                        
                        let ai = {};
                        try {
                            ai = typeof data.post.ai_feedback === 'string' ? JSON.parse(data.post.ai_feedback || '{}') : (data.post.ai_feedback || {});
                        } catch (ex) {}

                        let successHeading = 'Post Submitted Successfully!';
                        let statusText = 'Status: Pending Approval';
                        let reviewHeading = 'Review Details:';
                        let verdictLabel = 'Verdict: Safe';
                        
                        if (currentLang === 'hi') {
                            successHeading = 'पोस्ट सफलतापूर्वक सबमिट की गई!';
                            statusText = 'स्थिति: मंजूरी लंबित';
                            reviewHeading = 'समीक्षा विवरण:';
                            verdictLabel = 'निर्णय: सुरक्षित';
                        } else if (currentLang === 'pb') {
                            successHeading = 'ਪੋਸਟ ਸਫਲਤਾਪੂਰਵਕ ਦਰਜ ਕੀਤੀ ਗਈ!';
                            statusText = 'ਸਥਿਤੀ: ਮਨਜ਼ੂਰੀ ਲੰਬਿਤ';
                            reviewHeading = 'ਸਮੀਖਿਆ ਵੇਰਵੇ:';
                            verdictLabel = 'ਨਿਰਣਾ: ਸੁਰੱਖਿਅਤ';
                        }

                        submitFeedback.innerHTML = `
                            <div style="font-weight: 700; display: flex; align-items: center; gap: 6px; color: #10b981; margin-bottom: 6px;">
                                <i data-feather="check-circle"></i>
                                ${successHeading}
                            </div>
                            <div style="font-size: 0.85rem;">${data.message}</div>
                            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed rgba(0,0,0,0.08); font-size: 0.8rem; color: var(--text-muted);">
                                <strong>${reviewHeading}</strong>
                                <ul style="padding-left: 15px; margin-top: 4px; list-style-type: disc; text-align: left; display: flex; flex-direction: column; gap: 2px;">
                                    <li>${statusText}</li>
                                    <li>${verdictLabel}</li>
                                    ${ai.suggested_category ? `<li>Suggested Category: ${ai.suggested_category}</li>` : ''}
                                    ${ai.reason ? `<li>Details: ${ai.reason}</li>` : ''}
                                </ul>
                            </div>
                        `;
                        postForm.reset();
                        fetchUserPosts();
                    } else {
                        submitFeedback.style.border = '1px solid #ef4444';
                        submitFeedback.style.background = 'rgba(239, 68, 68, 0.06)';
                        submitFeedback.style.color = 'var(--text-main)';

                        let ai = {};
                        try {
                            ai = data.post ? (typeof data.post.ai_feedback === 'string' ? JSON.parse(data.post.ai_feedback || '{}') : (data.post.ai_feedback || {})) : {};
                        } catch (ex) {}

                        let errorHeading = 'Submission Rejected';
                        let errorStatusText = 'Status: Flagged Content';
                        let errorReviewHeading = 'Review Details:';
                        
                        if (currentLang === 'hi') {
                            errorHeading = 'प्रकाशन अस्वीकृत';
                            errorStatusText = 'स्थिति: प्रतिबंधित सामग्री (Rejected)';
                            errorReviewHeading = 'समीक्षा विवरण:';
                        } else if (currentLang === 'pb') {
                            errorHeading = 'ਪ੍ਰਕਾਸ਼ਨ ਅਸਵੀਕਾਰ';
                            errorStatusText = 'ਸਥਿਤੀ: ਪ੍ਰਤਿਬੰਧਿਤ ਸਮੱਗਰੀ (Rejected)';
                            errorReviewHeading = 'ਸਮੀਖਿਆ ਵੇਰਵੇ:';
                        }

                        submitFeedback.innerHTML = `
                            <div style="font-weight: 700; display: flex; align-items: center; gap: 6px; color: #ef4444; margin-bottom: 6px;">
                                <i data-feather="alert-circle"></i>
                                ${errorHeading}
                            </div>
                            <div style="font-size: 0.85rem;">${data.message}</div>
                            ${ai.reason ? `
                                <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed rgba(0,0,0,0.1); font-size: 0.8rem; color: var(--text-muted);">
                                    <strong>${errorReviewHeading}</strong>
                                    <ul style="padding-left: 15px; margin-top: 4px; list-style-type: disc; text-align: left; display: flex; flex-direction: column; gap: 2px;">
                                        <li>${errorStatusText}</li>
                                        <li>Details: ${ai.reason}</li>
                                    </ul>
                                </div>
                            ` : ''}
                        `;
                    }
                })
                .catch(err => {
                    console.error('Error submitting post:', err);
                    submitBtn.disabled = false;
                    let publishText = 'Publish';
                    if (currentLang === 'hi') publishText = 'प्रकाशित करें';
                    else if (currentLang === 'pb') publishText = 'ਪ੍ਰਕਾਸ਼ਿਤ ਕਰੋ';
                    submitBtn.innerHTML = '<i data-feather="send"></i> ' + publishText;
                    submitFeedback.style.display = 'block';
                    submitFeedback.style.border = '1px solid #ef4444';
                    submitFeedback.style.background = 'rgba(239, 68, 68, 0.06)';
                    submitFeedback.style.color = 'var(--text-main)';
                    
                    let errorHeading = 'Error';
                    let errorDesc = 'Unable to connect to the server.';
                    if (currentLang === 'hi') {
                        errorHeading = 'त्रुटि';
                        errorDesc = 'सर्वर से संपर्क करने में असमर्थ।';
                    } else if (currentLang === 'pb') {
                        errorHeading = 'ਗਲਤੀ';
                        errorDesc = 'ਸਰਵਰ ਨਾਲ ਸੰਪਰਕ ਕਰਨ ਵਿੱਚ ਅਸਮਰੱਥ।';
                    }
                    submitFeedback.innerHTML = `
                        <div style="font-weight: 700; display: flex; align-items: center; gap: 6px; color: #ef4444; margin-bottom: 8px;">
                            <i data-feather="alert-circle"></i>
                            ${errorHeading}
                        </div>
                        <div>${errorDesc}</div>
                    `;
                });
            });

            // Initial fetch
            fetchUserPosts();
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
