<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Puihaha') · Puihaha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/puihaha.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">P</span><span>puihaha<small>LEARNING PLATFORM</small></span></a>
        <div class="side-label">WORKSPACE</div>
        <a class="side-link" href="{{ route('dashboard') }}">◫ <span>Overview</span></a>
        <a class="side-link" href="{{ route('courses.index') }}">▤ <span>Course library</span></a>

        @if(auth()->user()->role !== 'student')
            <a class="side-link" href="{{ route('courses.manage') }}">✎ <span>Manage courses</span></a>
        @endif

        @if(auth()->user()->role === 'student')
            <a class="side-link" href="{{ route('student.membership') }}">♙ <span>My membership</span></a>
        @endif

        @if(auth()->user()->role === 'admin')
            <div class="side-label">ADMINISTRATION</div>
            <a class="side-link" href="{{ route('members.index') }}">♙ <span>Members</span></a>
            <a class="side-link" href="{{ route('categories.index') }}">▦ <span>Categories</span></a>
            <a class="side-link" href="{{ route('levels.index') }}">◇ <span>Membership levels</span></a>
            <a class="side-link" href="{{ route('transactions.index') }}">⇄ <span>Transactions</span></a>
        @endif

        <div class="sidebar-bottom">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div class="user-meta"><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role) }}</small></div>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="logout-btn" type="submit" title="Sign out">↗</button>
            </form>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div><span class="eyebrow">PUHAHA / LEARNING SPACE</span><h1>@yield('heading','Welcome back')</h1></div>
            <div class="top-actions"><span class="role-pill">{{ ucfirst(auth()->user()->role) }}</span><span class="date-label">{{ now()->format('D, d M Y') }}</span></div>
        </header>
        <section class="page-content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger"><strong>Please check the form.</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
