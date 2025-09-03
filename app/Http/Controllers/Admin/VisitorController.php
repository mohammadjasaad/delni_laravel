<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorController extends Controller
{
    public function index()
    {
        // ✅ جلب آخر 50 زيارة مرتبة تنازلياً
        $visitors = Visitor::orderBy('visited_at', 'desc')->paginate(20);

        return view('admin.visitors.index', compact('visitors'));
    }
}
