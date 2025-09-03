<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;

class AdApiController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('search');

        if ($query) {
            $ads = \App\Models\Ad::where('title', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->orWhere('city', 'like', "%$query%")
                ->orWhere('category', 'like', "%$query%")
                ->orderBy("created_at","desc")
                ->get();
        } else {
            $ads = \App\Models\Ad::latest()->get();
        }

        return response()->json($ads);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'city'        => 'required|string',
            'category'    => 'required|string',
            'images'      => 'required',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ads', 'public');
                $imagePaths[] = basename($path);
            }
        }

        $ad = \App\Models\Ad::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'city'        => $request->city,
            'category'    => $request->category,
            'images'      => $imagePaths,
            'user_id'     => $request->user()->id,
        ]);

        return response()->json($ad, 201);
    }
}
