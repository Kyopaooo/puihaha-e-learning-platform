
@extends('layouts.app')

@section('title', 'Member profile')
@section('heading', 'Member profile')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="page-toolbar">
    <div>
        <span class="eyebrow">{{ $member->member_code }}</span>
        <h2 class="serif-title">{{ $member->full_name }}</h2>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('members.edit', $member) }}" class="btn-outline">
            Edit profile
        </a>

        <form method="POST"
              action="{{ route('members.toggle-status', $member) }}">
            @csrf

            <button type="submit"
                    class="btn-outline"
                    onclick="return confirm('Are you sure you want to {{ $member->status === 'Active' ? 'deactivate' : 'reactivate' }} this member?')">
                {{ $member->status === 'Active' ? 'Deactivate' : 'Reactivate' }}
            </button>
        </form>
    </div>
</div>

<div class="content-grid">

    <div class="panel">
        <span class="eyebrow">MEMBER DETAILS</span>

        <div class="detail-list">
            <div>
                <small>Email</small>
                <strong>{{ $member->email }}</strong>
            </div>

            <div>
                <small>Phone</small>
                <strong>{{ $member->phone ?: '—' }}</strong>
            </div>

            <div>
                <small>Address</small>
                <strong>{{ $member->address ?: '—' }}</strong>
            </div>

            <div>
                <small>Category</small>
                <strong>{{ $member->membershipCategory?->name ?? $member->category }}</strong>
            </div>

            <div>
                <small>Level</small>
                <strong>{{ $member->membershipLevel?->name ?? $member->level }}</strong>
            </div>

            <div>
                <small>Expires</small>
                <strong>{{ $member->expires_at?->format('M d, Y') ?? 'Not set' }}</strong>
            </div>

            <div>
                <small>Status</small>
                <strong>{{ $member->status }}</strong>
            </div>
        </div>
    </div>

    <div class="panel">
        <span class="eyebrow">TRANSACTION HISTORY</span>

        @forelse($member->transactions as $tx)
            <div class="history-row">
                <strong>{{ $tx->reference_number }}</strong>

                <span>
                    {{ $tx->status }} ·
                    ₱{{ number_format($tx->amount, 2) }}
                </span>

                <small>
                    {{ $tx->transaction_date->format('M d, Y') }}
                </small>
            </div>
        @empty
            <p class="empty-state">No transactions recorded.</p>
        @endforelse
    </div>

</div>

@endsection
