<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AdvertisementApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/advertisements
     */
    public function index()
    {
        $ads = Advertisement::where('status', 'active')->latest()->get()->map(function ($ad) {
            $img = $ad->image_url;
            if ($img && !str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                $img = url(ltrim($img, '/'));
            }

            return [
                'id'        => (string) $ad->id,
                'name'      => $ad->name,
                'image_url' => $img,
                'link_url'  => $ad->link_url,
                'status'    => $ad->status,
                'slot'      => self::detectSlot($ad->name),
            ];
        });

        return $this->successResponse($ads, 'Advertisements fetched successfully.');
    }

    /**
     * Identify slot name from advertisement label.
     */
    private static function detectSlot(string $name): string
    {
        $lower = strtolower($name);
        if (str_contains($lower, 'header') || str_contains($lower, '728x90') || str_contains($lower, 'top')) {
            return 'header';
        }
        if (str_contains($lower, 'sidebar') || str_contains($lower, '300x250')) {
            return 'sidebar';
        }
        if (str_contains($lower, 'feed') || str_contains($lower, 'in-feed') || str_contains($lower, '600x150')) {
            return 'feed';
        }
        if (str_contains($lower, 'footer')) {
            return 'footer';
        }
        return 'header';
    }
}
