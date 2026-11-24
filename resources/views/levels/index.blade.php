
@extends('layouts.app')

@section('title', 'Membership levels')
@section('heading', 'Membership levels')

@section('content')

<div class="content-grid">

    {{-- CREATE LEVEL --}}
    <div class="panel">
        <span class="eyebrow">CREATE A LEVEL</span>

        <form method="POST" action="{{ route('levels.store') }}" class="stack-form">
            @csrf

            <label>Level name</label>
            <input name="name" required placeholder="e.g. Silver">

            <label>Fee (PHP)</label>
            <input type="number" name="fee" min="0" step="0.01" required>

            <label>Validity (months)</label>
            <input type="number" name="validity_months" min="1" max="120" required>

            <label>Benefits</label>
            <textarea name="benefits" rows="3"></textarea>

            <label>Description</label>
            <textarea name="description" rows="2"></textarea>

            <button type="submit" class="btn-primary">
                Create level
            </button>
        </form>
    </div>

    {{-- EXISTING LEVELS --}}
    <div class="panel">
        <span class="eyebrow">LEVEL OVERVIEW</span>

        @forelse($levels as $level)

            <div class="level-row">

                {{-- EDIT FORM --}}
                <form method="POST"
                      action="{{ route('levels.update', $level) }}"
                      class="stack-form">

                    @csrf
                    @method('PUT')

                    <label>Level name</label>
                    <input name="name"
                           value="{{ $level->name }}"
                           required>

                    <label>Fee (PHP)</label>
                    <input type="number"
                           name="fee"
                           min="0"
                           step="0.01"
                           value="{{ $level->fee }}"
                           required>

                    <label>Validity (months)</label>
                    <input type="number"
                           name="validity_months"
                           min="1"
                           max="120"
                           value="{{ $level->validity_months }}"
                           required>

                    <label>Benefits</label>
                    <input name="benefits"
                           value="{{ $level->benefits }}"
                           placeholder="Benefits">

                    <label>Description</label>
                    <input name="description"
                           value="{{ $level->description }}"
                           placeholder="Description">

                    <small>
                        {{ $level->members_count }} assigned members
                    </small>

                    <button type="submit" class="text-link">
                        Save changes
                    </button>
                </form>

                {{-- DELETE FORM --}}
                @if($level->members_count == 0)

                    <form method="POST"
                          action="{{ route('levels.destroy', $level) }}"
                          onsubmit="return confirm('Are you sure you want to delete this membership level?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-danger">
                            Delete level
                        </button>
                    </form>

                @else

                    <button type="button"
                            class="btn-outline"
                            disabled
                            title="This level is assigned to existing members.">
                        In use
                    </button>

                @endif

            </div>

        @empty

            <p class="empty-state">No membership levels available.</p>

        @endforelse

    </div>

</div>

@endsection
