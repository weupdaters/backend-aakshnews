<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CricketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'matchTitle'  => $this['matchTitle'] ?? ($this['match_title'] ?? 'IPL 2026 - Live'),
            'status'      => $this['status'] ?? 'Punjab Kings won by 8 wickets',
            'team1'       => $this['team1'] ?? [
                'name'  => 'Punjab Kings',
                'code'  => 'PBKS',
                'runs'  => '186/2',
                'overs' => '17.3',
            ],
            'team2'       => $this['team2'] ?? [
                'name'  => 'Delhi Capitals',
                'code'  => 'DC',
                'runs'  => '155/8',
                'overs' => '20',
            ],
            'resultNote'  => $this['resultNote'] ?? ($this['summary'] ?? 'Shikhar Dhawan 82* (45 balls)'),
            'isLive'      => (bool) ($this['isLive'] ?? true),
        ];
    }
}
