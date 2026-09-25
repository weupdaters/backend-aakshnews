@extends('reporter.layouts.app')

@section('title', 'Report Dossier - ' . ($report->trackingId ?? 'REP-2026-001'))

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="font-mono text-xs font-bold text-[#FFC400] bg-white/10 px-2.5 py-0.5 rounded-full">
                    {{ $report->trackingId }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-[#1769D2] text-white">
                    {{ $report->category }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black font-manrope">
                {{ $report->title }}
            </h1>
            <p class="text-xs text-blue-100/90 mt-1">
                Filed by {{ $reporter->name }} • {{ $report->district }} District Bureau • {{ $report->submittedAt }}
            </p>
        </div>

        <a href="{{ route('reporter.my-reports') }}" class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center gap-1.5 self-start sm:self-auto shrink-0">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Back to Reports</span>
        </a>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-5">
            <div class="rounded-2xl overflow-hidden max-h-96 bg-slate-100 border border-slate-200">
                <img src="{{ $report->image }}" alt="{{ $report->title }}" class="w-full h-full object-cover">
            </div>

            <div>
                <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-2">Detailed Ground Story</h3>
                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-3 whitespace-pre-line">
                    {{ $report->content }}
                </div>
            </div>
        </div>

        <!-- Right Side: AI Veracity & Editorial Review Milestone -->
        <div class="space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-black uppercase text-[#1769D2] tracking-wider">AI Veracity Scorecard</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                        {{ $report->aiScore }}% Veracity
                    </span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">EXIF Geotag Check</span>
                        <span class="font-bold text-emerald-600"><i class="fa-solid fa-check"></i> Passed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Duplicate Incident Test</span>
                        <span class="font-bold text-emerald-600"><i class="fa-solid fa-check"></i> Original Story</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Municipal Corroboration</span>
                        <span class="font-bold text-emerald-600"><i class="fa-solid fa-check"></i> Patiala Local Feeds</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider">Editorial Review Milestones</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-[10px] mt-0.5">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">Report Filed on Ground</div>
                            <div class="text-[10px] text-slate-400">{{ $report->submittedAt }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-[10px] mt-0.5">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">AI Pre-Flight Veracity Passed</div>
                            <div class="text-[10px] text-slate-400">Score: {{ $report->aiScore }}%</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full {{ $report->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} flex items-center justify-center shrink-0 text-[10px] mt-0.5">
                            <i class="fa-solid {{ $report->status === 'published' ? 'fa-check' : 'fa-clock' }}"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">{{ $report->status === 'published' ? 'Senior Bureau Sign-Off' : 'Pending Desk Review' }}</div>
                            <div class="text-[10px] text-slate-400">Patiala Regional Bureau</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
