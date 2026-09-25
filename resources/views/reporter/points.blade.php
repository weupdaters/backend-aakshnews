@extends('reporter.layouts.app')

@section('title', 'Points & Rewards')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
            <i class="fa-solid fa-star text-[#FFC400]"></i> Reporter Incentive Registry
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Points, Rewards & Honorarium
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Earn points for verified reports, breaking coverage speed, and high AI accuracy ratings.
        </p>
    </div>

    <div class="px-5 py-3 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-xs flex items-center gap-3 shrink-0">
        <div class="w-10 h-10 rounded-full bg-[#FFC400] text-[#062B63] flex items-center justify-center font-black text-lg shadow-sm">
            ★
        </div>
        <div>
            <div class="text-[10px] font-black uppercase text-blue-200">Current Balance</div>
            <div class="text-2xl font-black text-white">{{ number_format($reporter->points ?? 980) }} pts</div>
        </div>
    </div>
</div>

<!-- 3 Metrics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400">Reporter Tier</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-blue-50 text-[#1769D2]">Level 4</span>
        </div>
        <div class="text-xl font-black text-slate-900">Senior Contributor</div>
        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
            <div class="bg-[#1769D2] h-full rounded-full" style="width: 82%"></div>
        </div>
        <div class="text-[11px] text-slate-400 font-semibold flex justify-between">
            <span>{{ $reporter->points ?? 980 }} pts</span>
            <span>Next: Level 5 Bureau Fellow (1,200 pts)</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400">Estimated Cash Value</span>
            <span class="text-emerald-600 font-black text-xs">₹5 per point</span>
        </div>
        <div class="text-2xl font-black text-emerald-600">₹{{ number_format(($reporter->points ?? 980) * 5) }}</div>
        <p class="text-[11px] text-slate-500 font-medium">Eligible for monthly automated direct UPI honorarium settlement.</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400">Lifetime Earned</span>
            <span class="text-[#1769D2] font-black text-xs">All Time</span>
        </div>
        <div class="text-2xl font-black text-slate-900">3,450 pts</div>
        <p class="text-[11px] text-slate-500 font-medium">28 published stories & 14 editorial excellence commendations.</p>
    </div>
</div>

<!-- Perks Catalog -->
<div class="space-y-4">
    <div>
        <h2 class="text-lg font-black text-slate-900">Redeemable Bureau Perks & Rewards</h2>
        <p class="text-xs text-slate-500">Convert your journalism reputation points into equipment, accreditation, or cash.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Perk 1 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">UPI Cash Honorarium</h3>
                    <p class="text-xs text-slate-500 mt-1">Direct cash transfer credited to your linked UPI VPA or Bank Account.</p>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Cost</div>
                    <div class="text-xs font-black text-[#1769D2]">500 pts</div>
                </div>
                <form action="{{ route('reporter.points.redeem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perk" value="UPI Cash Honorarium">
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-extrabold transition-all shadow-xs cursor-pointer">
                        Redeem ₹2,500
                    </button>
                </form>
            </div>
        </div>

        <!-- Perk 2 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-vest"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Official Press Jacket</h3>
                    <p class="text-xs text-slate-500 mt-1">Weather-resistant high-visibility ground reporter vest with Press insignia.</p>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Cost</div>
                    <div class="text-xs font-black text-[#1769D2]">750 pts</div>
                </div>
                <form action="{{ route('reporter.points.redeem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perk" value="Press Jacket">
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-extrabold transition-all shadow-xs cursor-pointer">
                        Redeem Vest
                    </button>
                </form>
            </div>
        </div>

        <!-- Perk 3 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-id-badge"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Physical Press Badge</h3>
                    <p class="text-xs text-slate-500 mt-1">Hard-laminated QR physical press badge with hologram security seal.</p>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Cost</div>
                    <div class="text-xs font-black text-[#1769D2]">400 pts</div>
                </div>
                <form action="{{ route('reporter.points.redeem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perk" value="Physical Press Badge">
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-extrabold transition-all shadow-xs cursor-pointer">
                        Redeem Badge
                    </button>
                </form>
            </div>
        </div>

        <!-- Perk 4 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 to-violet-700 text-white flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Press Club Membership</h3>
                    <p class="text-xs text-slate-500 mt-1">Annual subscription to Indian Digital Journalists Guild & legal protection.</p>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Cost</div>
                    <div class="text-xs font-black text-[#1769D2]">900 pts</div>
                </div>
                <form action="{{ route('reporter.points.redeem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perk" value="Press Club Membership">
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-extrabold transition-all shadow-xs cursor-pointer">
                        Redeem Pass
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
