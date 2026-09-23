@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1 font-bold">Edit Category</h3>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/category">Categories</a></li>
                <li><span>Edit Category</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="panel-white">
            <div class="panel-body p-4">
                <form action="/admin/category/{{ $category->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Primary Category Name -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">Category Name (English/Default) <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="category-name" class="form-control w-100" required placeholder="Enter category name" value="{{ $category->name }}">
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="category-slug" class="form-control w-100" required placeholder="Enter category slug" value="{{ $category->slug }}">
                            </div>
                        </div>

                        <!-- Punjabi Name -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">ਨਾਮ ਪੰਜਾਬੀ ਵਿੱਚ (Punjabi Name)</label>
                                <input type="text" name="name_pb" class="form-control w-100" placeholder="e.g. ਰਾਜਨੀਤੀ, ਖੇਡਾਂ, ਕਾਰੋਬਾਰ" value="{{ $category->name_pb }}">
                            </div>
                        </div>

                        <!-- Hindi Name -->
                        <div class="col-lg-6 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">नाम हिंदी में (Hindi Name)</label>
                                <input type="text" name="name_hi" class="form-control w-100" placeholder="e.g. राजनीति, खेल, व्यापार" value="{{ $category->name_hi }}">
                            </div>
                        </div>

                        <!-- CATEGORY ICON SELECTOR (Requested for Landing Page Display) -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold d-flex align-items-center justify-content-between">
                                    <span>Category Icon (Shown on Landing Page)</span>
                                    <span class="text-muted" style="font-size: 11px;">Select an icon or type custom Lucide icon name</span>
                                </label>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-center" id="icon-preview-box" style="width: 44px; height: 44px;">
                                        <i data-lucide="{{ $category->icon ?? 'newspaper' }}" id="selected-icon-preview" style="width: 22px; height: 22px; color: {{ $category->color ?? '#1769D2' }};"></i>
                                    </div>
                                    <input type="text" name="icon" id="category-icon-input" class="form-control" value="{{ $category->icon ?? 'newspaper' }}" placeholder="e.g. vote, trophy, bar-chart-2, sparkles">
                                </div>

                                <!-- Popular Icon Pills -->
                                <div class="d-flex flex-wrap gap-2 pt-1" id="icon-picker-pills">
                                    @php
                                        $currentIcon = $category->icon ?? 'newspaper';
                                        $iconPresets = [
                                            ['name' => 'vote', 'label' => 'Politics (Vote)'],
                                            ['name' => 'trophy', 'label' => 'Sports (Trophy)'],
                                            ['name' => 'bar-chart-2', 'label' => 'Business (Chart)'],
                                            ['name' => 'sparkles', 'label' => 'Punjab (Sparkles)'],
                                            ['name' => 'globe', 'label' => 'World (Globe)'],
                                            ['name' => 'tv', 'label' => 'Entertainment (TV)'],
                                            ['name' => 'cpu', 'label' => 'Tech (CPU)'],
                                            ['name' => 'flag', 'label' => 'National (Flag)'],
                                            ['name' => 'shield', 'label' => 'Crime (Shield)'],
                                            ['name' => 'heart', 'label' => 'Health (Heart)'],
                                            ['name' => 'book-open', 'label' => 'Education (Book)'],
                                            ['name' => 'sun', 'label' => 'Weather (Sun)'],
                                            ['name' => 'newspaper', 'label' => 'General (News)'],
                                        ];
                                    @endphp
                                    @foreach($iconPresets as $preset)
                                        <button type="button" class="btn btn-sm {{ $currentIcon === $preset['name'] ? 'btn-primary' : 'btn-outline-secondary' }} d-inline-flex align-items-center gap-1.5 py-1 px-2.5 icon-preset-btn" data-icon="{{ $preset['name'] }}" style="border-radius: 8px; font-size: 11.5px; font-weight: 600;">
                                            <i data-lucide="{{ $preset['name'] }}" style="width: 13px; height: 13px;"></i>
                                            <span>{{ $preset['label'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- CATEGORY COLOR (With Quick Preset Palette) -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">Category Color Theme <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="color" name="color" id="category-color" class="form-control form-control-color p-0 border-0 shadow-sm" style="width: 50px; height: 42px; cursor: pointer; border-radius: 8px;" value="{{ $category->color ?? '#DC2626' }}" required>
                                    <input type="text" id="category-color-text" class="form-control font-monospace" style="width: 120px; height: 42px;" value="{{ $category->color ?? '#DC2626' }}">
                                    
                                    <!-- Quick Color Swatches -->
                                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                        @php
                                            $colorSwatches = [
                                                ['color' => '#DC2626', 'title' => 'Red (Politics)'],
                                                ['color' => '#16A34A', 'title' => 'Green (Sports)'],
                                                ['color' => '#2563EB', 'title' => 'Blue (Business)'],
                                                ['color' => '#7C3AED', 'title' => 'Purple (Tech)'],
                                                ['color' => '#D97706', 'title' => 'Amber (Punjab)'],
                                                ['color' => '#DB2777', 'title' => 'Pink (Entertainment)'],
                                                ['color' => '#0D9488', 'title' => 'Teal (World)'],
                                                ['color' => '#EA580C', 'title' => 'Orange (National)'],
                                            ];
                                        @endphp
                                        @foreach($colorSwatches as $swatch)
                                            <span class="color-swatch-btn rounded-circle shadow-xs" data-color="{{ $swatch['color'] }}" title="{{ $swatch['title'] }}" style="width: 26px; height: 26px; background-color: {{ $swatch['color'] }}; cursor: pointer; border: 2px solid white; outline: 1px solid #CBD5E1;"></span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Title -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control w-100" placeholder="Enter meta title" value="{{ $category->meta_title }}">
                            </div>
                        </div>

                        <!-- Meta Desc -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta Desc</label>
                                <textarea name="meta_desc" class="form-control w-100" rows="3" placeholder="Enter meta description">{{ $category->meta_desc }}</textarea>
                            </div>
                        </div>

                        <!-- Meta keywords -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Meta keywords</label>
                                <input type="text" name="meta_keywords" class="form-control w-100" placeholder="Enter meta keywords" value="{{ $category->meta_keywords }}">
                            </div>
                        </div>

                        <!-- Status Select -->
                        <div class="col-lg-12 mb-4">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2 font-bold">Status Select</label>
                                <select name="status" class="form-control w-100" style="height: 46px;">
                                    <option value="active" {{ ($category->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ ($category->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="submit-btn text-white font-bold" style="background-color: #1769D2; border: none; padding: 12px 28px; border-radius: 8px; box-shadow: 0 4px 12px rgba(23, 105, 210, 0.25);">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if (window.lucide) {
            window.lucide.createIcons();
        }

        // Icon picker pills
        $('.icon-preset-btn').on('click', function() {
            $('.icon-preset-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
            let iconName = $(this).attr('data-icon');
            $('#category-icon-input').val(iconName);
            updateIconPreview(iconName);
        });

        $('#category-icon-input').on('input', function() {
            updateIconPreview($(this).val().trim());
        });

        function updateIconPreview(iconName) {
            let color = $('#category-color').val() || '#1769D2';
            $('#icon-preview-box').html(`<i data-lucide="${iconName || 'newspaper'}" style="width: 22px; height: 22px; color: ${color};"></i>`);
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        // Color swatches
        $('.color-swatch-btn').on('click', function() {
            let col = $(this).attr('data-color');
            $('#category-color').val(col);
            $('#category-color-text').val(col);
            updateIconPreview($('#category-icon-input').val());
        });

        $('#category-color').on('input', function() {
            let col = $(this).val();
            $('#category-color-text').val(col);
            updateIconPreview($('#category-icon-input').val());
        });

        $('#category-color-text').on('input', function() {
            let col = $(this).val();
            if (/^#[0-9A-Fa-f]{6}$/.test(col)) {
                $('#category-color').val(col);
                updateIconPreview($('#category-icon-input').val());
            }
        });
    });
</script>
@endsection
