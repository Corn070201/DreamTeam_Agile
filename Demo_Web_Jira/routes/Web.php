<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Mail\WelcomeMail;

//frontend
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index');
Route::post('/tim-kiem', 'App\Http\Controllers\HomeController@search');
//errors
Route::get('/404', 'App\Http\Controllers\HomeController@error_page');
//send-mail
Route::get('/email', 'App\Http\Controllers\EmailController@create');
Route::post('/email', 'App\Http\Controllers\EmailController@sendEmail')->name('send.email');
Route::get('/send-mail', 'App\Http\Controllers\HomeController@send_mail');


// Route::get('/send-coupon', 'App\Http\Controllers\HomeController@send_coupon');
//Route::get('/mail-example', 'App\Http\Controllers\HomeController@mail_example');

use App\Http\Controllers\AdminController;
//backend
Route::get('/admin', 'App\Http\Controllers\AdminController@indexx');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@show_dashboard');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout');
Route::post('/admin-dashboard', 'App\Http\Controllers\AdminController@dashboard');

//Login facebook
//----dang lỗi----
Route::get('/login-facebook','App\Http\Controllers\AdminController@login_facebook');
Route::get('/admin/callback','App\Http\Controllers\AdminController@callback_facebook');
//-----/------
//Lọc doanh số theo ngày
Route::post('/filter-by-date','App\Http\Controllers\AdminController@filter_by_date');
Route::post('/dashboard-filter','App\Http\Controllers\AdminController@dashboard_filter');
Route::post('/day-order','App\Http\Controllers\AdminController@day_order');
use App\Http\Controllers\CategoryProduct;
//CategoryProduct
Route::get('/add-category-product', 'App\Http\Controllers\CategoryProduct@add_category_product')->middleware('auth.roles');
Route::get('/edit-category-product/{actegory_product_id}', 'App\Http\Controllers\CategoryProduct@edit_category_product')->middleware('auth.roles');
Route::get('/delete-category-product/{actegory_product_id}', 'App\Http\Controllers\CategoryProduct@delete_category_product');
Route::get('/all-category-product', 'App\Http\Controllers\CategoryProduct@all_category_product')->middleware('auth.roles');

Route::get('/active-category-product/{actegory_product_id}', 'App\Http\Controllers\CategoryProduct@active_category_product');
Route::get('/unactive-category-product/{actegory_product_id}', 'App\Http\Controllers\CategoryProduct@unactive_category_product');

Route::post('/save-category-product', 'App\Http\Controllers\CategoryProduct@save_category_product');
Route::post('/update-category-product/{actegory_product_id}', 'App\Http\Controllers\CategoryProduct@update_category_product');
Route::post('/export-csv','App\Http\Controllers\CategoryProduct@export_csv');
Route::post('/import-csv','App\Http\Controllers\CategoryProduct@import_csv');

//Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{category_id}', 'App\Http\Controllers\CategoryProduct@show_category_home');


use App\Http\Controllers\BrandProduct;

Route::get('/add-brand-product', 'App\Http\Controllers\BrandProduct@add_brand_product')->middleware('auth.roles');
Route::get('/edit-brand-product/{brand_product_id}', 'App\Http\Controllers\BrandProduct@edit_brand_product')->middleware('auth.roles');
Route::get('/delete-brand-product/{brand_product_id}', 'App\Http\Controllers\BrandProduct@delete_brand_product');
Route::get('/all-brand-product', 'App\Http\Controllers\BrandProduct@all_brand_product')->middleware('auth.roles');

Route::get('/active-brand-product/{brand_product_id}', 'App\Http\Controllers\BrandProduct@active_brand_product');
Route::get('/unactive-brand-product/{brand_product_id}', 'App\Http\Controllers\BrandProduct@unactive_brand_product');

Route::post('/export-csv-brand','App\Http\Controllers\BrandProduct@export_csv_brand');//xuất dữ liệu thương hiệu về file excel
Route::post('/import-csv-brand','App\Http\Controllers\BrandProduct@import_csv_brand');//load dữ liệu thương hiệu từ file excel

Route::post('/save-brand-product', 'App\Http\Controllers\BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'App\Http\Controllers\BrandProduct@update_brand_product');


Route::get('/thuong-hieu-san-pham/{brand_id}', 'App\Http\Controllers\BrandProduct@show_brand_home');//danh mục Thương hiệu trang chủ

use App\Http\Controllers\ProductController;

Route::get('/delete-product/{brand_product_id}', 'App\Http\Controllers\ProductController@delete_product');
Route::get('/all-product', 'App\Http\Controllers\ProductController@all_product')->middleware('auth.roles');
Route::get('/active-product/{brand_product_id}', 'App\Http\Controllers\ProductController@active_product');
Route::get('/unactive-product/{brand_product_id}', 'App\Http\Controllers\ProductController@unactive_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::post('/update-product/{brand_product_id}', 'App\Http\Controllers\ProductController@update_product');

Route::post('/export-csv-product','App\Http\Controllers\ProductController@export_csv_product');//xuất dữ liệu về file excel
Route::post('/import-csv-product','App\Http\Controllers\ProductController@import_csv_product');//load dữ liệu về file excel
//danh mục chi tiết sản phẩm <trang chủ>
Route::get('/chi-tiet-san-pham/{product_id}', 'App\Http\Controllers\ProductController@details_product');

use App\Http\Controllers\UserController;
use App\Http\Middleware\AccessPermission;
//
Route::group(['middleware' => 'auth.roles'],function(){

    Route::get('/add-product', 'App\Http\Controllers\ProductController@add_product');
    Route::get('/edit-product/{brand_product_id}', 'App\Http\Controllers\ProductController@edit_product');
    Route::get('/all-users','App\Http\Controllers\UserController@index');//liệt kê users
    Route::post('/assign-roles','App\Http\Controllers\UserController@assign_roles');// phân công vai trò từng user
    Route::get('/add-users','App\Http\Controllers\UserController@add_users');//thêm users
});
Route::get('/delete-users-roles/{admin_id}', 'App\Http\Controllers\UserController@delete_users_roles');
Route::post('/store-users','App\Http\Controllers\UserController@store_users');

use App\Http\Controllers\CartController;


//Cart
Route::post('/update-cart-quantity', 'App\Http\Controllers\CartController@update_cart_quantity');   //cập nhật giỏ hàng
Route::post('/update-cart', 'App\Http\Controllers\CartController@update_cart');   //cập nhật giỏ hàng Ajax
Route::post('/save-cart', 'App\Http\Controllers\CartController@save_cart');
Route::get('/show-cart', 'App\Http\Controllers\CartController@show_cart');
Route::get('/delete-to-cart/{rowId}', 'App\Http\Controllers\CartController@delete_to_cart');
Route::get('/del-product/{session_id}', 'App\Http\Controllers\CartController@del_product');//xóa giỏ hàng Ajax
Route::post('/add-cart-ajax','App\Http\Controllers\CartController@add_cart_ajax');
Route::get('/gio-hang','App\Http\Controllers\CartController@gio_hang'); 
Route::get('/del-all-product','App\Http\Controllers\CartController@del_all_product'); //xóa tất cả giỏ hàng Ajax


//Coupon
Route::post('/check-coupon', 'App\Http\Controllers\CartController@check_coupon');// lấy mã giảm giá ra giỏi hàng
use App\Http\Controllers\CouponController;
Route::get('/insert-coupon', 'App\Http\Controllers\CouponController@insert_coupon');
Route::get('/list-coupon', 'App\Http\Controllers\CouponController@list_coupon')->middleware('auth.roles'); // liệt kê mã giảm
Route::post('/insert-coupon-code', 'App\Http\Controllers\CouponController@insert_coupon_code'); //thêm mã giảm giá
Route::get('/delete-coupon/{coupon_id}', 'App\Http\Controllers\CouponController@delete_coupon'); // xóa mã giảm giá
Route::get('/del-all-coupon','App\Http\Controllers\CouponController@del_all_coupon'); //xóa tất cả mã giảm giá

Route::post('/export-csv-coupon','App\Http\Controllers\CouponController@export_csv_coupon');//xuất dữ liệu mã giảm về file excel
Route::post('/import-csv-coupon','App\Http\Controllers\CouponController@import_csv_coupon');//load dữ liệu mã giảm từ file excel

use App\Http\Controllers\CheckoutController;
//Checkout
Route::get('/login-checkout', 'App\Http\Controllers\CheckoutController@login_checkout');
Route::get('/logout-checkout', 'App\Http\Controllers\CheckoutController@logout_checkout');
Route::post('/add-customer', 'App\Http\Controllers\CheckoutController@add_customer');
Route::post('/login-customer', 'App\Http\Controllers\CheckoutController@login_customer');
Route::post('/order-place', 'App\Http\Controllers\CheckoutController@order_place');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@checkout');
Route::get('/payment', 'App\Http\Controllers\CheckoutController@payment');
Route::post('/save-checkout-customer', 'App\Http\Controllers\CheckoutController@save_checkout_customer');
Route::post('/select-delivery-home', 'App\Http\Controllers\CheckoutController@select_delivery_home');//Chọn địa chỉ vận chuyển để tính phí ship
Route::post('/confirm-order', 'App\Http\Controllers\CheckoutController@confirm_order');//ajax thông tin đặt hàng
Route::post('/calculate-fee', 'App\Http\Controllers\CheckoutController@calculate_fee');


use App\Http\Controllers\OrderController;
//order
Route::get('/manage-order', 'App\Http\Controllers\OrderController@manage_order')->middleware('auth.roles');//liệt kê đơn hàng
Route::get('/view-order/{order_code}', 'App\Http\Controllers\OrderController@view_order')->middleware('auth.roles');//chi tiết đơn hàng

Route::post('/export-csv-order','App\Http\Controllers\OrderController@export_csv_order');//xuất dữ liệu đơn hàng về file excel
Route::post('/import-csv-order','App\Http\Controllers\OrderController@import_csv_order');//load dữ liệu đơn hàng từ file excel

Route::post('/update-order-qty', 'App\Http\Controllers\OrderController@update_order_qty');//thay đổi tình trạng đơn hàng
Route::post('/update-qty', 'App\Http\Controllers\OrderController@update_qty');//Cập nhật số lượng trong chi tết đơn hàng


//
Route::get('/delete-order/{order_id}', 'App\Http\Controllers\OrderController@delete_order');
Route::get('/print-order/{checkout_code}', 'App\Http\Controllers\OrderController@print_order');
use App\Http\Controllers\DeliveryController;

//delivery
Route::get('/delivery', 'App\Http\Controllers\DeliveryController@delivery')->middleware('auth.roles');//form quản lý vận chuyển
Route::post('/select-delivery', 'App\Http\Controllers\DeliveryController@select_delivery'); //vận chuyển 
Route::post('/insert-delivery', 'App\Http\Controllers\DeliveryController@insert_delivery'); //phí vận chuyển 
Route::post('/select-feeship', 'App\Http\Controllers\DeliveryController@select_feeship');//hiện thông tin vận chuyển
Route::post('/update-delivery', 'App\Http\Controllers\DeliveryController@update_delivery');//update phí vận chuyển

//phân quyền
use App\Http\Controllers\AuthController;
Route::get('/register-auth', 'App\Http\Controllers\AuthController@register_auth');//form đăng ký auth
Route::get('/login-auth', 'App\Http\Controllers\AuthController@login_auth'); //form đăng nhập auth
Route::get('/logout-auth', 'App\Http\Controllers\AuthController@logout_auth'); //đăng xuất auth
Route::post('/register', 'App\Http\Controllers\AuthController@register');//hàm đăng ký auth
Route::post('/login', 'App\Http\Controllers\AuthController@login'); //hàm đăng nhập auth



use App\Http\Controllers\CategoryPost;
//danh mục bài viết
Route::get('/add-cate-post', 'App\Http\Controllers\CategoryPost@add_cate_post')->middleware('auth.roles');//thêm danh mục bài viết
Route::post('/save-cate-post', 'App\Http\Controllers\CategoryPost@save_cate_post');
Route::get('/all-cate-post', 'App\Http\Controllers\CategoryPost@all_cate_post')->middleware('auth.roles');//liệt kê danh mục bài viết
Route::post('/update-cate-post/{cate_id}', 'App\Http\Controllers\CategoryPost@update_cate_post');//Cập nhật danh mục bài viết
Route::get('/edit-cate-post/{cate_post_id}', 'App\Http\Controllers\CategoryPost@edit_cate_post');//chỉnh sửa danh mục bài viết
Route::get('/delete-cate-post/{cate_post_id}', 'App\Http\Controllers\CategoryPost@delete_cate_post');//Xóa danh mục bài viết


use App\Http\Controllers\PostController;

// ////add-post bài viết

Route::get('/add-post', 'App\Http\Controllers\PostController@add_post')->middleware('auth.roles');//thêm bài viết
Route::post('/save-post', 'App\Http\Controllers\PostController@save_post');
Route::get('/all-post', 'App\Http\Controllers\PostController@all_post')->middleware('auth.roles');//liệt kê bài viết
Route::post('/update-post/{post_id}', 'App\Http\Controllers\PostController@update_post');//Cập nhật bài viết
Route::get('/edit-post/{post_id}', 'App\Http\Controllers\PostController@edit_post');//chỉnh sửa bài viết
Route::get('/delete-post/{post_id}', 'App\Http\Controllers\PostController@delete_post');//Xóa bài viết
Route::get('/active-post/{post_id}', 'App\Http\Controllers\PostController@active_post');//hiện bài viết
Route::get('/unactive-post/{post_id}', 'App\Http\Controllers\PostController@unactive_post');//ẩn bài viết
//Trang pages
Route::get('/danh-muc-bai-viet/{post_slug}', 'App\Http\Controllers\PostController@danh_muc_bai_viet');//hiển thị danh mục bài viết
Route::get('/bai-viet/{post_slug}', 'App\Http\Controllers\PostController@bai_viet');//hiển thị bài viết


use App\Http\Controllers\GalleryController;
//thư mục ảnh(danh sách liệt kê sản phẩm)
Route::get('/add-gallery/{product_id}', 'App\Http\Controllers\GalleryController@add_gallery');//thêm thư viện ảnh
Route::post('/select-gallery', 'App\Http\Controllers\GalleryController@select_gallery');//hiện thư mục con
Route::post('/insert-gallery/{pro_id}', 'App\Http\Controllers\GalleryController@insert_gallery');//Chèn dữ liệu thư mục ảnh
Route::post('/update-gallery-name', 'App\Http\Controllers\GalleryController@update_gallery_name');//update tên hình ảnh
Route::post('/delete-gallery', 'App\Http\Controllers\GalleryController@delete_gallery');//Xóa gallery
Route::post('/update-gallery', 'App\Http\Controllers\GalleryController@update_gallery');//update hình ảnh