<div class="panel weather-panel">
    <span class="eyebrow">WEATHER AT THE LEARNING CENTER</span>
    <h3>{{ $center?->name ?? 'Puihaha Main Learning Center' }}</h3>
    @if($weather && data_get($weather, 'current'))
        @php
            $current = $weather['current'];
            $weatherDescriptions = [
                0 => 'Clear sky', 1 => 'Mainly clear', 2 => 'Partly cloudy', 3 => 'Overcast',
                45 => 'Fog', 48 => 'Depositing rime fog',
                51 => 'Light drizzle', 53 => 'Moderate drizzle', 55 => 'Dense drizzle',
                61 => 'Slight rain', 63 => 'Moderate rain', 65 => 'Heavy rain',
                71 => 'Slight snow', 73 => 'Moderate snow', 75 => 'Heavy snow',
                80 => 'Rain showers', 81 => 'Moderate rain showers', 82 => 'Violent rain showers',
                95 => 'Thunderstorm', 96 => 'Thunderstorm with hail', 99 => 'Thunderstorm with heavy hail',
            ];
            $code = (int) data_get($current, 'weather_code', -1);
        @endphp
        <div class="weather-temp">{{ data_get($current, 'temperature_2m', '—') }}°C</div>
        <p>{{ $weatherDescriptions[$code] ?? 'Current weather conditions' }}</p>
        <small>
            Humidity: {{ data_get($current, 'relative_humidity_2m', '—') }}%
            · Wind: {{ data_get($current, 'wind_speed_10m', '—') }} km/h
        </small>
        <small class="d-block mt-2">Updated: {{ data_get($current, 'time', '—') }} · Weather data by <a href="https://open-meteo.com/" target="_blank" rel="noopener">Open-Meteo</a>.</small>
    @else
        <div class="weather-placeholder">
            Weather is unavailable. Check that the learning center has valid latitude and longitude coordinates and that the server can access Open-Meteo.
        </div>
    @endif
</div>
