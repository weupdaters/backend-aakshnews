@extends('reporter.layouts.app')

@section('title', 'Master Ground Reports Repository')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200">
            Citizen Reporter Network • Central Registry
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Master Ground Reports Repository
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Comprehensive tabular records of your dispatched stories, editorial verification, and AI veracity index.
        </p>
    </div>

    <a href="{{ route('reporter.submit-news') }}" class="px-5 py-3 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black text-xs transition-all shadow-md flex items-center justify-center gap-2 shrink-0 self-start sm:self-auto">
        <i class="fa-solid fa-circle-plus"></i>
        <span>File New Ground Story</span>
    </a>
</div>

<!-- Metrics Row -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Dispatched</div>
        <div class="text-xl sm:text-2xl font-black text-[#062B63] mt-0.5">{{ $counts['all'] }} Reports</div>
        <div class="text-[10px] text-slate-500 mt-1">100% On-Ground Coverage</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Published Live</div>
        <div class="text-xl sm:text-2xl font-black text-emerald-600 mt-0.5">{{ $counts['published'] }}</div>
        <div class="text-[10px] text-emerald-600 font-bold mt-1">Live on Newsroom</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Under Review</div>
        <div class="text-xl sm:text-2xl font-black text-amber-500 mt-0.5">{{ $counts['in_review'] }}</div>
        <div class="text-[10px] text-amber-600 font-bold mt-1">Desk Sign-Off Pending</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Saved Drafts</div>
        <div class="text-xl sm:text-2xl font-black text-slate-700 mt-0.5">{{ $counts['drafts'] }}</div>
        <div class="text-[10px] text-slate-500 mt-1">Ready for Submission</div>
    </div>
</div>

<!-- Toolbar: Filter Tabs & Search -->
<div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
    
    <!-- Status Filter Tabs -->
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0">
        <a href="{{ route('reporter.my-reports') }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition-all whitespace-nowrap {{ !$filterStatus || $filterStatus === 'all' ? 'bg-[#1769D2] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            All Reports ({{ $counts['all'] }})
        </a>

        <a href="{{ route('reporter.my-reports', ['status' => 'published']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition-all whitespace-nowrap {{ $filterStatus === 'published' ? 'bg-[#16A34A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Published ({{ $counts['published'] }})
        </a>

        <a href="{{ route('reporter.my-reports', ['status' => 'in_review']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition-all whitespace-nowrap {{ $filterStatus === 'in_review' ? 'bg-[#F59E0B] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            In Review ({{ $counts['in_review'] }})
        </a>

        <a href="{{ route('reporter.my-reports', ['status' => 'drafts']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition-all whitespace-nowrap {{ $filterStatus === 'drafts' ? 'bg-slate-800 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Drafts ({{ $counts['drafts'] }})
        </a>

        <a href="{{ route('reporter.my-reports', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition-all whitespace-nowrap {{ $filterStatus === 'rejected' ? 'bg-[#EF4444] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Right: Search Form & Toggle -->
    <div class="flex items-center gap-3 w-full lg:w-auto">
        <form action="{{ route('reporter.my-reports') }}" method="GET" class="relative flex-1 lg:w-64">
            <input type="hidden" name="status" value="{{ $filterStatus }}">
            <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-3 text-xs"></i>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search tracking ID, headline..."
                class="w-full pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1769D2] bg-slate-50"
            />
        </form>

        <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 shrink-0">
            <button onclick="setViewMode('table')" id="btnTable" title="Table View" class="p-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 bg-white text-[#1769D2] shadow-xs">
                <i class="fa-solid fa-table-list"></i>
                <span class="hidden sm:inline text-[11px]">Table</span>
            </button>
            <button onclick="setViewMode('card')" id="btnCard" title="Card View" class="p-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 text-slate-600 hover:text-slate-900">
                <i class="fa-solid fa-grip"></i>
                <span class="hidden sm:inline text-[11px]">Cards</span>
            </button>
        </div>
    </div>

</div>

<!-- MASTER DATA TABLE VIEW (Default) -->
<div id="tableView" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
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
                @forelse($reports as $report)
                <tr class="hover:bg-slate-50/70 transition-colors group">
                    <td class="py-3.5 px-4 font-mono font-bold text-[#1769D2] whitespace-nowrap">
                        {{ $report->trackingId }}
                    </td>
                    <td class="py-3.5 px-4 max-w-md">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded-lg bg-slate-100 overflow-hidden relative shrink-0 border border-slate-200">
                                <img src="{{ $report->image }}" alt="{{ $report->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-black uppercase text-[#1769D2] block">
                                    {{ $report->category }}
                                </span>
                                <span class="font-bold text-slate-900 line-clamp-1 block text-xs">
                                    {{ $report->title }}
                                </span>
                            </div>
                        </div>
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
                        @elseif($report->status === 'draft')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-slate-100 text-slate-700 border border-slate-200">
                                <i class="fa-solid fa-pen-ruler"></i> Saved Draft
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
                    <td class="py-3.5 px-4 text-right whitespace-nowrap space-x-1">
                        @if($report->status === 'draft')
                            <a href="{{ route('reporter.submit-news') }}" class="px-3 py-1.5 rounded-lg bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] font-black text-[11px] inline-flex items-center gap-1 transition-all shadow-xs">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit Draft</span>
                            </a>
                        @else
                            <a href="{{ route('reporter.report.show', $report->id) }}" class="px-3 py-1.5 rounded-lg bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] font-bold text-[11px] inline-flex items-center gap-1 transition-all shadow-xs">
                                <span>Track Dossier</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-10 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-2xl mb-2 block"></i>
                        No stories found matching your filter criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3.5 bg-slate-50/70 border-t border-slate-200/80 text-[11px] text-slate-500 flex items-center justify-between">
        <span>Showing {{ count($reports) }} recorded stories</span>
        <span class="font-semibold text-slate-700">Aaksh News Citizen Dispatch Desk</span>
    </div>
</div>

<!-- CARD VIEW (Hidden by default, toggleable) -->
<div id="cardView" class="space-y-3 hidden">
    @foreach($reports as $report)
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-[#1769D2]/60 transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-5 group">
        <div class="flex items-start gap-4 flex-1">
            <div class="w-24 h-20 rounded-xl bg-slate-100 overflow-hidden relative shrink-0">
                <img src="{{ $report->image }}" alt="{{ $report->title }}" class="w-full h-full object-cover">
            </div>

            <div class="space-y-1.5 flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-mono text-xs font-black text-[#1769D2]">{{ $report->trackingId }}</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-[#EFF6FF] text-[#1E40AF]">
                        {{ $report->category }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-location-dot"></i> {{ $report->district }}
                    </span>
                </div>

                <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-[#1769D2] transition-colors line-clamp-2">
                    {{ $report->title }}
                </h3>

                <p class="text-xs text-slate-500 line-clamp-1">{{ $report->content }}</p>

                <div class="flex items-center gap-3 text-[11px] text-slate-400 pt-1">
                    <span>Filed: {{ $report->submittedAt }}</span>
                    @if($report->views > 0)
                        <span>•</span>
                        <span class="font-bold text-slate-600"><i class="fa-regular fa-eye"></i> {{ number_format($report->views) }} reads</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0 self-end md:self-center">
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-blue-50 text-[#1769D2]">
                <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i> {{ $report->aiScore }}%
            </span>
            <a href="{{ route('reporter.report.show', $report->id) }}" class="px-4 py-2 rounded-xl bg-[#062B63] hover:bg-[#1769D2] text-[#FFC400] text-xs font-bold transition-all shadow-xs flex items-center gap-1">
                <span>Track</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

<script>
    function setViewMode(mode) {
        const table = document.getElementById('tableView');
        const card = document.getElementById('cardView');
        const btnTable = document.getElementById('btnTable');
        const btnCard = document.getElementById('btnCard');

        if (mode === 'card') {
            table.classList.add('hidden');
            card.classList.remove('hidden');
            btnCard.classList.add('bg-white', 'text-[#1769D2]', 'shadow-xs');
            btnCard.classList.remove('text-slate-600');
            btnTable.classList.remove('bg-white', 'text-[#1769D2]', 'shadow-xs');
            btnTable.classList.add('text-slate-600');
        } else {
            card.classList.add('hidden');
            table.classList.remove('hidden');
            btnTable.classList.add('bg-white', 'text-[#1769D2]', 'shadow-xs');
            btnTable.classList.remove('text-slate-600');
            btnCard.classList.remove('bg-white', 'text-[#1769D2]', 'shadow-xs');
            btnCard.classList.add('text-slate-600');
        }
    }
</script>
@endsection
