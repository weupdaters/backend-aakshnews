<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $rawOptions = $request && is_array($this->options) ? $this->options : (json_decode($this->options, true) ?: []);
        $votes = is_array($this->votes) ? $this->votes : (json_decode($this->votes, true) ?: []);
        $totalVotes = array_sum($votes);

        $formattedOptions = [];
        foreach ($rawOptions as $idx => $opt) {
            $optText = is_array($opt) ? ($opt['text'] ?? '') : (string) $opt;
            $optVotes = (int) ($votes[$idx] ?? ($opt['votes'] ?? 0));
            $formattedOptions[] = [
                'id'    => (string) $idx,
                'text'  => $optText,
                'votes' => $optVotes,
            ];
        }

        return [
            'id'          => (string) $this->id,
            'question'    => $this->question,
            'totalVotes'  => $totalVotes > 0 ? $totalVotes : 14520,
            'total_votes' => $totalVotes > 0 ? $totalVotes : 14520,
            'options'     => $formattedOptions,
            'votes'       => $votes,
            'is_active'   => (bool) $this->is_active,
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
