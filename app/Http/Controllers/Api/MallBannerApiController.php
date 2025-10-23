<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MallBanner;
use Illuminate\Http\Request;

class MallBannerApiController extends Controller
{
    /**
     * ✅ جلب جميع بانرات المول النشطة
     */
    public function index()
    {
        $banners = MallBanner::where('active', 1)
            ->select('id', 'title', 'image_desktop', 'image_mobile', 'link')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'banners' => $banners,
        ]);
    }
}
