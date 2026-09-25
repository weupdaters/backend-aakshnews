@extends('reporter.layouts.app')

@section('title', 'Reporter Dashboard')

@section('content')
<!-- Page Title & CTA Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200">
            Citizen Reporter Network • Live Bureau Dispatch
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Ground Dispatch Dashboard
        </h1>
        <p className="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Logged in as <strong class="text-[#FFC400]">{{ $reporter->name ?? 'Gurpreet Singh Chahal' }}</strong> • {{ $reporter->district ?? 'Patiala' }} Bureau ({{ $reporter->badge ?? 'Senior Contributor' }})
        </p>
    </div>

    <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('reporter.submit-news') }}" class="px-5 py-3 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black text-xs transition-all shadow-md flex items-center justify-center gap-2">
            <i class="fa-solid fa-circle-plus"></i>
            <span>File New Ground Story</span>
        </a>
    </div>
</div>

<!-- 4 Key Stat Cards -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase">Total Dispatches</span>
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1769D2] flex items-center justify-center text-xs">
                <i class="fa-regular fa-file-lines"></i>
            </div>
        </div>
        <div class="text-2xl font-black text-[#062B63] mt-2">{{ $stats['total'] }}</div>
        <div class="text-[11px] text-slate-500 font-medium mt-1">100% Filed on Ground</div>
    </div>

    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase">Published Live</span>
            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
        <div class="text-2xl font-black text-emerald-600 mt-2">{{ $stats['published'] }}</div>
        <div class="text-[11px] text-emerald-600 font-bold mt-1">Live on Main Newsroom</div>
    </div>

    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase">Under Review</span>
            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
        <div class="text-2xl font-black text-amber-500 mt-2">{{ $stats['in_review'] }}</div>
        <div class="text-[11px] text-amber-600 font-bold mt-1">Desk Sign-Off Pending</div>
    </div>

    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase">Reputation Points</span>
            <div class="w-8 h-8 rounded-xl bg-amber-50 text-[#FFC400] flex items-center justify-center text-xs font-black">
                ★
            </div>
        </div>
        <div class="text-2xl font-black text-[#1769D2] mt-2">{{ $stats['points'] }} pts</div>
        <div class="text-[11px] text-slate-500 font-medium mt-1">Level 4 Contributor</div>
    </div>
</div>

<!-- Recent Reports Table -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-black text-slate-900">Recent Dispatched Ground Reports</h2>
            <p class="text-xs text-slate-500">Live status of your submitted investigative reports and civic coverage</p>
        </div>
        <a href="{{ route('reporter.my-reports') }}" class="text-xs font-bold text-[#1769D2] hover:underline flex items-center gap-1">
            <span>View All Reports</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] border-b border-slate-200">
                <tr>
                    <th class="py-3 px-4">Tracking ID</th>
                    <th class="py-3 px-4">Headline & Media</th>
                    <th class="py-3 px-4">District</th>
                    <th class="py-3 px-4">Filed Date</th>
                    <th class="py-3 px-4">Advisory AI</th>
                    <th class="py-3 px-4">Editorial Status</th>
                    <th class="py-3 px-4 text-center">Reads</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($reports as $report)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="py-3.5 px-4 font-mono font-bold text-[#1769D2]">
                        {{ $report->trackingId }}
                    </td>
                    <td class="py-3.5 px-4 max-w-sm">
                        <span class="text-[10px] font-black uppercase text-[#1769D2] block">
                            {{ $report->category }}
                        </span>
                        <span class="font-bold text-slate-900 line-clamp-1">
                            {{ $report->title }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-slate-600 font-semibold whitespace-nowrap">
                        <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>
                        {{ $report->district }}
                    </td>
                    <td class="py-3.5 px-4 text-slate-500 font-medium whitespace-nowrap">
                        {{ $report->submittedAt }}
                    </td>
                    <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-blue-50 text-[#1769D2] border border-blue-100">
                            <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i>
                            {{ $report->aiScore }}%
                        </span>
                    </td>
                    <td class="py-3.5 px-4 whitespace-nowrap">
                        @if($report->status === 'published')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <i class="fa-solid fa-circle-check"></i> Published Live
                            </span>
                        @elseif($report->status === 'rejected')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-200">
                                <i class="fa-solid fa-circle-xmark"></i> Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200">
                                <i class="fa-solid fa-clock"></i> Desk Review
                            </span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 text-center font-bold text-slate-600 whitespace-nowrap">
                        @if($report->views > 0)
                            <span class="flex items-center justify-center gap-1">
                                <i class="fa-regular fa-eye text-slate-400"></i>
                                {{ number_format($report->views) }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                        <a href="{{ route('reporter.report.show', $report->id) }}" class="px-3 py-1.5 rounded-lg bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] font-bold text-[11px] inline-flex items-center gap-1 transition-all shadow-xs">
                            <span>Track Dossier</span>
                            <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
