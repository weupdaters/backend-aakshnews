@extends('reporter.layouts.app')

@section('title', 'Press Accreditation & Certificates')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md no-print">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
            <i class="fa-solid fa-award text-[#FFC400]"></i> Accreditation & Media Passes
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Press ID & Accreditation Credentials
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Official verifiable credentials issued by AAKSH NEWS 24 Citizen Journalism Bureau.
        </p>
    </div>

    <div class="flex items-center gap-3">
        <button onclick="window.print()" class="px-4 py-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-extrabold text-xs transition-all flex items-center gap-2 cursor-pointer shadow-xs">
            <i class="fa-solid fa-print text-[#FFC400]"></i>
            <span>Print Pass</span>
        </button>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-full bg-[#FFC400] hover:bg-[#F5A900] text-[#062B63] font-black text-xs transition-all flex items-center gap-2 cursor-pointer shadow-md">
            <i class="fa-solid fa-download text-[#062B63]"></i>
            <span>Download Digital Pass</span>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    
    <!-- 1. Official Field Press ID Card -->
    <div class="space-y-3">
        <div class="flex items-center justify-between no-print">
            <h2 class="text-base font-extrabold text-slate-900">Official Field Press ID</h2>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                Valid & Active
            </span>
        </div>

        <div class="w-full max-w-md mx-auto bg-white rounded-3xl overflow-hidden border-2 border-[#062B63] shadow-xl relative text-slate-800">
            <!-- Lanyard slot -->
            <div class="w-16 h-3.5 rounded-full bg-slate-200 mx-auto mt-2 border border-slate-300"></div>

            <!-- Header -->
            <div class="bg-[#062B63] text-white p-4 pt-3 text-center border-b-4 border-[#FFC400]">
                <div class="flex items-center justify-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-[#1769D2] flex items-center justify-center text-[#FFC400] font-black text-sm">
                        A
                    </div>
                    <div class="text-left leading-tight">
                        <div class="font-black text-sm tracking-tight text-white">
                            AAKSH <span class="text-[#FFC400]">NEWS 24</span>
                        </div>
                        <div class="text-[9px] uppercase tracking-widest text-blue-200 font-extrabold">
                            Citizen Reporter Desk
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-[10px] font-black tracking-widest uppercase bg-blue-900/80 py-0.5 rounded-md text-amber-300">
                    OFFICIAL PRESS ACCREDITATION PASS
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="flex gap-4 items-center">
                    <div class="w-24 h-28 rounded-2xl bg-slate-100 border-2 border-slate-300 overflow-hidden relative shrink-0 shadow-inner">
                        <img src="{{ $reporter->avatar ?? '/images/author_avatar.png' }}" alt="{{ $reporter->name }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&q=80'">
                        <div class="absolute bottom-0 inset-x-0 bg-[#062B63]/90 text-[8px] font-bold text-center text-white py-0.5">
                            VERIFIED
                        </div>
                    </div>

                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Correspondent</div>
                        <h3 class="text-base font-black text-[#062B63] leading-snug">
                            {{ $reporter->name ?? 'Gurpreet Singh Chahal' }}
                        </h3>
                        <div class="text-[11px] font-bold text-[#1769D2]">
                            {{ $reporter->badge ?? 'Senior Ground Contributor' }}
                        </div>
                        <div class="text-[10px] font-mono font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md inline-block">
                            ID: {{ $reporter->reporter_id ?? 'AAKSH-REP-0101' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[11px]">
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] uppercase">Assigned Beat</span>
                        <span class="font-extrabold text-slate-800">{{ $reporter->district ?? 'Patiala' }} & Malwa Region</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] uppercase">Valid Until</span>
                        <span class="font-extrabold text-emerald-700">31 DEC 2026</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] uppercase">Bureau Desk</span>
                        <span class="font-extrabold text-slate-800">Punjab Regional Office</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] uppercase">Emergency No.</span>
                        <span class="font-extrabold text-slate-800">1800-123-4567</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200 p-1 flex items-center justify-center text-slate-800">
                            <i class="fa-solid fa-qrcode text-3xl"></i>
                        </div>
                        <div class="text-[9px] text-slate-500 leading-tight">
                            Scan to verify<br>online status<br>
                            <span class="text-emerald-600 font-black">● AUTHENTIC</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="font-serif italic font-black text-slate-700 text-sm">R. Verma</div>
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">
                            Bureau Chief Signature
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-100 py-1.5 px-4 text-center border-t border-slate-200 text-[9px] font-bold text-slate-500">
                Holder is an accredited citizen reporter under Aaksh News Network. Provide lawful access.
            </div>
        </div>
    </div>

    <!-- 2. Certificate of Journalistic Excellence -->
    <div class="space-y-3">
        <div class="flex items-center justify-between no-print">
            <h2 class="text-base font-extrabold text-slate-900">Certificate of Journalistic Excellence</h2>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-blue-100 text-blue-800">
                Commendation
            </span>
        </div>

        <div class="bg-[#FFFDF9] rounded-3xl p-7 border-4 border-double border-[#D4AF37] shadow-xl space-y-5 text-center relative overflow-hidden">
            <div>
                <div class="text-xs font-black tracking-widest uppercase text-[#B8860B]">
                    AAKSH NEWS 24 EDITORIAL BOARD
                </div>
                <h3 class="text-2xl font-black font-serif text-[#062B63] mt-1">
                    Certificate of Excellence
                </h3>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 mt-0.5">
                    IN CITIZEN JOURNALISM & FACTUAL INTEGRITY
                </p>
            </div>

            <div class="py-2 text-xs text-slate-600 space-y-2 max-w-md mx-auto">
                <p class="italic font-serif">This commendation is proudly conferred upon</p>
                <div class="text-xl font-black font-manrope text-[#062B63] underline decoration-[#D4AF37] decoration-2 underline-offset-4">
                    {{ $reporter->name ?? 'Gurpreet Singh Chahal' }}
                </div>
                <p class="text-[11px] leading-relaxed pt-1">
                    for sustained dedication to fearless, unbiased, and verified grassroots reporting across the {{ $reporter->district ?? 'Patiala' }} district, maintaining an exemplary AI veracity consistency score of 92%.
                </p>
            </div>

            <div class="pt-4 border-t border-slate-200/80 grid grid-cols-2 gap-4 items-center">
                <div class="text-left text-[10px] text-slate-500">
                    <span class="font-bold text-slate-700 block">Date of Issue:</span>
                    15 January 2026<br>
                    Registry: #AAKSH-CERT-2026-980
                </div>

                <div class="text-right">
                    <div class="w-12 h-12 rounded-full border-2 border-[#D4AF37] bg-amber-50 flex items-center justify-center font-black text-[10px] text-[#B8860B] ml-auto shadow-inner">
                        SEAL
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
