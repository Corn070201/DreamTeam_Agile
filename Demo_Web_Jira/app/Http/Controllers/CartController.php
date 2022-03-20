<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use App\Models\Category_Post;
use Session;
use App\Models\Coupon;
//use App\Http\Request;
use Illuminate\Support\Facades\redirect;
session_start();
class CartController extends Controller
{
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }
        Session::save();
    }  
    public function gio_hang(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        //SEO
        $meta_desc="giỏ hàng Ajax";
        $meta_keywords="giỏ hàng Ajax";
        $meta_title="giỏ hàng Ajax";
        $url_canonical=$request->url();
        //--SEO
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
    }
    //update gio-hang
    public function update_cart(Request $request){
        $data=$request->all();
        $cart=Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key=>$qty){
                foreach($cart as $session =>$val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
               
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Cập nhật số lượng thành công');
        }else{
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');
        }
    }
    //Xóa sp
    public function del_product($session_id){
        $cart = Session::get('cart');
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        if($cart==true){
            foreach($cart as $key =>$val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }
    //Xóa hết sp
    public function del_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa giỏ hàng thành công');
        }
    }
    //test mã giảm để sử dụng
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_avaiable=0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'coupon_code'=>$coupon->coupon_code,
                            'coupon_condition'=>$coupon->coupon_condition,
                            'coupon_number'=>$coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'coupon_code'=> $coupon->coupon_code,
                        'coupon_condition'=> $coupon->coupon_condition,
                        'coupon_number'=> $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return Redirect()->back()->with('message','Thêm mã giảm giá thành công');
            }
        }else{
            return Redirect()->back()->with('message','Mã giảm giá không đúng');
        }
       

        
    }
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first();
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        
        //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        //Cart::destroy();
        $data['id']=$product_info->product_id;
        $data['qty']=$quantity;
        $data['name']=$product_info->product_name;
        $data['price']=$product_info->product_price;
        $data['weight']='123';
        $data['options']['image']=$product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(0);
        return Redirect::to('/show-cart');
    
    }
    public function show_cart(Request $request){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        //SEO
        $meta_desc="giỏ hàng của bạn";
        $meta_keywords="giỏ hàng của bạn";
        $meta_title="giỏ hàng của bạn";
        $url_canonical=$request->url();
        //--SEO
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');

    }
    //update số lượng
    public function update_cart_quantity(Request $request){
        $rowId=$request->rowId_cart;
        $qty=$request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
