<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    // ✅ Show login form
    public function loginForm()
    {
        return view('taxi.drivers.login');
    }

    // ✅ Handle login (phone + password)
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $driver = Driver::where('phone', $request->phone)->first();

        if ($driver && Hash::check($request->password, $driver->password)) {
            session(['driver_id' => $driver->id]);
            return redirect()->route('driver.dashboard')->with('success', 'Login successful');
        }

        return back()->withErrors(['phone' => 'Invalid credentials']);
    }

    // ✅ Driver dashboard
    public function dashboard()
    {
        $driverId = session('driver_id');

        if (!$driverId) {
            return redirect()->route('driver.login')->withErrors(['unauthorized' => 'Please login first.']);
        }

        $driver = Driver::findOrFail($driverId);
        return view('taxi.drivers.panel', compact('driver'));
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        $request->session()->forget('driver_id');
        return redirect()->route('driver.login')->with('success', 'Logged out successfully');
    }

    // ✅ Show map of all drivers
    public function map()
    {
        $drivers = Driver::whereNotNull('latitude')->whereNotNull('longitude')->get();
        return view('taxi.drivers.map', compact('drivers'));
    }

    // ✅ Edit driver
    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('taxi.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'car_number' => 'required|string|max:255',
            'status' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $driver = Driver::findOrFail($id);
        $driver->update($request->only(['name', 'car_number', 'status', 'latitude', 'longitude']));

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully');
    }

    // ✅ Update driver status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $driver = Driver::findOrFail($id);
        $driver->status = $request->status;
        $driver->save();

        return redirect()->back()->with('success', 'Driver status updated');
    }

    // ✅ Show single driver
    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        return view('taxi.drivers.show', compact('driver'));
    }
}
