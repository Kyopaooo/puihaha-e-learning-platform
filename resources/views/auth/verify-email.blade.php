@extends('layouts.app')

@section('title', 'Verify email')
@section('heading', 'Verify your email address')

@section('content')
<div class="panel form-panel">
    <span class="eyebrow">ONE QUICK STEP</span>
    <h2 class="serif-title">Check your inbox.</h2>

    <p>
        Thanks for creating a Puihaha account. Before continuing, please verify
        your email address using the link we sent to
        <strong>{{ auth()->user()->email }}</strong>.
    </p>

    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success">A fresh verification link has been sent.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">Resend verification email</button>
    </form>

    <p class="muted mt-3 mb-0">
        If you cannot find the message, check your spam or junk folder.
    </p>
</div>
@endsection
