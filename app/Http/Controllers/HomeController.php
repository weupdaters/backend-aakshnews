<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectDashboard()
    {
        return redirect('/admin/dashboard');
    }

    public function fallback(Request $request)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'API endpoint not found.'], 404);
        }
        return redirect('/admin/dashboard');
    }
}
