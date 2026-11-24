<div class="panel dashboard-location-panel">
    <div class="dashboard-location-heading">
        <div>
            <span class="eyebrow">FIND US</span>
            <h3>{{ $center?->name ?? 'Puihaha Main Learning Center' }}</h3>
            <p>{{ $center?->address ?? 'FEU Institute of Technology, 855 P. Paredes St., Sampaloc, Manila' }}</p>
        </div>
        <span class="location-pin-icon" aria-hidden="true">⌖</span>
    </div>

    @if($center && $center->latitude !== null && $center->longitude !== null)
        <div id="dashboard-learning-center-map"
             class="dashboard-location-map"
             data-lat="{{ $center->latitude }}"
             data-lng="{{ $center->longitude }}"
             data-name="{{ $center->name }}"
             data-address="{{ $center->address }}"></div>
    @else
        <div class="dashboard-map-unavailable">
            The learning center's map location has not been configured yet.
        </div>
    @endif

    <div class="dashboard-location-footer">
        <span>Map data © <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap contributors</a></span>
        @if($center && $center->latitude !== null && $center->longitude !== null)
            <a href="https://www.openstreetmap.org/?mlat={{ $center->latitude }}&mlon={{ $center->longitude }}#map=17/{{ $center->latitude }}/{{ $center->longitude }}"
               target="_blank" rel="noopener">Open larger map ↗</a>
        @endif
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('dashboard-learning-center-map');
            if (!element || typeof L === 'undefined') return;

            const lat = Number(element.dataset.lat);
            const lng = Number(element.dataset.lng);
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

            const map = L.map(element, { scrollWheelZoom: false }).setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup(
                '<strong>' + element.dataset.name.replace(/[&<>"']/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]); }) +
                '</strong><br>' + element.dataset.address.replace(/[&<>"']/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]); })
            );
            setTimeout(function () { map.invalidateSize(); }, 150);
        });
        </script>
    @endpush
@endonce
