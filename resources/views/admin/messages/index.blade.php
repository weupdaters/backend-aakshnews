@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="box-title">
        <h3 class="mb-0" style="font-weight: 800; color: var(--heading-color);">Contact Messages</h3>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Admin</a></li>
                <li><span>Contact Messages</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="panel-white mb-30" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
        <h5 class="mb-0" style="font-weight: 800; color: var(--heading-color);">
            <i data-lucide="message-square" class="text-primary me-2" style="width: 20px; height: 20px;"></i> Reader Inquiries & Messages ({{ count($messages ?? []) }})
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">#</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Sender</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Subject</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Message</th>
                    <th scope="col" style="font-size: 12px; font-weight: 700;">Received At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $idx => $msg)
                <tr>
                    <td style="font-size: 13px; font-weight: 600;">{{ $idx + 1 }}</td>
                    <td>
                        <div style="font-size: 13px; font-weight: 700; color: var(--heading-color);">{{ $msg->name }}</div>
                        <small class="text-muted" style="font-size: 11px;">{{ $msg->email }}</small>
                    </td>
                    <td style="font-size: 13px; font-weight: 600;">{{ $msg->subject ?? 'General Inquiry' }}</td>
                    <td style="font-size: 12px; max-width: 320px; color: var(--text-color);">
                        {{ $msg->message }}
                    </td>
                    <td style="font-size: 12px; color: var(--text-color); white-space: nowrap;">
                        {{ $msg->created_at ? $msg->created_at->format('d M Y, h:i A') : 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i data-lucide="inbox" style="width: 40px; height: 40px; opacity: 0.3;" class="mb-2"></i>
                        <p class="mb-0">No reader messages received yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
