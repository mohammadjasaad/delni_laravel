<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxiOrder;

class TaxiOrderAdminController extends Controller
{
    public function index()
    {
        $orders = TaxiOrder::with('driver')->orderBy("created_at","desc")->get();
        return view('admin.taxi_orders.index', compact('orders'));
    }
}
