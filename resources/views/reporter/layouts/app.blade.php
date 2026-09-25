<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Reporter Desk') - Aaksh News 24</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            900: '#062B63',
                            800: '#0B3A7A',
                            700: '#1769D2',
                        },
                        brandYellow: '#FFC400',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        manrope: ['"Manrope"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-manrope { font-family: 'Manrope', sans-serif; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-[#F0F4F9] text-slate-800 min-h-screen flex flex-col">

    @if(session()->has('impersonator_admin_id'))
    <div class="bg-amber-500 text-white px-4 py-2 text-sm font-semibold flex items-center justify-between shadow-md z-[60] sticky top-0">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-user-shield"></i>
            <span>You are logged in as Reporter <strong>{{ Auth::user()->name }}</strong> (Admin Impersonation Mode)</span>
        </div>
        <a href="/admin/leave-impersonation" class="bg-slate-900 hover:bg-black text-white text-xs px-3.5 py-1.5 rounded-full font-bold flex items-center gap-1.5 transition">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Return to Admin Account
        </a>
    </div>
    @endif

    <!-- 1. TOP HEADER (Exact Match: Navy Blue Bar) -->
    <header class="bg-[#062B63] text-white sticky top-0 z-50 shadow-md no-print">
        <div class="max-w-[1600px] mx-auto px-4 py-2.5 flex items-center justify-between gap-4">
            
            <!-- Left: Mobile Menu + Brand + Reporter Desk Badge -->
            <div class="flex items-center gap-3">
                <button onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <a href="{{ route('reporter.dashboard') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-xl bg-[#0B4496] flex items-center justify-center font-black text-xl text-white shadow-inner">
                        A
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-lg tracking-tight leading-none text-white">
                            AAKSH<span class="text-[#FFC400]">NEWS24</span>
                        </span>
                        <span class="text-[9px] font-extrabold text-blue-200 tracking-wider uppercase mt-0.5">
                            Citizen Reporter Network
                        </span>
                    </div>
                </a>

                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFC400] text-[#062B63] font-black text-xs shadow-sm ml-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>REPORTER DESK</span>
                </div>
            </div>

            <!-- Center: Quick Header Navigation Pills -->
            <nav class="hidden xl:flex items-center gap-1.5 text-xs font-bold">
                <a href="{{ route('reporter.dashboard') }}" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all {{ request()->routeIs('reporter.dashboard') ? 'bg-white/20 text-white font-extrabold shadow-inner' : 'hover:bg-white/10 text-blue-100 hover:text-white' }}">
                    <i class="fa-solid fa-table-columns text-xs"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('reporter.submit-news') }}" class="flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black shadow-sm transition-all">
                    <i class="fa-solid fa-circle-plus text-xs"></i>
                    <span>+ Submit News</span>
                </a>

                <a href="{{ route('reporter.my-reports') }}" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all {{ request()->routeIs('reporter.my-reports*') ? 'bg-white/20 text-white font-extrabold shadow-inner' : 'hover:bg-white/10 text-blue-100 hover:text-white' }}">
                    <i class="fa-regular fa-file-lines text-xs"></i>
                    <span>My Reports</span>
                </a>

                <a href="{{ route('reporter.profile') }}" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all {{ request()->routeIs('reporter.profile') ? 'bg-white/20 text-white font-extrabold shadow-inner' : 'hover:bg-white/10 text-blue-100 hover:text-white' }}">
                    <i class="fa-regular fa-user text-xs"></i>
                    <span>Reporter Profile</span>
                </a>
            </nav>

            <!-- Right: Return to Portal & Reporter Pill -->
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/15 text-xs font-bold border border-white/20 text-slate-200 hover:text-white transition-colors">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Main Newsroom</span>
                </a>

                <!-- Profile Pill -->
                <div class="flex items-center gap-2 pl-2 pr-3 py-1 rounded-full bg-[#0B4496] border border-blue-400/30 text-xs">
                    <div class="w-7 h-7 rounded-full bg-[#1769D2] text-white flex items-center justify-center font-black text-xs shadow-sm">
                        {{ strtoupper(substr($reporter->name ?? 'Gurpreet', 0, 1)) }}
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="font-extrabold text-white text-xs leading-none">
                            {{ explode(' ', $reporter->name ?? 'Gurpreet')[0] }}
                        </span>
                        <span class="text-[10px] font-black text-[#FFC400] flex items-center gap-0.5">
                            ★ {{ $reporter->points ?? 980 }} pts
                        </span>
                    </div>
                    <form action="{{ route('reporter.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="ml-1 p-1 hover:bg-white/20 rounded-full text-blue-200 hover:text-white cursor-pointer transition-colors">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </header>

    <!-- 2. MAIN CONTAINER -->
    <div class="max-w-[1600px] w-full mx-auto flex flex-1 overflow-hidden">
        
        <!-- LEFT SIDEBAR -->
        <aside id="reporterSidebar" class="w-64 bg-white border-r border-slate-200/80 p-4 space-y-6 shrink-0 hidden lg:block overflow-y-auto no-print">
            
            <!-- Quick Action Button -->
            <a href="{{ route('reporter.submit-news') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] font-black text-xs shadow-md transition-all">
                <i class="fa-solid fa-circle-plus"></i>
                <span>File Ground Story</span>
            </a>

            <!-- Group 1: REPORTS -->
            <div class="space-y-1">
                <span class="text-[10px] font-black tracking-wider text-slate-400 uppercase px-3">
                    REPORTS
                </span>
                <div class="pt-1 space-y-0.5">
                    <a href="{{ route('reporter.dashboard') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.dashboard') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-table-columns w-4 text-slate-400"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('reporter.submit-news') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.submit-news') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-circle-plus w-4 text-slate-400"></i>
                        <span>Submit News</span>
                    </a>

                    <a href="{{ route('reporter.my-reports') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.my-reports') && !request()->has('status') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-regular fa-file-lines w-4 text-slate-400"></i>
                        <span>My Reports</span>
                    </a>

                    <a href="{{ route('reporter.my-reports', ['status' => 'published']) }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'published' ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-regular fa-circle-check w-4 text-slate-400"></i>
                        <span>Published News</span>
                    </a>

                    <a href="{{ route('reporter.my-reports', ['status' => 'drafts']) }}" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'drafts' ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-pen-ruler w-4 text-slate-400"></i>
                            <span>Drafts</span>
                        </div>
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-500 font-black text-[10px] flex items-center justify-center">
                            3
                        </span>
                    </a>

                    <a href="{{ route('reporter.my-reports', ['status' => 'rejected']) }}" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'rejected' ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-regular fa-circle-xmark w-4 text-slate-400"></i>
                            <span>Rejected News</span>
                        </div>
                        <span class="w-5 h-5 rounded-full bg-rose-50 text-rose-600 font-black text-[10px] flex items-center justify-center">
                            1
                        </span>
                    </a>
                </div>
            </div>

            <!-- Group 2: CITIZEN TOOLS -->
            <div class="space-y-1">
                <span class="text-[10px] font-black tracking-wider text-slate-400 uppercase px-3">
                    CITIZEN TOOLS
                </span>
                <div class="pt-1 space-y-0.5">
                    <a href="{{ route('reporter.my-reports') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <i class="fa-solid fa-bullseye w-4 text-slate-400"></i>
                        <span>Fact Check</span>
                    </a>

                    <a href="{{ route('reporter.my-reports') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <i class="fa-solid fa-chart-line w-4 text-slate-400"></i>
                        <span>My Activity</span>
                    </a>

                    <a href="{{ route('reporter.points') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.points') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-star w-4 text-slate-400"></i>
                        <span>Points & Rewards</span>
                    </a>

                    <a href="{{ route('reporter.certificates') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.certificates') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-award w-4 text-slate-400"></i>
                        <span>Certificates</span>
                    </a>
                </div>
            </div>

            <!-- Group 3: ACCOUNT -->
            <div class="space-y-1">
                <span class="text-[10px] font-black tracking-wider text-slate-400 uppercase px-3">
                    ACCOUNT
                </span>
                <div class="pt-1 space-y-0.5">
                    <a href="{{ route('reporter.profile') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.profile') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-regular fa-user w-4 text-slate-400"></i>
                        <span>Reporter Profile</span>
                    </a>

                    <a href="{{ route('reporter.notifications') }}" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.notifications') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-regular fa-bell w-4 text-slate-400"></i>
                            <span>Notifications</span>
                        </div>
                        <span class="w-5 h-5 rounded-full bg-rose-500 text-white font-black text-[10px] flex items-center justify-center shadow-xs">
                            5
                        </span>
                    </a>

                    <a href="{{ route('reporter.settings') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.settings') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-gear w-4 text-slate-400"></i>
                        <span>Settings</span>
                    </a>

                    <a href="{{ route('reporter.help') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('reporter.help') ? 'bg-[#EBF2FE] text-[#1769D2]' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-regular fa-circle-question w-4 text-slate-400"></i>
                        <span>Help & Support</span>
                    </a>
                </div>
            </div>

        </aside>

        <!-- RIGHT MAIN WORKSPACE -->
        <main class="flex-1 p-4 sm:p-6 lg:p-7 space-y-6 overflow-y-auto min-w-0">
            
            <!-- Toast notification messages -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500 text-white text-xs font-extrabold flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-slate-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-500 text-white text-xs font-extrabold flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-slate-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Mobile Drawer Script -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('reporterSidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-50', 'w-72', 'shadow-2xl');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-50', 'w-72', 'shadow-2xl');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
