@extends('layouts.app')

@section('title', 'My membership')
@section('heading', 'My membership')

@section('content')
@if(!$member)
    <div class="panel">
        <span class="eyebrow">MEMBERSHIP PROFILE</span>
        <h2 class="serif-title">No membership linked yet.</h2>
        <p class="muted">Your student login is not currently connected to a member record. Please contact the administrator to link your membership profile.</p>
    </div>
@else
    <div class="stats-grid">
        <div class="stat-card"><span>Membership number</span><strong>{{ $member->member_code }}</strong><small>{{ $member->full_name }}</small></div>
        <div class="stat-card"><span>Category</span><strong>{{ $member->membershipCategory?->name ?? $member->category ?? '—' }}</strong><small>Membership category</small></div>
        <div class="stat-card"><span>Membership level</span><strong>{{ $member->membershipLevel?->name ?? $member->level ?? '—' }}</strong><small>Current level</small></div>
        <div class="stat-card"><span>Status</span><strong>{{ $member->status }}</strong><small>Expires {{ $member->expires_at?->format('M d, Y') ?? 'Not set' }}</small></div>
    </div>

    <div class="panel mt-4">
        <span class="eyebrow">PERSONAL DETAILS</span>
        <h3>{{ $member->full_name }}</h3>
        <p class="mb-1">{{ $member->email }}</p>
        <p class="muted">{{ $member->phone ?: 'No phone number recorded' }}</p>
    </div>

    <div class="panel mt-4">
        <div class="panel-head">
            <div><span class="eyebrow">MEMBERSHIP ACTIVITY</span><h3>Transaction history</h3></div>
        </div>
        <div class="table-responsive">
            <table class="table elegant-table">
                <thead><tr><th>Reference</th><th>Type</th><th>Level</th><th>Amount</th><th>Paid</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($member->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->reference_number }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->level?->name ?? '—' }}</td>
                        <td>₱{{ number_format($transaction->amount, 2) }}</td>
                        <td>₱{{ number_format($transaction->amount_paid, 2) }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->transaction_date?->format('M d, Y') ?? '—' }}</td>
                    </tr>
                    @foreach($transaction->payments as $payment)
                        <tr>
                            <td colspan="2">Payment: {{ $payment->payment_reference }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td colspan="2">{{ $payment->payment_date?->format('M d, Y') ?? '—' }}</td>
                            <td><span class="muted">Recorded payment</span></td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="7" class="empty-state">No membership transactions yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
