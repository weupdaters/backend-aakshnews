@extends('reporter.layouts.app')

@section('title', 'Reporter Notifications')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
            <i class="fa-regular fa-bell"></i> Dispatch Alert Hub
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Notifications & Dispatch Alerts
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Real-time editorial desk updates, AI screening scores, and reputation incentives.
        </p>
    </div>

    <button onclick="markAllRead()" id="btnMarkAll" class="px-4 py-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-extrabold text-xs transition-all flex items-center gap-2 cursor-pointer shrink-0 self-start sm:self-auto">
        <i class="fa-solid fa-check text-[#FFC400]"></i>
        <span>Mark All as Read (5)</span>
    </button>
</div>

<!-- Notification Feed -->
<div class="space-y-3">
    <!-- Item 1 -->
    <div class="notif-card bg-white rounded-2xl p-5 border border-[#1769D2]/40 bg-gradient-to-r from-blue-50/20 to-white shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4 flex-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border bg-emerald-50 text-emerald-700 border-emerald-200">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="space-y-1 flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full border bg-emerald-50 text-emerald-700 border-emerald-200">
                        Editorial Desk
                    </span>
                    <span class="w-2 h-2 rounded-full bg-rose-500 unread-dot"></span>
                    <span class="text-[11px] text-slate-400 font-medium">10 minutes ago</span>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900">Ground Report Published by Bureau Chief</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Your investigative report "Stubble Burning Incidents Drop 34% Across Patiala Border" has received editorial sign-off and is now live on the main newsroom.
                </p>
            </div>
        </div>
        <a href="{{ route('reporter.my-reports', ['status' => 'published']) }}" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-bold transition-all shadow-xs flex items-center gap-1 shrink-0 self-end sm:self-center">
            <span>View Published</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <!-- Item 2 -->
    <div class="notif-card bg-white rounded-2xl p-5 border border-[#1769D2]/40 bg-gradient-to-r from-blue-50/20 to-white shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4 flex-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border bg-blue-50 text-blue-700 border-blue-200">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="space-y-1 flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full border bg-blue-50 text-blue-700 border-blue-200">
                        AI Verification
                    </span>
                    <span class="w-2 h-2 rounded-full bg-rose-500 unread-dot"></span>
                    <span class="text-[11px] text-slate-400 font-medium">1 hour ago</span>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900">AI Authenticity Screening Verified: 96% Score</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Your submission passed automated geotag consistency, image EXIF authenticity, and municipal civic feed corroboration.
                </p>
            </div>
        </div>
        <a href="{{ route('reporter.my-reports') }}" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-bold transition-all shadow-xs flex items-center gap-1 shrink-0 self-end sm:self-center">
            <span>Inspect Score</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <!-- Item 3 -->
    <div class="notif-card bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4 flex-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border bg-amber-50 text-amber-700 border-amber-200">
                <i class="fa-solid fa-award"></i>
            </div>
            <div class="space-y-1 flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full border bg-amber-50 text-amber-700 border-amber-200">
                        Reputation Points
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">5 hours ago</span>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900">+150 Points Credited for Breaking Coverage</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Editorial desk awarded you 150 bonus reputation points for rapid on-the-ground reporting during the District Council elections.
                </p>
            </div>
        </div>
        <a href="{{ route('reporter.points') }}" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-bold transition-all shadow-xs flex items-center gap-1 shrink-0 self-end sm:self-center">
            <span>Points Ledger</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <!-- Item 4 -->
    <div class="notif-card bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4 flex-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border bg-purple-50 text-purple-700 border-purple-200">
                <i class="fa-solid fa-id-card"></i>
            </div>
            <div class="space-y-1 flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full border bg-purple-50 text-purple-700 border-purple-200">
                        Accreditation
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">2 days ago</span>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900">Q1 Press Accreditation Card Ready for Renewal</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Your official AAKSH NEWS 24 Citizen Journalist press pass has been renewed for the current quarter. Download or print the digital credential badge.
                </p>
            </div>
        </div>
        <a href="{{ route('reporter.certificates') }}" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-bold transition-all shadow-xs flex items-center gap-1 shrink-0 self-end sm:self-center">
            <span>View Digital Pass</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</div>

<script>
    function markAllRead() {
        document.querySelectorAll('.unread-dot').forEach(el => el.remove());
        document.querySelectorAll('.notif-card').forEach(el => {
            el.classList.remove('border-[#1769D2]/40', 'bg-gradient-to-r', 'from-blue-50/20', 'to-white');
            el.classList.add('border-slate-200/80');
        });
        document.getElementById('btnMarkAll').remove();
    }
</script>
@endsection
