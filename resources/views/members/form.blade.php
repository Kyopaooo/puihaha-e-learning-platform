@extends('layouts.app')

@section('title', $member->exists ? 'Edit member' : 'Add member')
@section('heading', $member->exists ? 'Edit member' : 'Register a member')

@section('content')
<div class="panel form-panel">
    <form method="POST" action="{{ $member->exists ? route('members.update', $member) : route('members.store') }}">
        @csrf
        @if($member->exists) @method('PUT') @endif

        <div class="form-grid">
            <div class="field full">
                <label>Link student account (optional)</label>
                <select name="user_id">
                    <option value="">No linked account</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" @selected(old('user_id', $member->user_id) == $u->id)>
                            {{ $u->name }} · {{ $u->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>First name</label>
                <input name="first_name" value="{{ old('first_name', $member->first_name) }}" required>
            </div>
            <div class="field">
                <label>Last name</label>
                <input name="last_name" value="{{ old('last_name', $member->last_name) }}" required>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" required>
            </div>
            <div class="field">
                <label>Phone</label>
                <input name="phone" value="{{ old('phone', $member->phone) }}">
            </div>
            <div class="field full">
                <label>Address</label>
                <input id="address" name="address" value="{{ old('address', $member->address) }}">
                <small class="muted">Enter the address, then click the map to place the member's location.</small>
            </div>
            <div class="field">
                <label>Membership category</label>
                <select name="membership_category_id" required>
                    <option value="">Select category</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('membership_category_id', $member->membership_category_id) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Membership level</label>
                <select name="membership_level_id" required>
                    <option value="">Select level</option>
                    @foreach($levels as $l)
                        <option value="{{ $l->id }}" @selected(old('membership_level_id', $member->membership_level_id) == $l->id)>
                            {{ $l->name }} — ₱{{ number_format($l->fee, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $member->latitude) }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $member->longitude) }}">
        </div>

        <div class="mt-3">
            <div id="member-map" class="map-box" style="height:340px;width:100%;border:1px solid #deded5;z-index:1"></div>
            <small class="muted d-block mt-2">
                Map data © <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap contributors</a>.
                Click the map or drag the marker to save coordinates.
            </small>
            <p class="muted mt-1 mb-0" id="map-coordinates" aria-live="polite"></p>
        </div>

        <div class="form-actions">
            <a href="{{ route('members.index') }}" class="btn-outline">Cancel</a>
            <button class="btn-primary">{{ $member->exists ? 'Save changes' : 'Create member' }}</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const coordinateLabel = document.getElementById('map-coordinates');

    const initialLat = parseFloat(latInput.value) || 14.5995;
    const initialLng = parseFloat(lngInput.value) || 120.9842;

    const map = L.map('member-map').setView([initialLat, initialLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    function saveCoordinates(latlng) {
        latInput.value = latlng.lat.toFixed(7);
        lngInput.value = latlng.lng.toFixed(7);
        coordinateLabel.textContent = 'Selected coordinates: ' + latInput.value + ', ' + lngInput.value;
    }

    map.on('click', function (event) {
        marker.setLatLng(event.latlng);
        saveCoordinates(event.latlng);
    });

    marker.on('dragend', function (event) {
        saveCoordinates(event.target.getLatLng());
    });

    if (latInput.value && lngInput.value) {
        saveCoordinates({lat: initialLat, lng: initialLng});
    }

    setTimeout(function () { map.invalidateSize(); }, 200);
});
</script>
@endpush
