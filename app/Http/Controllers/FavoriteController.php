<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('ad')->where('user_id', Auth::id())->get();
        return view('dashboard.favorites', compact('favorites'));
    }

    public function store($adId)
    {
        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'ad_id' => $adId,
        ]);

        return back()->with('success', 'تمت إضافة الإعلان إلى المفضلة ❤️');
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('ad_id', $id)->first();
        if ($favorite) {
            $favorite->delete();
        }

        return back()->with('success', 'تمت إزالة الإعلان من المفضلة 💔');
    }
}
