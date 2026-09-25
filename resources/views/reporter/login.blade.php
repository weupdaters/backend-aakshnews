<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporter Desk Login - Aaksh News 24</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-manrope { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-[#062B63] via-[#0B1E3F] to-[#0A1222] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl p-7 sm:p-8 shadow-2xl border border-white/20 space-y-6">
        
        <!-- Header & Branding -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-[#062B63] text-white flex items-center justify-center font-black text-2xl mx-auto shadow-md border-2 border-[#FFC400]">
                A
            </div>
            <div>
                <h1 class="text-2xl font-black font-manrope text-slate-900 tracking-tight">
                    AAKSH <span class="text-[#1769D2]">NEWS 24</span>
                </h1>
                <div class="inline-block px-3 py-0.5 rounded-full bg-[#FFC400] text-[#062B63] text-[10px] font-black uppercase tracking-wider mt-1">
                    Citizen Reporter Desk
                </div>
            </div>
            <p class="text-xs text-slate-500 font-medium">
                Sign in with your registered correspondent credentials to file and track ground reports.
            </p>
        </div>

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('reporter.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">
                    Reporter Email Address
                </label>
                <div class="relative">
                    <i class="fa-regular fa-envelope text-slate-400 absolute left-3.5 top-3.5 text-xs"></i>
                    <input
                        type="email"
                        id="emailField"
                        name="email"
                        value="{{ old('email', 'gurpreet.patiala@aakshnews.in') }}"
                        required
                        placeholder="e.g. gurpreet.patiala@aakshnews.in"
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2] bg-slate-50 focus:bg-white"
                    />
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">
                        Password
                    </label>
                    <span class="text-[10px] text-[#1769D2] font-bold">Default: password123</span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-lock text-slate-400 absolute left-3.5 top-3.5 text-xs"></i>
                    <input
                        type="password"
                        id="passwordField"
                        name="password"
                        value="password123"
                        required
                        placeholder="••••••••"
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2] bg-slate-50 focus:bg-white"
                    />
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                    <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded text-[#1769D2] accent-[#1769D2]">
                    <span>Keep me logged in</span>
                </label>
                <a href="{{ route('reporter.help') }}" class="text-[#1769D2] font-bold hover:underline">
                    Forgot Password?
                </a>
            </div>

            <button
                type="submit"
                class="w-full py-3 rounded-2xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] font-black text-xs transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Sign In to Reporter Desk</span>
            </button>
        </form>

        <!-- Quick 1-Click Demo Profiles -->
        <div class="pt-4 border-t border-slate-100 space-y-2">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block text-center">
                One-Click Demo Correspondents
            </span>
            <div class="space-y-1.5">
                @foreach($demoAccounts as $demo)
                    <button
                        type="button"
                        onclick="fillDemo('{{ $demo['email'] }}')"
                        class="w-full text-left p-2.5 rounded-xl border border-slate-200 hover:border-[#1769D2] hover:bg-blue-50/50 transition-all flex items-center justify-between text-xs cursor-pointer group"
                    >
                        <div>
                            <div class="font-bold text-slate-800 group-hover:text-[#1769D2]">
                                {{ $demo['name'] }}
                            </div>
                            <div class="text-[10px] text-slate-400">
                                {{ $demo['district'] }} • {{ $demo['badge'] }}
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">
                            {{ $demo['points'] }} pts
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="text-center text-xs text-slate-400 pt-1">
            <a href="{{ url('/') }}" class="hover:underline flex items-center justify-center gap-1">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Return to Public Newsroom</span>
            </a>
        </div>

    </div>

    <script>
        function fillDemo(email) {
            document.getElementById('emailField').value = email;
            document.getElementById('passwordField').value = 'password123';
        }
    </script>
</body>
</html>
