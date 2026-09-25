@extends('admin.layouts.app')

@section('content')
<!-- Custom Styles to match reference mockup media_1790110704755.png -->
<style>
    /* Design Tokens */
    :root {
        --color-purple-primary: #1769D2;
        --color-purple-hover: #0D56B5;
        --color-purple-light: #EBF3FC;
        --color-purple-border: #BFDBFE;
        --border-card: #E2E8F0;
        --text-slate-800: #111827;
        --text-slate-500: #64748B;
        --text-slate-400: #94A3B8;
    }

    .news-page-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
        padding: 24px;
        margin-bottom: 24px;
    }

    .icon-squircle {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .icon-squircle-purple { background: #EBF3FC; color: #1769D2; }
    .icon-squircle-blue { background: #EFF6FF; color: #1769D2; }
    .icon-squircle-orange { background: #FFF7ED; color: #EA580C; }
    .icon-squircle-green { background: #ECFDF5; color: #16A34A; }

    .card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-title-main {
        font-size: 16px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 2px;
    }
    .card-subtitle-sub {
        font-size: 12px;
        color: #64748B;
        margin-bottom: 0;
    }

    .btn-ai-pill {
        background: #EBF3FC;
        color: #1769D2;
        border: 1px solid #BFDBFE;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        padding: 5px 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-ai-pill:hover {
        background: #DCEAF9;
        color: #0D56B5;
    }

    .form-control-modern {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13.5px;
        color: #111827;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #ffffff;
    }
    .form-control-modern:focus {
        border-color: #1769D2;
        box-shadow: 0 0 0 3px rgba(23, 105, 210, 0.15);
        outline: none;
    }

    /* iOS Switch Style */
    .custom-switch-label {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin-bottom: 0;
    }
    .custom-switch-label input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .custom-switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #E2E8F0;
        transition: .25s ease-in-out;
        border-radius: 24px;
    }
    .custom-switch-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .25s ease-in-out;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    input:checked + .custom-switch-slider {
        background-color: #1769D2;
    }
    input:checked + .custom-switch-slider:before {
        transform: translateX(20px);
    }

    /* Tag badge */
    .tag-badge-pill {
        background: #F1F5F9;
        color: #334155;
        border-radius: 9999px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s ease;
    }
    .tag-badge-pill:hover {
        background: #E2E8F0;
    }
    .tag-badge-remove {
        cursor: pointer;
        font-size: 13px;
        line-height: 1;
        color: #64748B;
    }
    .tag-badge-remove:hover {
        color: #EF4444;
    }

    /* Lang tabs */
    .lang-tab-btn {
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        background: #F8FAFC;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .lang-tab-btn.active {
        background: #EFF6FF;
        color: #2563EB;
        border-color: #93C5FD;
    }

    /* Rich text editor toolbar */
    .editor-toolbar-btn {
        background: transparent;
        border: none;
        padding: 5px 8px;
        border-radius: 4px;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .editor-toolbar-btn:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    /* Dashed upload box */
    .upload-zone-dashed {
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        background: #F8FAFC;
        padding: 24px 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .upload-zone-dashed:hover {
        border-color: #1769D2;
        background: #F5F8FC;
    }

    /* SERP box */
    .serp-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 14px 16px;
    }

    /* Real Image Finder Modal & Cards */
    .real-image-card {
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .real-image-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.15);
        border-color: #1769D2;
    }
    .real-image-thumb-wrap {
        position: relative;
        width: 100%;
        height: 150px;
        background: #0F172A;
        overflow: hidden;
    }
    .real-image-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .real-image-card:hover .real-image-thumb-wrap img {
        transform: scale(1.05);
    }
    .real-image-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.72);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: 700;
        gap: 6px;
        backdrop-filter: blur(2px);
    }
    .real-image-card:hover .real-image-overlay {
        opacity: 1;
    }
    .real-image-card.is-saving .real-image-overlay {
        opacity: 1 !important;
        background: rgba(15, 23, 42, 0.88);
    }
    .real-image-meta {
        padding: 10px 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .real-image-title {
        font-size: 11.5px;
        font-weight: 600;
        color: #1E293B;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 32px;
        margin-bottom: 6px;
    }
    .real-image-badge-domain {
        font-size: 10.5px;
        font-weight: 600;
        color: #1769D2;
        background: #EBF3FC;
        padding: 2px 7px;
        border-radius: 4px;
        display: inline-block;
        max-width: 130px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .quick-search-pill {
        transition: all 0.15s ease;
        font-weight: 500;
    }
    .quick-search-pill:hover, .quick-search-pill.active {
        background: #EBF3FC !important;
        color: #1769D2 !important;
        border-color: #BFDBFE !important;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<!-- Top Breadcrumbs & Page Heading -->
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h3 class="mb-1" style="font-size: 24px; font-weight: 800; color: #111827; letter-spacing: -0.02em;">Edit News Article</h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">Edit and update news article with AI tools, multilingual support and SEO optimization.</p>
    </div>
    <div class="text-end">
        <div class="d-flex align-items-center gap-1 font-xs text-muted mb-2 justify-content-end" style="font-size: 12px;">
            <a href="/admin/dashboard" class="text-muted text-decoration-none">Dashboard</a>
            <span>&gt;</span>
            <a href="/admin/post" class="text-muted text-decoration-none">News Articles</a>
            <span>&gt;</span>
            <span style="color: #1769D2; font-weight: 600;">Edit News</span>
        </div>
        <a href="/admin/post" class="btn btn-sm btn-white border d-inline-flex align-items-center bg-white shadow-sm" style="border-radius: 8px; font-weight: 600; font-size: 12.5px; padding: 6px 14px; gap: 6px; color: #334155;">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Back to Articles
        </a>
    </div>
</div>

<form id="post-edit-form" class="row">
    <input type="hidden" id="post-id" value="{{ $post->id }}">

    <!-- ========================================== -->
    <!-- LEFT COLUMN: Content, AI & Translations    -->
    <!-- ========================================== -->
    <div class="col-xxl-8 col-xl-8 col-lg-8 mb-4">
        
        <!-- CARD 1: ARTICLE DETAILS -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-purple">
                        <i data-lucide="newspaper" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Article Details</div>
                        <div class="card-subtitle-sub">Basic information about your news article</div>
                    </div>
                </div>
            </div>

            <!-- Input Language Selector & Instant Auto-Translate -->
            <div class="p-3 mb-3 rounded-3" style="background: linear-gradient(135deg, #EFF6FF 0%, #F5F3FF 100%); border: 1px solid #BFDBFE;">
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

            <!-- Title -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-sm text-dark mb-0" style="font-weight: 600;">Title (Any Language: Punjabi / Hindi / English) <span class="text-danger">*</span></label>
                    <button type="button" class="btn-ai-pill" id="btn-ai-suggest-title">
                        <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i> AI Suggest Title
                    </button>
                </div>
                <input type="text" name="title" id="post-title" class="form-control form-control-modern w-100" required value="{{ $post->title }}" placeholder="Enter headline in Punjabi, Hindi, or English..." maxlength="200">
                <div class="d-flex justify-content-end mt-1">
                    <span class="text-muted" style="font-size: 11px;" id="title-char-count">0/200</span>
                </div>
            </div>

            <!-- Category & Sub Category Row -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="font-sm text-dark mb-2" style="font-weight: 600;">Category <span class="text-danger">*</span></label>
                    <select name="category" id="post-category" class="form-control form-control-modern w-100" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ $post->category == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                        @if($categories->isEmpty())
                            <option value="National" {{ $post->category == 'National' ? 'selected' : '' }}>National</option>
                            <option value="Punjab" {{ $post->category == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                            <option value="Politics" {{ $post->category == 'Politics' ? 'selected' : '' }}>Politics</option>
                            <option value="Sports" {{ $post->category == 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Business" {{ $post->category == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Technology" {{ $post->category == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Entertainment" {{ $post->category == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                            <option value="World" {{ $post->category == 'World' ? 'selected' : '' }}>World</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="font-sm text-dark mb-2" style="font-weight: 600;">Sub Category</label>
                    <select name="sub_category" id="post-sub-category" class="form-control form-control-modern w-100">
                        <option value="">Select Sub Category</option>
                        <option value="State Politics" selected>State Politics</option>
                        <option value="Governance">Governance</option>
                        <option value="Crime & Law">Crime & Law</option>
                        <option value="Development & Economy">Development & Economy</option>
                        <option value="Agriculture & Farmers">Agriculture & Farmers</option>
                        <option value="City News">City News</option>
                    </select>
                </div>
            </div>

            <!-- Author Name -->
            <div class="mb-4">
                <label class="font-sm text-dark mb-2" style="font-weight: 600;">Author Name</label>
                <input type="text" name="author_name" id="post-author" class="form-control form-control-modern w-100" value="{{ old('author_name', $post->author_name ?? (Auth::check() ? Auth::user()->name : 'Aakash News Desk')) }}" placeholder="Enter author name">
            </div>

            <!-- Short Description -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-sm text-dark mb-0" style="font-weight: 600;">Short Description <span class="text-danger">*</span></label>
                    <button type="button" class="btn-ai-pill" id="btn-ai-desc">
                        <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i> Generate with AI
                    </button>
                </div>
                <textarea name="short_description" id="post-short-desc" class="form-control form-control-modern w-100" rows="3" maxlength="300" placeholder="Write a short summary of the article (will be used in listings and social media)...">{{ $post->short_description ?? Str::limit(strip_tags($post->content), 180, '') }}</textarea>
                <div class="d-flex justify-content-end mt-1">
                    <span class="text-muted" style="font-size: 11px;" id="desc-char-count">0/300</span>
                </div>
            </div>

            <!-- Content with Rich Toolbar -->
            <div class="mb-4">
                <label class="font-sm text-dark mb-2" style="font-weight: 600;">Content <span class="text-danger">*</span></label>
                
                <!-- Formatting Toolbar -->
                <div class="d-flex flex-wrap align-items-center gap-1 p-2 rounded-top border border-bottom-0" style="background: #F8FAFC; border-color: #E2E8F0 !important;">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="editor-toolbar-btn dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 12px;">
                            Paragraph
                        </button>
                        <ul class="dropdown-menu shadow-sm border-0 font-sm">
                            <li><a class="dropdown-item py-1" href="#" onclick="applyFormat('formatBlock', 'p'); return false;">Paragraph</a></li>
                            <li><a class="dropdown-item py-1" href="#" onclick="applyFormat('formatBlock', 'h2'); return false;">Heading 2</a></li>
                            <li><a class="dropdown-item py-1" href="#" onclick="applyFormat('formatBlock', 'h3'); return false;">Heading 3</a></li>
                            <li><a class="dropdown-item py-1" href="#" onclick="applyFormat('formatBlock', 'h4'); return false;">Heading 4</a></li>
                        </ul>
                    </div>
                    <span class="text-muted mx-1">|</span>
                    <button type="button" class="editor-toolbar-btn" title="Bold" onclick="wrapText('**', '**')"><b>B</b></button>
                    <button type="button" class="editor-toolbar-btn" title="Italic" onclick="wrapText('*', '*')"><i>I</i></button>
                    <button type="button" class="editor-toolbar-btn" title="Underline" onclick="wrapText('<u>', '</u>')"><u>U</u></button>
                    <span class="text-muted mx-1">|</span>
                    <button type="button" class="editor-toolbar-btn" title="Bullet List" onclick="wrapText('\n- ', '')"><i data-lucide="list" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Numbered List" onclick="wrapText('\n1. ', '')"><i data-lucide="list-ordered" style="width: 14px; height: 14px;"></i></button>
                    <span class="text-muted mx-1">|</span>
                    <button type="button" class="editor-toolbar-btn" title="Quote" onclick="wrapText('\n> ', '')"><i data-lucide="quote" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Insert Link" onclick="insertLink()"><i data-lucide="link" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Insert Image" onclick="triggerImageUpload()"><i data-lucide="image" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Insert Video" onclick="insertVideoPrompt()"><i data-lucide="video" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Table"><i data-lucide="table" style="width: 14px; height: 14px;"></i></button>
                    <span class="text-muted mx-1">|</span>
                    <button type="button" class="editor-toolbar-btn" title="More"><i data-lucide="more-horizontal" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn" title="Align"><i data-lucide="align-left" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="editor-toolbar-btn ms-auto" title="Expand"><i data-lucide="maximize-2" style="width: 14px; height: 14px;"></i></button>
                </div>
                
                <!-- Textarea Editor -->
                <textarea name="content" id="post-content" class="form-control rounded-bottom rounded-top-0 border-top-0 w-100" rows="10" required placeholder="Write your news content here..." style="border-color: #E2E8F0; font-size: 14px; line-height: 1.6;">{{ $post->content }}</textarea>
                <div class="d-flex justify-content-end mt-1">
                    <span class="text-muted" style="font-size: 11px;" id="word-count-display">Words: 0</span>
                </div>
            </div>

            <!-- AI Assistant Callout Box -->
            <div class="p-3 rounded-3" style="background: linear-gradient(135deg, #EFF6FF 0%, #E0EEFD 100%); border: 1px solid #BFDBFE;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 26px; height: 26px; background: #1769D2; color: #FFC400;">
                        <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                    </span>
                    <div>
                        <span style="font-weight: 700; color: #062B63; font-size: 13.5px;">AI Assistant</span>
                        <span class="text-muted ms-1" style="font-size: 11.5px;">Improve writing, fix grammar, or translate content instantly.</span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2 pt-1">
                    <button type="button" class="btn btn-sm btn-white text-dark d-inline-flex align-items-center border bg-white shadow-sm" id="btn-ai-improve" style="font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 6px; gap: 5px;">
                        <i data-lucide="wand-2" style="width: 13px; height: 13px; color: #1769D2;"></i> Improve
                    </button>
                    <button type="button" class="btn btn-sm btn-white text-dark d-inline-flex align-items-center border bg-white shadow-sm" id="btn-ai-grammar" style="font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 6px; gap: 5px;">
                        <i data-lucide="check-check" style="width: 13px; height: 13px; color: #16A34A;"></i> Fix Grammar
                    </button>
                    <button type="button" class="btn btn-sm btn-white text-dark d-inline-flex align-items-center border bg-white shadow-sm" id="btn-ai-summarize" style="font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 6px; gap: 5px;">
                        <i data-lucide="file-text" style="width: 13px; height: 13px; color: #1769D2;"></i> Summarize
                    </button>
                    <button type="button" class="btn btn-sm btn-white text-dark d-inline-flex align-items-center border bg-white shadow-sm" id="btn-ai-translate-quick" style="font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 6px; gap: 5px;">
                        <i data-lucide="languages" style="width: 13px; height: 13px; color: #D97706;"></i> Translate
                    </button>
                </div>
            </div>
        </div>

        <!-- CARD 2: MULTILINGUAL TRANSLATIONS & AUTO-TRANSLATE -->
        <div class="news-page-card" id="multilingual-hub-card" style="border: 1.5px solid #BFDBFE; background: #F8FAFC;">
            <div class="card-header-flex flex-wrap gap-2">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-blue" style="background: #1769D2; color: #FFFFFF;">
                        <i data-lucide="languages" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main d-flex align-items-center gap-2">
                            <span>Multilingual News Hub (English • हिंदी • ਪੰਜਾਬੀ)</span>
                            <span class="badge" style="background-color: #22C55E; color: white; font-size: 10px; font-weight: 800; border-radius: 999px; padding: 2px 8px;">Auto-Translate Active</span>
                        </div>
                        <div class="card-subtitle-sub">Edit in <strong>any</strong> language (Punjabi, Hindi, or English) — auto-translates instantly with 100% manual edit control!</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm d-inline-flex align-items-center gap-1.5 shadow-sm fw-bold text-white" id="btn-auto-translate" style="background: linear-gradient(135deg, #1769D2 0%, #0D56B5 100%); border-radius: 8px; font-size: 12px; padding: 8px 16px;">
                        <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                        <span>Auto-Translate All Languages</span>
                    </button>
                </div>
            </div>

            <!-- Language Tabs with Status Pills -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3 p-2 rounded-3 bg-white border" style="border-color: #E2E8F0;">
                <button type="button" class="lang-tab-btn active d-inline-flex align-items-center gap-2" data-lang="en">
                    <span>🇬🇧</span>
                    <strong>English Edition</strong>
                    <span class="badge bg-light text-muted font-xxs border" id="badge-status-en">Synced</span>
                </button>
                <button type="button" class="lang-tab-btn d-inline-flex align-items-center gap-2" data-lang="hi">
                    <span>🇮🇳</span>
                    <strong>हिंदी संस्करण (Hindi)</strong>
                    <span class="badge bg-light text-muted font-xxs border" id="badge-status-hi">Synced</span>
                </button>
                <button type="button" class="lang-tab-btn d-inline-flex align-items-center gap-2" data-lang="pb">
                    <span>☬</span>
                    <strong>ਪੰਜਾਬੀ ਸੰਸਕਰਣ (Punjabi)</strong>
                    <span class="badge bg-light text-muted font-xxs border" id="badge-status-pb">Synced</span>
                </button>
            </div>

            <!-- Language Tab Content Panes -->
            <div id="lang-pane-en" class="lang-pane bg-white p-3 rounded-3 border" style="border-color: #E2E8F0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">🇬🇧 English Headline / Title</label>
                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 font-xxs fw-bold rounded" onclick="translateSpecificField('en')">
                        <i data-lucide="refresh-cw" style="width: 11px; height: 11px;"></i> Re-translate English
                    </button>
                </div>
                <input type="text" name="title_en" id="post-title-en" class="form-control form-control-modern w-100 mb-3" value="{{ $post->title_en }}" placeholder="Enter headline in English (or auto-translated)...">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">🇬🇧 English Article Body</label>
                    <span class="text-muted font-xxs">Fully editable — refine or format as desired</span>
                </div>
                <textarea name="content_en" id="post-content-en" class="form-control form-control-modern w-100" rows="5" placeholder="Enter full story in English (or auto-translated)...">{{ $post->content_en }}</textarea>
            </div>

            <div id="lang-pane-hi" class="lang-pane d-none bg-white p-3 rounded-3 border" style="border-color: #E2E8F0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">🇮🇳 हिंदी शीर्षक (Hindi Headline)</label>
                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 font-xxs fw-bold rounded" onclick="translateSpecificField('hi')">
                        <i data-lucide="refresh-cw" style="width: 11px; height: 11px;"></i> Re-translate Hindi
                    </button>
                </div>
                <input type="text" name="title_hi" id="post-title-hi" class="form-control form-control-modern w-100 mb-3" value="{{ $post->title_hi }}" placeholder="हिंदी में शीर्षक दर्ज करें (या ऑटो-ट्रांसलेट होगा)...">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">🇮🇳 हिंदी समाचार विवरण (Hindi Content)</label>
                    <span class="text-muted font-xxs">पूरी तरह संपादन योग्य — आप अपनी इच्छानुसार सुधार सकते हैं</span>
                </div>
                <textarea name="content_hi" id="post-content-hi" class="form-control form-control-modern w-100" rows="5" placeholder="हिंदी में समाचार का पूरा विवरण दर्ज करें...">{{ $post->content_hi }}</textarea>
            </div>

            <div id="lang-pane-pb" class="lang-pane d-none bg-white p-3 rounded-3 border" style="border-color: #E2E8F0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">☬ ਪੰਜਾਬੀ ਸਿਰਲੇਖ (Punjabi Headline)</label>
                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 font-xxs fw-bold rounded" onclick="translateSpecificField('pa')">
                        <i data-lucide="refresh-cw" style="width: 11px; height: 11px;"></i> Re-translate Punjabi
                    </button>
                </div>
                <input type="text" name="title_pb" id="post-title-pb" class="form-control form-control-modern w-100 mb-3" value="{{ $post->title_pb }}" placeholder="ਪੰਜਾਬੀ ਵਿੱਚ ਸਿਰਲੇਖ ਦਰਜ ਕਰੋ (ਜਾਂ ਆਟੋ-ਟਰਾਂਸਲੇਟ ਹੋਵੇਗਾ)...">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-xs text-dark mb-0 fw-bold">☬ ਪੰਜਾਬੀ ਖ਼ਬਰ ਦਾ ਵੇਰਵਾ (Punjabi Content)</label>
                    <span class="text-muted font-xxs">ਪੂਰੀ ਤਰ੍ਹਾਂ ਸੰਪਾਦਨ ਯੋਗ — ਤੁਸੀਂ ਆਪਣੀ ਮਰਜ਼ੀ ਮੁਤਾਬਕ ਬਦਲ ਸਕਦੇ ਹੋ</span>
                </div>
                <textarea name="content_pb" id="post-content-pb" class="form-control form-control-modern w-100" rows="5" placeholder="ਪੰਜਾਬੀ ਵਿੱਚ ਖ਼ਬਰ ਦਾ ਪੂਰਾ ਵੇਰਵਾ ਦਰਜ ਕਰੋ...">{{ $post->content_pb }}</textarea>
            </div>

            <div class="mt-3 p-2 rounded-2 d-flex align-items-center gap-2 font-xs" style="background: #EFF6FF; color: #1E40AF; border: 1px solid #DBEAFE;">
                <i data-lucide="check-circle" style="width: 15px; height: 15px; flex-shrink: 0; color: #16A34A;"></i>
                <span><strong>Guarantee:</strong> Even if you leave any language tab blank, the system automatically detects your input and translates it before updating so the news appears in English, Hindi, and Punjabi across the website!</span>
            </div>
        </div>

        <!-- CARD 3: TAGS & KEYWORDS -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-orange">
                        <i data-lucide="tag" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Tags & Keywords</div>
                        <div class="card-subtitle-sub">Add relevant tags to improve search visibility</div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <input type="text" id="tag-input-field" class="form-control form-control-modern w-100" placeholder="Type a tag and press Enter, Comma (,) or Tab...">
                <input type="hidden" name="meta_keywords" id="post-meta-keywords" value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}">
            </div>

            <!-- Tags List -->
            <div class="d-flex flex-wrap align-items-center gap-2" id="tags-badges-container">
                @php
                    $rawKws = old('meta_keywords', $post->meta_keywords ?? '');
                    $existingKeywords = $rawKws ? array_filter(array_map('trim', explode(',', $rawKws))) : [];
                @endphp
                @foreach($existingKeywords as $kw)
                    @php $cleanKw = ltrim(trim($kw), '#'); @endphp
                    @if($cleanKw !== '')
                        <span class="tag-badge-pill">#{{ $cleanKw }} <span class="tag-badge-remove" onclick="removeTag(this, '{{ addslashes($cleanKw) }}')">&times;</span></span>
                    @endif
                @endforeach
            </div>
            <div class="form-text mt-2 d-flex align-items-center gap-1.5" style="font-size: 11.5px; color: #94A3B8;">
                <i data-lucide="info" style="width: 13px; height: 13px;"></i>
                <span>Type keyword and press <kbd style="background:#F1F5F9;color:#334155;padding:1px 5px;border-radius:4px;font-size:10px;border:1px solid #CBD5E1;">Enter</kbd>, <kbd style="background:#F1F5F9;color:#334155;padding:1px 5px;border-radius:4px;font-size:10px;border:1px solid #CBD5E1;">,</kbd> (Comma) or <kbd style="background:#F1F5F9;color:#334155;padding:1px 5px;border-radius:4px;font-size:10px;border:1px solid #CBD5E1;">Tab</kbd> to add tag.</span>
            </div>
        </div>

        <!-- CARD 4: RELATED CONTENT (ACCORDION) -->
        <div class="news-page-card">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseRelatedContent">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-blue">
                        <i data-lucide="link-2" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Related Content</div>
                        <div class="card-subtitle-sub">Link related articles, videos or external sources</div>
                    </div>
                </div>
                <i data-lucide="chevron-down" style="width: 18px; height: 18px; color: #64748B;"></i>
            </div>
            
            <div class="collapse pt-3 mt-3 border-top" id="collapseRelatedContent">
                <div class="mb-3">
                    <label class="font-xs text-muted mb-1" style="font-weight: 600;">Search & Link Articles</label>
                    <input type="text" class="form-control form-control-modern" placeholder="Type keywords to search existing articles...">
                </div>
                <div class="mb-2">
                    <label class="font-xs text-muted mb-1" style="font-weight: 600;">External Reference URL</label>
                    <input type="url" name="external_url" class="form-control form-control-modern" value="{{ $post->external_url ?? '' }}" placeholder="https://external-source.com/report">
                </div>
            </div>
        </div>

        <!-- CARD 5: ADVANCED OPTIONS (ACCORDION) -->
        <div class="news-page-card">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseAdvancedOptions">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-blue">
                        <i data-lucide="sliders" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Advanced Options</div>
                        <div class="card-subtitle-sub">Schedule, location, featured settings and more</div>
                    </div>
                </div>
                <i data-lucide="chevron-down" style="width: 18px; height: 18px; color: #64748B;"></i>
            </div>

            <div class="collapse pt-3 mt-3 border-top" id="collapseAdvancedOptions">
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="font-xs text-muted mb-1" style="font-weight: 600;">Location / District</label>
                        <input type="text" name="location" class="form-control form-control-modern" value="{{ $post->location ?? '' }}" placeholder="e.g. Chandigarh, Amritsar, Ludhiana">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="font-xs text-muted mb-1" style="font-weight: 600;">Video / Reel URL</label>
                        <input type="url" name="video_url" id="post-video-url" class="form-control form-control-modern" value="{{ $post->video_url }}" placeholder="https://youtube.com/watch?v=...">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="font-xs text-muted mb-1" style="font-weight: 600;">Video Duration</label>
                        <input type="text" name="duration" id="post-duration" class="form-control form-control-modern" value="{{ $post->duration }}" placeholder="e.g. 02:30">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="font-xs text-muted mb-1" style="font-weight: 600;">Views Count</label>
                        <input type="number" name="views_count" id="post-views" class="form-control form-control-modern" value="{{ $post->views_count }}">
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-4 pt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_reel" id="post-is-reel" {{ $post->is_reel ? 'checked' : '' }}>
                        <label class="form-check-label font-sm" for="post-is-reel">Open as Reel (Short Format)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_middle_stack" id="post-is-middle-stack" {{ $post->is_middle_stack ? 'checked' : '' }}>
                        <label class="form-check-label font-sm" for="post-is-middle-stack">Show in Middle Stack</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="send_push_notification" id="post-send-push" value="1">
                        <label class="form-check-label font-sm text-primary font-weight-bold" for="post-send-push">
                            <i data-lucide="bell" style="width: 13px; height: 13px;" class="text-danger me-1"></i> Send Instant Push Notification Alert
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- RIGHT COLUMN: Publish Settings & Media     -->
    <!-- ========================================== -->
    <div class="col-xxl-4 col-xl-4 col-lg-4 mb-4">
        
        <!-- CARD 1: PUBLISH SETTINGS -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-green">
                        <i data-lucide="settings-2" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Publish Settings</div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="font-sm text-dark mb-1" style="font-weight: 600;">Status</label>
                <select name="status" id="post-status" class="form-control form-control-modern w-100">
                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="hidden" {{ $post->status == 'hidden' ? 'selected' : '' }}>Hidden</option>
                </select>
            </div>

            <!-- Publish Date & Time -->
            <div class="mb-4">
                <label class="font-sm text-dark mb-1" style="font-weight: 600;">Publish Date & Time</label>
                <div class="row g-2">
                    <div class="col-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color: #E2E8F0;"><i data-lucide="calendar" style="width: 14px; height: 14px; color: #64748B;"></i></span>
                            <input type="date" name="publish_date" id="post-publish-date" class="form-control form-control-modern border-start-0 ps-0" value="{{ $post->created_at ? $post->created_at->format('Y-m-d') : date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color: #E2E8F0;"><i data-lucide="clock" style="width: 14px; height: 14px; color: #64748B;"></i></span>
                            <input type="time" name="publish_time" id="post-publish-time" class="form-control form-control-modern border-start-0 ps-0" value="{{ $post->created_at ? $post->created_at->format('H:i') : date('H:i') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toggle Switches (iOS style) -->
            <div class="d-flex flex-column gap-3 pt-2 border-top">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="check-circle-2" style="width: 16px; height: 16px; color: #64748B;"></i>
                        <span class="font-sm" style="font-weight: 600; color: #334155;">Set as Breaking News</span>
                    </div>
                    <label class="custom-switch-label">
                        <input type="checkbox" name="is_breaking" id="post-is-breaking" {{ ($post->is_breaking ?? false) ? 'checked' : '' }}>
                        <span class="custom-switch-slider"></span>
                    </label>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="check-circle-2" style="width: 16px; height: 16px; color: #16A34A;"></i>
                        <span class="font-sm" style="font-weight: 600; color: #334155;">Feature on Homepage</span>
                    </div>
                    <label class="custom-switch-label">
                        <input type="checkbox" name="is_hero" id="post-is-hero" {{ $post->is_hero ? 'checked' : '' }}>
                        <span class="custom-switch-slider"></span>
                    </label>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="check-circle-2" style="width: 16px; height: 16px; color: #16A34A;"></i>
                        <span class="font-sm" style="font-weight: 600; color: #334155;">Allow Comments</span>
                    </div>
                    <label class="custom-switch-label">
                        <input type="checkbox" name="allow_comments" id="post-allow-comments" checked>
                        <span class="custom-switch-slider"></span>
                    </label>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="lock" style="width: 16px; height: 16px; color: #64748B;"></i>
                        <span class="font-sm" style="font-weight: 600; color: #334155;">Lock this article</span>
                    </div>
                    <label class="custom-switch-label">
                        <input type="checkbox" name="is_locked" id="post-is-locked" {{ ($post->is_locked ?? false) ? 'checked' : '' }}>
                        <span class="custom-switch-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- CARD 2: FEATURED IMAGE -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-blue">
                        <i data-lucide="image" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Featured Image</div>
                    </div>
                </div>
            </div>

            <!-- Upload Zone Dashed -->
            <div class="upload-zone-dashed mb-3" onclick="$('#post-image-file').click();">
                <div class="d-flex justify-content-center mb-2">
                    <div class="rounded-circle p-2 bg-white shadow-sm" style="color: #64748B;">
                        <i data-lucide="image-plus" style="width: 28px; height: 28px;"></i>
                    </div>
                </div>
                <div class="font-sm font-weight-bold text-dark mb-1">Upload Featured Image</div>
                <div class="text-muted font-xxs mb-3" style="font-size: 11px;">Recommended size: 1200 × 630 px<br>JPG, PNG or WebP (Max 5MB)</div>

                <div class="d-flex justify-content-center gap-2 flex-wrap" onclick="event.stopPropagation();">
                    <label class="btn btn-sm text-white mb-0 d-inline-flex align-items-center" style="background: #1769D2; border-radius: 6px; font-weight: 600; font-size: 11.5px; padding: 6px 12px; gap: 5px; cursor: pointer;">
                        <i data-lucide="upload" style="width: 13px; height: 13px;"></i> Upload Image
                        <input type="file" id="post-image-file" accept="image/*" class="d-none">
                    </label>
                    <button type="button" class="btn btn-sm btn-white border shadow-sm d-inline-flex align-items-center" id="btn-find-real-image" style="border-radius: 6px; font-weight: 600; font-size: 11.5px; padding: 6px 12px; gap: 5px; color: #1E293B; background: #F8FAFC;">
                        <i data-lucide="globe" style="width: 13px; height: 13px; color: #2563EB;"></i> Find Real News Image
                    </button>
                </div>
            </div>

            <!-- Manual URL input & Preview -->
            <div class="mb-2">
                <input type="text" name="image_url" id="post-image-url" class="form-control form-control-modern font-xs" value="{{ $post->image_url }}" placeholder="Or paste image URL...">
                <span id="upload-status" class="font-xs text-muted mt-1 d-none"><i data-lucide="loader-2" class="lucide-spin" style="width: 12px; height: 12px;"></i> Uploading image...</span>
            </div>

            <!-- Live Featured Image Preview -->
            <div id="featured-image-preview-container" class="mb-3 p-2 bg-light rounded border position-relative" style="{{ $post->image_url ? '' : 'display: none;' }}">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="font-xxs text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">Selected Featured Photo</span>
                    <button type="button" class="btn btn-link btn-sm p-0 text-danger text-decoration-none" id="btn-remove-featured-image" style="font-size: 11px;">
                        <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i> Clear
                    </button>
                </div>
                <div class="position-relative overflow-hidden rounded border bg-dark" style="max-height: 160px;">
                    <img id="featured-image-preview-img" src="{{ $post->image_url }}" alt="Featured Preview" class="w-100 object-fit-cover" style="max-height: 160px; display: block;">
                </div>
            </div>

            <!-- Thumbnails selection row matching mockup -->
            <div class="d-flex align-items-center gap-2 overflow-auto py-1" id="preset-thumbnails-row">
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="Current Featured" class="rounded object-fit-cover shadow-sm thumb-pick border border-primary" style="width: 64px; height: 44px; cursor: pointer;" onclick="selectThumbnail('{{ $post->image_url }}', this)">
                @endif
                <img src="/top_story_punjab_1784880621670.jpg" alt="Preset 1" class="rounded object-fit-cover shadow-sm thumb-pick" style="width: 64px; height: 44px; cursor: pointer;" onclick="selectThumbnail('/top_story_punjab_1784880621670.jpg', this)">
                <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=600&auto=format&fit=crop&q=80" alt="Preset 2" class="rounded object-fit-cover shadow-sm thumb-pick" style="width: 64px; height: 44px; cursor: pointer;" onclick="selectThumbnail('https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=600&auto=format&fit=crop&q=80', this)">
            </div>
        </div>

        <!-- CARD 3: MEDIA GALLERY (OPTIONAL) -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-blue">
                        <i data-lucide="images" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">Media Gallery <span class="text-muted font-normal" style="font-size: 13px; font-weight: normal;">(Optional)</span></div>
                    </div>
                </div>
            </div>

            <!-- Upload Zone -->
            <div class="upload-zone-dashed mb-3 p-3">
                <i data-lucide="cloud-upload" style="width: 24px; height: 24px; color: #64748B;" class="mb-1"></i>
                <div class="text-muted font-xs mb-2" style="font-size: 11.5px;">Drag & drop images or videos here or</div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-sm text-white" style="background: #1769D2; border-radius: 6px; font-size: 11px; padding: 4px 10px;" onclick="$('#post-image-file').click();">Upload Media</button>
                    <button type="button" class="btn btn-sm btn-white border shadow-sm" style="border-radius: 6px; font-size: 11px; padding: 4px 10px; color: #475569;" onclick="alert('Media library loaded.');">Browse Library</button>
                </div>
            </div>

            <!-- Gallery Thumbnails with remove ✕ and video duration tag -->
            <div class="d-flex align-items-center gap-2 mb-2" id="gallery-preview-strip">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&auto=format&fit=crop&q=80" class="rounded object-fit-cover" style="width: 60px; height: 50px;">
                    <span class="position-absolute top-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; font-size: 9px; cursor: pointer; transform: translate(30%, -30%);" onclick="$(this).parent().remove();">&times;</span>
                </div>
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=120&auto=format&fit=crop&q=80" class="rounded object-fit-cover" style="width: 60px; height: 50px;">
                    <span class="position-absolute top-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; font-size: 9px; cursor: pointer; transform: translate(30%, -30%);" onclick="$(this).parent().remove();">&times;</span>
                </div>
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=120&auto=format&fit=crop&q=80" class="rounded object-fit-cover" style="width: 60px; height: 50px;">
                    <span class="position-absolute bottom-0 end-0 bg-dark text-white font-xxs px-1 rounded" style="font-size: 9px; margin: 2px;">01:24</span>
                    <span class="position-absolute top-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; font-size: 9px; cursor: pointer; transform: translate(30%, -30%);" onclick="$(this).parent().remove();">&times;</span>
                </div>
            </div>
            <a href="#" class="font-xs text-decoration-none d-inline-flex align-items-center" style="color: #1769D2; font-weight: 600; font-size: 12px; gap: 4px;" onclick="$('#post-image-file').click(); return false;">
                <i data-lucide="plus" style="width: 12px; height: 12px;"></i> Add more media
            </a>
        </div>

        <!-- CARD 4: SEO PREVIEW -->
        <div class="news-page-card">
            <div class="card-header-flex">
                <div class="card-header-left">
                    <div class="icon-squircle icon-squircle-green">
                        <i data-lucide="search" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <div class="card-title-main">SEO Preview</div>
                    </div>
                </div>
            </div>

            <!-- SERP Card Preview -->
            <div class="serp-card mb-3">
                <div id="serp-preview-title" class="text-truncate" style="color: #1A0DAB; font-size: 14.5px; font-weight: 600; line-height: 1.3;">
                    {{ $post->meta_title ?: $post->title }}
                </div>
                <div id="serp-preview-url" class="text-truncate text-muted my-1" style="color: #0F5132; font-size: 11px;">
                    https://aakshnews.com/news/{{ $post->slug ?: $post->id }}
                </div>
                <div id="serp-preview-desc" class="text-muted" style="font-size: 11.5px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $post->meta_desc ?: Str::limit(strip_tags($post->content), 120) }}
                </div>
            </div>

            <!-- Meta Title -->
            <div class="mb-3">
                <label class="font-xs text-dark mb-1" style="font-weight: 600;">Meta Title</label>
                <input type="text" name="meta_title" id="post-meta-title" class="form-control form-control-modern w-100 font-xs" value="{{ $post->meta_title }}" placeholder="Enter SEO title..." maxlength="60">
                <div class="d-flex justify-content-end mt-1">
                    <span class="text-muted" style="font-size: 10.5px;" id="meta-title-count">0/60</span>
                </div>
            </div>

            <!-- Meta Description -->
            <div class="mb-2">
                <label class="font-xs text-dark mb-1" style="font-weight: 600;">Meta Description</label>
                <textarea name="meta_desc" id="post-meta-desc" class="form-control form-control-modern w-100 font-xs" rows="3" placeholder="Enter SEO description..." maxlength="160">{{ $post->meta_desc }}</textarea>
                <div class="d-flex justify-content-end mt-1">
                    <span class="text-muted" style="font-size: 10.5px;" id="meta-desc-count">0/160</span>
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="d-flex flex-column gap-2">
            <div class="row g-2">
                <div class="col-6">
                    <button type="button" class="btn btn-white border w-100 bg-white shadow-sm d-inline-flex align-items-center justify-content-center" id="btn-save-draft" style="border-radius: 10px; font-weight: 600; font-size: 13px; padding: 10px; gap: 6px; color: #334155;">
                        <i data-lucide="bookmark" style="width: 14px; height: 14px;"></i> Save as Draft
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-white border w-100 bg-white shadow-sm d-inline-flex align-items-center justify-content-center" id="btn-preview-article" style="border-radius: 10px; font-weight: 600; font-size: 13px; padding: 10px; gap: 6px; color: #334155;">
                        <i data-lucide="eye" style="width: 14px; height: 14px;"></i> Preview
                    </button>
                </div>
            </div>

            <button type="submit" class="btn w-100 d-inline-flex align-items-center justify-content-center shadow-sm btn-publish-yellow" style="background-color: #FFC400; color: #062B63; border: 1.5px solid #F5A900; border-radius: 12px; font-weight: 800; font-size: 15px; padding: 13px; gap: 8px;">
                <i data-lucide="save" style="width: 17px; height: 17px; color: #062B63;"></i> Save Changes
            </button>
        </div>

    </div>
</form>

<!-- MODAL: REAL NEWS IMAGE FINDER -->
<div class="modal fade" id="modal-real-image-finder" tabindex="-1" aria-labelledby="realImageFinderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-2xl" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom py-3 px-4" style="background: #F8FAFC;">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #EBF3FC; color: #1769D2;">
                        <i data-lucide="globe" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" id="realImageFinderLabel" style="font-size: 16px;">
                            Find Real News Image <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-xxs px-2 py-0.5 rounded-pill ms-1" style="font-size: 11px;">Real Press Photos</span>
                        </h5>
                        <div class="text-muted font-xxs" style="font-size: 12px;">Search authentic news photographs from media archives matching your story</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background: #FFFFFF;">
                <!-- Search Box -->
                <div class="mb-3">
                    <div class="input-group input-group-lg shadow-sm" style="border-radius: 10px; overflow: hidden; border: 1.5px solid #CBD5E1;">
                        <span class="input-group-text bg-white border-0 text-muted ps-3">
                            <i data-lucide="search" style="width: 18px; height: 18px; color: #64748B;"></i>
                        </span>
                        <input type="text" id="real-image-query" class="form-control border-0 font-sm py-2.5" placeholder="Enter headline, politician name, city or event (e.g. Bhagwant Mann, Harpal Cheema, Punjab Budget)...">
                        <button class="btn btn-primary px-4 font-sm font-weight-bold d-inline-flex align-items-center gap-2" type="button" id="btn-search-real-images" style="background: #1769D2;">
                            <span id="search-btn-spinner" class="d-none"><i data-lucide="loader-2" class="lucide-spin" style="width: 14px; height: 14px;"></i></span>
                            <span id="search-btn-text">Search Photos</span>
                        </button>
                    </div>
                </div>

                <!-- Quick Keywords / Entity Suggestion Pills -->
                <div class="d-flex align-items-center gap-2 flex-wrap mb-3" id="quick-keywords-container">
                    <span class="font-xxs text-muted fw-bold me-1" style="font-size: 11px;">Quick Topics:</span>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="ਭਗਵੰਤ ਮਾਨ">CM Bhagwant Mann</button>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="ਹਰਪਾਲ ਚੀਮਾ">Harpal Cheema</button>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="ਪੰਜਾਬ ਕੈਬਨਿਟ">Punjab Cabinet</button>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="ਪੰਜਾਬ ਪੁਲਿਸ">Punjab Police</button>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="ਪੰਜਾਬ ਬਜਟ 2026">Punjab Budget</button>
                    <button type="button" class="btn btn-xs btn-light border py-1 px-2.5 rounded-pill quick-search-pill font-xxs" data-keyword="Punjab News Breaking">Punjab Breaking</button>
                </div>

                <!-- Status Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
                    <div class="font-xs text-muted" id="real-images-status-text">
                        Showing news photographs for: <strong class="text-dark" id="current-search-term-display">-</strong>
                    </div>
                    <div class="font-xxs text-muted">
                        Click any image to automatically download & set as featured
                    </div>
                </div>

                <!-- Loading State Skeleton -->
                <div id="real-images-skeleton" class="d-none">
                    <div class="row g-3">
                        @for ($i = 0; $i < 6; $i++)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card border rounded-3 overflow-hidden shadow-sm h-100">
                                <div class="bg-secondary-subtle" style="height: 150px; animation: pulse 1.5s infinite;"></div>
                                <div class="p-2.5">
                                    <div class="bg-secondary-subtle rounded mb-2" style="height: 12px; width: 85%;"></div>
                                    <div class="bg-secondary-subtle rounded" style="height: 10px; width: 45%;"></div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Results Grid -->
                <div id="real-images-grid" class="row g-3">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Empty State -->
                <div id="real-images-empty" class="text-center py-5 d-none">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-2" style="background: #F1F5F9; color: #94A3B8;">
                        <i data-lucide="image-off" style="width: 32px; height: 32px;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">No photographs found</h6>
                    <p class="text-muted font-xs mb-3">Try searching with a shorter name, leader or department (e.g. "Bhagwant Mann" or "Punjab Police").</p>
                </div>
            </div>

            <div class="modal-footer py-2.5 px-4 bg-light d-flex justify-content-between align-items-center">
                <div class="font-xxs text-muted d-flex align-items-center gap-1.5" style="font-size: 11.5px;">
                    <i data-lucide="shield-check" style="width: 14px; height: 14px; color: #16A34A;"></i>
                    Photos are automatically downloaded & saved locally on your server for fast, permanent loading.
                </div>
                <button type="button" class="btn btn-sm btn-secondary font-xs px-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global helper to select thumbnails
    function selectThumbnail(url, el) {
        $('#post-image-url').val(url).trigger('input');
        $('.thumb-pick').removeClass('border border-primary');
        if (el) $(el).addClass('border border-primary');
    }

    // Tag remover
    function removeTag(el, tagName) {
        $(el).closest('.tag-badge-pill').remove();
        syncTagsToKeywords();
    }

    function syncTagsToKeywords() {
        var tags = [];
        $('#tags-badges-container .tag-badge-pill').each(function() {
            var text = $(this).text().replace('×', '').trim();
            if (text.startsWith('#')) text = text.substring(1);
            if (text) tags.push(text);
        });
        $('#post-meta-keywords').val(tags.join(', '));
    }

    function addSingleTag(rawTag) {
        if (!rawTag) return;
        var tag = rawTag.trim().replace(/^#+/, '');
        if (!tag) return;

        // Check duplicates (case-insensitive)
        var exists = false;
        $('#tags-badges-container .tag-badge-pill').each(function() {
            var currentText = $(this).text().replace('×', '').trim().replace(/^#+/, '');
            if (currentText.toLowerCase() === tag.toLowerCase()) {
                exists = true;
                return false;
            }
        });

        if (exists) {
            if (window.showToast) window.showToast('Tag #' + tag + ' is already added.', 'info');
            return;
        }

        var safeTag = $('<div>').text(tag).html();
        var safeJsTag = tag.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
        var badgeHtml = '<span class="tag-badge-pill">#' + safeTag + ' <span class="tag-badge-remove" onclick="removeTag(this, \'' + safeJsTag + '\')">&times;</span></span> ';
        $('#tags-badges-container').append(badgeHtml);
        syncTagsToKeywords();
    }

    function processTagsInput(val) {
        if (!val) return;
        var parts = val.split(',');
        for (var i = 0; i < parts.length; i++) {
            addSingleTag(parts[i]);
        }
    }

    // Text formatting helpers for rich toolbar
    function wrapText(prefix, suffix) {
        var textarea = document.getElementById('post-content');
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selected = textarea.value.substring(start, end);
        var replacement = prefix + (selected || 'text') + suffix;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + prefix.length, start + prefix.length + (selected || 'text').length);
        updateCounters();
    }

    function insertLink() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Insert Link',
                input: 'url',
                inputPlaceholder: 'https://example.com',
                inputValue: 'https://',
                showCancelButton: true,
                confirmButtonText: 'Insert',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'modern-swal-popup',
                    confirmButton: 'modern-swal-btn-primary',
                    cancelButton: 'modern-swal-btn-cancel'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed && result.value) {
                    wrapText('[', '](' + result.value + ')');
                }
            });
        } else {
            var url = prompt('Enter the link URL:', 'https://');
            if (url) wrapText('[', '](' + url + ')');
        }
    }

    function insertVideoPrompt() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Attach Video URL',
                text: 'Enter YouTube or MP4 Video Stream URL:',
                input: 'url',
                inputValue: $('#post-video-url').val() || '',
                inputPlaceholder: 'https://www.youtube.com/watch?v=...',
                showCancelButton: true,
                confirmButtonText: 'Attach Video',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'modern-swal-popup',
                    confirmButton: 'modern-swal-btn-primary',
                    cancelButton: 'modern-swal-btn-cancel'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed && result.value) {
                    $('#post-video-url').val(result.value);
                    $('#collapseAdvancedOptions').collapse('show');
                    if (window.showToast) window.showToast('Video URL attached to article.', 'success');
                }
            });
        } else {
            var url = prompt('Enter YouTube or Video URL:', $('#post-video-url').val() || '');
            if (url) {
                $('#post-video-url').val(url);
                $('#collapseAdvancedOptions').collapse('show');
                if (window.showToast) window.showToast('Video URL linked to article.', 'success');
            }
        }
    }

    function triggerImageUpload() {
        $('#post-image-file').click();
    }

    function updateCounters() {
        var title = $('#post-title').val() || '';
        $('#title-char-count').text(title.length + '/200');

        var desc = $('#post-short-desc').val() || '';
        $('#desc-char-count').text(desc.length + '/300');

        var content = $('#post-content').val() || '';
        var words = content.trim() ? content.trim().split(/\s+/).length : 0;
        $('#word-count-display').text('Words: ' + words);

        var metaTitle = $('#post-meta-title').val() || '';
        $('#meta-title-count').text(metaTitle.length + '/60');

        var metaDesc = $('#post-meta-desc').val() || '';
        $('#meta-desc-count').text(metaDesc.length + '/160');

        // Update SERP Mockup Live
        $('#serp-preview-title').text(metaTitle || title || 'News Article Title');
        $('#serp-preview-desc').text(metaDesc || desc || 'News article description snippet...');
    }

    $(document).ready(function() {
        // Setup CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize counters & SERP
        updateCounters();
        $('#post-title, #post-short-desc, #post-content, #post-meta-title, #post-meta-desc').on('input', updateCounters);

        // Language Switcher Tabs
        $('.lang-tab-btn[data-lang]').on('click', function() {
            var lang = $(this).data('lang');
            $('.lang-tab-btn').removeClass('active');
            $(this).addClass('active');

            $('.lang-pane').addClass('d-none');
            $('#lang-pane-' + lang).removeClass('d-none');
        });

        // Reliable Accordion toggle for Advanced Options & Related Content
        $('[data-bs-toggle="collapse"]').on('click', function() {
            var target = $(this).attr('data-bs-target');
            if (target && $(target).length) {
                var $chevron = $(this).find('[data-lucide="chevron-down"]');
                setTimeout(function() {
                    var isShown = $(target).hasClass('show');
                    $chevron.css({
                        'transform': isShown ? 'rotate(180deg)' : 'rotate(0deg)',
                        'transition': 'transform 0.25s ease'
                    });
                }, 150);
            }
        });

        // Tags Input Handler: Enter (13), Comma (188 or ','), Tab (9)
        $('#tag-input-field').on('keydown', function(e) {
            var key = e.which || e.keyCode;
            var val = $(this).val();

            // 1. Enter Key
            if (key === 13) {
                e.preventDefault();
                if (val.trim()) {
                    processTagsInput(val);
                    $(this).val('');
                }
                return false;
            }

            // 2. Tab Key
            if (key === 9) {
                if (val.trim()) {
                    e.preventDefault();
                    processTagsInput(val);
                    $(this).val('');
                    return false;
                }
                // Allow natural Tab navigation if field is blank
            }

            // 3. Comma Key
            if (key === 188 || e.key === ',') {
                e.preventDefault();
                if (val.trim()) {
                    processTagsInput(val);
                    $(this).val('');
                }
                return false;
            }
        });

        // Also handle Paste event for comma-separated tags
        $('#tag-input-field').on('paste', function(e) {
            var pastedText = (e.originalEvent || e).clipboardData ? (e.originalEvent || e).clipboardData.getData('text/plain') : '';
            if (pastedText && pastedText.indexOf(',') !== -1) {
                e.preventDefault();
                processTagsInput(pastedText);
                $(this).val('');
            }
        });

        // 1. AI Suggest Title
        $('#btn-ai-suggest-title').on('click', function() {
            var $btn = $(this);
            var originalHtml = $btn.html();
            var currentTitle = $('#post-title').val();
            var category = $('#post-category').val();
            var content = $('#post-content').val();

            $btn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:13px;height:13px;"></i> Suggesting...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();

            $.post('/api/ai-suggest-title', { title: currentTitle, category: category, content: content })
             .done(function(res) {
                 if (res.success && res.titles && res.titles.length > 0) {
                     var currentIdx = $btn.data('suggest-idx') || 0;
                     var picked = res.titles[currentIdx % res.titles.length];
                     $('#post-title').val(picked).focus();
                     $btn.data('suggest-idx', currentIdx + 1);
                     updateCounters();
                 } else {
                     alert('No title suggestions returned.');
                 }
             })
             .fail(function() {
                 alert('Unable to contact AI suggestion service.');
             })
             .always(function() {
                 $btn.html(originalHtml).prop('disabled', false);
                 if (window.lucide) lucide.createIcons();
             });
        });

        // 2. AI Description Generation
        $('#btn-ai-desc').on('click', function() {
            var title = $('#post-title').val();
            if (!title) {
                alert('Please enter a title first to generate AI description.');
                return;
            }
            var $btn = $(this);
            var originalHtml = $btn.html();
            $btn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:13px;height:13px;"></i> Generating...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();
            
            $.post('/api/generate-description', { title: title })
             .done(function(res) {
                 if (res.success) {
                     $('#post-short-desc').val(res.description);
                     updateCounters();
                 } else {
                     alert('Error generating content: ' + res.message);
                 }
             })
             .fail(function() {
                 alert('Unable to contact server.');
             })
             .always(function() {
                 $btn.html(originalHtml).prop('disabled', false);
                 if (window.lucide) lucide.createIcons();
             });
        });

        // 3. AI Assistant Actions (Improve, Fix Grammar, Summarize)
        function runAiAssistantAction(action, btnSelector) {
            var content = $('#post-content').val();
            if (!content || !content.trim()) {
                alert('Please write or generate some content first.');
                return;
            }
            var $btn = $(btnSelector);
            var originalHtml = $btn.html();
            $btn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:12px;height:12px;"></i> Working...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();

            $.post('/api/ai-assistant', { action: action, content: content })
             .done(function(res) {
                 if (res.success && res.result) {
                     $('#post-content').val(res.result).focus();
                     updateCounters();
                 } else {
                     alert(res.message || 'Error processing content.');
                 }
             })
             .fail(function() {
                 alert('Failed to run AI assistant action.');
             })
             .always(function() {
                 $btn.html(originalHtml).prop('disabled', false);
                 if (window.lucide) lucide.createIcons();
             });
        }

        $('#btn-ai-improve').on('click', function() { runAiAssistantAction('improve', this); });
        $('#btn-ai-grammar').on('click', function() { runAiAssistantAction('grammar', this); });
        $('#btn-ai-summarize').on('click', function() { runAiAssistantAction('summarize', this); });
        $('#btn-ai-translate-quick').on('click', function() {
            $('#btn-auto-translate').click();
        });

        // Live Script Detector for Title
        $('#post-title').on('input', function() {
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
        if ($('#post-title').val()) {
            $('#post-title').trigger('input');
        }

        // Quick Translate Button Hook
        $('#btn-quick-translate-all').on('click', function() {
            $('#btn-auto-translate').click();
            $('html, body').animate({
                scrollTop: $("#multilingual-hub-card").offset().top - 100
            }, 400);
        });

        // Function to translate specific single edition
        window.translateSpecificField = function(targetLang) {
            var title = $('#post-title').val();
            var content = $('#post-content').val() || $('#post-short-desc').val();
            if (!title && !content) {
                alert('Please enter a Title or Content first.');
                return;
            }

            var targetGtx = (targetLang === 'pb' || targetLang === 'pa') ? 'pa' : targetLang;
            var targetFieldTitle = '#post-title-' + (targetLang === 'pa' ? 'pb' : targetLang);
            var targetFieldContent = '#post-content-' + (targetLang === 'pa' ? 'pb' : targetLang);
            var badgeId = '#badge-status-' + (targetLang === 'pa' ? 'pb' : targetLang);

            $(badgeId).text('Translating...').removeClass('bg-light').addClass('bg-warning text-dark');

            var p1 = title ? $.post('/api/translate', { text: title, target: targetGtx }).done(function(res) {
                if (res.success) $(targetFieldTitle).val(res.translated);
            }) : Promise.resolve();

            var p2 = content ? $.post('/api/translate', { text: content, target: targetGtx }).done(function(res) {
                if (res.success) $(targetFieldContent).val(res.translated);
            }) : Promise.resolve();

            $.when(p1, p2).always(function() {
                $(badgeId).text('Updated').removeClass('bg-warning text-dark').addClass('bg-success text-white');
                setTimeout(function() {
                    $(badgeId).text('Synced').removeClass('bg-success text-white').addClass('bg-light text-muted');
                }, 3000);
            });
        };

        // 4. Multilingual Auto-Translate All
        $('#btn-auto-translate').on('click', function() {
            var title = $('#post-title').val();
            var content = $('#post-content').val() || $('#post-short-desc').val();

            if (!title && !content) {
                alert('Please fill in Title or Content to translate.');
                return;
            }

            var $btn = $(this);
            var originalHtml = $btn.html();
            $btn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:13px;height:13px;"></i> Translating to all languages...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();

            $('#badge-status-en, #badge-status-hi, #badge-status-pb').text('Translating...').removeClass('bg-light text-muted').addClass('bg-warning text-dark');

            var promises = [];

            // English
            if (title) {
                promises.push(
                    $.post('/api/translate', { text: title, target: 'en' }).done(function(res) {
                        if (res.success) $('#post-title-en').val(res.translated);
                    })
                );
            }
            if (content) {
                promises.push(
                    $.post('/api/translate', { text: content, target: 'en' }).done(function(res) {
                        if (res.success) $('#post-content-en').val(res.translated);
                    })
                );
            }

            // Hindi
            if (title) {
                promises.push(
                    $.post('/api/translate', { text: title, target: 'hi' }).done(function(res) {
                        if (res.success) $('#post-title-hi').val(res.translated);
                    })
                );
            }
            if (content) {
                promises.push(
                    $.post('/api/translate', { text: content, target: 'hi' }).done(function(res) {
                        if (res.success) $('#post-content-hi').val(res.translated);
                    })
                );
            }

            // Punjabi
            if (title) {
                promises.push(
                    $.post('/api/translate', { text: title, target: 'pa' }).done(function(res) {
                        if (res.success) $('#post-title-pb').val(res.translated);
                    })
                );
            }
            if (content) {
                promises.push(
                    $.post('/api/translate', { text: content, target: 'pa' }).done(function(res) {
                        if (res.success) $('#post-content-pb').val(res.translated);
                    })
                );
            }

            $.when.apply($, promises).always(function() {
                $btn.html(originalHtml).prop('disabled', false);
                if (window.lucide) lucide.createIcons();
                $('#badge-status-en, #badge-status-hi, #badge-status-pb').text('Auto-Generated (Editable)').removeClass('bg-warning text-dark').addClass('bg-success text-white');
                setTimeout(function() {
                    $('#badge-status-en, #badge-status-hi, #badge-status-pb').text('Ready').removeClass('bg-success text-white').addClass('bg-light text-dark');
                }, 4000);
            });
        });

        // 5. Featured Image Preview & Real Image Finder
        function updateFeaturedImagePreview(url) {
            if (url && url.trim() !== '') {
                $('#featured-image-preview-img').attr('src', url.trim());
                $('#featured-image-preview-container').slideDown(150);
            } else {
                $('#featured-image-preview-img').attr('src', '');
                $('#featured-image-preview-container').slideUp(150);
            }
        }

        $('#post-image-url').on('input change', function() {
            updateFeaturedImagePreview($(this).val());
        });

        $('#btn-remove-featured-image').on('click', function() {
            $('#post-image-url').val('').trigger('input');
            $('.thumb-pick').removeClass('border border-primary');
        });

        if ($('#post-image-url').val()) {
            updateFeaturedImagePreview($('#post-image-url').val());
        }

        // Open Real Image Finder Modal
        $('#btn-find-real-image').on('click', function() {
            var title = $('#post-title').val() ? $('#post-title').val().trim() : '';
            var searchInit = title || 'Punjab News';
            $('#real-image-query').val(searchInit);

            // Move modal to body to avoid container stacking context traps
            if ($('#modal-real-image-finder').parent()[0] !== document.body) {
                $('body').append($('#modal-real-image-finder'));
            }

            var modalEl = document.getElementById('modal-real-image-finder');
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var inst = bootstrap.Modal.getOrCreateInstance(modalEl);
                inst.show();
            } else {
                $('#modal-real-image-finder').modal('show');
            }
            executeRealImageSearch(searchInit);
        });

        $('#btn-search-real-images').on('click', function() {
            var q = $('#real-image-query').val().trim();
            if (q) executeRealImageSearch(q);
        });

        $('#real-image-query').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                var q = $(this).val().trim();
                if (q) executeRealImageSearch(q);
            }
        });

        $('.quick-search-pill').on('click', function() {
            var keyword = $(this).data('keyword');
            $('#real-image-query').val(keyword);
            $('.quick-search-pill').removeClass('active');
            $(this).addClass('active');
            executeRealImageSearch(keyword);
        });

        function executeRealImageSearch(query) {
            $('#current-search-term-display').text(query);
            $('#real-images-skeleton').removeClass('d-none');
            $('#real-images-grid').addClass('d-none').empty();
            $('#real-images-empty').addClass('d-none');
            $('#search-btn-spinner').removeClass('d-none');
            $('#search-btn-text').text('Searching...');
            $('#btn-search-real-images').prop('disabled', true);

            $.post('/api/search-real-images', { query: query })
             .done(function(res) {
                 if (res.success && res.images && res.images.length > 0) {
                     var html = '';
                     res.images.forEach(function(item) {
                         var safeTitle = $('<div>').text(item.title || 'News Photograph').html();
                         var safeDomain = $('<div>').text(item.domain || 'Media').html();
                         var imgUrl = item.thumb || item.url;

                         html += `
                         <div class="col-12 col-sm-6 col-md-4">
                             <div class="real-image-card h-100" data-img-url="${item.url}" title="Click to select this photograph">
                                 <div class="real-image-thumb-wrap">
                                     <img src="${imgUrl}" alt="${safeTitle}" loading="lazy" onerror="this.src='/top_story_punjab_1784880621670.jpg'">
                                     <div class="real-image-overlay">
                                         <div class="overlay-spinner d-none mb-1"><i data-lucide="loader-2" class="lucide-spin" style="width:20px;height:20px;"></i></div>
                                         <div class="overlay-text d-flex align-items-center gap-1.5"><i data-lucide="check-circle-2" style="width:16px;height:16px;color:#22C55E;"></i> Use This Photo</div>
                                     </div>
                                 </div>
                                 <div class="real-image-meta">
                                     <div class="real-image-title">${safeTitle}</div>
                                     <div class="d-flex align-items-center justify-content-between mt-auto">
                                         <span class="real-image-badge-domain">${safeDomain}</span>
                                         <a href="${item.page_url || '#'}" target="_blank" onclick="event.stopPropagation();" class="text-muted font-xxs text-decoration-none" title="View Source Article" style="font-size:11px;">
                                             <i data-lucide="external-link" style="width:12px;height:12px;"></i>
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         </div>`;
                     });
                     $('#real-images-grid').html(html).removeClass('d-none');
                     if (window.lucide) lucide.createIcons();
                     attachCardSelectionHandler();
                 } else {
                     $('#real-images-empty').removeClass('d-none');
                 }
             })
             .fail(function() {
                 $('#real-images-empty').removeClass('d-none');
             })
             .always(function() {
                 $('#real-images-skeleton').addClass('d-none');
                 $('#search-btn-spinner').addClass('d-none');
                 $('#search-btn-text').text('Search Photos');
                 $('#btn-search-real-images').prop('disabled', false);
             });
        }

        function closeRealImageModal() {
            var modalEl = document.getElementById('modal-real-image-finder');
            if (modalEl) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    try {
                        var inst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
                        if (inst) inst.hide();
                    } catch(e) {}
                }
                $(modalEl).removeClass('show').css('display', 'none').attr('aria-hidden', 'true');
            }
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
        }

        function attachCardSelectionHandler() {
            $('.real-image-card').off('click').on('click', function() {
                var $card = $(this);
                var selectedUrl = $card.data('img-url');
                if (!selectedUrl) return;

                // Show downloading state
                $card.addClass('is-saving');
                $card.find('.overlay-spinner').removeClass('d-none');
                $card.find('.overlay-text').html('Downloading to server...');
                if (window.lucide) lucide.createIcons();

                $.post('/api/save-remote-image', { image_url: selectedUrl })
                 .done(function(res) {
                     var finalUrl = (res.success && res.local_url) ? res.local_url : selectedUrl;
                     $('#post-image-url').val(finalUrl).trigger('input');
                     if (typeof updateFeaturedImagePreview === 'function') {
                         updateFeaturedImagePreview(finalUrl);
                     }

                     // Prepend to presets row
                     var newThumb = $(`<img src="${finalUrl}" alt="Selected Real Photo" class="rounded object-fit-cover shadow-sm thumb-pick border border-primary" style="width: 64px; height: 44px; cursor: pointer;">`);
                     newThumb.on('click', function() {
                         selectThumbnail(finalUrl, this);
                     });
                     $('.thumb-pick').removeClass('border border-primary');
                     $('#preset-thumbnails-row').prepend(newThumb);

                     closeRealImageModal();
                     if (window.showToast) window.showToast('Photo selected and set as featured!', 'success');
                 })
                 .fail(function() {
                     // Fallback to direct URL if server download encounters an issue
                     $('#post-image-url').val(selectedUrl).trigger('input');
                     if (typeof updateFeaturedImagePreview === 'function') {
                         updateFeaturedImagePreview(selectedUrl);
                     }
                     closeRealImageModal();
                     if (window.showToast) window.showToast('Photo selected and set as featured!', 'success');
                 });
            });
        }

        // 6. Image File Upload
        $('#post-image-file').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            var formData = new FormData();
            formData.append('image', file);

            var $status = $('#upload-status');
            $status.removeClass('d-none');

            $.ajax({
                url: '/api/admin/upload-image',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.success) {
                        $('#post-image-url').val(res.url);
                        var newThumbHtml = '<div class="position-relative">' +
                            '<img src="' + res.url + '" class="rounded object-fit-cover" style="width: 60px; height: 50px;">' +
                            '<span class="position-absolute top-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; font-size: 9px; cursor: pointer; transform: translate(30%, -30%);" onclick="$(this).parent().remove();">&times;</span>' +
                            '</div>';
                        $('#gallery-preview-strip').prepend(newThumbHtml);
                    } else {
                        alert('Upload error: ' + res.message);
                    }
                },
                error: function() {
                    alert('Failed to upload file.');
                },
                complete: function() {
                    $status.addClass('d-none');
                }
            });
        });

        // 7. Save as Draft Handler
        $('#btn-save-draft').on('click', function() {
            $('#post-status').val('draft');
            $('#post-edit-form').submit();
        });

        // 8. Preview Handler
        $('#btn-preview-article').on('click', function() {
            var title = $('#post-title').val() || 'Preview News';
            var content = $('#post-content').val() || $('#post-short-desc').val() || 'News content preview...';
            var previewWin = window.open('', '_blank');
            previewWin.document.write('<html><head><title>' + title + '</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head><body class="p-5"><div class="container" style="max-width:800px;"><h1>' + title + '</h1><hr><div class="lead">' + content + '</div></div></body></html>');
        });

        // 9. Main Form Submit (Update Article)
        $('#post-edit-form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#post-id').val();
            
            var payload = {
                title: $('#post-title').val(),
                category: $('#post-category').val(),
                author_name: $('#post-author').val(),
                source: $('#post-source').val(),
                short_description: $('#post-short-desc').val(),
                content: $('#post-content').val() || $('#post-short-desc').val(),
                video_url: $('#post-video-url').val(),
                image_url: $('#post-image-url').val(),
                duration: $('#post-duration').val(),
                views_count: $('#post-views').val(),
                status: $('#post-status').val(),
                is_hero: $('#post-is-hero').is(':checked') ? 1 : 0,
                is_breaking: $('#post-is-breaking').is(':checked') ? 1 : 0,
                allow_comments: $('#post-allow-comments').is(':checked') ? 1 : 0,
                is_locked: $('#post-is-locked').is(':checked') ? 1 : 0,
                is_middle_stack: $('#post-is-middle-stack').is(':checked') ? 1 : 0,
                is_reel: $('#post-is-reel').is(':checked') ? 1 : 0,
                send_push_notification: $('#post-send-push').is(':checked') ? 1 : 0,
                media_type: $('#post-is-reel').is(':checked') ? 'reel' : ($('#post-video-url').val() ? 'video' : 'image'),
                is_admin_post: 1,
                title_en: $('#post-title-en').val(),
                title_hi: $('#post-title-hi').val(),
                title_pb: $('#post-title-pb').val(),
                content_en: $('#post-content-en').val(),
                content_hi: $('#post-content-hi').val(),
                content_pb: $('#post-content-pb').val(),
                meta_title: $('#post-meta-title').val() || $('#post-title').val(),
                meta_desc: $('#post-meta-desc').val() || $('#post-short-desc').val(),
                meta_keywords: $('#post-meta-keywords').val()
            };

            var $submitBtn = $(this).find('button[type="submit"]');
            var origSubmitHtml = $submitBtn.html();
            $submitBtn.html('<i data-lucide="loader-2" class="lucide-spin" style="width:17px;height:17px;"></i> Saving...').prop('disabled', true);
            if (window.lucide) lucide.createIcons();

            $.post('/api/posts/' + id + '/update', payload)
             .done(function(res) {
                 if (res.success) {
                     alert('Article updated successfully!');
                     window.location.href = '/admin/post';
                 } else {
                     alert('Notice: ' + res.message);
                 }
             })
             .fail(function(xhr) {
                 var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to update article.';
                 alert(msg);
             })
             .always(function() {
                 $submitBtn.html(origSubmitHtml).prop('disabled', false);
                 if (window.lucide) lucide.createIcons();
             });
        });
    });
</script>
@endsection
