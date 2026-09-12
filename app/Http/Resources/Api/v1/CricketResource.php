<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CricketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'match_title' => $this['match_title'] ?? 'India vs Australia - 3rd ODI',
            'status'      => $this['status'] ?? 'Live',
            'team_a'      => $this['team_a'] ?? ['name' => 'India', 'score' => '285/4 (44.2 ov)'],
            'team_b'      => $this['team_b'] ?? ['name' => 'Australia', 'score' => '280/10 (49.5 ov)'],
            'summary'     => $this['summary'] ?? 'India need 6 runs in 34 balls',
            'venue'       => $this['venue'] ?? 'Wankhede Stadium, Mumbai',
        ];
    }
}
