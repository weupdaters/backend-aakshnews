@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-1" style="font-weight: 800; color: #062B63;">Website Settings & Portal Configuration</h3>
        <p class="text-muted mb-0 font-sm">Configure frontend behaviors, live TV streaming, breaking ticker speed, header notices, and social channels.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li><span>Website Settings</span></li>
            </ul>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #047857; border-radius: 10px; border-left: 4px solid #10b981 !important;">
    <div class="d-flex align-items-center">
        <i data-lucide="check-circle-2" class="me-2" style="width: 20px; height: 20px;"></i>
        <span>{{ session('success') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="{{ route('admin.website-settings.update') }}" method="POST">
    @csrf
    <div class="row g-4">
        <!-- CARD 1: LIVE TV & BROADCAST STREAMING -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(220, 38, 38, 0.1); color: #DC2626;">
                        <i data-lucide="tv" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-bold" style="color: #0F172A;">Live TV & Video Broadcast</h5>
                        <small class="text-muted font-xs">Configure Live 24x7 news stream on the frontend header and /live-tv</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Live Stream Status</label>
                    <select name="livetv_enabled" class="form-select font-sm">
                        <option value="1" {{ ($settings['livetv_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Enabled (Live Now Pill Visible)</option>
                        <option value="0" {{ ($settings['livetv_enabled'] ?? '1') == '0' ? 'selected' : '' }}>Disabled (Hidden from Header)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">YouTube Live Video / Embed URL</label>
                    <input type="text" name="livetv_embed_url" value="{{ $settings['livetv_embed_url'] ?? 'https://www.youtube.com/embed/live_stream?channel=UC...' }}" class="form-control font-sm" placeholder="https://www.youtube.com/embed/...">
                    <small class="text-muted font-xs">Enter YouTube live video ID or full embed URL.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Live Channel Title (Overlay)</label>
                    <input type="text" name="livetv_title" value="{{ $settings['livetv_title'] ?? 'Aaksh News 24x7 Live Stream' }}" class="form-control font-sm">
                </div>

                <div class="mb-0">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">WhatsApp News Broadcast Channel URL</label>
                    <input type="text" name="whatsapp_channel_url" value="{{ $settings['whatsapp_channel_url'] ?? 'https://whatsapp.com/channel/...' }}" class="form-control font-sm" placeholder="https://whatsapp.com/channel/...">
                    <small class="text-muted font-xs">One-click join button in header and footer.</small>
                </div>
            </div>
        </div>

        <!-- CARD 2: HEADER ALERT & BREAKING MARQUEE -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                        <i data-lucide="bell" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-bold" style="color: #0F172A;">Breaking Marquee & Top Bar Alert</h5>
                        <small class="text-muted font-xs">Configure red breaking banner and scroll speed</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Top Bar Emergency Notice (Optional)</label>
                    <input type="text" name="header_notice_text" value="{{ $settings['header_notice_text'] ?? '' }}" class="form-control font-sm" placeholder="e.g. ਮੌਸਮ ਚਿਤਾਵਨੀ: ਪੰਜਾਬ ਦੇ 12 ਜ਼ਿਲ੍ਹਿਆਂ ਵਿੱਚ ਭਾਰੀ ਮੀਂਹ ਦਾ ਰੈੱਡ ਅਲਰਟ">
                    <small class="text-muted font-xs">Leave blank to display normal live date and weather ticker.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Breaking Ticker Speed</label>
                    <select name="ticker_speed" class="form-select font-sm">
                        <option value="normal" {{ ($settings['ticker_speed'] ?? 'normal') == 'normal' ? 'selected' : '' }}>Normal (Recommended)</option>
                        <option value="slow" {{ ($settings['ticker_speed'] ?? 'normal') == 'slow' ? 'selected' : '' }}>Slow (Easy to Read)</option>
                        <option value="fast" {{ ($settings['ticker_speed'] ?? 'normal') == 'fast' ? 'selected' : '' }}>Fast</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Breaking News Sound Alert</label>
                    <select name="breaking_sound_enabled" class="form-select font-sm">
                        <option value="0" {{ ($settings['breaking_sound_enabled'] ?? '0') == '0' ? 'selected' : '' }}>Muted / Silent (Default)</option>
                        <option value="1" {{ ($settings['breaking_sound_enabled'] ?? '0') == '1' ? 'selected' : '' }}>Gentle Ding on Breaking News</option>
                    </select>
                </div>

                <div class="mb-0">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Contact Hotline / News Bureau Phone</label>
                    <input type="text" name="bureau_phone" value="{{ $settings['bureau_phone'] ?? '+91 98765 43210' }}" class="form-control font-sm">
                </div>
            </div>
        </div>

        <!-- CARD 3: SEO & SOCIAL CHANNELS -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                        <i data-lucide="share-2" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-bold" style="color: #0F172A;">Social Media & Syndication</h5>
                        <small class="text-muted font-xs">Official channels linked across desktop and mobile navigation</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Facebook Page URL</label>
                    <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? 'https://facebook.com/aakshnews' }}" class="form-control font-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">YouTube Channel URL</label>
                    <input type="url" name="youtube_url" value="{{ $settings['youtube_url'] ?? 'https://youtube.com/@aakshnews' }}" class="form-control font-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Instagram Profile URL</label>
                    <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? 'https://instagram.com/aakshnews' }}" class="form-control font-sm">
                </div>

                <div class="mb-0">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">X (Twitter) Profile URL</label>
                    <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? 'https://twitter.com/aakshnews' }}" class="form-control font-sm">
                </div>
            </div>
        </div>

        <!-- CARD 4: ANALYTICS, ADSENSE & PERFORMANCE -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 p-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10B981;">
                        <i data-lucide="bar-chart-3" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-bold" style="color: #0F172A;">Analytics, Ads & Compliance</h5>
                        <small class="text-muted font-xs">Tracking measurement codes and monetisation</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Google Analytics 4 Measurement ID</label>
                    <input type="text" name="ga_measurement_id" value="{{ $settings['ga_measurement_id'] ?? 'G-XXXXXXXXXX' }}" class="form-control font-sm" placeholder="G-XXXXXXXXXX">
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Google AdSense Publisher ID</label>
                    <input type="text" name="adsense_publisher_id" value="{{ $settings['adsense_publisher_id'] ?? 'ca-pub-XXXXXXXXXX' }}" class="form-control font-sm" placeholder="ca-pub-XXXXXXXXXX">
                </div>

                <div class="mb-3">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">RNI Registration / Editorial Notice</label>
                    <input type="text" name="rni_number" value="{{ $settings['rni_number'] ?? 'PUNPUN/2026/XXXXX' }}" class="form-control font-sm">
                </div>

                <div class="mb-0">
                    <label class="form-label font-xs font-bold text-uppercase text-muted">Footer Copyright Notice</label>
                    <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '© 2026 Aaksh News 24. All rights reserved.' }}" class="form-control font-sm">
                </div>
            </div>
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn text-white px-5 py-2.5 font-sm fw-bold shadow-sm" style="background-color: #1769D2; border-radius: 10px;">
                <i data-lucide="save" class="me-1" style="width: 16px; height: 16px;"></i> Save Website Settings
            </button>
        </div>
    </div>
</form>
@endsection
