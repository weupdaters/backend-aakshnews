@extends('reporter.layouts.app')

@section('title', 'Reporter Profile')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white shadow-md">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 border-2 border-[#FFC400] overflow-hidden p-1 shrink-0">
                <img src="{{ $reporter->avatar ?? '/images/author_avatar.png' }}" alt="{{ $reporter->name }}" class="w-full h-full object-cover rounded-xl" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&q=80'">
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-black font-manrope">{{ $reporter->name ?? 'Gurpreet Singh Chahal' }}</h1>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-[#FFC400] text-[#062B63]">
                        Verified Field Reporter
                    </span>
                </div>
                <p class="text-xs text-blue-100/90 mt-1">
                    {{ $reporter->badge ?? 'Senior Contributor' }} • {{ $reporter->district ?? 'Patiala' }}, {{ $reporter->state ?? 'Punjab' }}
                </p>
                <div class="flex items-center gap-3 text-[11px] text-blue-200 mt-2">
                    <span><i class="fa-regular fa-envelope"></i> {{ $reporter->email ?? 'gurpreet.patiala@aakshnews.in' }}</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-phone"></i> {{ $reporter->phone ?? '+91 98765-43210' }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('reporter.certificates') }}" class="px-4 py-2.5 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black text-xs transition-all shadow-md flex items-center gap-2 self-start sm:self-auto shrink-0">
            <i class="fa-solid fa-award"></i>
            <span>View Press Accreditation</span>
        </a>
    </div>
</div>

<!-- Details Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-6">
        <div>
            <h3 class="text-sm font-black text-slate-900 mb-1">Journalistic Bio & Ground Beat</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                {{ $reporter->bio ?? 'Senior Ground Correspondent covering rural governance, agrarian economy, water resource management, and local civic issues in the Malwa region of Punjab.' }}
            </p>
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h3 class="text-sm font-black text-slate-900 mb-3">Accreditation Profile Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">Reporter ID</span>
                    <span class="font-mono font-black text-[#1769D2] text-sm">{{ $reporter->reporter_id ?? 'REP-101' }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">Assigned Bureau</span>
                    <span class="font-black text-slate-800 text-sm">{{ $reporter->district ?? 'Patiala' }} District Bureau</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">Accreditation Rank</span>
                    <span class="font-black text-emerald-700 text-sm">Level 4 Senior Citizen Journalist</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">Valid Until</span>
                    <span class="font-black text-slate-800 text-sm">31 December 2026</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side Stats -->
    <div class="space-y-4">
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider">Reputation & Honorarium</h3>
            <div class="p-4 rounded-2xl bg-gradient-to-br from-[#062B63] to-[#1769D2] text-white">
                <span class="text-[10px] uppercase tracking-wider text-blue-200 font-bold block">Current Points Balance</span>
                <div class="text-3xl font-black mt-1 text-[#FFC400]">★ {{ $reporter->points ?? 980 }} pts</div>
                <div class="text-xs text-blue-100 font-semibold mt-1">₹{{ number_format(($reporter->points ?? 980) * 5) }} Estimated Cash Value</div>
            </div>
            <a href="{{ route('reporter.points') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center gap-1.5 transition-colors">
                <span>Open Points & Rewards</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
@endsection
