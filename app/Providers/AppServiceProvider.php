<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    // ✅ اللغة
    App::setLocale(Session::get('locale', config('app.locale')));

    try {
        // ✅ إجمالي الزوار
        $visitorsCount = DB::table('visits')->count();

        // ✅ زوار اليوم
        $todayVisitorsCount = DB::table('visits')
            ->whereDate('created_at', today())
            ->count();
    } catch (\Exception $e) {
        $visitorsCount = 0;
        $todayVisitorsCount = 0;
    }

    // مشاركة القيم مع جميع الواجهات
    View::share('visitorsCount', $visitorsCount);
    View::share('todayVisitorsCount', $todayVisitorsCount);
}

}
