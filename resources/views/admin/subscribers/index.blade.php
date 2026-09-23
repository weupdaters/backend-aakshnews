@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-0" style="font-weight: 800; color: var(--heading-color);">Newsletter Subscribers</h3>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                <li><span>Subscribers</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="panel-white mb-30" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
        <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">
            <i data-lucide="mail" class="text-primary me-2" style="width: 20px; height: 20px;"></i> All Active Subscribers ({{ count($subscribers ?? []) }})
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">#</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Subscriber Email</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Status</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Subscribed Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $idx => $sub)
                <tr>
                    <td style="font-size: 13px; font-weight: 600;">{{ $idx + 1 }}</td>
                    <td style="font-size: 13px; font-weight: 700; color: var(--heading-color);">
                        <i data-lucide="mail" class="text-muted me-2" style="width: 14px; height: 14px;"></i> {{ $sub->email }}
                    </td>
                    <td>
                        <span class="badge bg-success-subtle text-success px-2.5 py-1 rounded-pill" style="font-size: 11px;">Active</span>
                    </td>
                    <td style="font-size: 12px; color: var(--text-color);">
                        {{ $sub->created_at ? $sub->created_at->format('d M Y, h:i A') : 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i data-lucide="inbox" style="width: 40px; height: 40px; opacity: 0.3;" class="mb-2"></i>
                        <p class="mb-0">No newsletter subscribers found yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
