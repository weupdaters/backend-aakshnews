@extends('reporter.layouts.app')

@section('title', 'Help & Support')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
            <i class="fa-regular fa-circle-question"></i> 24x7 Bureau Support
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Help, Support & Editorial Guidelines
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Direct access to senior bureau editors, fact-checking policies, and reporting assistance.
        </p>
    </div>

    <a href="tel:+918001234567" class="px-4 py-2.5 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black text-xs transition-all shadow-md flex items-center gap-2 self-start sm:self-auto shrink-0">
        <i class="fa-solid fa-phone"></i>
        <span>Bureau Hotline: 1800-123-4567</span>
    </a>
</div>

<!-- 3 Contact Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1769D2] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-phone text-lg"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold text-slate-400 uppercase">Emergency Desk</div>
            <div class="text-sm font-extrabold text-slate-900">+91 98765-NEWS1</div>
            <div class="text-[11px] text-emerald-600 font-bold">Available 24x7</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <i class="fa-brands fa-whatsapp text-xl"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold text-slate-400 uppercase">WhatsApp Newsroom</div>
            <div class="text-sm font-extrabold text-slate-900">+91 98765-WHATS</div>
            <div class="text-[11px] text-slate-500 font-medium">Fast ground response</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <i class="fa-regular fa-envelope text-lg"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold text-slate-400 uppercase">Bureau Editorial Mail</div>
            <div class="text-sm font-extrabold text-slate-900">desk@aakshnews.in</div>
            <div class="text-[11px] text-slate-500 font-medium">Official communications</div>
        </div>
    </div>
</div>

<!-- Forms & FAQs -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-5">
        <div class="border-b border-slate-100 pb-3">
            <span class="text-[10px] font-black uppercase text-[#1769D2] tracking-wider">DIRECT DESK MESSAGING</span>
            <h2 class="text-lg font-black text-slate-900 mt-0.5">Contact Senior Bureau Desk</h2>
            <p class="text-xs text-slate-500">Submit an urgent clarification about a story rejection or score dispute.</p>
        </div>

        <form action="{{ route('reporter.help.contact') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Query Topic</label>
                <select name="topic" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2] bg-white">
                    <option value="Editorial Review">Editorial Review & Sign-Off</option>
                    <option value="AI Score Dispute">AI Authenticity Score Dispute</option>
                    <option value="Reporter Safety">Ground Safety & Protection</option>
                    <option value="Press Accreditation">Press ID & Accreditation</option>
                    <option value="Payment Incentive">Points & Incentive Payouts</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Subject / Tracking ID</label>
                <input type="text" name="subject" required placeholder="e.g. Clarification on Report #REP-2025-081" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">
            </div>

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Detailed Explanation</label>
                <textarea name="message" rows="4" required placeholder="Provide context, eyewitness contact or details..." class="w-full p-4 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]"></textarea>
            </div>

            <button type="submit" class="w-full py-3 rounded-full bg-[#1769D2] hover:bg-[#0B4496] text-white font-black text-xs transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-regular fa-paper-plane"></i>
                <span>Submit Query to Bureau</span>
            </button>
        </form>
    </div>

    <!-- FAQs -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-4">
        <div class="border-b border-slate-100 pb-3">
            <span class="text-[10px] font-black uppercase text-[#1769D2] tracking-wider">KNOWLEDGE BASE</span>
            <h2 class="text-lg font-black text-slate-900 mt-0.5">Frequently Asked Questions</h2>
            <p class="text-xs text-slate-500">Guidance for citizen journalists and on-ground correspondents.</p>
        </div>

        <div class="space-y-2.5 text-xs">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80">
                <div class="font-extrabold text-slate-800">How long does editorial review take?</div>
                <div class="text-slate-600 mt-1 leading-relaxed">
                    Automated AI screening finishes in 30 seconds. Following that, regional bureau editors inspect and publish verified reports within 15-45 minutes.
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80">
                <div class="font-extrabold text-slate-800">How are AI authenticity scores calculated?</div>
                <div class="text-slate-600 mt-1 leading-relaxed">
                    Evaluates image EXIF integrity, ground GPS geotag consistency, corroboration with meteorological/civic official feeds, and factuality checks.
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80">
                <div class="font-extrabold text-slate-800">How do reputation points convert to incentives?</div>
                <div class="text-slate-600 mt-1 leading-relaxed">
                    Each verified story earns 100 points, breaking coverage awards +150 points. Every point is valued at ₹5 redeemable directly to your UPI.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
