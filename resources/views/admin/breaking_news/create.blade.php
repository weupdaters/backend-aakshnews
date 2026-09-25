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
    <div class="col-lg-9 col-md-11 mb-4">
        <div class="panel-white" style="border: 1px solid var(--border-color); border-radius: 16px; background: var(--card-bg); padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div class="panel-body">
                <form action="/admin/breaking-news" method="POST" id="breaking-form">
                    @csrf
                    
                    <!-- Quick Language Detector Banner -->
                    <div class="p-3 mb-4 rounded-3" style="background: linear-gradient(135deg, #EFF6FF 0%, #F5F3FF 100%); border: 1px solid #BFDBFE;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="font-xs font-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">✍️ Writing Language:</span>
                                <span class="badge" id="detected-script-badge" style="background: #1769D2; color: #FFF; font-size: 11px; padding: 4px 10px; border-radius: 6px;">Auto-Detect (Any Language)</span>
                            </div>
                            <button type="button" class="btn btn-sm text-white fw-bold shadow-sm d-inline-flex align-items-center gap-2" id="btn-quick-translate-all" style="background: #1769D2; border-radius: 8px; font-size: 12px; padding: 6px 14px;">
                                <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                                <span>Auto-Translate to English, Hindi & Punjabi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Title Input (Primary) -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Breaking News Alert (Any Language: Punjabi / Hindi / English) <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="breaking-title" class="form-control w-100 @error('title') is-invalid @enderror" placeholder="Type breaking headline in Punjabi, Hindi, or English..." style="height: 46px; border-radius: 8px; font-size: 14px;" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Multilingual Translations Hub -->
                    <div class="p-3 rounded-3 mb-4 border" style="background: #F8FAFC; border-color: #BFDBFE !important;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="languages" style="width: 18px; height: 18px; color: #1769D2;"></i>
                                <span class="font-xs font-bold text-dark text-uppercase">Multi-Language Editions (English • हिंदी • ਪੰਜਾਬੀ)</span>
                            </div>
                            <span class="badge bg-success text-white font-xxs">Auto-Sync Enabled</span>
                        </div>

                        <!-- Language Tabs -->
                        <ul class="nav nav-pills mb-3 gap-2" id="langTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="btn btn-sm btn-outline-primary active font-xs fw-bold px-3 py-1.5 rounded-3 d-inline-flex align-items-center gap-1.5" id="en-tab" data-bs-toggle="pill" data-bs-target="#tab-en" type="button" role="tab">
                                    <span>🇬🇧</span> English Edition
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="btn btn-sm btn-outline-danger font-xs fw-bold px-3 py-1.5 rounded-3 d-inline-flex align-items-center gap-1.5" id="hi-tab" data-bs-toggle="pill" data-bs-target="#tab-hi" type="button" role="tab">
                                    <span>🇮🇳</span> हिंदी संस्करण (Hindi)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="btn btn-sm btn-outline-warning font-xs fw-bold px-3 py-1.5 rounded-3 d-inline-flex align-items-center gap-1.5" id="pb-tab" data-bs-toggle="pill" data-bs-target="#tab-pb" type="button" role="tab">
                                    <span>☬</span> ਪੰਜਾਬੀ ਸੰਸਕਰਣ (Punjabi)
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content bg-white p-3 rounded-3 border" style="border-color: #E2E8F0;">
                            <!-- English -->
                            <div class="tab-pane fade show active" id="tab-en" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="font-xs text-muted fw-bold">English Breaking Ticker Text</label>
                                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 font-xxs rounded" onclick="translateBreakingTo('en')">Re-translate English</button>
                                </div>
                                <input type="text" name="title_en" id="breaking-title-en" class="form-control font-sm" placeholder="English alert headline...">
                            </div>

                            <!-- Hindi -->
                            <div class="tab-pane fade" id="tab-hi" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="font-xs text-muted fw-bold">हिंदी ब्रेकिंग न्यूज़ टिकर</label>
                                    <button type="button" class="btn btn-xs btn-outline-danger py-0.5 px-2 font-xxs rounded" onclick="translateBreakingTo('hi')">Re-translate Hindi</button>
                                </div>
                                <input type="text" name="title_hi" id="breaking-title-hi" class="form-control font-sm" placeholder="हिंदी में ब्रेकिंग न्यूज़ हेडलाइन...">
                            </div>

                            <!-- Punjabi -->
                            <div class="tab-pane fade" id="tab-pb" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="font-xs text-muted fw-bold">ਪੰਜਾਬੀ ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼ ਟਿਕਰ</label>
                                    <button type="button" class="btn btn-xs btn-outline-warning py-0.5 px-2 font-xxs rounded" onclick="translateBreakingTo('pa')">Re-translate Punjabi</button>
                                </div>
                                <input type="text" name="title_pb" id="breaking-title-pb" class="form-control font-sm" placeholder="ਪੰਜਾਬੀ ਵਿੱਚ ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼ ਸਿਰਲੇਖ...">
                            </div>
                        </div>

                        <div class="mt-2 font-xxs text-muted">
                            <i data-lucide="info" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i>
                            Leave blank to automatically auto-translate upon saving so breaking alerts render across all 3 language readers!
                        </div>
                    </div>

                    <!-- Status Select -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2" style="font-weight: 600;">Status</label>
                        <select name="is_active" class="form-control w-100" style="height: 46px; border-radius: 8px;">
                            <option value="1" selected>Active (Ticker Visible)</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white px-4 py-2.5" style="background-color: #1769D2; border-radius: 8px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(23, 105, 210, 0.25); border: none;">
                            Save Breaking News
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
        if (window.lucide) lucide.createIcons();

        // Live script detector
        $('#breaking-title').on('input', function() {
            var val = $(this).val();
            var $badge = $('#detected-script-badge');
            if (val) {
                if (/[\u0A00-\u0A7F]/.test(val)) {
                    $badge.text('☬ Punjabi (ਪੰਜਾਬੀ) Detected').css('background', '#D97706');
                } else if (/[\u0900-\u097F]/.test(val)) {
                    $badge.text('🇮🇳 Hindi (हिंदी) Detected').css('background', '#E53935');
                } else {
                    $badge.text('🇬🇧 English Detected').css('background', '#1769D2');
                }
            } else {
                $badge.text('Auto-Detect (Any Language)').css('background', '#1769D2');
            }
        });

        // Translate single field
        window.translateBreakingTo = function(targetLang) {
            var title = $('#breaking-title').val();
            if (!title) {
                alert('Please enter a headline first.');
                return;
            }
            var targetField = '#breaking-title-' + (targetLang === 'pa' ? 'pb' : targetLang);
            $.post('/api/translate', { text: title, target: targetLang }).done(function(res) {
                if (res.success) {
                    $(targetField).val(res.translated);
                }
            });
        };

        // Quick translate all button
        $('#btn-quick-translate-all').on('click', function() {
            var title = $('#breaking-title').val();
            if (!title) {
                alert('Please enter a headline first.');
                return;
            }
            var $btn = $(this);
            var orig = $btn.html();
            $btn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:13px;height:13px;"></i> Translating...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();

            var p1 = $.post('/api/translate', { text: title, target: 'en' }).done(function(r) { if (r.success) $('#breaking-title-en').val(r.translated); });
            var p2 = $.post('/api/translate', { text: title, target: 'hi' }).done(function(r) { if (r.success) $('#breaking-title-hi').val(r.translated); });
            var p3 = $.post('/api/translate', { text: title, target: 'pa' }).done(function(r) { if (r.success) $('#breaking-title-pb').val(r.translated); });

            $.when(p1, p2, p3).always(function() {
                $btn.html(orig).prop('disabled', false);
                if (window.lucide) lucide.createIcons();
            });
        });
    });
</script>
@endsection
