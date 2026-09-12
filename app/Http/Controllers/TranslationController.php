<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TranslationService;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->input('text');
        $target = $request->input('target');
        if (empty($text) || empty($target)) {
            return response()->json(['success' => false, 'message' => 'Missing parameters.'], 400);
        }
        $translated = TranslationService::translateText($text, $target);
        return response()->json(['success' => true, 'translated' => $translated]);
    }
}
