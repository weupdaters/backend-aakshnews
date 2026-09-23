<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'city'        => $this['city'] ?? 'Patiala, Punjab',
            'temp'        => (int) ($this['temp'] ?? 29),
            'temperature' => $this['temperature'] ?? '29°C',
            'condition'   => $this['condition'] ?? 'Sunny',
            'high'        => (int) ($this['high'] ?? 32),
            'low'         => (int) ($this['low'] ?? 24),
            'humidity'    => (int) ($this['humidity'] ?? 65),
            'windSpeed'   => $this['windSpeed'] ?? '12 km/h',
            'aqi'         => (int) ($this['aqi'] ?? 42),
            'aqiStatus'   => $this['aqiStatus'] ?? 'Good',
            'hourly'      => $this['hourly'] ?? [
                ['time' => 'Now', 'temp' => 29, 'icon' => 'sun'],
                ['time' => '12 PM', 'temp' => 31, 'icon' => 'sun'],
                ['time' => '3 PM', 'temp' => 32, 'icon' => 'sun'],
                ['time' => '6 PM', 'temp' => 30, 'icon' => 'cloud-sun'],
                ['time' => '9 PM', 'temp' => 27, 'icon' => 'moon'],
            ],
            'icon'        => $this['icon'] ?? '☀️',
        ];
    }
}
