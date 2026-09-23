<!DOCTYPE html>
<html lang="{{ session('lang', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>akkshnews Dashboard - Aaksh News 24 Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700;800&family=Noto+Sans+Gurmukhi:wght@400;500;600;700;800&display=swap');

        :root {
            /* AAKSH NEWS 24 LOGO BRAND COLOR SYSTEM */
            --primary-color: #1769D2;       /* Royal Blue */
            --primary-hover: #0D56B5;       /* Subtle Blue Hover */
            --navy-deep: #062B63;           /* Deep Navy */
            --logo-blue: #1557A6;           /* Logo Blue */
            --cta-yellow: #FFC400;          /* Signature Yellow */
            --cta-yellow-text: #062B63;     /* Yellow Button Text: Deep Navy */
            --gold-accent: #F5A900;         /* Gold Accent */
            
            --bg-color: #F5F8FC;            /* Page Background */
            --card-bg: #FFFFFF;            /* Card Background */
            --text-color: #64748B;          /* Secondary Text */
            --heading-color: #111827;       /* Primary Text / Headings */
            --border-color: #E2E8F0;        /* Border */
            
            --header-bg: #FFFFFF;           /* Header White */
            --sidebar-bg: #062B63;          /* Sidebar Deep Navy */
            --sidebar-text: #E2E8F0;        /* Sidebar Item Text */
            --sidebar-hover-bg: #0D56B5;    /* Sidebar Hover Subtle Blue */
            --sidebar-active-bg: #1769D2;   /* Sidebar Active Royal Blue */
            --sidebar-active-color: #FFFFFF;
            --sidebar-indicator: #FFC400;   /* Active Navigation Indicator */
            
            --badge-bg: #EBF3FC;
            --badge-color: #1769D2;
            
            /* Status Colors */
            --success-color: #16A34A;       /* Success */
            --danger-color: #E53935;        /* Breaking / Error */
            --warning-color: #F59E0B;       /* Warning */
            --info-color: #2563EB;          /* Info */
        }

        .dark-theme {
            --primary-color: #38BDF8;
            --primary-hover: #0284C7;
            --navy-deep: #062B63;
            --logo-blue: #1557A6;
            --cta-yellow: #FFC400;
            --cta-yellow-text: #062B63;
            --gold-accent: #F5A900;

            --bg-color: #041633;
            --card-bg: #09214A;
            --text-color: #94A3B8;
            --heading-color: #F8FAFC;
            --border-color: #1E3A6E;

            --header-bg: #06224E;
            --sidebar-bg: #03142F;
            --sidebar-text: #CBD5E1;
            --sidebar-hover-bg: #0D56B5;
            --sidebar-active-bg: #1769D2;
            --sidebar-active-color: #FFFFFF;
            --sidebar-indicator: #FFC400;

            --badge-bg: #0F2D62;
            --badge-color: #60A5FA;

            --success-color: #4ADE80;
            --danger-color: #F87171;
            --warning-color: #FBBF24;
            --info-color: #60A5FA;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s, color 0.3s;
        }

        html[lang="hi"] body {
            font-family: 'Noto Sans Devanagari', 'Plus Jakarta Sans', sans-serif;
        }

        html[lang="pb"] body {
            font-family: 'Noto Sans Gurmukhi', 'Plus Jakarta Sans', sans-serif;
        }

        html[lang="en"] body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Preloader */
        #preloader-active {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--card-bg);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s, visibility 0.4s;
        }

        #preloader-active.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        /* Header Styles */
        .header.sticky-bar {
            height: 80px;
            background-color: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding: 0 24px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-logo a {
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .brand-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--heading-color);
            margin-left: 10px;
        }

        .brand-logo-text span {
            color: var(--primary-color);
        }

        .btn-grey-small {
            font-size: 11px;
            font-weight: 700;
            color: var(--badge-color);
            background-color: var(--badge-bg);
            border-radius: 4px;
            padding: 4px 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        /* Search Box */
        .header-search {
            margin-left: 24px;
        }

        .box-search {
            position: relative;
            background: var(--badge-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 16px;
            display: flex;
            align-items: center;
            width: 280px;
        }

        .box-search input {
            border: none;
            background: transparent;
            outline: none;
            color: var(--heading-color);
            font-size: 13px;
            width: 100%;
        }

        .box-search::after {
            content: "🔍";
            font-size: 12px;
            position: absolute;
            right: 14px;
            opacity: 0.6;
        }

        /* Header Menu */
        .header-menu ul {
            display: flex;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .header-menu ul li a {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.2s;
        }

        .header-menu ul li a:hover {
            color: var(--primary-color);
        }

        /* Header Right */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .theme-toggle-btn {
            background-color: var(--badge-bg);
            color: var(--heading-color);
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .theme-toggle-btn:hover {
            background-color: var(--border-color);
        }

        /* Member Info */
        .member-login {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-circle {
            background: var(--primary-color);
            color: #FFFFFF;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .info-member {
            display: flex;
            flex-direction: column;
        }

        .info-member strong {
            font-size: 13px;
            font-weight: 700;
            color: var(--heading-color);
        }

        .info-member .dropdown-toggle {
            font-size: 11px;
            color: var(--text-muted);
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
            text-align: left;
        }

        .info-member .dropdown-menu {
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 8px;
            margin-top: 10px;
        }

        .info-member .dropdown-item {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-color);
            border-radius: 6px;
            padding: 8px 12px;
        }

        .info-member .dropdown-item:hover {
            background-color: var(--badge-bg);
            color: var(--primary-color);
        }

        /* Layout Main Grid */
        .main {
            display: flex;
            flex-grow: 1;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar (`.nav`) */
        .nav-sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .nav-main-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-section-title {
            color: #8EA5C8 !important;
            font-weight: 800;
            letter-spacing: 0.08em;
            font-size: 11px;
        }

        .main-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .main-menu li {
            width: 100%;
        }

        .main-menu li button, .main-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            position: relative;
        }

        .main-menu li button i, .main-menu li a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            opacity: 0.9;
            color: inherit;
        }

        .main-menu li button:hover, .main-menu li a:hover {
            background-color: var(--sidebar-hover-bg);
            color: #FFFFFF;
        }

        .main-menu li button.active, .main-menu li a.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(23, 105, 210, 0.4);
        }

        /* Active navigation indicator: Signature Yellow #FFC400 */
        .main-menu li button.active::before, .main-menu li a.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 4px;
            background-color: var(--sidebar-indicator);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 8px rgba(255, 196, 0, 0.6);
        }

        /* Profile Completed Widget */
        .box-profile-completed {
            background: var(--badge-bg);
            border-radius: 12px;
            padding: 16px;
            border: 1px dashed var(--border-color);
            text-align: center;
            margin-top: 16px;
        }

        .box-profile-completed h6 {
            font-size: 13px;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: 6px;
        }

        .box-profile-completed p {
            font-size: 11px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        /* Hiring Card Banner */
        .sidebar-border-bg {
            background: linear-gradient(135deg, #05264E 0%, #0E3C6E 100%);
            color: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            position: relative;
            overflow: hidden;
            margin-top: auto;
        }

        .sidebar-border-bg .text-grey {
            font-size: 10px;
            font-weight: 700;
            color: #94A3B8;
            letter-spacing: 1px;
            display: block;
        }

        .sidebar-border-bg .text-hiring {
            font-size: 20px;
            font-weight: 800;
            color: #38BDF8;
            display: block;
            margin-bottom: 8px;
        }

        .sidebar-border-bg p {
            font-size: 11px;
            color: #E2E8F0;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .sidebar-border-bg .btn-paragraph-2 {
            background: #FFFFFF;
            color: #05264E;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .sidebar-border-bg .btn-paragraph-2:hover {
            background: #38BDF8;
            color: #FFFFFF;
        }

        /* Content Area (`.box-content`) */
        .box-content {
            flex-grow: 1;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            overflow-y: auto;
            max-width: calc(100% - 280px);
        }

        .box-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .box-title h3 {
            font-size: 24px;
            font-weight: 800;
            color: var(--heading-color);
            margin: 0;
        }

        .breadcrumbs ul {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
            align-items: center;
        }

        .breadcrumbs ul li a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .breadcrumbs ul li span {
            color: var(--primary-color);
            font-weight: 600;
        }

        .breadcrumbs ul li:not(:last-child)::after {
            content: "/";
            margin-left: 6px;
            opacity: 0.5;
        }

        /* Metric Cards */
        .card-style-1 {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s;
            height: 100%;
            text-decoration: none;
            cursor: pointer;
        }

        .card-style-1:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(181, 196, 217, 0.25);
        }

        .card-style-1 .card-image {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .card-style-1 .card-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-style-1 .card-title {
            margin: 0 0 2px 0;
            border: none;
            padding: 0;
        }

        .card-style-1 .card-title h3 {
            font-size: 22px;
            font-weight: 800;
            color: var(--heading-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-style-1 .status {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .card-style-1 .status.up {
            background: rgba(34, 197, 94, 0.1);
            color: var(--success-color);
        }

        .card-style-1 p {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        /* Accent classes for images */
        .bg-primary-light { background: rgba(23, 105, 210, 0.1); color: var(--primary-color); }
        .bg-success-light { background: rgba(22, 163, 74, 0.1); color: var(--success-color); }
        .bg-danger-light { background: rgba(229, 57, 53, 0.1); color: var(--danger-color); }
        .bg-warning-light { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
        .bg-purple-light { background: rgba(23, 105, 210, 0.1); color: var(--primary-color); }
        .bg-info-light { background: rgba(37, 99, 235, 0.1); color: #2563EB; }

        /* Panel styles */
        .panel-white {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.01);
            transition: all 0.3s;
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
        }

        .panel-head h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--heading-color);
        }

        .panel-head .menudrop {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-muted);
        }

        .panel-head .menudrop::after {
            content: "•••";
            font-size: 14px;
            letter-spacing: 1px;
        }

        /* card-style-2 for news list */
        .card-style-2 {
            background-color: var(--bg-color);
            border-radius: 10px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 12px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .card-style-2:hover {
            border-color: var(--border-color);
            background-color: var(--card-bg);
            transform: translateX(4px);
        }

        .card-style-2 .card-head {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .card-style-2 .card-image img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
        }

        .card-style-2 .card-title h6 {
            margin: 0 0 4px 0;
            font-size: 13px;
            font-weight: 700;
            color: var(--heading-color);
            max-width: 280px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-style-2 .card-title .time-post,
        .card-style-2 .card-title .views-count {
            font-size: 11px;
            color: var(--text-muted);
            margin-right: 12px;
        }

        .card-style-2 .card-tags {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .card-style-2 .btn-tag {
            background-color: var(--badge-bg);
            color: var(--badge-color);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }

        .card-style-2 .btn-tag:hover {
            background-color: var(--primary-color);
            color: #FFFFFF;
        }

        .card-style-2 .card-price {
            text-align: right;
            font-size: 14px;
            font-weight: 700;
            color: var(--heading-color);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .card-style-2 .card-actions {
            display: flex;
            gap: 6px;
        }

        .card-style-2 .card-actions button {
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            color: #FFFFFF;
            cursor: pointer;
            transition: all 0.2s;
        }

        /* card-style-3 for active subscribers */
        .card-style-3 {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .card-style-3:last-child {
            border-bottom: none;
        }

        .card-style-3 .card-image {
            position: relative;
        }

        .card-style-3 .card-image img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card-style-3 .card-image.online::after {
            content: "";
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background-color: var(--success-color);
            border: 2px solid var(--card-bg);
            border-radius: 50%;
        }

        .card-style-3 .card-info {
            flex-grow: 1;
        }

        .card-style-3 .card-info h6 {
            margin: 0 0 2px 0;
            font-size: 12px;
            font-weight: 700;
            color: var(--heading-color);
        }

        .card-style-3 .card-info .job-position {
            font-size: 11px;
            color: var(--text-muted);
            display: block;
        }

        .card-style-3 .card-location {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* card-style-5 for popular categories */
        .card-style-5 {
            background-color: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 12px;
            transition: all 0.2s;
        }

        .card-style-5:hover {
            background-color: var(--card-bg);
            transform: translateY(-2px);
        }

        .card-style-5 .card-title {
            margin: 0 0 8px 0;
            padding: 0;
            border: none;
        }

        .card-style-5 .card-title h6 {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: var(--heading-color);
        }

        .card-style-5 .card-progress {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-style-5 .progress {
            height: 6px;
            flex-grow: 1;
            border-radius: 3px;
            background-color: var(--border-color);
            margin: 0;
        }

        .card-style-5 .progress-bar {
            background-color: var(--primary-color);
            border-radius: 3px;
        }

        .card-style-5 .number {
            font-size: 11px;
            font-weight: 700;
            color: var(--heading-color);
            min-width: 20px;
            text-align: right;
        }

        /* Tabs content styling */
        .tab-content {
            display: none;
        }

        .tab-content.show {
            display: block;
        }

        /* Table custom designs */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.85rem;
        }

        .data-table th {
            padding: 12px 16px;
            border-bottom: 2px solid var(--border-color);
            color: var(--heading-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
            vertical-align: middle;
        }

        .data-table tr:hover td {
            background-color: rgba(60, 101, 245, 0.02);
        }

        /* Forms inputs */
        .input-group label {
            display: block;
            font-size: 0.82rem;
            margin-bottom: 6px;
            color: var(--heading-color);
            font-weight: 600;
        }

        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--heading-color);
            font-size: 13px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .input-group input:focus,
        .input-group textarea:focus,
        .input-group select:focus,
        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(23, 105, 210, 0.18) !important;
            background-color: var(--card-bg) !important;
        }

        .submit-btn, .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #FFFFFF !important;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 22px;
            border-radius: 8px;
            border: 1px solid var(--primary-color);
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .submit-btn:hover, .btn-primary:hover {
            background-color: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
            color: #FFFFFF !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(23, 105, 210, 0.3);
        }

        /* Signature Yellow Publish / Important CTA Button */
        .btn-cta-yellow, .btn-publish-yellow {
            background-color: var(--cta-yellow) !important;
            border: 1px solid var(--gold-accent) !important;
            color: var(--cta-yellow-text) !important;
            font-weight: 800 !important;
            padding: 10px 22px !important;
            border-radius: 8px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            box-shadow: 0 2px 8px rgba(255, 196, 0, 0.3) !important;
            text-decoration: none !important;
        }

        .btn-cta-yellow:hover, .btn-publish-yellow:hover {
            background-color: var(--gold-accent) !important;
            color: var(--cta-yellow-text) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 14px rgba(245, 169, 0, 0.45) !important;
        }

        /* Links */
        a {
            color: var(--primary-color);
            transition: color 0.2s ease;
        }
        a:hover {
            color: var(--primary-hover);
        }

        /* ========================================================
           UNIFIED LUCIDE ANIMATION SUITE (Backend & Frontend)
           ======================================================== */
        @keyframes iconBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        @keyframes iconWiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }

        @keyframes iconPulseGlow {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(23, 105, 210, 0)); }
            50% { transform: scale(1.1); filter: drop-shadow(0 0 6px rgba(23, 105, 210, 0.6)); }
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes lucideSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .lucide-spin {
            animation: lucideSpin 0.9s linear infinite !important;
            display: inline-block;
        }

        .lucide {
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), stroke 0.2s ease, filter 0.2s ease;
            vertical-align: middle;
        }

        .sidebar-btn:hover .lucide,
        .btn:hover .lucide,
        .hover-up:hover .lucide {
            transform: scale(1.18);
        }

        .icon-hover-bounce:hover,
        .hover-up:hover .icon-hover-bounce {
            animation: iconBounce 0.6s ease-in-out;
        }

        .icon-hover-spin:hover,
        .hover-up:hover .icon-hover-spin {
            transform: rotate(180deg);
        }

        .icon-wiggle-hover:hover,
        .hover-up:hover .icon-wiggle-hover {
            animation: iconWiggle 0.4s ease-in-out;
        }

        .icon-pulse-glow {
            animation: iconPulseGlow 2s ease-in-out infinite;
        }

        .icon-float {
            animation: iconFloat 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Top Loading Progress Line -->
    <div id="admin-top-loading-line" style="position: fixed; top: 0; left: 0; right: 0; height: 3.5px; z-index: 9999999; pointer-events: none; opacity: 0; transition: opacity 0.2s ease;">
        <div id="admin-top-loading-bar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #7C3AED 0%, #2563EB 50%, #06B6D4 100%); box-shadow: 0 0 12px rgba(124, 58, 237, 0.8), 0 0 6px rgba(37, 99, 235, 0.6); transition: width 0.2s cubic-bezier(0.12, 0.45, 0.25, 1);"></div>
    </div>

    @include('admin.layouts.header')
    
    <div class="main">
        @include('admin.layouts.sidebar')
        
        <div class="box-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Unified Lucide Icons Library (Matches Next.js Frontend) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        // Admin Top Loading Line Logic
        (function() {
            const line = document.getElementById('admin-top-loading-line');
            const bar = document.getElementById('admin-top-loading-bar');
            let timer = null;

            function startLoading() {
                if (!line || !bar) return;
                clearInterval(timer);
                line.style.opacity = '1';
                bar.style.width = '18%';

                let progress = 18;
                timer = setInterval(function() {
                    if (progress < 60) {
                        progress += Math.random() * 10 + 5;
                    } else if (progress < 85) {
                        progress += Math.random() * 3 + 1;
                    } else if (progress < 94) {
                        progress += 0.4;
                    }
                    bar.style.width = progress + '%';
                }, 100);
            }

            function stopLoading() {
                if (!line || !bar) return;
                clearInterval(timer);
                bar.style.width = '100%';
                setTimeout(function() {
                    line.style.opacity = '0';
                    setTimeout(function() {
                        bar.style.width = '0%';
                    }, 300);
                }, 200);
            }

            window.addEventListener('click', function(e) {
                const a = e.target.closest('a');
                if (!a) return;
                const href = a.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || a.target === '_blank' || a.hasAttribute('download') || e.ctrlKey || e.metaKey) return;
                
                try {
                    const url = new URL(href, window.location.href);
                    if (url.origin === window.location.origin && (url.pathname !== window.location.pathname || url.search !== window.location.search)) {
                        startLoading();
                    }
                } catch(err) {
                    if (href.startsWith('/') && href !== window.location.pathname) {
                        startLoading();
                    }
                }
            }, true);

            window.addEventListener('submit', function() {
                startLoading();
            });

            window.addEventListener('pageshow', function() {
                stopLoading();
            });
        })();

        // Theme toggle logic
        const themeBtn = document.getElementById('theme-btn');
        const lightText = "{{ $lang === 'hi' ? '☀️ लाइट मोड' : ($lang === 'pb' ? '☀️ ਲਾਈਟ ਮੋਡ' : '☀️ Light Mode') }}";
        const darkText = "{{ $lang === 'hi' ? '🌙 डार्क मोड' : ($lang === 'pb' ? '🌙 ਡਾਰਕ ਮੋਡ' : '🌙 Dark Mode') }}";
        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                document.body.classList.toggle('dark-theme');
                if (document.body.classList.contains('dark-theme')) {
                    themeBtn.innerHTML = lightText;
                } else {
                    themeBtn.innerHTML = darkText;
                }
            });
        }
        
        // Auto-upgrade legacy data-feather to data-lucide so 100% of icons render in modern Lucide
        document.querySelectorAll('[data-feather]').forEach(el => {
            if (!el.getAttribute('data-lucide')) {
                let name = el.getAttribute('data-feather');
                if (name === 'grid') name = 'layout-dashboard';
                el.setAttribute('data-lucide', name);
            }
        });

        // Render Lucide Icons with smooth transitions
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
    @yield('scripts')
</body>
</html>