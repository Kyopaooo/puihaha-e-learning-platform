@extends('members.layout')
@section('title', 'Edit Member')
@section('content')<div class="heading"><div><h1>Edit Member</h1><p class="muted">{{ $member->member_code }}</p></div></div><div class="card"><form method="POST" action="{{ route('members.update', $member) }}">@csrf @method('PUT') @include('members.form')<div class="actions" style="margin-top:20px"><button class="btn" type="submit">Save Changes</button><a class="btn secondary" href="{{ route('members.show', $member) }}">Cancel</a></div></form></div>@endsection
