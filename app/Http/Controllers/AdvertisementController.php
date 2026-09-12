<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function index()
    {
        $ads = Advertisement::where('status', 'active')->get();
        return response()->json($ads);
    }
}
