<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerApiController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();

        $banners->transform(function ($banner) {
            $banner->image = $banner->image
                ? Storage::url($banner->image)
                : null;
            return $banner;
        });

        return response()->json([
            'status' => 'success',
            'banners' => $banners
        ]);
    }
}
