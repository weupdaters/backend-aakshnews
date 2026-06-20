@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Add Instagram Reel</h3>
        <p class="text-muted mb-0 font-sm">Link an Instagram Reel or post video to show on the main news feed.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/instagram">Instagram Reels</a></li>
                <li><span>Add Reel</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 mb-4">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/instagram" method="POST">
                    @csrf
                    
                    <!-- Title Input -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Reel Title / Description <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="title" class="form-control w-100 @error('title') is-invalid @enderror" placeholder="Enter title or video description..." style="height: 46px; border-radius: 8px;" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Instagram URL Input -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Instagram Reel / Video URL <span class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control w-100 @error('url') is-invalid @enderror" placeholder="https://www.instagram.com/reel/... or https://www.instagram.com/p/..." style="height: 46px; border-radius: 8px;" value="{{ old('url') }}" required>
                        <small class="text-muted mt-1 d-block font-xs">Enter a standard Instagram post, reel, or TV URL (e.g. <code>https://www.instagram.com/reel/CtX2Y3...</code>)</small>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color: #E1306C; border-radius: 8px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(225, 48, 108, 0.2);">
                            Save Instagram Reel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
