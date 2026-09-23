@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-1">Web Push Notifications</h3>
        <p class="text-muted mb-0 font-sm">Broadcast instant breaking news alerts directly to subscribers' desktops and mobile phones.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><span>Push Notifications</span></li>
            </ul>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #047857; border-radius: 8px;">
    <i data-lucide="check-circle" class="me-2" style="width: 16px; height: 16px;"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card p-3 border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #062B63 0%, #1769D2 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase font-weight-bold">Active Subscribers</span>
                    <h3 class="text-white mt-1 mb-0 font-weight-bold">{{ number_format($totalSubscribers) }}</h3>
                </div>
                <div class="rounded-circle p-2 bg-white/20">
                    <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90">
                <i data-lucide="trending-up" style="width: 12px; height: 12px;" class="me-1"></i> +14% increase this week
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card p-3 border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #1557A6 0%, #0D56B5 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase font-weight-bold">Campaigns Broadcasted</span>
                    <h3 class="text-white mt-1 mb-0 font-weight-bold">{{ number_format($totalSent) }}</h3>
                </div>
                <div class="rounded-circle p-2 bg-white/20">
                    <i data-lucide="send" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90">
                <i data-lucide="check" style="width: 12px; height: 12px;" class="me-1"></i> Instant delivery enabled
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card p-3 border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase font-weight-bold">Total Clicks & Reads</span>
                    <h3 class="text-white mt-1 mb-0 font-weight-bold">{{ number_format($totalClicks) }}</h3>
                </div>
                <div class="rounded-circle p-2 bg-white/20">
                    <i data-lucide="mouse-pointer" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90">
                <i data-lucide="bar-chart-2" style="width: 12px; height: 12px;" class="me-1"></i> 27.8% Average CTR
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card p-3 border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #D97706 0%, #F59E0B 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase font-weight-bold">Delivery Success</span>
                    <h3 class="text-white mt-1 mb-0 font-weight-bold">99.8%</h3>
                </div>
                <div class="rounded-circle p-2 bg-white/20">
                    <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90">
                <i data-lucide="clock" style="width: 12px; height: 12px;" class="me-1"></i> Real-time push queue active
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Column: Compose Broadcast -->
    <div class="col-lg-7 mb-4">
        <div class="panel-white h-100">
            <div class="panel-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="color-brand-1 mb-0" style="font-weight: 700;">
                        <i data-lucide="bell-ring" class="me-2" style="width: 20px; height: 20px; color: #1769D2;"></i>
                        Send Push Notification
                    </h5>
                    <span class="badge" style="background: #EBF3FC; color: #1769D2; font-weight: 700;">1,482 Devices Ready</span>
                </div>

                <!-- Quick Presets -->
                <div class="mb-3">
                    <span class="font-xs text-muted mb-2 d-block font-weight-bold">Quick Templates:</span>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary font-xs py-1 px-2.5 rounded-3 preset-btn" data-title="🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: ਵੱਡੀ ਖ਼ਬਰ ਸਾਹਮਣੇ ਆਈ" data-body="ਪੰਜਾਬ ਵਿੱਚ ਵੱਡਾ ਫੈਸਲਾ, ਜਾਣਕਾਰੀ ਲਈ ਕਲਿੱਕ ਕਰੋ।" data-cat="Breaking News">
                            ⚡ Breaking
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary font-xs py-1 px-2.5 rounded-3 preset-btn" data-title="🏏 ਕ੍ਰਿਕਟ ਅਲਰਟ: ਰੋਮਾਂਚਕ ਮੋੜ 'ਤੇ ਪਹੁੰਚਿਆ ਮੈਚ" data-body="ਲਾਈਵ ਸਕੋਰ ਅਤੇ ਅਪਡੇਟਸ ਸਭ ਤੋਂ ਪਹਿਲਾਂ ਇੱਥੇ ਦੇਖੋ।" data-cat="Sports">
                            🏏 Cricket
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary font-xs py-1 px-2.5 rounded-3 preset-btn" data-title="🔴 LIVE TV: ਵਿਸ਼ੇਸ਼ ਬੁਲੇਟਿਨ ਸ਼ੁਰੂ" data-body="ਆਕਾਸ਼ ਨਿਊਜ਼ 24 'ਤੇ ਦੇਖੋ ਅੱਜ ਦੀਆਂ ਸਭ ਤੋਂ ਵੱਡੀਆਂ ਸੁਰਖੀਆਂ।" data-cat="Live TV">
                            📺 Live TV
                        </button>
                    </div>
                </div>

                <form action="/admin/push/send" method="POST" id="push-send-form">
                    @csrf
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="font-sm color-text-mutted mb-1">Headline Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="push-title" class="form-control" placeholder="e.g. 🚨 Breaking News: Major announcement in Punjab" required maxlength="120">
                        <small class="text-muted font-xs">Keep it concise and punchy (under 60-80 chars recommended).</small>
                    </div>

                    <!-- Body / Summary -->
                    <div class="mb-3">
                        <label class="font-sm color-text-mutted mb-1">Alert Message / Summary <span class="text-danger">*</span></label>
                        <textarea name="body" id="push-body" rows="3" class="form-control font-sm" placeholder="Short description of the event to entice the reader..." required maxlength="250"></textarea>
                    </div>

                    <!-- Target URL -->
                    <div class="mb-3">
                        <label class="font-sm color-text-mutted mb-1">Destination URL</label>
                        <input type="text" name="url" id="push-url" class="form-control" value="http://localhost:3000" placeholder="https://... or article link">
                        <small class="text-muted font-xs">Tapping the notification opens this link on their device.</small>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-1">Alert Category</label>
                        <select name="category" id="push-category" class="form-control" style="height: 42px;">
                            <option value="Breaking News">⚡ Breaking News</option>
                            <option value="Politics">🏛️ Politics & State Affairs</option>
                            <option value="Sports">🏏 Sports & Cricket</option>
                            <option value="Weather">🌦️ Weather & Alerts</option>
                            <option value="Live TV">📺 Live TV Stream</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="submit-btn d-inline-flex align-items-center justify-content-center flex-grow-1" style="background-color: var(--primary-color); padding: 12px; gap: 8px;">
                            <i data-lucide="send" style="width: 16px; height: 16px;"></i> Broadcast to 1,482 Subscribers
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Live Mockup Preview -->
    <div class="col-lg-5 mb-4">
        <div class="panel-white h-100">
            <div class="panel-body p-4">
                <h5 class="color-brand-1 mb-3 pb-2 border-bottom" style="font-weight: 700;">
                    <i data-lucide="smartphone" class="me-2" style="width: 20px; height: 20px; color: #3B82F6;"></i>
                    Real-time Device Preview
                </h5>
                <p class="text-muted font-xs mb-3">Live preview of how your alert will render on Windows, Android & macOS notification trays.</p>

                <!-- Desktop / Windows Toast Preview -->
                <div class="card p-3 rounded-4 shadow-sm mb-3" style="background-color: #0F172A; color: white; border: 1px solid #334155;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded bg-primary px-1.5 py-0.5 text-white font-weight-bold" style="font-size: 10px;">AAKSH 24</span>
                            <span class="text-muted" style="font-size: 10px;">Chrome • Just now</span>
                        </div>
                        <i data-lucide="x" style="width: 12px; height: 12px; color: #94A3B8;"></i>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <h6 id="preview-title" class="text-white mb-1 font-sm" style="font-weight: 700; line-height: 1.3;">
                                🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: AAKSH NEWS 24 Live Alert
                            </h6>
                            <p id="preview-body" class="text-muted font-xs mb-0" style="line-height: 1.4; color: #cbd5e1 !important;">
                                ਪੰਜਾਬ ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਵਿਕਾਸ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ। ਟੈਪ ਕਰਕੇ ਪੂਰੀ ਰਿਪੋਰਟ ਪੜ੍ਹੋ।
                            </p>
                        </div>
                        <div class="rounded-3 bg-secondary shrink-0 overflow-hidden" style="width: 48px; height: 48px;">
                            <img src="/top_story_punjab_1784880621670.jpg" alt="Icon" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2 pt-2 border-top border-secondary">
                        <button class="btn btn-sm btn-outline-light py-0 px-2 font-xxs rounded-pill">Read News 📰</button>
                        <button class="btn btn-sm btn-outline-secondary py-0 px-2 font-xxs rounded-pill text-white">Dismiss</button>
                    </div>
                </div>

                <!-- Guidance Info Box -->
                <div class="card p-3 rounded-3" style="background-color: #F8FAFC; border: 1px dashed #CBD5E1;">
                    <div class="d-flex gap-2">
                        <i data-lucide="info" class="text-primary shrink-0" style="width: 18px; height: 18px;"></i>
                        <div class="font-xs text-muted">
                            <strong class="text-dark d-block mb-1">Subscriber Notification Guarantee:</strong>
                            Subscribers who enabled alerts via the website notification bell receive these broadcasts instantly, even if their browser tab is closed.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Broadcast History Table -->
<div class="row">
    <div class="col-12">
        <div class="panel-white">
            <div class="panel-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="color-brand-1 mb-0" style="font-weight: 700;">Broadcast History Log</h5>
                    <span class="text-muted font-xs">Showing last {{ count($history) }} sent notifications</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle font-sm mb-0">
                        <thead class="table-light font-xs text-uppercase text-muted">
                            <tr>
                                <th>#</th>
                                <th>Alert Headline</th>
                                <th>Category</th>
                                <th>Sent Date & Time</th>
                                <th>Recipients</th>
                                <th>Clicks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $item['title'] }}</div>
                                    <div class="font-xs text-muted" style="max-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['body'] }}</div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #EBF3FC; color: #1769D2; font-weight: 700;">{{ $item['category'] ?? 'General' }}</span>
                                </td>
                                <td class="text-muted font-xs">{{ $item['sent_at'] }}</td>
                                <td>
                                    <span class="font-weight-bold text-dark">{{ number_format($item['recipients'] ?? 1482) }}</span>
                                </td>
                                <td>
                                    <span class="text-success font-weight-bold">{{ number_format($item['clicks'] ?? 0) }}</span>
                                </td>
                                <td>
                                    <span class="badge" style="background: #D1FAE5; color: #065F46; font-weight: 700;">Delivered</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No push broadcasts recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Real-time preview synchronizer
        $('#push-title').on('input', function() {
            var val = $(this).val();
            $('#preview-title').text(val || '🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: AAKSH NEWS 24 Live Alert');
        });

        $('#push-body').on('input', function() {
            var val = $(this).val();
            $('#preview-body').text(val || 'ਪੰਜਾਬ ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਵਿਕਾਸ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ। ਟੈਪ ਕਰਕੇ ਪੂਰੀ ਰਿਪੋਰਟ ਪੜ੍ਹੋ।');
        });

        // Quick Preset buttons
        $('.preset-btn').on('click', function() {
            var title = $(this).data('title');
            var body = $(this).data('body');
            var cat = $(this).data('cat');

            $('#push-title').val(title).trigger('input');
            $('#push-body').val(body).trigger('input');
            if (cat) $('#push-category').val(cat);
        });
    });
</script>
@endsection
