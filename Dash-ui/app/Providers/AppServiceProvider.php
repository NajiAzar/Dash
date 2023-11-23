<?php

namespace App\Providers;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\CategoryViewComposer;
use App\Http\View\Composers\CartViewComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Facades\View::composer('layouts.app', CategoryViewComposer::class);
        View::composer('layouts.app', CartViewComposer::class);
      //  View::composer('thank-you', CartViewComposer::class);
        
        View::composer('checkout.form', CartViewComposer::class);
        View::composer('wishlist.index', CartViewComposer::class);
     
      //  view()->composer('layout.app', CategoryViewComposer::class);

    }
}
