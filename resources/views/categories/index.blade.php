@extends('layouts.app')

@section('title', 'Categories')
@section('heading', 'Membership categories')

@section('content')
<div class="content-grid">
    <div class="panel">
        <span class="eyebrow">ADD CATEGORY</span>
        <form method="POST" action="{{ route('categories.store') }}" class="stack-form">
            @csrf
            <label>Category name</label>
            <input name="name" value="{{ old('name') }}" placeholder="e.g. Student" required>

            <label>Description</label>
            <textarea name="description" rows="3" placeholder="Describe this membership category">{{ old('description') }}</textarea>

            <button type="submit" class="btn-primary">Add category</button>
        </form>
    </div>

    <div class="panel">
        <span class="eyebrow">AVAILABLE CATEGORIES</span>

        @forelse($categories as $c)
            <div class="manage-row">
                <form method="POST" action="{{ route('categories.update', $c) }}" class="manage-edit">
                    @csrf
                    @method('PUT')

                    <input name="name" value="{{ $c->name }}" required aria-label="Category name">
                    <input name="description" value="{{ $c->description }}" placeholder="Description" aria-label="Category description">
                    <input type="hidden" name="is_active" value="0">
                    <label style="display:flex;align-items:center;gap:7px;font-size:11px;color:#687365">
                        <input type="checkbox" name="is_active" value="1" {{ $c->is_active ? 'checked' : '' }} style="width:auto">
                        Active
                    </label>
                    <small>{{ $c->members_count }} assigned {{ \Illuminate\Support\Str::plural('member', $c->members_count) }}</small>
                    <button type="submit" class="btn-outline">Save changes</button>
                </form>

                <div class="d-flex flex-column gap-2" style="min-width:105px;align-items:flex-end">
                    @if($c->members_count === 0)
                        <form method="POST" action="{{ route('categories.destroy', $c) }}" onsubmit="return confirm('Delete the category {{ addslashes($c->name) }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-outline" style="border-color:#a65b50;color:#8a4037">Delete</button>
                        </form>
                    @else
                        <span class="muted" title="This category is assigned to members and cannot be deleted.">In use</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="empty-state">No membership categories have been created yet.</p>
        @endforelse
    </div>
</div>
@endsection
