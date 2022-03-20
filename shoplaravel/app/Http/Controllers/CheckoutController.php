<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Category_Post;
use App\Models\OrderDetails;
use Auth;
//use App\Http\Request;
use Illuminate\Support\Facades\redirect;
session_start();
class CheckoutController extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    //Xác nhận đơn hàng
    public function confirm_order(Request $request){
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name=$data['shipping_name'];
        $shipping->shipping_email=$data['shipping_email'];
        $shipping->shipping_phone=$data['shipping_phone'];
        $shipping->shipping_address=$data['shipping_address'];
        $shipping->shipping_notes=$data['shipping_notes'];
        $shipping->shipping_method=$data['shipping_method'];
        $shipping->save();
        // $shipping->order_coupon=$data['order_coupon'];
        $shipping_id = $shipping->shipping_id;
        $checkout_code = substr(md5(microtime()),rand(0,26),5);
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at=$today;
        $order->order_date = $order_date;
        $order->save();

        
        if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key =>$cart){
                $order_details = new OrderDetails();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('cart');
    }
    // public function calculate_fee(Request $request){
    //     $data = $request->all();
    //     if($data['matp']){
    //         $feeship=Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->
    //         where('fee_xaid',$data['xaid'])->get();
    //         foreach($feeship as $key=>$fee){
    //             Sesion::put('fee',$fee->fee_ship);
    //             Session::save();
    //         }
    //     }
    // }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key =>$province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }else{
                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                    $output.='<option>---Chọn phường xã---</option>';
                foreach($select_wards as $key =>$ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
        }
        echo $output;
    }
    public function login_checkout(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        //SEO
        $meta_desc="Đăng nhập thanh toán";
        $meta_keywords="Đăng nhập thanh toán";
        $meta_title="Đăng nhập thanh toán";
        $url_canonical=$request->url();
        //--SEO
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);

    }
    public function add_customer(Request $request){
    
        $data=array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        
        $customer_id=DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }
    public function checkout(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
         //SEO
         $meta_desc="Thanh toán sản phẩm";
         $meta_keywords="Thanh toán sản phẩm";
         $meta_title="Thanh toán sản phẩm";
         $url_canonical=$request->url();
         //--SEO

        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        /////////
        $city = City::orderby('matp','ASC')->get();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('city',$city)->with('cate_post',$cate_post);
    }
    public function save_checkout_customer(Request $request){
        $data=array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;
        $shipping_id=DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        
        return Redirect::to('/payment');
    }
    public function payment(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
        //SEO
        $meta_desc="Thanh toán sản phẩm";
        $meta_keywords="Thanh toán sản phẩm";
        $meta_title="Thanh toán sản phẩm";
        $url_canonical=$request->url();
        //--SEO
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email= $request->email_account;
        $password = md5($request->password_account);
        $result= DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();
        //Session::put('customer_id',$result->customer_id);
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
             return Redirect::to('/login-checkout');
        }
    }
    public function order_place(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
         //SEO
         $meta_desc="Thanh toán sản phẩm";
         $meta_keywords="Thanh toán sản phẩm";
         $meta_title="Thanh toán sản phẩm";
         $url_canonical=$request->url();
         //--SEO
        //lấy hình thức thanh toán
        $data=array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id=DB::table('tbl_payment')->insertGetId($data);
        // đơn hàng
        $order_data=array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id=DB::table('tbl_order')->insertGetId($order_data);
        //chi tiết đơn hàng
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
            if($data['payment_method']==1){
                echo "Thanh toán thẻ ATM";
            }elseif($data['payment_method']==2){
                //đang lỗi style
                Cart::destroy();
                $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
                $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
                return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product)
                ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
                ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
            }
            else{
                echo "thẻ ghi nợ";
            }
        }
        
    }
    public function manage_order(){
        $this->Authlogin();
        $all_order=DB::table('tbl_order')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->paginate(5);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
       
    }
    public function view_order($orderId){
        $this->Authlogin();
        $order_by_id=DB::table('tbl_order')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->first();
       
        $manage_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manage_by_id);
    }
    
}
