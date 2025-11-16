<?php

namespace App\Http\Controllers;

use App\Events\TaxiOrderStatusChanged;
use App\Models\TaxiOrder;
use App\Services\TaxiPricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxiOrderController extends Controller
{
    public function quote(Request $req, TaxiPricingService $pricing)
    {
        $distanceKm = (float) $req->get('distance_km', 0);
        $fare = $pricing->quote($distanceKm);
        return response()->json(['fare_syp' => $fare]);
    }

    public function store(Request $req, TaxiPricingService $pricing)
    {
        $data = $req->validate([
            'pickup_lat'  => 'required|numeric',
            'pickup_lng'  => 'required|numeric',
            'dropoff_lat' => 'required|numeric',
            'dropoff_lng' => 'required|numeric',
            'distance_km' => 'required|numeric|min:0.1',
            'route_polyline' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['fare_syp'] = $pricing->quote($data['distance_km']);
        $data['status'] = 'pending';

        $order = TaxiOrder::create($data);
        TaxiOrderStatusChanged::dispatch($order);

        return response()->json(['ok' => true, 'order' => $order]);
    }

    public function show(TaxiOrder $order)
    {
        $this->authorize('view', $order); // لو عندك Policy
        return view('taxi.order', compact('order'));
    }

    public function start(TaxiOrder $order)
    {
        $order->update(['status' => 'started']);
        TaxiOrderStatusChanged::dispatch($order);
        return response()->json(['ok' => true, 'order' => $order]);
    }

    public function complete(TaxiOrder $order)
    {
        $order->update(['status' => 'completed']);
        TaxiOrderStatusChanged::dispatch($order);
        return response()->json(['ok' => true, 'order' => $order]);
    }

    public function cancel(TaxiOrder $order)
    {
        $order->update(['status' => 'canceled']);
        TaxiOrderStatusChanged::dispatch($order);
        return response()->json(['ok' => true, 'order' => $order]);
    }
}
