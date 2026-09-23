@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['settings'] ?? 'Site & Brand Settings' }}</h3>
        <small class="text-muted font-sm">Manage site logo, tagline, favicon, SEO meta tags, social media channels, and contact info.</small>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                <li><span>{{ $t['settings'] ?? 'Settings' }}</span></li>
            </ul>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #047857; border-radius: 12px; font-weight: 600;">
    <i data-lucide="check-circle" class="me-2" style="width: 20px; height: 20px;"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="/admin/settings" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        
        <!-- CARD 1: BRAND IDENTITY & LOGO -->
        <div class="col-lg-6">
            <div class="panel-white h-100" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <div style="background-color: #FEF3C7; color: #D97706; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="image" class="icon-animate" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['branding_settings'] ?? 'Brand Identity & Logo' }}</h5>
                        <small class="text-muted" style="font-size: 11px;">Upload brand logo, browser favicon, site title and tagline</small>
                    </div>
                </div>

                <!-- Site Title -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark">Site / Portal Name <span class="text-danger">*</span></label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'AAKSH NEWS') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;" required>
                    <small class="text-muted" style="font-size: 11px;">Displayed in header, browser tab, and copyright notices.</small>
                </div>

                <!-- Brand Tagline -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark">Brand Tagline</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Voice of Truth') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                    <small class="text-muted" style="font-size: 11px;">E.g. "Voice of Truth" or "ਸੱਚ ਦੀ ਆਵਾਜ਼", displayed directly below header logo.</small>
                </div>

                <!-- Site Logo Upload -->
                <div class="mb-4">
                    <label class="form-label font-sm font-weight-bold text-dark">Site Logo Image</label>
                    <div class="p-3 rounded-3 text-center" style="background-color: var(--bg-color); border: 2px dashed var(--border-color);">
                        @if(!empty($settings['site_logo']))
                            <div class="mb-2">
                                <img id="logo-preview-img" src="{{ asset($settings['site_logo']) }}" alt="Current Logo" style="max-height: 55px; max-width: 220px; object-fit: contain;">
                            </div>
                            <span class="text-muted font-xs d-block mb-2">Current Active Logo</span>
                        @else
                            <div class="mb-2">
                                <img id="logo-preview-img" src="{{ asset('assets/imgs/theme/logo.svg') }}" alt="Default Logo" style="max-height: 45px; max-width: 180px; object-fit: contain; opacity: 0.6;">
                            </div>
                            <span class="text-muted font-xs d-block mb-2">Default Stylized Badge in use</span>
                        @endif
                        <input type="file" name="site_logo" id="site-logo-input" accept="image/*" class="form-control form-control-sm mt-1" style="font-size: 12px;">
                        <small class="text-muted font-xs d-block mt-1">Recommended: PNG / SVG / WebP with transparent background (Height: 40-60px).</small>
                    </div>
                </div>

                <!-- Site Icon / Favicon Upload -->
                <div class="mb-2">
                    <label class="form-label font-sm font-weight-bold text-dark">Site Icon / Browser Favicon</label>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fff; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;" class="shadow-xs shrink-0">
                            @if(!empty($settings['site_favicon']))
                                <img id="favicon-preview-img" src="{{ asset($settings['site_favicon']) }}" alt="Favicon" style="width: 28px; height: 28px; object-fit: contain;">
                            @else
                                <div class="w-7 h-7 rounded bg-amber-500 text-white font-bold d-flex align-items-center justify-content-center text-xs">A</div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" name="site_favicon" id="site-favicon-input" accept="image/x-icon,image/png,image/svg+xml" class="form-control form-control-sm" style="font-size: 12px;">
                            <small class="text-muted font-xs">Square icon (32x32 or 64x64 px). Displayed in browser tab.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- CARD 2: SEO & META SETTINGS -->
        <div class="col-lg-6">
            <div class="panel-white h-100" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <div style="background-color: #EBF3FC; color: #1769D2; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="search" class="icon-animate" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['seo_settings'] ?? 'SEO & Search Engine Meta' }}</h5>
                        <small class="text-muted" style="font-size: 11px;">Configure meta tags for Google rankings, WhatsApp & social previews</small>
                    </div>
                </div>

                <!-- Global Meta Title -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark">Global SEO Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? 'AAKSH NEWS - Voice of Truth | Latest Punjab, India & World News') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                    <small class="text-muted" style="font-size: 11px;">Primary title shown in Google search result snippet (50-60 characters recommended).</small>
                </div>

                <!-- Global Meta Description -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark">Global SEO Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">{{ old('meta_description', $settings['meta_description'] ?? 'AAKSH NEWS delivers reliable, unbiased 24x7 breaking news, live TV broadcast, political analysis, sports updates, and regional reports across Punjab, India, and worldwide.') }}</textarea>
                    <small class="text-muted" style="font-size: 11px;">Description shown below search results and when sharing home page link (150-160 characters).</small>
                </div>

                <!-- Global Meta Keywords -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark">SEO Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? 'Aaksh News, Punjab News, Breaking News, Punjabi News, Live TV, India News, Politics, Sports') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                    <small class="text-muted" style="font-size: 11px;">Comma-separated keywords for search engine indexing.</small>
                </div>

                <!-- Google Search Live Snippet Preview Box -->
                <div class="p-3 rounded-3 mt-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <span class="text-muted font-xs text-uppercase font-weight-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.05em;">Google Search Preview</span>
                    <div style="color: #1a0dab; font-size: 15px; font-weight: 600; text-decoration: none; cursor: pointer;" class="text-truncate">
                        {{ $settings['meta_title'] ?? 'AAKSH NEWS - Voice of Truth' }}
                    </div>
                    <div style="color: #006621; font-size: 11px;">http://localhost:3000/</div>
                    <div style="color: #545454; font-size: 12px; line-height: 1.4;" class="text-truncate-2">
                        {{ $settings['meta_description'] ?? 'AAKSH NEWS delivers reliable, unbiased 24x7 breaking news across Punjab, India and the world.' }}
                    </div>
                </div>

            </div>
        </div>

        <!-- CARD 3: SOCIAL MEDIA LINKS -->
        <div class="col-lg-6">
            <div class="panel-white h-100" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="background-color: #FEE2E2; color: #DC2626; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="share-2" class="icon-animate" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['social_media'] ?? 'Social Media Channels' }}</h5>
                            <small class="text-muted" style="font-size: 11px;">Configure URLs for TopBar, Footer & Quick Access</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 font-xs font-weight-bold" style="font-size: 11px;">Auto-hide Enabled</span>
                </div>

                <div class="alert alert-info border-0 mb-4" style="background-color: #eff6ff; color: #1e40af; border-radius: 10px; font-size: 12px; line-height: 1.5;">
                    <i data-lucide="info" class="me-1" style="width: 15px; height: 15px; vertical-align: -2px;"></i>
                    <strong>Important Rule:</strong> {{ $t['social_media_desc'] ?? 'Any link left blank will automatically hide that social icon from the website. Fill only the platforms you actively maintain.' }}
                </div>

                <!-- YouTube URL -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="youtube" class="text-danger" style="width: 16px; height: 16px;"></i> YouTube Channel URL
                    </label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" 
                           placeholder="https://www.youtube.com/@AakshNews24x7" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Facebook URL -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="facebook" class="text-primary" style="width: 16px; height: 16px;"></i> Facebook Page URL
                    </label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" 
                           placeholder="https://facebook.com/AakshNews24" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Instagram URL -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="instagram" style="color: #E1306C; width: 16px; height: 16px;"></i> Instagram Profile URL
                    </label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" 
                           placeholder="https://instagram.com/aakshnews24" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Twitter / X URL -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="twitter" class="text-info" style="width: 16px; height: 16px;"></i> Twitter / X Profile URL
                    </label>
                    <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" 
                           placeholder="https://twitter.com/AakshNews24" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- WhatsApp Contact -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="message-circle" class="text-success" style="width: 16px; height: 16px;"></i> WhatsApp Channel / Number Link
                    </label>
                    <input type="url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}" 
                           placeholder="https://wa.me/919876543210" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Telegram Channel -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="send" class="text-primary" style="width: 16px; height: 16px;"></i> Telegram Channel URL
                    </label>
                    <input type="url" name="telegram_url" value="{{ old('telegram_url', $settings['telegram_url'] ?? '') }}" 
                           placeholder="https://t.me/AakshNews24" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- LinkedIn URL -->
                <div class="mb-2">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="linkedin" class="text-primary" style="width: 16px; height: 16px;"></i> LinkedIn Page URL
                    </label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" 
                           placeholder="https://linkedin.com/company/aakshnews" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>
            </div>
        </div>

        <!-- CARD 4: GENERAL SITE & CONTACT SETTINGS -->
        <div class="col-lg-6">
            <div class="panel-white h-100" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <div style="background-color: #EBF3FC; color: #062B63; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="globe" class="icon-animate" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">{{ $t['general_settings'] ?? 'Broadcast & Bureau Contact' }}</h5>
                        <small class="text-muted" style="font-size: 11px;">Live TV stream embed and contact info</small>
                    </div>
                </div>

                <!-- Live TV Stream Embed URL -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="tv" class="text-danger" style="width: 16px; height: 16px;"></i> Live TV Broadcast Stream Embed URL
                    </label>
                    <input type="url" name="live_tv_stream_url" value="{{ old('live_tv_stream_url', $settings['live_tv_stream_url'] ?? '') }}" 
                           placeholder="https://www.youtube.com/embed/live_stream?channel=..." 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                    <small class="text-muted" style="font-size: 11px;">Used inside the Live TV player modal and <code>/live-tv</code> broadcast page.</small>
                </div>

                <!-- Contact Email -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="mail" style="width: 16px; height: 16px;"></i> Editorial & Bureau Email
                    </label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'contact@aakshnews.com') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Contact Phone -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="phone" style="width: 16px; height: 16px;"></i> Newsroom Helpline Number
                    </label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+91 98765 43210') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>

                <!-- Office Address -->
                <div class="mb-3">
                    <label class="form-label font-sm font-weight-bold text-dark d-flex align-items-center gap-2">
                        <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i> Office / Headquarters Address
                    </label>
                    <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? 'Sector 17, Chandigarh, Punjab 160017') }}" 
                           class="form-control" style="background-color: var(--bg-color); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px; font-size: 13px;">
                </div>
            </div>
        </div>

        <!-- SAVE BUTTON BAR -->
        <div class="col-12 mt-4 text-end">
            <button type="submit" class="submit-btn text-white" style="background-color: var(--primary-color); padding: 14px 36px; border-radius: 12px; font-weight: 800; font-size: 14px; box-shadow: 0 4px 15px rgba(23, 105, 210, 0.25);">
                <i data-lucide="save" class="icon-animate me-1" style="width: 18px; height: 18px;"></i> {{ $t['save_settings'] ?? 'Save All Settings' }}
            </button>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('site-logo-input');
        const logoPreview = document.getElementById('logo-preview-img');
        if (logoInput && logoPreview) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        logoPreview.src = ev.target.result;
                        logoPreview.style.opacity = '1';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        const favInput = document.getElementById('site-favicon-input');
        const favPreview = document.getElementById('favicon-preview-img');
        if (favInput && favPreview) {
            favInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        favPreview.src = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
