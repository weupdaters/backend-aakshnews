@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-1" style="font-weight: 800; color: #062B63;">Users & Roles Management</h3>
        <p class="text-muted mb-0 font-sm">Manage administrators, editors, field reporters, and citizen users with granular role-based access.</p>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="box-breadcrumb">
            <div class="breadcrumbs">
                <ul>
                    <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                    <li><span>Users & Roles</span></li>
                </ul>
            </div>
        </div>
        <button type="button" class="btn text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal" style="background-color: #1769D2; padding: 9px 18px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i> Add New User
        </button>
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

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; color: #b91c1c; border-radius: 10px; border-left: 4px solid #ef4444 !important;">
    <div class="d-flex align-items-center">
        <i data-lucide="alert-triangle" class="me-2" style="width: 20px; height: 20px;"></i>
        <span>{{ session('error') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; color: #b91c1c; border-radius: 10px;">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- METRIC STATS ROW -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Total Accounts</span>
                    <h3 class="mb-0 mt-1 font-black" style="color: #062B63;">{{ number_format($totalUsers) }}</h3>
                    <small class="text-success font-xs"><i data-lucide="check" style="width: 12px; height: 12px;"></i> {{ $activeCount }} Active</small>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(23, 105, 210, 0.1); color: #1769D2;">
                    <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Admins</span>
                    <h3 class="mb-0 mt-1 font-black" style="color: #7C3AED;">{{ number_format($adminCount) }}</h3>
                    <small class="text-muted font-xs">Full Permissions</small>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(124, 58, 237, 0.1); color: #7C3AED;">
                    <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Field Reporters</span>
                    <h3 class="mb-0 mt-1 font-black" style="color: #059669;">{{ number_format($reporterCount) }}</h3>
                    <small class="text-success font-xs">Citizen Bureau</small>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); color: #059669;">
                    <i data-lucide="newspaper" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-xs p-3 rounded-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Editors & Readers</span>
                    <h3 class="mb-0 mt-1 font-black" style="color: #D97706;">{{ number_format($editorCount + $readerCount) }}</h3>
                    <small class="text-muted font-xs">{{ $editorCount }} Editors • {{ $readerCount }} Readers</small>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(217, 119, 6, 0.1); color: #D97706;">
                    <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & SEARCH PANEL -->
<div class="card border-0 shadow-xs rounded-4 mb-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted" style="border-color: #CBD5E1;">
                        <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 font-sm" placeholder="Search by name, email, phone, district..." style="border-color: #CBD5E1;">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select font-sm" style="border-color: #CBD5E1;">
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles (ਸਾਰੀਆਂ ਭੂਮਿਕਾਵਾਂ)</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin (ਪ੍ਰਬੰਧਕ)</option>
                    <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor (ਸੰਪਾਦਕ)</option>
                    <option value="reporter" {{ request('role') == 'reporter' ? 'selected' : '' }}>Reporter (ਪੱਤਰਕਾਰ)</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Reader / User (ਪਾਠਕ)</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select font-sm" style="border-color: #CBD5E1;">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 font-sm fw-bold" style="background-color: #1769D2;">Filter</button>
                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light border font-sm" title="Reset Filters"><i data-lucide="rotate-ccw" style="width: 16px; height: 16px;"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- USERS DATA TABLE -->
<div class="card border-0 shadow-xs rounded-4 mb-4 overflow-hidden" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-bold" style="font-size: 15px; color: #0F172A;">
            System Users Directory ({{ $users->total() }} accounts)
        </h5>
        <span class="badge bg-light text-muted border font-xs">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead style="background-color: #F8FAFC;">
                <tr>
                    <th class="ps-4 py-3 text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">User</th>
                    <th class="py-3 text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Contact & Location</th>
                    <th class="py-3 text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Role</th>
                    <th class="py-3 text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Status</th>
                    <th class="py-3 text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Registered</th>
                    <th class="pe-4 py-3 text-end text-muted font-xs text-uppercase font-bold" style="letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $roleColor = match(strtolower($user->role ?? 'user')) {
                        'admin'    => ['bg' => '#F3E8FF', 'text' => '#7C3AED', 'label' => 'Admin'],
                        'editor'   => ['bg' => '#FEF3C7', 'text' => '#D97706', 'label' => 'Editor'],
                        'reporter' => ['bg' => '#ECFDF5', 'text' => '#059669', 'label' => 'Reporter'],
                        default    => ['bg' => '#EFF6FF', 'text' => '#1D4ED8', 'label' => 'Reader/User'],
                    };
                    $initials = strtoupper(substr($user->name, 0, 2));
                    $avatarBg = match(abs(crc32($user->name)) % 5) {
                        0 => 'linear-gradient(135deg, #3B82F6, #1D4ED8)',
                        1 => 'linear-gradient(135deg, #8B5CF6, #6D28D9)',
                        2 => 'linear-gradient(135deg, #10B981, #047857)',
                        3 => 'linear-gradient(135deg, #F59E0B, #B45309)',
                        default => 'linear-gradient(135deg, #EC4899, #BE185D)',
                    };
                @endphp
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-bold shadow-xs shrink-0" style="width: 40px; height: 40px; background: {{ $avatarBg }}; font-size: 13px;">
                                {{ $initials }}
                            </div>
                            <div>
                                <div class="font-bold text-dark" style="font-size: 14px;">
                                    {{ $user->name }}
                                    @if(Auth::id() === $user->id)
                                        <span class="badge bg-primary-subtle text-primary font-xxs ms-1">You</span>
                                    @endif
                                </div>
                                <small class="text-muted font-xs">ID: #{{ $user->id }} @if($user->reporter_id) • {{ $user->reporter_id }} @endif</small>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="font-sm text-dark">{{ $user->email }}</div>
                        <div class="text-muted font-xs">
                            @if($user->phone)<i data-lucide="phone" style="width: 11px; height: 11px;"></i> {{ $user->phone }}@endif
                            @if($user->district) • <i data-lucide="map-pin" style="width: 11px; height: 11px;"></i> {{ $user->district }}@endif
                        </div>
                    </td>
                    <td class="py-3">
                        <span class="badge rounded-pill px-2.5 py-1 font-xs font-bold" style="background-color: {{ $roleColor['bg'] }}; color: {{ $roleColor['text'] }}; border: 1px solid {{ $roleColor['text'] }}33;">
                            {{ $roleColor['label'] }}
                        </span>
                    </td>
                    <td class="py-3">
                        @if($user->status === 'active')
                            <span class="badge rounded-pill px-2.5 py-1 font-xs font-bold" style="background-color: #ECFDF5; color: #047857; border: 1px solid #10B98133;">
                                <span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span> Active
                            </span>
                        @else
                            <span class="badge rounded-pill px-2.5 py-1 font-xs font-bold" style="background-color: #FEF2F2; color: #B91C1C; border: 1px solid #EF444433;">
                                <span class="d-inline-block rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span> Suspended
                            </span>
                        @endif
                    </td>
                    <td class="py-3 text-muted font-xs">
                        {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <div class="d-inline-flex gap-1">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-light border p-1.5 edit-user-btn" 
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-phone="{{ $user->phone }}"
                                data-role="{{ $user->role ?? 'user' }}"
                                data-status="{{ $user->status ?? 'active' }}"
                                data-district="{{ $user->district }}"
                                data-bio="{{ $user->bio }}"
                                title="Edit User">
                                <i data-lucide="edit-3" style="width: 15px; height: 15px; color: #4B5563;"></i>
                            </button>

                            <!-- Toggle Status Button -->
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light border p-1.5" title="{{ $user->status === 'active' ? 'Suspend User' : 'Activate User' }}">
                                    @if($user->status === 'active')
                                        <i data-lucide="user-x" style="width: 15px; height: 15px; color: #DC2626;"></i>
                                    @else
                                        <i data-lucide="user-check" style="width: 15px; height: 15px; color: #16A34A;"></i>
                                    @endif
                                </button>
                            </form>
                            @endif

                            <!-- Delete Button -->
                            @if(Auth::id() !== $user->id)
                            <button type="button" class="btn btn-sm btn-light border p-1.5 delete-user-btn" 
                                data-id="{{ $user->id }}" 
                                data-name="{{ $user->name }}" 
                                title="Delete User">
                                <i data-lucide="trash-2" style="width: 15px; height: 15px; color: #DC2626;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i data-lucide="users" style="width: 48px; height: 48px; opacity: 0.3; margin-bottom: 12px;"></i>
                            <h6>No users found matching your filters.</h6>
                            <p class="font-xs">Try clearing search terms or adding a new user.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-end">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- ROLE PERMISSION CARDS OVERVIEW -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-xs p-3 rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background-color: #F3E8FF; color: #7C3AED; font-size: 11px;">Administrator</span>
            </div>
            <p class="text-muted font-xs mb-0">Full root access to create/edit/delete all news, categories, settings, users, breaking news, push notifications, and API keys.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-xs p-3 rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background-color: #FEF3C7; color: #D97706; font-size: 11px;">Editor</span>
            </div>
            <p class="text-muted font-xs mb-0">Can write, review, approve, publish, and edit news articles, photo galleries, and breaking tickers without access to site settings or user administration.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-xs p-3 rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background-color: #ECFDF5; color: #059669; font-size: 11px;">Reporter</span>
            </div>
            <p class="text-muted font-xs mb-0">Access to Field Reporter Portal (`/reporter/dashboard`). Files ground reports from districts, uploads photos/videos, earns points, and gets press credentials.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-xs p-3 rounded-4 h-100" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background-color: #EFF6FF; color: #1D4ED8; font-size: 11px;">Reader / Citizen</span>
            </div>
            <p class="text-muted font-xs mb-0">Frontend authenticated readers. Can bookmark news, customize notification preferences, comment, and submit citizen journalism tips via Reader's Corner.</p>
        </div>
    </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title font-bold" id="addUserModalLabel" style="color: #062B63;">
                    <i data-lucide="user-plus" class="me-2" style="width: 20px; height: 20px; color: #1769D2;"></i> Add New System User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Full Name *</label>
                            <input type="text" name="name" class="form-control font-sm" placeholder="e.g. Manpreet Singh" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Email Address *</label>
                            <input type="email" name="email" class="form-control font-sm" placeholder="e.g. manpreet@aakshnews.in" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Password (Min 6 chars) *</label>
                            <input type="password" name="password" class="form-control font-sm" placeholder="••••••••" required minlength="6">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control font-sm" placeholder="+91 98765 43210">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">System Role *</label>
                            <select name="role" class="form-select font-sm" required>
                                <option value="reporter" selected>Field Reporter (ਪੱਤਰਕਾਰ)</option>
                                <option value="editor">Editor (ਸੰਪਾਦਕ)</option>
                                <option value="admin">Administrator (ਮੁੱਖ ਪ੍ਰਬੰਧਕ)</option>
                                <option value="user">Reader / User (ਪਾਠਕ)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Account Status *</label>
                            <select name="status" class="form-select font-sm" required>
                                <option value="active" selected>Active</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">District / Jurisdiction</label>
                            <input type="text" name="district" class="form-control font-sm" placeholder="e.g. Patiala, Ludhiana, Chandigarh">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Bio / Bureau Notes</label>
                            <input type="text" name="bio" class="form-control font-sm" placeholder="Senior crime & politics correspondent">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light font-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-sm fw-bold" style="background-color: #1769D2;">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title font-bold" id="editUserModalLabel" style="color: #062B63;">
                    <i data-lucide="edit-3" class="me-2" style="width: 20px; height: 20px; color: #1769D2;"></i> Edit User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Full Name *</label>
                            <input type="text" id="edit_name" name="name" class="form-control font-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Email Address *</label>
                            <input type="email" id="edit_email" name="email" class="form-control font-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Change Password (leave blank to keep)</label>
                            <input type="password" name="password" class="form-control font-sm" placeholder="Leave empty to retain existing password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Phone Number</label>
                            <input type="text" id="edit_phone" name="phone" class="form-control font-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">System Role *</label>
                            <select id="edit_role" name="role" class="form-select font-sm" required>
                                <option value="admin">Administrator (ਮੁੱਖ ਪ੍ਰਬੰਧਕ)</option>
                                <option value="editor">Editor (ਸੰਪਾਦਕ)</option>
                                <option value="reporter">Field Reporter (ਪੱਤਰਕਾਰ)</option>
                                <option value="user">Reader / User (ਪਾਠਕ)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Account Status *</label>
                            <select id="edit_status" name="status" class="form-select font-sm" required>
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">District / Jurisdiction</label>
                            <input type="text" id="edit_district" name="district" class="form-control font-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-xs font-bold text-uppercase text-muted">Bio / Bureau Notes</label>
                            <input type="text" id="edit_bio" name="bio" class="form-control font-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light font-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-sm fw-bold" style="background-color: #1769D2;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE USER MODAL -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title font-bold text-danger">Confirm Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger mb-3" style="width: 56px; height: 56px;">
                        <i data-lucide="alert-octagon" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h6 class="font-bold text-dark mb-1">Delete Account Permanently?</h6>
                    <p class="text-muted font-sm mb-0">Are you sure you want to delete user <strong id="delete_user_name"></strong>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light font-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger font-sm fw-bold">Yes, Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal Hook
    const editBtns = document.querySelectorAll('.edit-user-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    const editForm = document.getElementById('editUserForm');

    editBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            editForm.action = `/admin/users/${id}`;
            document.getElementById('edit_name').value = this.getAttribute('data-name') || '';
            document.getElementById('edit_email').value = this.getAttribute('data-email') || '';
            document.getElementById('edit_phone').value = this.getAttribute('data-phone') || '';
            document.getElementById('edit_role').value = this.getAttribute('data-role') || 'user';
            document.getElementById('edit_status').value = this.getAttribute('data-status') || 'active';
            document.getElementById('edit_district').value = this.getAttribute('data-district') || '';
            document.getElementById('edit_bio').value = this.getAttribute('data-bio') || '';
            editModal.show();
        });
    });

    // Delete Modal Hook
    const deleteBtns = document.querySelectorAll('.delete-user-btn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
    const deleteForm = document.getElementById('deleteUserForm');
    const deleteNameSpan = document.getElementById('delete_user_name');

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            deleteForm.action = `/admin/users/${id}`;
            deleteNameSpan.textContent = name;
            deleteModal.show();
        });
    });

    // Refresh Lucide icons inside modals
    if (window.lucide) {
        window.lucide.createIcons();
    }
});
</script>
@endsection
