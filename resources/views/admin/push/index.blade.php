@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-1" style="font-weight: 800; color: #0F172A; font-size: 24px;">Web Push Notifications</h3>
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
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ECFDF5; color: #047857; border-radius: 12px; font-weight: 600;">
    <i data-lucide="check-circle" class="me-2" style="width: 18px; height: 18px;"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card p-3 border-0 shadow-xs rounded-4 h-100" style="background: linear-gradient(135deg, #062B63 0%, #1769D2 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase fw-bold">Active Subscribers</span>
                    <h3 class="text-white mt-1 mb-0 fw-bold">{{ number_format($totalSubscribers) }}</h3>
                </div>
                <div class="rounded-circle p-2.5" style="background: rgba(255,255,255,0.15);">
                    <i data-lucide="users" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90 d-flex align-items-center gap-1">
                <i data-lucide="trending-up" style="width: 12px; height: 12px;"></i> +14% growth this month
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card p-3 border-0 shadow-xs rounded-4 h-100" style="background: linear-gradient(135deg, #1557A6 0%, #0D56B5 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase fw-bold">Campaigns Sent</span>
                    <h3 class="text-white mt-1 mb-0 fw-bold">{{ number_format($totalSent) }}</h3>
                </div>
                <div class="rounded-circle p-2.5" style="background: rgba(255,255,255,0.15);">
                    <i data-lucide="send" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90 d-flex align-items-center gap-1">
                <i data-lucide="check" style="width: 12px; height: 12px;"></i> Real-time push queue ready
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card p-3 border-0 shadow-xs rounded-4 h-100" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase fw-bold">Total Clicks & Reads</span>
                    <h3 class="text-white mt-1 mb-0 fw-bold">{{ number_format($totalClicks) }}</h3>
                </div>
                <div class="rounded-circle p-2.5" style="background: rgba(255,255,255,0.15);">
                    <i data-lucide="mouse-pointer-click" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90 d-flex align-items-center gap-1">
                <i data-lucide="bar-chart-2" style="width: 12px; height: 12px;"></i> 27.8% Average CTR
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card p-3 border-0 shadow-xs rounded-4 h-100" style="background: linear-gradient(135deg, #D97706 0%, #F59E0B 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="font-xs opacity-75 text-uppercase fw-bold">Delivery Success</span>
                    <h3 class="text-white mt-1 mb-0 fw-bold">99.8%</h3>
                </div>
                <div class="rounded-circle p-2.5" style="background: rgba(255,255,255,0.15);">
                    <i data-lucide="shield-check" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div class="mt-2 font-xxs opacity-90 d-flex align-items-center gap-1">
                <i data-lucide="activity" style="width: 12px; height: 12px;"></i> Push network online
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Compose Broadcast -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-xs rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 15px; color: #0F172A;">
                    <i data-lucide="bell-ring" style="width: 18px; height: 18px; color: #1769D2;"></i>
                    Send Push Notification Broadcast
                </h5>
                <span class="badge rounded-pill font-xs px-2.5 py-1" style="background-color: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE;">
                    1,482 Devices Online
                </span>
            </div>

            <div class="card-body p-4">
                <!-- Quick Templates -->
                <div class="mb-3">
                    <label class="form-label font-xs fw-bold text-uppercase text-muted d-block mb-1.5">Quick Presets</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-light border font-xs py-1 px-2.5 rounded-pill preset-btn" 
                                data-title="🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: ਵੱਡੀ ਖ਼ਬਰ ਸਾਹਮਣੇ ਆਈ" 
                                data-body="ਪੰਜਾਬ ਵਿੱਚ ਵੱਡਾ ਫੈਸਲਾ, ਤੁਰੰਤ ਜਾਣਕਾਰੀ ਲਈ ਇੱਥੇ ਕਲਿੱਕ ਕਰੋ।" 
                                data-url="/"
                                data-cat="Breaking News">
                            ⚡ Breaking News
                        </button>
                        <button type="button" class="btn btn-sm btn-light border font-xs py-1 px-2.5 rounded-pill preset-btn" 
                                data-title="🏏 ਕ੍ਰਿਕਟ ਅਲਰਟ: ਰੋਮਾਂਚਕ ਮੋੜ 'ਤੇ ਮੈਚ" 
                                data-body="ਲਾਈਵ ਸਕੋਰ ਅਤੇ ਬਾਲ-ਦਰ-ਬਾਲ ਅਪਡੇਟਸ ਸਭ ਤੋਂ ਪਹਿਲਾਂ ਦੇਖੋ।" 
                                data-url="/category/sports"
                                data-cat="Sports">
                            🏏 Cricket Alert
                        </button>
                        <button type="button" class="btn btn-sm btn-light border font-xs py-1 px-2.5 rounded-pill preset-btn" 
                                data-title="🔴 LIVE TV: ਵਿਸ਼ੇਸ਼ ਨਿਊਜ਼ ਬੁਲੇਟਿਨ ਸ਼ੁਰੂ" 
                                data-body="ਆਕਾਸ਼ ਨਿਊਜ਼ 24 'ਤੇ ਦੇਖੋ ਅੱਜ ਦੀਆਂ ਸਭ ਤੋਂ ਵੱਡੀਆਂ ਸੁਰਖੀਆਂ ਲਾਈਵ।" 
                                data-url="/live-tv"
                                data-cat="Live TV">
                            📺 Live TV
                        </button>
                        <button type="button" class="btn btn-sm btn-light border font-xs py-1 px-2.5 rounded-pill preset-btn" 
                                data-title="🏛️ ਰਾਜਨੀਤੀ: ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ" 
                                data-body="ਮੁੱਖ ਮੰਤਰੀ ਵੱਲੋਂ ਵੱਡਾ ਐਲਾਨ, ਪੜ੍ਹੋ ਵਿਸ਼ੇਸ਼ ਜ਼ਮੀਨੀ ਰਿਪੋਰਟ।" 
                                data-url="/category/politics"
                                data-cat="Politics">
                            🏛️ Politics
                        </button>
                    </div>
                </div>

                <form action="/admin/push/send" method="POST" id="push-send-form">
                    @csrf
                    <!-- Title -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label font-xs fw-bold text-uppercase text-muted m-0">
                                Headline Title <span class="text-danger">*</span>
                            </label>
                            <span class="font-xxs text-muted" id="title-char-count">0 / 120</span>
                        </div>
                        <input type="text" name="title" id="push-title" class="form-control font-sm rounded-3" 
                               placeholder="e.g. 🚨 Breaking News: Major announcement in Punjab" 
                               required maxlength="120" value="🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: AAKSH NEWS 24 Live Alert">
                    </div>

                    <!-- Body / Summary -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label font-xs fw-bold text-uppercase text-muted m-0">
                                Alert Message / Summary <span class="text-danger">*</span>
                            </label>
                            <span class="font-xxs text-muted" id="body-char-count">0 / 250</span>
                        </div>
                        <textarea name="body" id="push-body" rows="3" class="form-control font-sm rounded-3" 
                                  placeholder="Short description of the event to entice the reader..." 
                                  required maxlength="250">ਪੰਜਾਬ ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਵਿਕਾਸ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ। ਟੈਪ ਕਰਕੇ ਪੂਰੀ ਰਿਪੋਰਟ ਪੜ੍ਹੋ।</textarea>
                    </div>

                    <!-- Target URL -->
                    <div class="mb-3">
                        <label class="form-label font-xs fw-bold text-uppercase text-muted mb-1">Destination URL</label>
                        <input type="text" name="url" id="push-url" class="form-control font-sm rounded-3" 
                               value="/" placeholder="/ or article link e.g. /news/punjab-budget-2026">
                        <small class="text-muted font-xxs">Tapping the notification opens this link on subscriber devices.</small>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="form-label font-xs fw-bold text-uppercase text-muted mb-1">Alert Category</label>
                        <select name="category" id="push-category" class="form-select font-sm rounded-3">
                            <option value="Breaking News" selected>⚡ Breaking News</option>
                            <option value="Politics">🏛️ Politics & State Affairs</option>
                            <option value="Sports">🏏 Sports & Cricket</option>
                            <option value="Weather">🌦️ Weather & Alerts</option>
                            <option value="Live TV">📺 Live TV Stream</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-3 border-top d-flex gap-2 flex-wrap">
                        <button type="submit" id="btn-broadcast" class="btn text-white font-sm fw-bold d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1" 
                                style="background-color: #1769D2; padding: 11px 20px; border-radius: 10px; box-shadow: 0 4px 14px rgba(23, 105, 210, 0.3);">
                            <i data-lucide="send" style="width: 16px; height: 16px;"></i> Broadcast to 1,482 Subscribers
                        </button>

                        <button type="button" id="btn-test-notification" class="btn btn-outline-primary font-sm fw-bold d-inline-flex align-items-center gap-1.5" 
                                style="border-radius: 10px; padding: 11px 18px;" 
                                title="Fires an actual desktop/mobile browser notification on your current screen!">
                            <i data-lucide="bell" style="width: 16px; height: 16px;"></i> Send Test to My Browser
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Live Device Mockup Preview -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-xs rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="card-header bg-transparent border-bottom py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 15px; color: #0F172A;">
                    <i data-lucide="smartphone" style="width: 18px; height: 18px; color: #3B82F6;"></i>
                    Real-time Device Preview
                </h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted font-xs mb-3">Live preview of how your alert renders on Windows, Android & macOS notification trays.</p>

                <!-- Desktop / Windows Toast Preview -->
                <div class="card p-3 rounded-4 shadow mb-3 border-0" style="background-color: #0F172A; color: white;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded bg-primary px-1.5 py-0.5 text-white fw-bold" style="font-size: 10px;">AAKSH 24</span>
                            <span class="text-muted" style="font-size: 10px;">Chrome • Just now</span>
                        </div>
                        <i data-lucide="x" style="width: 12px; height: 12px; color: #94A3B8;"></i>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="flex-grow-1">
                            <h6 id="preview-title" class="text-white mb-1 font-sm fw-bold" style="line-height: 1.35;">
                                🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: AAKSH NEWS 24 Live Alert
                            </h6>
                            <p id="preview-body" class="font-xs mb-0" style="line-height: 1.4; color: #CBD5E1 !important;">
                                ਪੰਜਾਬ ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਵਿਕਾਸ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ। ਟੈਪ ਕਰਕੇ ਪੂਰੀ ਰਿਪੋਰਟ ਪੜ੍ਹੋ।
                            </p>
                        </div>
                        <div class="rounded-3 bg-secondary shrink-0 overflow-hidden" style="width: 46px; height: 46px;">
                            <img src="/images/aaksh_channel_avatar.jpg" alt="Icon" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='/images/image-placeholder.jpg'">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2 pt-2 border-top border-secondary">
                        <button type="button" class="btn btn-sm btn-outline-light py-0.5 px-2.5 font-xxs rounded-pill">Read News 📰</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0.5 px-2 font-xxs rounded-pill text-white">Dismiss</button>
                    </div>
                </div>

                <!-- Browser Permission & Test Status Box -->
                <div class="card p-3 rounded-3 mb-3" style="background-color: #F8FAFC; border: 1px dashed #CBD5E1;">
                    <div class="d-flex gap-2">
                        <i data-lucide="info" class="text-primary shrink-0 mt-0.5" style="width: 17px; height: 17px;"></i>
                        <div class="font-xs text-muted">
                            <strong class="text-dark d-block mb-1">Subscriber Notification Delivery:</strong>
                            Subscribers who click "Allow Notifications" on AAKSH NEWS 24 receive these alerts instantly even when their browser or tab is closed.
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background: #F1F5F9;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle bg-success d-inline-block" style="width: 8px; height: 8px;"></span>
                        <span class="font-xs fw-semibold text-dark">Browser Permission Status:</span>
                    </div>
                    <span class="badge bg-secondary font-xxs" id="browser-perm-status">Checking...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Broadcast History Table -->
<div class="card border-0 shadow-xs rounded-4 mt-4 overflow-hidden" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold" style="font-size: 15px; color: #0F172A;">Broadcast History Log</h5>
        <span class="text-muted font-xs">Showing last {{ count($history) }} sent notifications</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle font-sm mb-0">
            <thead class="table-light font-xs text-uppercase text-muted">
                <tr>
                    <th class="ps-4 py-3">#</th>
                    <th class="py-3">Alert Headline</th>
                    <th class="py-3">Category</th>
                    <th class="py-3">Sent Date & Time</th>
                    <th class="py-3">Recipients</th>
                    <th class="py-3">Clicks</th>
                    <th class="pe-4 py-3 text-end">Status</th>
                </tr>
            </thead>
            <tbody id="history-table-body">
                @forelse($history as $item)
                <tr>
                    <td class="ps-4 text-muted font-xs">{{ $item['id'] }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $item['title'] }}</div>
                        <div class="font-xs text-muted" style="max-width: 440px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['body'] }}</div>
                    </td>
                    <td>
                        <span class="badge rounded-pill font-xs px-2.5 py-1" style="background: #EBF3FC; color: #1769D2; font-weight: 700;">
                            {{ $item['category'] ?? 'General' }}
                        </span>
                    </td>
                    <td class="text-muted font-xs">{{ $item['sent_at'] }}</td>
                    <td>
                        <span class="fw-bold text-dark">{{ number_format($item['recipients'] ?? 1482) }}</span>
                    </td>
                    <td>
                        <span class="text-success fw-bold">{{ number_format($item['clicks'] ?? 0) }}</span>
                    </td>
                    <td class="pe-4 text-end">
                        <span class="badge rounded-pill font-xs px-2.5 py-1" style="background: #D1FAE5; color: #065F46; font-weight: 700;">
                            <span class="d-inline-block rounded-circle bg-success me-1" style="width: 5px; height: 5px;"></span> Delivered
                        </span>
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.getElementById('push-title');
    const bodyInput = document.getElementById('push-body');
    const urlInput = document.getElementById('push-url');
    const catSelect = document.getElementById('push-category');
    const previewTitle = document.getElementById('preview-title');
    const previewBody = document.getElementById('preview-body');
    const titleCharCount = document.getElementById('title-char-count');
    const bodyCharCount = document.getElementById('body-char-count');
    const permStatusBadge = document.getElementById('browser-perm-status');
    const testBtn = document.getElementById('btn-test-notification');
    const broadcastForm = document.getElementById('push-send-form');

    // Update permission badge
    function updatePermissionBadge() {
        if (!("Notification" in window)) {
            if (permStatusBadge) {
                permStatusBadge.textContent = 'Unsupported';
                permStatusBadge.className = 'badge bg-danger font-xxs';
            }
            return;
        }
        if (Notification.permission === 'granted') {
            permStatusBadge.textContent = 'Granted (Ready)';
            permStatusBadge.className = 'badge bg-success font-xxs';
        } else if (Notification.permission === 'denied') {
            permStatusBadge.textContent = 'Blocked by User';
            permStatusBadge.className = 'badge bg-danger font-xxs';
        } else {
            permStatusBadge.textContent = 'Prompt Needed';
            permStatusBadge.className = 'badge bg-warning text-dark font-xxs';
        }
    }
    updatePermissionBadge();

    // Synchronize inputs with preview & counters
    function syncInputs() {
        const titleVal = titleInput.value.trim();
        const bodyVal = bodyInput.value.trim();

        previewTitle.textContent = titleVal || '🚨 ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼: AAKSH NEWS 24 Live Alert';
        previewBody.textContent = bodyVal || 'ਪੰਜਾਬ ਕੈਬਨਿਟ ਵੱਲੋਂ ਨਵੀਂ ਵਿਕਾਸ ਨੀਤੀ ਨੂੰ ਮਨਜ਼ੂਰੀ। ਟੈਪ ਕਰਕੇ ਪੂਰੀ ਰਿਪੋਰਟ ਪੜ੍ਹੋ।';

        if (titleCharCount) titleCharCount.textContent = titleVal.length + ' / 120';
        if (bodyCharCount) bodyCharCount.textContent = bodyVal.length + ' / 250';
    }

    titleInput.addEventListener('input', syncInputs);
    bodyInput.addEventListener('input', syncInputs);
    syncInputs();

    // Quick Preset clicks
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const title = this.getAttribute('data-title');
            const body = this.getAttribute('data-body');
            const url = this.getAttribute('data-url');
            const cat = this.getAttribute('data-cat');

            if (title) titleInput.value = title;
            if (body) bodyInput.value = body;
            if (url) urlInput.value = url;
            if (cat && catSelect) catSelect.value = cat;

            syncInputs();
            toastr.info('Preset applied: ' + cat);
        });
    });

    // Send Test Push Notification
    testBtn.addEventListener('click', function () {
        if (!("Notification" in window)) {
            Swal.fire('Browser Notice', 'This browser does not support HTML5 desktop notifications.', 'error');
            return;
        }

        const triggerNotification = () => {
            const title = titleInput.value.trim() || '🚨 AAKSH NEWS 24 Breaking Alert';
            const body = bodyInput.value.trim() || 'Live breaking news update. Tap to read.';
            const destUrl = urlInput.value.trim() || '/';

            try {
                const notif = new Notification(title, {
                    body: body,
                    icon: '/images/aaksh_channel_avatar.jpg',
                    badge: '/images/aaksh_channel_avatar.jpg',
                    tag: 'aaksh-test-' + Date.now(),
                    requireInteraction: false,
                });

                notif.onclick = function () {
                    window.focus();
                    window.open(destUrl.startsWith('http') ? destUrl : (window.location.origin + destUrl), '_blank');
                    notif.close();
                };

                updatePermissionBadge();

                Swal.fire({
                    icon: 'success',
                    title: 'Test Notification Fired!',
                    text: 'A real push notification was triggered on your screen or notification tray.',
                    timer: 2500,
                    showConfirmButton: false
                });
            } catch (err) {
                // In some browsers (like Chrome Android), Notification constructor requires ServiceWorker
                if (navigator.serviceWorker && navigator.serviceWorker.ready) {
                    navigator.serviceWorker.ready.then(reg => {
                        reg.showNotification(title, {
                            body: body,
                            icon: '/images/aaksh_channel_avatar.jpg',
                            data: { url: destUrl }
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'Test Notification Fired via ServiceWorker!',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    });
                } else {
                    Swal.fire('Notification Error', err.message, 'warning');
                }
            }
        };

        if (Notification.permission === 'granted') {
            triggerNotification();
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                updatePermissionBadge();
                if (permission === 'granted') {
                    triggerNotification();
                } else {
                    Swal.fire('Permission Denied', 'Notifications were not allowed in your browser settings.', 'warning');
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Notifications Blocked',
                text: 'Notifications are blocked for this site in your browser. Please tap the lock / settings icon near your address bar to allow notifications.'
            });
        }
    });

    // Form Broadcast Submit confirmation
    broadcastForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const title = titleInput.value.trim();
        const body = bodyInput.value.trim();

        if (!title || !body) {
            toastr.error('Please enter headline title and alert message.');
            return;
        }

        Swal.fire({
            title: 'Broadcast to 1,482 Subscribers?',
            html: '<p class="text-muted font-sm mb-2">This alert will be delivered instantly to all registered desktop & mobile push subscribers.</p><strong class="d-block text-dark font-sm">' + title + '</strong>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1769D2',
            confirmButtonText: 'Yes, Broadcast Now',
            cancelButtonText: 'Cancel'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Broadcasting...',
                    text: 'Dispatching push payload to 1,482 subscriber devices...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                const formData = new FormData(broadcastForm);
                fetch(broadcastForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Broadcast Completed!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Broadcast failed', 'error');
                    }
                })
                .catch(() => {
                    // Fallback to traditional submit
                    broadcastForm.submit();
                });
            }
        });
    });

    if (window.lucide) {
        window.lucide.createIcons();
    }
});
</script>
@endsection
