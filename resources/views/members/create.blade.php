@extends('members.layout')
@section('title', 'Register Member')
@section('content')<div class="heading"><div><h1>Register New Member</h1><p class="muted">Create a member profile and assign a category and level.</p></div></div><div class="card"><form method="POST" action="{{ route('members.store') }}">@csrf @include('members.form')<div class="actions" style="margin-top:20px"><button class="btn" type="submit">Register Member</button><a class="btn secondary" href="{{ route('members.index') }}">Cancel</a></div></form></div>@endsection
