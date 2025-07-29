use Illuminate\Support\Facades\Blade;

public function boot()
{
    Blade::component('main-layout', \App\View\Components\MainLayout::class);
}
