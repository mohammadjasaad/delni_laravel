<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class AdApiController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required',
        'city' => 'required',
        'category' => 'required',
    ]);

    $imagePaths = $this->handleImages($request);

    $ad = Ad::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'city' => $request->city,
        'category' => $request->category,
        'user_id' => auth()->id() ?? $request->user_id ?? 1,
        'images' => json_encode($imagePaths),
    ]);

    return response()->json($ad, 201);
}

private function handleImages(Request $request): array
{
    $paths = [];

    // ✅ Android/iOS: Multipart
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $paths[] = $file->store('ads', 'public');
        }
    }
    // ✅ Web: Base64
    elseif (is_array($request->images)) {
        foreach ($request->images as $base64) {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $image = base64_decode(substr($base64, strpos($base64, ',') + 1));
                $extension = strtolower($type[1]);
                $filename = 'ads/' . uniqid() . '.' . $extension;
                Storage::disk('public')->put($filename, $image);
                $paths[] = $filename;
            }
        }
    }

    return $paths;
}

}
