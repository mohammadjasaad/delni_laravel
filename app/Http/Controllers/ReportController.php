<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Ad;

class ReportController extends Controller
{
    public function store(Request $request, $adId)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'ad_id' => $adId,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', __('messages.report_submitted'));
    }
}
