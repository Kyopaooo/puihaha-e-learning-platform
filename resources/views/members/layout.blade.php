<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member Management')</title>
    <style>
        :root { font-family: Inter, ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f4f7fb; }
        * { box-sizing: border-box; } body { margin: 0; } a { color: inherit; text-decoration: none; }
        .topbar { background: #173b68; color: white; padding: 18px max(20px, calc((100% - 1120px)/2)); display:flex; justify-content:space-between; align-items:center; gap:20px; }
        .brand { font-size: 1.15rem; font-weight: 750; } .nav a { margin-left: 18px; color: #d9e7f8; }
        .container { width: min(1120px, calc(100% - 32px)); margin: 32px auto; } .heading { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:22px; }
        h1 { margin:0; font-size:1.8rem; } h2 { margin-top:0; } .muted { color:#667085; }
        .card { background:white; border:1px solid #e2e8f0; border-radius:12px; padding:22px; box-shadow:0 5px 18px #14213d0a; }
        .filters, .form-grid { display:grid; grid-template-columns: repeat(4, 1fr); gap:14px; align-items:end; } .form-grid { grid-template-columns:repeat(2, 1fr); }
        label { display:block; font-weight:650; font-size:.9rem; margin-bottom:6px; } input, select, textarea { width:100%; border:1px solid #cbd5e1; border-radius:7px; padding:10px 11px; font:inherit; background:#fff; } textarea { min-height:90px; resize:vertical; }
        .full { grid-column:1 / -1; } .actions { display:flex; gap:9px; flex-wrap:wrap; align-items:center; } .btn { display:inline-block; border:0; border-radius:7px; padding:10px 14px; background:#1d65a6; color:white; cursor:pointer; font-weight:650; } .btn.secondary { background:#e8eef6; color:#22415f; } .btn.danger { background:#b42318; } .btn.small { padding:7px 10px; font-size:.88rem; }
        .table-wrap { overflow:auto; margin-top:18px; } table { width:100%; border-collapse:collapse; } th, td { text-align:left; padding:13px 10px; border-bottom:1px solid #e5eaf0; white-space:nowrap; } th { color:#526071; font-size:.82rem; text-transform:uppercase; letter-spacing:.04em; } .badge { display:inline-block; border-radius:20px; padding:4px 9px; font-size:.78rem; background:#dcfce7; color:#166534; } .badge.inactive { background:#fee2e2; color:#991b1b; }
        .alert { background:#e6f7ed; border:1px solid #a7e0bd; color:#166534; border-radius:8px; padding:12px 14px; margin-bottom:18px; } .errors { background:#fff1f2; color:#9f1239; border:1px solid #fecdd3; padding:12px 18px; border-radius:8px; margin-bottom:18px; }
        .profile { display:grid; grid-template-columns:repeat(2, 1fr); gap:18px; } .profile dt { color:#667085; font-size:.85rem; margin-bottom:3px; } .profile dd { margin:0; font-size:1.05rem; } .pagination { margin-top:18px; display:flex; gap:6px; } .pagination a, .pagination span { padding:7px 10px; border:1px solid #d8e0ea; border-radius:6px; } .pagination .active { background:#1d65a6; color:#fff; }
        @media (max-width: 720px) { .filters, .form-grid, .profile { grid-template-columns:1fr; } .heading { align-items:flex-start; flex-direction:column; } .nav a { margin-left:8px; } }
    </style>
</head>
<body>
    <header class="topbar"><a class="brand" href="{{ route('members.index') }}">Membership Management System</a><nav class="nav"><a href="{{ route('members.index') }}">Members</a><a href="{{ route('members.create') }}">Register Member</a></nav></header>
    <main class="container">
        @if (session('success')) <div class="alert">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="errors"><strong>Please correct the following:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
        @yield('content')
    </main>
</body>
</html>
