<?php

namespace App\Providers;
use App\Models\Visitors;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*',function($view){
            //đếm sản phẩm
            $app_product = Product::all()->count();
            //đếm đơn hàng
            $app_order = Order::all()->count();
            //đếm khách hàng
            $app_customer = Customer::all()->count();
            //đếm bài viết
            $app_post = Post::all()->count();
            $view->with('app_product',$app_product)->with('app_order',$app_order)
            ->with('app_customer',$app_customer)->with('app_post',$app_post);
        });
    }
}
