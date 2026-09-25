@extends('reporter.layouts.app')

@section('title', 'Reporter Settings')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#062B63] to-[#1769D2] rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <span class="text-[11px] font-black uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
            <i class="fa-solid fa-sliders"></i> Bureau Portal Configuration
        </span>
        <h1 class="text-2xl sm:text-3xl font-black font-manrope mt-1">
            Reporter Account & Settings
        </h1>
        <p class="text-xs sm:text-sm text-blue-100/90 font-medium mt-1">
            Manage your accreditation credentials, contact phone, security parameters, and notification alerts.
        </p>
    </div>
</div>

<form action="{{ route('reporter.settings.update') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
    @csrf

    <div class="border-b border-slate-100 pb-4">
        <h2 class="text-base font-extrabold text-slate-900">Personal & Correspondent Details</h2>
        <p class="text-xs text-slate-500">These credentials appear on your public author byline and official press certificates.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Full Legal Name</label>
            <input type="text" name="name" value="{{ $reporter->name ?? 'Gurpreet Singh Chahal' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">
        </div>

        <div>
            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Official Email</label>
            <input type="email" name="email" value="{{ $reporter->email ?? 'gurpreet.patiala@aakshnews.in' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">
        </div>

        <div>
            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Mobile / WhatsApp</label>
            <input type="tel" name="phone" value="{{ $reporter->phone ?? '+91 98765-43210' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">
        </div>

        <div>
            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Assigned District</label>
            <input type="text" name="district" value="{{ $reporter->district ?? 'Patiala' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Journalistic Bio</label>
            <textarea name="bio" rows="3" class="w-full p-4 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1769D2]">{{ $reporter->bio ?? 'Senior Ground Correspondent covering rural governance, farmers welfare, and municipal issues in Malwa region.' }}</textarea>
        </div>
    </div>

    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
        <span class="text-xs text-slate-400 font-semibold">Changes sync immediately with the central newsroom registry.</span>
        <button type="submit" class="px-6 py-2.5 rounded-full bg-[#1769D2] hover:bg-[#0B4496] text-white font-extrabold text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save Configuration</span>
        </button>
    </div>
</form>
@endsection
