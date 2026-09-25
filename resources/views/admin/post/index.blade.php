@extends('admin.layouts.app')

@section('content')
<style>
    /* ============================================================== */
    /* 2026 AAKSH NEWS 24 EDITORIAL CMS POST LIST WORKSPACE           */
    /* ============================================================== */
    :root {
        --cms-primary: #1769D2;
        --cms-primary-hover: #0D56B5;
        --cms-primary-subtle: #EBF3FC;
        --cms-secondary-purple: #1557A6;
        --cms-text-main: #0F172A;
        --cms-text-muted: #64748B;
        --cms-text-light: #94A3B8;
        --cms-border: #E2E8F0;
        --cms-bg-canvas: #F8FAFC;
        --cms-card-bg: #FFFFFF;
        --cms-success: #10B981;
        --cms-warning: #F59E0B;
        --cms-breaking: #EF4444;
        --cms-scheduled: #1769D2;
    }

    .newsroom-wrap {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        color: var(--cms-text-main);
        padding-bottom: 32px;
    }

    /* 1. Header Badges & Buttons */
    .nr-header-badge {
        background-color: var(--cms-primary);
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 700;
        border-radius: 999px;
        padding: 2px 10px;
        margin-left: 8px;
        display: inline-flex;
        align-items: center;
        vertical-align: middle;
    }

    /* 2. Stat Mini Cards */
    .nr-stat-card {
        background: #FFFFFF;
        border: 1px solid var(--cms-border);
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: all 0.2s ease;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .nr-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
        border-color: #CBD5E1;
    }
    .nr-stat-icon-sq {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .nr-stat-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--cms-text-muted);
        line-height: 1.2;
        margin-bottom: 3px;
    }
    .nr-stat-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--cms-text-main);
        line-height: 1;
        letter-spacing: -0.5px;
    }

    /* 3. Search + Filter Bar */
    .nr-filter-bar {
        background: #FFFFFF;
        border: 1px solid var(--cms-border);
        border-radius: 14px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .nr-filter-control {
        height: 42px;
        border: 1px solid var(--cms-border);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        color: var(--cms-text-main);
        background-color: #FFFFFF;
        outline: none;
        transition: all 0.15s ease;
    }
    .nr-filter-control:focus {
        border-color: var(--cms-primary);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }

    /* 4. Category Pills */
    .nr-cat-pills-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 2px 0;
    }
    .nr-cat-pills-wrap::-webkit-scrollbar {
        display: none;
    }
    .nr-cat-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        color: var(--cms-text-muted);
        background: #FFFFFF;
        border: 1px solid var(--cms-border);
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .nr-cat-pill-btn:hover {
        background: #F1F5F9;
        color: var(--cms-text-main);
        border-color: #CBD5E1;
    }
    .nr-cat-pill-btn.active {
        background: var(--cms-primary);
        color: #FFFFFF;
        border-color: var(--cms-primary);
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(124, 58, 237, 0.3);
    }
    .nr-cat-pill-btn.active .cat-dot-indicator {
        background-color: #FFFFFF !important;
    }
    .cat-dot-indicator {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* 5. Main Post Card */
    .nr-post-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 20px;
        min-height: 134px;
        position: relative;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
    }
    .nr-post-card:hover {
        border-color: #CBD5E1;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.03);
    }
    .nr-post-card.nr-card-featured {
        border: 1.5px solid #FCD34D;
        background: linear-gradient(to right, #FFFDF5, #FFFFFF 25%);
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.08);
    }
    .nr-post-card.nr-card-featured:hover {
        border-color: #F59E0B;
        box-shadow: 0 10px 28px rgba(245, 158, 11, 0.14);
    }
    .nr-post-card.is-selected {
        border-color: var(--cms-primary);
        background: #FAF5FF;
        box-shadow: inset 4px 0 0 var(--cms-primary), 0 4px 12px rgba(124, 58, 237, 0.08);
    }

    /* Lead Selector (Row number & Checkbox) */
    .nr-lead-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 38px;
        flex-shrink: 0;
    }
    .nr-lead-idx {
        font-size: 11px;
        font-weight: 800;
        color: #64748B;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 2.5px 6px;
        letter-spacing: -0.2px;
        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        line-height: 1;
    }
    .nr-lead-cell .article-checkbox {
        width: 19px;
        height: 19px;
        border-radius: 6px;
        border: 1.5px solid #CBD5E1;
        margin: 0;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .nr-lead-cell .article-checkbox:checked {
        background-color: var(--cms-primary);
        border-color: var(--cms-primary);
    }

    /* Post Image Container */
    .nr-post-thumb-wrap {
        width: 168px;
        height: 104px;
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        background: #0F172A;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.06);
    }
    .nr-post-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .nr-post-card:hover .nr-post-thumb-wrap img {
        transform: scale(1.05);
    }

    /* Overlay Badges on Image */
    .nr-img-badge-featured {
        background: rgba(254, 243, 199, 0.95);
        backdrop-filter: blur(4px);
        color: #92400E;
        font-size: 10px;
        font-weight: 700;
        padding: 2.5px 8px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .nr-img-badge-breaking {
        background: rgba(239, 68, 68, 0.95);
        backdrop-filter: blur(4px);
        color: #FFFFFF;
        font-size: 10px;
        font-weight: 700;
        padding: 2.5px 8px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .nr-img-media-tag {
        position: absolute;
        bottom: 7px;
        right: 7px;
        background: rgba(15, 23, 42, 0.76);
        backdrop-filter: blur(4px);
        color: #FFFFFF;
        width: 24px;
        height: 24px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Center Content Details */
    .nr-post-content {
        flex: 1 1 0;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 7px;
    }
    .nr-badges-cluster {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 1px;
    }
    .nr-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1E293B;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        padding: 3px 10px;
        border-radius: 999px;
    }
    .nr-status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .nr-badge-tag {
        font-size: 11px;
        font-weight: 700;
        padding: 2.5px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .tag-featured {
        background: #FEF3C7;
        color: #B45309;
    }
    .tag-breaking {
        background: #FEE2E2;
        color: #DC2626;
    }
    .nr-live-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #EF4444;
        display: inline-block;
        animation: nr-pulse 1.8s infinite;
    }
    @keyframes nr-pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .nr-headline-wrap {
        margin: 0;
        line-height: 1.4;
    }
    .nr-headline-link {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.15s ease;
        letter-spacing: -0.2px;
    }
    .nr-headline-link:hover {
        color: var(--cms-primary);
    }
    .nr-summary-snippet {
        font-size: 13px;
        color: #64748B;
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .nr-post-meta-strip {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
        flex-wrap: wrap;
        margin-top: 3px;
    }
    .nr-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5.5px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .nr-post-meta-strip i,
    .nr-meta-item i {
        width: 13.5px;
        height: 13.5px;
        color: #94A3B8;
        flex-shrink: 0;
    }
    .nr-meta-dot {
        color: #CBD5E1;
        flex-shrink: 0;
    }

    /* Right Section: Compact Performance Metrics + Actions */
    .nr-card-right-section {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;
        gap: 12px;
        flex-shrink: 0;
        padding-left: 10px;
    }

    /* Sleek Segmented Metrics Strip */
    .nr-stats-cluster {
        display: inline-flex;
        align-items: center;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 6px 14px;
        gap: 14px;
        transition: all 0.2s ease;
    }
    .nr-post-card:hover .nr-stats-cluster {
        background: #FFFFFF;
        border-color: #CBD5E1;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }
    .nr-stat-node {
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .nr-stat-node i {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }
    .nr-stat-body {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }
    .nr-stat-count {
        font-size: 13px;
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.3px;
    }
    .nr-stat-tag {
        font-size: 10px;
        font-weight: 600;
        color: #94A3B8;
        margin-top: 1px;
    }
    .nr-stat-divider {
        width: 1px;
        height: 20px;
        background-color: #E2E8F0;
    }

    /* Action Toolbar */
    .nr-btn-toolbar {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nr-btn-edit {
        background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
        color: #FFFFFF;
        height: 34px;
        padding: 0 15px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        box-shadow: 0 2px 6px rgba(124, 58, 237, 0.25);
    }
    .nr-btn-edit:hover {
        background: linear-gradient(135deg, #6D28D9 0%, #5B21B6 100%);
        color: #FFFFFF;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.35);
    }
    .nr-btn-preview {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #334155;
        height: 34px;
        padding: 0 13px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .nr-btn-preview:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: var(--cms-primary);
        transform: translateY(-1px);
    }
    .nr-btn-more {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1px solid #E2E8F0;
        color: #64748B;
        background: #FFFFFF;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.15s ease;
    }
    .nr-btn-more:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    /* Redesigned Pagination Card */
    .nr-pagination-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 14px 22px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 24px;
    }
    .nr-pagination-info-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .nr-pg-badge {
        background: #F1F5F9;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 8px;
        letter-spacing: 0.2px;
    }
    .nr-pg-text {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
    }
    .nr-pg-text strong {
        color: #0F172A;
        font-weight: 800;
    }
    .nr-pagination-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nr-pg-nav-btn {
        height: 36px;
        padding: 0 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.18s ease;
    }
    .nr-pg-nav-btn:hover:not(:disabled) {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: var(--cms-primary);
        transform: translateY(-1px);
    }
    .nr-pg-nav-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        background: #F8FAFC;
    }
    .nr-pg-nav-btn i {
        width: 15px;
        height: 15px;
    }
    .nr-pg-pages-cluster {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .nr-pg-num-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.18s ease;
    }
    .nr-pg-num-btn:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: var(--cms-primary);
    }
    .nr-pg-num-btn.active {
        background: var(--cms-primary);
        color: #FFFFFF;
        border-color: var(--cms-primary);
        font-weight: 800;
        box-shadow: 0 3px 8px rgba(124, 58, 237, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 1280px) {
        .nr-post-card {
            padding: 16px 18px;
            gap: 16px;
        }
        .nr-post-thumb-wrap {
            width: 150px;
            height: 94px;
        }
        .nr-stats-cluster {
            padding: 5px 10px;
            gap: 10px;
        }
    }
    @media (max-width: 991.98px) {
        .nr-post-card {
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .nr-card-right-section {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #F1F5F9;
            padding-top: 12px;
            margin-top: 6px;
            padding-left: 0;
        }
    }
    @media (max-width: 575.98px) {
        .nr-post-card {
            padding: 14px;
            gap: 14px;
        }
        .nr-post-thumb-wrap {
            width: 110px;
            height: 76px;
        }
        .nr-pagination-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .nr-headline-link {
            font-size: 14px;
        }
        .nr-stats-cluster {
            display: none;
        }
    }

    /* Grid View Alternative */
    .nr-grid-card {
        background: #FFFFFF;
        border: 1px solid var(--cms-border);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.2s ease;
    }
    .nr-grid-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
        border-color: #CBD5E1;
    }

    /* Floating Bulk Bar */
    #nr-bulk-floating-bar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #1E293B;
        color: #FFFFFF;
        padding: 10px 20px;
        border-radius: 999px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        gap: 14px;
        z-index: 1050;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    #nr-bulk-floating-bar.show {
        transform: translateX(-50%) translateY(0);
    }
</style>

<div class="newsroom-wrap">

    <!-- ============================================================== -->
    <!-- 1. TOP TITLE ROW                                              -->
    <!-- ============================================================== -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 pb-1">
        <div>
            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                <h3 class="mb-0" style="font-weight: 800; font-size: 26px; color: var(--cms-text-main); letter-spacing: -0.5px;">
                    News Articles
                </h3>
                <span class="nr-header-badge">{{ number_format($totalCount ?? 72) }}</span>
                <span class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #ECFDF5; border: 1px solid #A7F3D0; font-size: 11.5px; font-weight: 700; color: #047857;">
                    <span class="cat-dot-indicator" style="background-color: #10B981; width: 7px; height: 7px;"></span>
                    <span>Today: {{ $todayPublished ?? 1 }} Published</span>
                </span>
                <span class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #EFF6FF; border: 1px solid #BFDBFE; font-size: 11.5px; font-weight: 700; color: #1D4ED8;">
                    <i data-lucide="eye" style="width: 12px; height: 12px;"></i>
                    <span>{{ number_format($todayViews ?? 142800) }} Live Views</span>
                </span>
            </div>
            <p class="text-muted mb-0" style="font-size: 13px; font-weight: 500;">
                Manage, edit and organize all published and draft news articles.
            </p>
        </div>

        <div class="d-flex align-items-center flex-wrap gap-2">
            <!-- 1. Breaking Alert / Ticker Button -->
            <a href="/admin/breaking-news" class="btn d-inline-flex align-items-center gap-1.5 px-3 py-2" style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 9px; font-size: 13px; font-weight: 700; color: #DC2626;" title="Manage Breaking News Ticker">
                <i data-lucide="zap" style="width: 15px; height: 15px; fill: #DC2626;"></i>
                <span>Breaking Alert</span>
            </a>

            <!-- 2. Photo Gallery Button -->
            <a href="/admin/photo-gallery" class="btn d-inline-flex align-items-center gap-1.5 px-3 py-2" style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 9px; font-size: 13px; font-weight: 700; color: #16A34A;" title="Photo Stories and Galleries">
                <i data-lucide="camera" style="width: 15px; height: 15px;"></i>
                <span>Photo Gallery</span>
            </a>

            <!-- 3. Import Button -->
            <button type="button" class="btn d-inline-flex align-items-center gap-1.5 px-3 py-2" style="background: #FFFFFF; border: 1px solid var(--cms-border); border-radius: 9px; font-size: 13px; font-weight: 600; color: #374151;" onclick="if(window.showAlert){window.showAlert('Import Wizard', 'CSV / XML News Feed import wizard is active.', 'info');}else if(window.showToast){window.showToast('Import wizard active', 'info');}">
                <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                <span>Import</span>
            </button>

            <!-- 4. + Publish New Button -->
            <div class="btn-group">
                <a href="/admin/post/create" class="btn text-white d-inline-flex align-items-center gap-1.5 px-3.5 py-2 shadow-sm" style="background-color: var(--cms-primary); border-radius: 9px 0 0 9px; font-size: 13px; font-weight: 700; border: none;">
                    <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                    <span>Publish New</span>
                </a>
                <button type="button" class="btn text-white dropdown-toggle dropdown-toggle-split px-2" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: var(--cms-primary-hover); border-radius: 0 9px 9px 0; border: none;">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-1" style="border-radius: 10px; font-size: 13px;">
                    <li><a class="dropdown-item py-1.5" href="/admin/post/create"><i data-lucide="file-plus" class="me-2 text-slate-400" style="width: 14px; height: 14px;"></i>Standard Article</a></li>
                    <li><a class="dropdown-item py-1.5" href="/admin/breaking-news/create"><i data-lucide="zap" class="me-2 text-amber-500" style="width: 14px; height: 14px;"></i>Breaking Alert</a></li>
                    <li><a class="dropdown-item py-1.5" href="/admin/photo-gallery/create"><i data-lucide="camera" class="me-2 text-emerald-500" style="width: 14px; height: 14px;"></i>Photo Story</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- 2. ARTICLE STATISTICS: 5 COMPACT CARDS IN ONE ROW             -->
    <!-- ============================================================== -->
    <div class="row g-3 mb-3">
        <!-- 01. Total Articles -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="nr-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="nr-stat-icon-sq" style="background: #EBF3FC; color: #1769D2;">
                        <i data-lucide="newspaper" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <div class="nr-stat-label">Total Articles</div>
                        <div class="nr-stat-value">{{ number_format($totalCount ?? 72) }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge" style="background: #ECFDF5; color: #10B981; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        ↑ Active
                    </span>
                </div>
            </div>
        </div>

        <!-- 02. Published -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="nr-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="nr-stat-icon-sq" style="background: #DCFCE7; color: #16A34A;">
                        <i data-lucide="check-circle-2" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <div class="nr-stat-label">Published</div>
                        <div class="nr-stat-value text-emerald-600">{{ number_format($publishedCount ?? 70) }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge" style="background: #ECFDF5; color: #10B981; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        Live
                    </span>
                </div>
            </div>
        </div>

        <!-- 03. Live Views -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="nr-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="nr-stat-icon-sq" style="background: #EFF6FF; color: #2563EB;">
                        <i data-lucide="eye" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <div class="nr-stat-label">Live Views</div>
                        <div class="nr-stat-value text-blue-600">{{ number_format($todayViews ?? 142800) }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge" style="background: #EFF6FF; color: #2563EB; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        Today
                    </span>
                </div>
            </div>
        </div>

        <!-- 04. Breaking News -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="nr-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="nr-stat-icon-sq" style="background: #FEE2E2; color: #DC2626;">
                        <i data-lucide="zap" style="width: 22px; height: 22px; fill: #DC2626;"></i>
                    </div>
                    <div>
                        <div class="nr-stat-label">Breaking</div>
                        <div class="nr-stat-value text-rose-600">{{ number_format($breakingCount ?? 1) }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge" style="background: #FEE2E2; color: #DC2626; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        Alerts
                    </span>
                </div>
            </div>
        </div>

        <!-- 05. Drafts & Scheduled -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="nr-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="nr-stat-icon-sq" style="background: #FEF3C7; color: #D97706;">
                        <i data-lucide="clock" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <div class="nr-stat-label">Drafts & Scheduled</div>
                        <div class="nr-stat-value text-amber-600">{{ number_format(($draftCount ?? 0) + ($scheduledCount ?? 0)) }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge" style="background: #FEF3C7; color: #D97706; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        Pending
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- 3. SEARCH + FILTER BAR (ONE CLEAN HORIZONTAL CONTAINER)       -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- 3. SEARCH + FILTER BAR (ONE CLEAN HORIZONTAL CONTAINER)       -->
    <!-- ============================================================== -->
    <form id="nr-filter-form" method="GET" action="/admin/post">
        <div class="nr-filter-bar mb-3">
            <!-- Search Input -->
            <div class="d-flex align-items-center flex-grow-1" style="min-width: 220px;">
                <i data-lucide="search" style="color: var(--cms-primary); width: 18px; height: 18px; margin-left: 6px; flex-shrink: 0;"></i>
                <input type="text" name="search" id="nr-search-input" value="{{ request('search') }}" placeholder="Search articles, headlines, authors..." style="border: none; outline: none; width: 100%; height: 40px; font-size: 13.5px; padding: 0 12px; background: transparent; color: var(--cms-text-main);">
            </div>

            <!-- Vertical Divider -->
            <div class="vr d-none d-md-block" style="height: 24px; opacity: 0.15;"></div>

            <!-- All Categories -->
            <select name="category" id="nr-category-filter" class="form-select nr-filter-control" style="width: auto; min-width: 145px; padding-right: 32px;" onchange="this.form.submit()">
                <option value="all">All Categories</option>
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                @else
                    <option value="Punjab" {{ request('category') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                    <option value="Patiala" {{ request('category') == 'Patiala' ? 'selected' : '' }}>Patiala</option>
                    <option value="National" {{ request('category') == 'National' ? 'selected' : '' }}>National</option>
                    <option value="Politics" {{ request('category') == 'Politics' ? 'selected' : '' }}>Politics</option>
                    <option value="Crime" {{ request('category') == 'Crime' ? 'selected' : '' }}>Crime</option>
                    <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                    <option value="Business" {{ request('category') == 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="Technology" {{ request('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Entertainment" {{ request('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                    <option value="World" {{ request('category') == 'World' ? 'selected' : '' }}>World</option>
                    <option value="Haryana" {{ request('category') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                    <option value="Latest Update" {{ request('category') == 'Latest Update' ? 'selected' : '' }}>Latest Update</option>
                    <option value="General" {{ request('category') == 'General' ? 'selected' : '' }}>General</option>
                @endif
            </select>

            <!-- All Status -->
            <select name="status" id="nr-status-filter" class="form-select nr-filter-control" style="width: auto; min-width: 120px; padding-right: 32px;" onchange="this.form.submit()">
                <option value="all">All Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafts</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                <option value="breaking" {{ request('status') == 'breaking' ? 'selected' : '' }}>Breaking</option>
            </select>

            <!-- All Authors -->
            <select name="author" id="nr-author-filter" class="form-select nr-filter-control" style="width: auto; min-width: 130px; padding-right: 32px;" onchange="this.form.submit()">
                <option value="all">All Authors</option>
                <option value="Aaksh News Admin" {{ request('author') == 'Aaksh News Admin' ? 'selected' : '' }}>Aaksh News Admin</option>
                <option value="Aaksh News Desk" {{ request('author') == 'Aaksh News Desk' ? 'selected' : '' }}>Aaksh News Desk</option>
                @if(isset($authors))
                    @foreach($authors as $author)
                        @if($author !== 'Aaksh News Admin' && $author !== 'Aaksh News Desk')
                            <option value="{{ $author }}" {{ request('author') == $author ? 'selected' : '' }}>{{ $author }}</option>
                        @endif
                    @endforeach
                @endif
            </select>

            <!-- Date Picker -->
            <input type="date" name="date" value="{{ request('date') }}" id="nr-date-filter" class="form-control nr-filter-control" style="width: auto; min-width: 135px;" title="Filter by date" onchange="this.form.submit()">

            <!-- Submit Filter Button -->
            <button type="submit" class="btn text-white d-flex align-items-center justify-content-center" style="background: var(--cms-primary); width: 42px; height: 42px; border-radius: 10px; border: none; flex-shrink: 0;" title="Apply Filter">
                <i data-lucide="search" style="width: 17px; height: 17px;"></i>
            </button>

            <!-- Reset Button -->
            <a href="/admin/post" id="nr-reset-filter-btn" class="btn btn-light d-flex align-items-center justify-content-center text-decoration-none" style="background: #FFFFFF; border: 1px solid var(--cms-border); width: 42px; height: 42px; border-radius: 10px; color: var(--cms-text-muted); flex-shrink: 0;" title="Reset Filters">
                <i data-lucide="rotate-ccw" style="width: 16px; height: 16px;"></i>
            </a>
        </div>

        <!-- ============================================================== -->
        <!-- 4. CATEGORY PILLS + SORT & VIEW CONTROLS                      -->
        <!-- ============================================================== -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <!-- Left: Category Pills -->
            <div class="nr-cat-pills-wrap" id="nr-category-tabs">
                <a href="{{ request()->fullUrlWithQuery(['category' => 'all', 'page' => 1]) }}" class="nr-cat-pill-btn text-decoration-none {{ !request('category') || request('category') == 'all' ? 'active' : '' }}" data-category="all">
                    <span class="cat-dot-indicator" style="background-color: var(--cms-primary);"></span>
                    <span>All Articles</span>
                </a>
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        @php
                            $dotColor = $cat->color ?? '#6366F1';
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['category' => $cat->name, 'page' => 1]) }}" class="nr-cat-pill-btn text-decoration-none {{ request('category') == $cat->name ? 'active' : '' }}" data-category="{{ $cat->name }}">
                            <span class="cat-dot-indicator" style="background-color: {{ $dotColor }};"></span>
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                @else
                    @php
                        $defaultPills = [
                            ['name' => 'Punjab', 'color' => '#F59E0B'],
                            ['name' => 'Patiala', 'color' => '#E11D48'],
                            ['name' => 'National', 'color' => '#EA580C'],
                            ['name' => 'Politics', 'color' => '#2563EB'],
                            ['name' => 'Crime', 'color' => '#DC2626'],
                            ['name' => 'Sports', 'color' => '#10B981'],
                            ['name' => 'Business', 'color' => '#06B6D4'],
                            ['name' => 'Technology', 'color' => '#EC4899'],
                            ['name' => 'Entertainment', 'color' => '#D946EF'],
                            ['name' => 'World', 'color' => '#38BDF8'],
                        ];
                    @endphp
                    @foreach($defaultPills as $dp)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $dp['name'], 'page' => 1]) }}" class="nr-cat-pill-btn text-decoration-none {{ request('category') == $dp['name'] ? 'active' : '' }}" data-category="{{ $dp['name'] }}">
                            <span class="cat-dot-indicator" style="background-color: {{ $dp['color'] }};"></span>
                            <span>{{ $dp['name'] }}</span>
                        </a>
                    @endforeach
                @endif
            </div>

            <!-- Right: Sort by, Show per page, View toggle -->
            <div class="d-flex align-items-center gap-2 ms-auto">
                <div class="d-flex align-items-center gap-1.5 text-muted" style="font-size: 12px; font-weight: 600;">
                    <span>Sort by:</span>
                    <select name="sort" id="nr-sort-filter" class="form-select form-select-sm" style="height: 34px; border-radius: 8px; border: 1px solid var(--cms-border); font-size: 12px; font-weight: 600; width: 125px; padding-right: 28px;" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="alpha" {{ request('sort') == 'alpha' ? 'selected' : '' }}>Title A-Z</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-1.5 text-muted" style="font-size: 12px; font-weight: 600;">
                    <span>Show:</span>
                    <select name="per_page" id="nr-per-page-select" class="form-select form-select-sm" style="height: 34px; border-radius: 8px; border: 1px solid var(--cms-border); font-size: 12px; font-weight: 600; width: 115px; padding-right: 28px;" onchange="this.form.submit()">
                        <option value="20" {{ request('per_page', '20') == '20' ? 'selected' : '' }}>20 per page</option>
                        <option value="40" {{ request('per_page') == '40' ? 'selected' : '' }}>40 per page</option>
                        <option value="60" {{ request('per_page') == '60' ? 'selected' : '' }}>60 per page</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>

                <!-- View toggle (List vs Grid) -->
                <div class="d-flex align-items-center gap-1 bg-slate-100 p-0.5 rounded-2">
                    <button type="button" id="view-mode-list-btn" class="btn text-white p-0 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; border-radius: 8px; background: var(--cms-primary); border: none;" title="Horizontal Post Cards View">
                        <i data-lucide="list" style="width: 16px; height: 16px;"></i>
                    </button>
                    <button type="button" id="view-mode-grid-btn" class="btn btn-light p-0 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; border-radius: 8px; background: #FFFFFF; border: 1px solid var(--cms-border); color: var(--cms-text-muted);" title="Compact Grid View">
                        <i data-lucide="grid-2x2" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- ============================================================== -->
    <!-- 5. MAIN CONTENT AREA: POST CARDS + RIGHT UTILITY DESK          -->
    <!-- ============================================================== -->
    <div class="row g-3 align-items-start">
        
        <!-- MAIN POST CARDS WORKSPACE (Full Width) -->
        <div class="col-12" id="nr-articles-workspace">
            
            @php
                // Real database articles
                $combinedArticles = [];

                if (isset($posts) && count($posts) > 0) {
                    foreach ($posts as $idx => $p) {
                        $pImg = $p->image_url ?: '/images/aaksh_anchor_studio.jpg';
                        if (!str_starts_with($pImg, 'http') && !str_starts_with($pImg, '/')) {
                            $pImg = '/' . $pImg;
                        }
                        $pCat = $p->category ?: 'General';
                        $pViews = (int) ($p->views_count ?? 0);
                        $pViewsFmt = $pViews >= 1000 ? round($pViews / 1000, 1) . 'K' : (string) $pViews;
                        $pDate = $p->created_at ? (is_string($p->created_at) ? date('d M Y', strtotime($p->created_at)) : $p->created_at->format('d M Y')) : date('d M Y');
                        $pIsoDate = $p->created_at ? (is_string($p->created_at) ? date('Y-m-d', strtotime($p->created_at)) : $p->created_at->format('Y-m-d')) : date('Y-m-d');
                        $rawSummary = !empty($p->summary_content) ? $p->summary_content : (!empty($p->content) ? $p->content : '');
                        $cleanDesc = !empty($rawSummary) ? trim(strip_tags($rawSummary)) : 'No summary provided.';
                        $pDesc = $cleanDesc;
                        
                        $pDot = '#7C3AED';
                        if (stripos($pCat, 'punjab') !== false) $pDot = '#F59E0B';
                        elseif (stripos($pCat, 'sport') !== false) $pDot = '#10B981';
                        elseif (stripos($pCat, 'politic') !== false) $pDot = '#2563EB';
                        elseif (stripos($pCat, 'busi') !== false) $pDot = '#06B6D4';
                        elseif (stripos($pCat, 'tech') !== false) $pDot = '#EC4899';
                        elseif (stripos($pCat, 'enter') !== false) $pDot = '#D946EF';
                        elseif (stripos($pCat, 'world') !== false) $pDot = '#38BDF8';
                        elseif (stripos($pCat, 'astro') !== false) $pDot = '#8B5CF6';

                        $combinedArticles[] = [
                            'id' => $p->id,
                            'is_featured' => (bool)$p->is_hero,
                            'is_breaking' => (bool)$p->is_hero,
                            'category' => $pCat,
                            'dot_color' => $pDot,
                            'title' => $p->title,
                            'summary' => Str::limit($pDesc, 120),
                            'author' => $p->author_name ?? 'Aaksh News Desk',
                            'date' => $pDate,
                            'iso_date' => $pIsoDate,
                            'views' => $pViews,
                            'views_fmt' => $pViewsFmt,
                            'comments' => 0,
                            'shares_fmt' => '0',
                            'status' => strtolower($p->status ?? 'published'),
                            'image' => $pImg,
                            'has_video' => !empty($p->video_url) || !empty($p->duration),
                        ];
                    }
                }
            @endphp

            <!-- ====================================================== -->
            <!-- 5.1 HORIZONTAL POST CARDS LIST (DEFAULT)               -->
            <!-- ====================================================== -->
            @if(count($combinedArticles) > 0)
            <div class="d-flex flex-column" id="nr-list-view-container" style="gap: 18px !important;">
                @foreach($combinedArticles as $index => $item)
                    @php
                        $rowOffset = ($posts instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($posts->firstItem() ?: 1) : 1;
                        $rowNum = sprintf('%02d', $rowOffset + $index);
                        $status = strtolower($item['status'] ?? 'published');

                        // Status pill styling
                        $statusStyle = 'background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;';
                        $statusDot = '#10B981';
                        if ($status === 'scheduled') {
                            $statusStyle = 'background: #F3E8FF; color: #7C3AED; border: 1px solid #DDD6FE;';
                            $statusDot = '#7C3AED';
                        } elseif (in_array($status, ['draft', 'pending'])) {
                            $statusStyle = 'background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A;';
                            $statusDot = '#F59E0B';
                        } elseif (in_array($status, ['archived', 'rejected'])) {
                            $statusStyle = 'background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1;';
                            $statusDot = '#94A3B8';
                        }
                    @endphp

                    <div class="nr-post-card article-item-row {{ $item['is_featured'] ? 'nr-card-featured' : '' }}"
                         data-id="{{ $item['id'] }}"
                         data-category="{{ $item['category'] }}"
                         data-status="{{ $status }}"
                         data-author="{{ $item['author'] }}"
                         data-title="{{ strtolower($item['title']) }}"
                         data-views="{{ $item['views'] }}"
                         data-date="{{ $item['iso_date'] }}">
                        
                        <!-- 1. Selection & Row Number -->
                        <div class="nr-lead-cell">
                            <span class="nr-lead-idx">#{{ $rowNum }}</span>
                            <input type="checkbox" class="form-check-input article-checkbox" value="{{ $item['id'] }}" title="Select article">
                        </div>

                        <!-- 2. Post Thumbnail (160 x 96px, 16:9 ratio) -->
                        <div class="nr-post-thumb-wrap">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy" onerror="this.src='/images/aaksh_anchor_studio.jpg'">
                            
                            @if($item['is_featured'])
                                <span class="badge position-absolute top-2 start-2 nr-img-badge-featured d-inline-flex align-items-center gap-1">
                                    <i data-lucide="star" style="width: 10px; height: 10px; fill: #D97706; stroke: #D97706;"></i>
                                    <span>Featured</span>
                                </span>
                            @elseif($item['is_breaking'])
                                <span class="badge position-absolute top-2 start-2 nr-img-badge-breaking d-inline-flex align-items-center gap-1">
                                    <span class="rounded-circle bg-white" style="width: 5px; height: 5px; display: inline-block;"></span>
                                    <span>Breaking</span>
                                </span>
                            @endif

                            <!-- Media type overlay icon -->
                            <div class="nr-img-media-tag">
                                @if($item['has_video'])
                                    <i data-lucide="play" style="width: 11px; height: 11px; fill: #FFFFFF;"></i>
                                @else
                                    <i data-lucide="image" style="width: 11px; height: 11px;"></i>
                                @endif
                            </div>
                        </div>

                        <!-- 3. Center Content Details -->
                        <div class="nr-post-content">
                            <!-- Top Line: Category & Status Badges Grouped Together -->
                            <div class="nr-badges-cluster">
                                <span class="nr-cat-badge">
                                    <span class="cat-dot-indicator" style="background-color: {{ $item['dot_color'] }}; width: 6px; height: 6px;"></span>
                                    <span>{{ $item['category'] }}</span>
                                </span>

                                <span class="badge nr-status-badge" style="{{ $statusStyle }}">
                                    <span class="rounded-circle" style="width: 6px; height: 6px; background-color: {{ $statusDot }};"></span>
                                    <span>{{ ucfirst($status) }}</span>
                                </span>

                                @if($item['is_featured'])
                                    <span class="badge nr-badge-tag tag-featured">
                                        <i data-lucide="star" style="width: 10px; height: 10px; fill: currentColor;"></i>
                                        <span>Featured</span>
                                    </span>
                                @endif
                                @if($item['is_breaking'])
                                    <span class="badge nr-badge-tag tag-breaking">
                                        <span class="nr-live-dot"></span>
                                        <span>Breaking</span>
                                    </span>
                                @endif
                            </div>

                            <!-- Headline (15.5px, Bold, Max 2 lines with ellipsis) -->
                            <h3 class="nr-headline-wrap">
                                <a href="/admin/post/{{ $item['id'] }}/edit" class="nr-headline-link" title="{{ $item['title'] }}">
                                    {{ $item['title'] }}
                                </a>
                            </h3>

                            <!-- Summary Snippet -->
                            <p class="nr-summary-snippet text-truncate" title="{{ $item['summary'] }}">
                                {{ $item['summary'] }}
                            </p>

                            <!-- Article Meta (Author • Date • Read time) -->
                            <div class="nr-post-meta-strip">
                                <span class="nr-meta-item">
                                    <i data-lucide="user"></i>
                                    <span>{{ $item['author'] }}</span>
                                </span>
                                <span class="nr-meta-dot">•</span>
                                <span class="nr-meta-item">
                                    <i data-lucide="calendar"></i>
                                    <span>{{ $item['date'] }}</span>
                                </span>
                                <span class="nr-meta-dot">•</span>
                                <span class="nr-meta-item text-slate-400">
                                    <i data-lucide="clock"></i>
                                    <span>2 min read</span>
                                </span>
                            </div>
                        </div>

                        <!-- 4. Right Section: Unified Performance Cluster + Actions -->
                        <div class="nr-card-right-section">
                            <!-- Sleek Segmented Metrics Strip -->
                            <div class="nr-stats-cluster">
                                <div class="nr-stat-node" title="Total Views">
                                    <i data-lucide="eye" style="color: #6366F1;"></i>
                                    <div class="nr-stat-body">
                                        <span class="nr-stat-count">{{ $item['views_fmt'] }}</span>
                                        <span class="nr-stat-tag">Views</span>
                                    </div>
                                </div>
                                <div class="nr-stat-divider"></div>
                                <div class="nr-stat-node" title="Comments">
                                    <i data-lucide="message-square" style="color: #8B5CF6;"></i>
                                    <div class="nr-stat-body">
                                        <span class="nr-stat-count">{{ $item['comments'] }}</span>
                                        <span class="nr-stat-tag">Comments</span>
                                    </div>
                                </div>
                                <div class="nr-stat-divider"></div>
                                <div class="nr-stat-node" title="Social Shares">
                                    <i data-lucide="share-2" style="color: #0EA5E9;"></i>
                                    <div class="nr-stat-body">
                                        <span class="nr-stat-count">{{ $item['shares_fmt'] }}</span>
                                        <span class="nr-stat-tag">Shares</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions Toolbar -->
                            <div class="nr-btn-toolbar">
                                <a href="/admin/post/{{ $item['id'] }}/edit" class="btn nr-btn-edit">
                                    <i data-lucide="pencil" style="width: 12.5px; height: 12.5px;"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn nr-btn-preview" onclick="previewArticle({{ $item['id'] }})" title="Quick Preview">
                                    <i data-lucide="eye" style="width: 12.5px; height: 12.5px;"></i>
                                    <span>Preview</span>
                                </button>
                                <div class="dropdown">
                                    <button type="button" class="btn nr-btn-more dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" title="More Options">
                                        <i data-lucide="more-horizontal" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-1.5" style="border-radius: 10px; font-size: 12.5px; min-width: 165px;">
                                        <li><a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="javascript:void(0)" onclick="duplicateArticle({{ $item['id'] }})"><i data-lucide="copy" class="text-slate-400" style="width: 13px; height: 13px;"></i>Duplicate</a></li>
                                        <li><a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="javascript:void(0)" onclick="updateStatus({{ $item['id'] }}, 'published')"><i data-lucide="check-circle-2" class="text-emerald-500" style="width: 13px; height: 13px;"></i>Mark Published</a></li>
                                        <li><a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="javascript:void(0)" onclick="updateStatus({{ $item['id'] }}, 'draft')"><i data-lucide="file-minus" class="text-amber-500" style="width: 13px; height: 13px;"></i>Move to Draft</a></li>
                                        <li><a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="javascript:void(0)" onclick="updateStatus({{ $item['id'] }}, 'archived')"><i data-lucide="archive" class="text-slate-400" style="width: 13px; height: 13px;"></i>Archive</a></li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li><a class="dropdown-item py-1.5 text-danger d-flex align-items-center gap-2" href="javascript:void(0)" onclick="deleteArticle({{ $item['id'] }})"><i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>Delete Post</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- ====================================================== -->
            <!-- 5.2 ALTERNATIVE GRID VIEW (TOGGLED VIA BUTTON)         -->
            <!-- ====================================================== -->
            <div id="nr-grid-view-container" class="row g-3 d-none">
                @foreach($combinedArticles as $item)
                    <div class="col-12 col-md-6 col-lg-4 article-grid-item"
                         data-id="{{ $item['id'] }}"
                         data-category="{{ $item['category'] }}"
                         data-status="{{ strtolower($item['status']) }}"
                         data-author="{{ $item['author'] }}"
                         data-title="{{ strtolower($item['title']) }}"
                         data-views="{{ $item['views'] }}"
                         data-date="{{ $item['iso_date'] }}">
                        <div class="nr-grid-card">
                            <div class="position-relative" style="height: 140px; background: #0F172A;">
                                <img src="{{ $item['image'] }}" alt="" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='/images/aaksh_anchor_studio.jpg'">
                                <input type="checkbox" class="form-check-input position-absolute top-2 start-2 m-0 article-checkbox" value="{{ $item['id'] }}" style="width: 18px; height: 18px; cursor: pointer; z-index: 2;">
                                @if($item['is_featured'])
                                    <span class="badge position-absolute top-2 end-2 nr-img-badge-featured font-bold">Featured</span>
                                @elseif($item['is_breaking'])
                                    <span class="badge position-absolute top-2 end-2 nr-img-badge-breaking font-bold">Breaking</span>
                                @endif
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                                        <span class="d-inline-flex align-items-center gap-1 font-bold" style="font-size: 11px; color: {{ $item['dot_color'] }};">
                                            <span class="rounded-circle" style="width: 6px; height: 6px; background-color: {{ $item['dot_color'] }};"></span>
                                            {{ $item['category'] }}
                                        </span>
                                        <span class="badge bg-light text-dark font-semibold" style="font-size: 10px;">{{ ucfirst($item['status']) }}</span>
                                    </div>
                                    <h4 style="font-size: 14px; font-weight: 700; line-height: 1.35; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <a href="/admin/post/{{ $item['id'] }}/edit" class="text-dark text-decoration-none">{{ $item['title'] }}</a>
                                    </h4>
                                </div>
                                <div class="pt-2 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                    <span>{{ $item['date'] }}</span>
                                    <span>{{ $item['views_fmt'] }} views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <!-- Empty State (When Filter matches nothing or table is empty) -->
            <div id="nr-empty-state" class="card text-center py-5 my-3" style="border: 1px dashed var(--cms-border); border-radius: 14px; background: #FFFFFF;">
                <div class="mb-3">
                    <i data-lucide="newspaper" style="width: 48px; height: 48px; color: #94A3B8;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No news articles found</h5>
                <p class="text-muted font-sm mb-3">There are no articles matching your criteria, or no news has been published yet.</p>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <a href="/admin/post/create" class="btn text-white px-3.5 py-2 font-semibold text-decoration-none shadow-sm" style="background: var(--cms-primary); border-radius: 8px; font-size: 13px;">
                        <i data-lucide="plus" style="width: 15px; height: 15px;"></i> Add News Article
                    </a>
                    @if(request()->hasAny(['search', 'category', 'status', 'author', 'date']))
                        <a href="/admin/post" class="btn btn-light px-3.5 py-2 font-semibold text-decoration-none border" style="border-radius: 8px; font-size: 13px;">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- ====================================================== -->
            <!-- 5.3 PAGINATION BAR                                     -->
            <!-- ====================================================== -->
            @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->total() > 0)
            <div class="nr-pagination-card" id="nr-pagination-bar">
                <div class="nr-pagination-info-wrap" id="nr-pagination-info">
                    <span class="nr-pg-badge" id="pg-current-page">Page {{ $posts->currentPage() }} of {{ max(1, $posts->lastPage()) }}</span>
                    <span class="nr-pg-text">
                        Showing <strong id="pg-start">{{ $posts->firstItem() ?: 0 }}</strong>–<strong id="pg-end">{{ $posts->lastItem() ?: 0 }}</strong> of <strong id="pg-total">{{ number_format($posts->total()) }}</strong> articles
                    </span>
                </div>

                <div class="nr-pagination-controls" id="nr-pagination-buttons">
                    @if($posts->onFirstPage())
                        <button type="button" class="nr-pg-nav-btn" disabled>
                            <i data-lucide="chevron-left"></i>
                            <span>Previous</span>
                        </button>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="nr-pg-nav-btn text-decoration-none">
                            <i data-lucide="chevron-left"></i>
                            <span>Previous</span>
                        </a>
                    @endif

                    <div id="pg-page-numbers" class="nr-pg-pages-cluster">
                        @php
                            $startPage = max(1, $posts->currentPage() - 2);
                            $endPage = min($posts->lastPage(), $posts->currentPage() + 2);
                        @endphp

                        @if($startPage > 1)
                            <a href="{{ $posts->url(1) }}" class="nr-pg-num-btn text-decoration-none">1</a>
                            @if($startPage > 2)
                                <span class="px-1 text-muted">...</span>
                            @endif
                        @endif

                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $posts->currentPage())
                                <span class="nr-pg-num-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $posts->url($page) }}" class="nr-pg-num-btn text-decoration-none">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($endPage < $posts->lastPage())
                            @if($endPage < $posts->lastPage() - 1)
                                <span class="px-1 text-muted">...</span>
                            @endif
                            <a href="{{ $posts->url($posts->lastPage()) }}" class="nr-pg-num-btn text-decoration-none">{{ $posts->lastPage() }}</a>
                        @endif
                    </div>

                    @if($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="nr-pg-nav-btn text-decoration-none">
                            <span>Next</span>
                            <i data-lucide="chevron-right"></i>
                        </a>
                    @else
                        <button type="button" class="nr-pg-nav-btn" disabled>
                            <span>Next</span>
                            <i data-lucide="chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>

</div>

<!-- ============================================================== -->
<!-- FLOATING BULK ACTIONS BAR                                      -->
<!-- ============================================================== -->
<div id="nr-bulk-floating-bar">
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-purple-500 text-white rounded-pill px-2.5 py-1 font-bold" id="nr-floating-count" style="background: var(--cms-primary);">
            0 Selected
        </span>
    </div>
    <div class="vr" style="height: 18px; opacity: 0.4;"></div>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-success px-3 py-1 font-semibold rounded-pill" onclick="applyBulkAction('publish')">
            <i data-lucide="check" style="width: 12px; height: 12px;" class="me-1"></i> Publish
        </button>
        <button type="button" class="btn btn-sm btn-warning px-3 py-1 font-semibold rounded-pill text-dark" onclick="applyBulkAction('draft')">
            <i data-lucide="file-minus" style="width: 12px; height: 12px;" class="me-1"></i> Draft
        </button>
        <button type="button" class="btn btn-sm btn-secondary px-3 py-1 font-semibold rounded-pill" onclick="applyBulkAction('archive')">
            <i data-lucide="archive" style="width: 12px; height: 12px;" class="me-1"></i> Archive
        </button>
        <button type="button" class="btn btn-sm btn-danger px-3 py-1 font-semibold rounded-pill" onclick="applyBulkAction('delete')">
            <i data-lucide="trash-2" style="width: 12px; height: 12px;" class="me-1"></i> Delete
        </button>
    </div>
    <button type="button" class="btn-close btn-close-white ms-2" onclick="deselectAllArticles()" aria-label="Close"></button>
</div>

<!-- ============================================================== -->
<!-- QUICK PREVIEW MODAL                                            -->
<!-- ============================================================== -->
<div class="modal fade" id="nrQuickPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-2xl" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom py-2.5 px-3.5 bg-slate-50">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge font-bold" id="preview-modal-cat" style="background-color: var(--cms-primary-subtle); color: var(--cms-primary);">Punjab News</span>
                    <span class="text-muted" style="font-size: 12px;">• Quick Editorial Preview</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h2 class="h5 font-extrabold text-slate-900 mb-2" id="preview-modal-title">Article Title</h2>
                <div class="text-muted mb-3 d-flex align-items-center gap-2" style="font-size: 12px;">
                    <span id="preview-modal-author">By Aaksh News Desk</span>
                    <span>•</span>
                    <span id="preview-modal-date">23 Sep 2026</span>
                </div>
                <div class="mb-3 rounded-3 overflow-hidden bg-dark" style="max-height: 280px;">
                    <img id="preview-modal-img" src="" alt="" style="width: 100%; height: 280px; object-fit: cover;">
                </div>
                <p class="text-slate-700" style="font-size: 13.5px; line-height: 1.6;" id="preview-modal-desc">
                    Article description preview...
                </p>
            </div>
            <div class="modal-footer py-2 px-3.5 bg-slate-50">
                <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal">Close</button>
                <a id="preview-modal-edit-link" href="#" class="btn btn-sm text-white px-3" style="background-color: var(--cms-primary);">
                    Edit Article
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT: FILTERING, SEARCH, PAGINATION, VIEW SWITCH         -->
<!-- ============================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        window.lucide.createIcons();
    }

    const searchInput = document.getElementById('nr-search-input');
    const filterForm = document.getElementById('nr-filter-form');
    const listViewContainer = document.getElementById('nr-list-view-container');
    const gridViewContainer = document.getElementById('nr-grid-view-container');
    const listBtn = document.getElementById('view-mode-list-btn');
    const gridBtn = document.getElementById('view-mode-grid-btn');
    const floatingBar = document.getElementById('nr-bulk-floating-bar');
    const floatingCount = document.getElementById('nr-floating-count');

    // 1. Submit form on search enter
    if (searchInput && filterForm) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });
    }

    // 2. View Switcher (List vs Grid)
    if (listBtn && gridBtn && listViewContainer && gridViewContainer) {
        listBtn.addEventListener('click', function () {
            listBtn.style.background = 'var(--cms-primary)';
            listBtn.style.color = '#FFFFFF';
            gridBtn.style.background = '#FFFFFF';
            gridBtn.style.color = 'var(--cms-text-muted)';
            listViewContainer.classList.remove('d-none');
            gridViewContainer.classList.add('d-none');
        });

        gridBtn.addEventListener('click', function () {
            gridBtn.style.background = 'var(--cms-primary)';
            gridBtn.style.color = '#FFFFFF';
            listBtn.style.background = '#FFFFFF';
            listBtn.style.color = 'var(--cms-text-muted)';
            gridViewContainer.classList.remove('d-none');
            listViewContainer.classList.add('d-none');
        });
    }

    // 3. Checkbox Selection & Floating Bar
    const checkboxes = document.querySelectorAll('.article-checkbox');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const card = this.closest('.nr-post-card') || this.closest('.article-grid-item');
            if (card) {
                if (this.checked) card.classList.add('is-selected');
                else card.classList.remove('is-selected');
            }
            updateFloatingBar();
        });
    });

    function updateFloatingBar() {
        const checkedCount = document.querySelectorAll('.article-checkbox:checked').length;
        if (checkedCount > 0) {
            floatingCount.textContent = `${checkedCount} Selected`;
            floatingBar.classList.add('show');
        } else {
            floatingBar.classList.remove('show');
        }
    }

    window.deselectAllArticles = function () {
        checkboxes.forEach(cb => {
            cb.checked = false;
            const card = cb.closest('.nr-post-card') || cb.closest('.article-grid-item');
            if (card) card.classList.remove('is-selected');
        });
        updateFloatingBar();
    };
});

// Quick Article Preview Modal
function previewArticle(articleId) {
    const row = document.querySelector(`.article-item-row[data-id="${articleId}"]`);
    if (!row) return;

    const title = row.querySelector('.nr-headline-link')?.textContent.trim() || 'Article Title';
    const cat = row.getAttribute('data-category') || 'General';
    const author = row.getAttribute('data-author') || 'Aaksh News Desk';
    const img = row.querySelector('.nr-post-thumb-wrap img')?.getAttribute('src') || '';
    const desc = row.querySelector('p.text-truncate')?.textContent.trim() || '';

    document.getElementById('preview-modal-title').textContent = title;
    document.getElementById('preview-modal-cat').textContent = cat;
    document.getElementById('preview-modal-author').textContent = 'By ' + author;
    document.getElementById('preview-modal-img').src = img;
    document.getElementById('preview-modal-desc').textContent = desc;
    document.getElementById('preview-modal-edit-link').href = `/admin/post/${articleId}/edit`;

    const previewModal = new bootstrap.Modal(document.getElementById('nrQuickPreviewModal'));
    previewModal.show();
}

// Single actions
function duplicateArticle(id) {
    if (window.showConfirm) {
        window.showConfirm('Duplicate Article?', `Create a new draft duplicate of article #${id}?`, 'Yes, Duplicate').then((result) => {
            if (result.isConfirmed) {
                submitDuplicate(id);
            }
        });
    } else {
        submitDuplicate(id);
    }
}

function submitDuplicate(id) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/post/${id}/duplicate`;
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
}

function updateStatus(id, newStatus) {
    const token = '{{ csrf_token() }}';
    fetch('/admin/post/bulk-action', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ids: [id],
            action: newStatus
        })
    }).then(res => res.json()).then(data => {
        if (window.showToast) window.showToast('Status updated.', 'success');
        setTimeout(() => location.reload(), 400);
    }).catch(() => {
        location.reload();
    });
}

function deleteArticle(id) {
    const doDelete = () => {
        const token = '{{ csrf_token() }}';
        fetch(`/admin/post/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(res => res.json()).then(data => {
            if (window.showToast) window.showToast('Article deleted successfully.', 'success');
            const row = document.querySelector(`.article-item-row[data-id="${id}"]`);
            if (row) {
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 250);
            }
        }).catch(() => {
            if (window.showToast) window.showToast('Article deleted.', 'success');
            const row = document.querySelector(`.article-item-row[data-id="${id}"]`);
            if (row) {
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 250);
            }
        });
    };

    if (window.showConfirm) {
        window.showConfirm('Delete Article?', 'Are you sure you want to permanently delete this article?', 'Yes, Delete', 'Cancel', 'error').then((result) => {
            if (result.isConfirmed) {
                doDelete();
            }
        });
    } else {
        doDelete();
    }
}

// Bulk Actions
function applyBulkAction(action) {
    const checked = Array.from(document.querySelectorAll('.article-checkbox:checked')).map(cb => cb.value);
    if (checked.length === 0) {
        if (window.showToast) {
            window.showToast('Please select at least one article.', 'warning');
        } else if (window.showAlert) {
            window.showAlert('Select Articles', 'Please select at least one article.', 'warning');
        }
        return;
    }

    if (action === 'delete') {
        if (window.showConfirm) {
            window.showConfirm('Delete Selected Articles?', `Are you sure you want to delete ${checked.length} selected articles? This action cannot be undone.`, 'Yes, Delete All', 'Cancel', 'error').then((result) => {
                if (result.isConfirmed) {
                    executeBulkAction(checked, action);
                }
            });
            return;
        }
    }

    executeBulkAction(checked, action);
}

function executeBulkAction(checked, action) {
    const token = '{{ csrf_token() }}';
    fetch('/admin/post/bulk-action', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ids: checked,
            action: action
        })
    }).then(res => res.json()).then(data => {
        deselectAllArticles();
        if (window.showToast) window.showToast(data.message || 'Action executed successfully.', 'success');
        setTimeout(() => location.reload(), 500);
    }).catch(() => {
        location.reload();
    });
}
</script>
@endsection
