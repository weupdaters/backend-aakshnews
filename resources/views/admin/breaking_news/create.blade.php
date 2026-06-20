@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Add Breaking News</h3>
        <p class="text-muted mb-0 font-sm">Create a ticking text alert to display at the top of the portal.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/breaking-news">Breaking News</a></li>
                <li><span>Add Breaking News</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 mb-4">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/breaking-news" method="POST">
                    @csrf
                    
                    <!-- Title Input -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Breaking News Alert Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control w-100 @error('title') is-invalid @enderror" placeholder="Enter breaking news text here..." style="height: 46px; border-radius: 8px;" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Select -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Status</label>
                        <select name="is_active" class="form-control w-100" style="height: 46px; border-radius: 8px;">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color: #8B5CF6; border-radius: 8px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2);">
                            Save Breaking News
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
