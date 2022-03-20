<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use App\Models\Category_Post;
//use App\Http\Request;
use App\Models\Coupon;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\redirect;
session_start();
class HomeController extends Controller
{
    public function error_page(){
        return view('errors.404');
    }
    //Truy vấn sữ liệu thông tin ra trang chính
    public function index(Request $request){
        //category_post
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        //SEO
        $meta_desc="Chuyên bán quần áo và giày dép";
        $meta_keywords="quần áo, giày dép";
        $meta_title="SHOPLARAVEL-Thời trang quần áo";
        $url_canonical=$request->url();
        //--SEO
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $all_product=DB::table('tbl_product')->where('product_status',1)->orderby('product_id','desc')->limit('4')->get();
        return view('pages.home')
        ->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
    }
    //Tìm kiếm
    public function search(Request $request){
        //SEO
        $meta_desc="Tìm kiếm sản phẩm";
        $meta_keywords="Tìm kiếm sản phẩm";
        $meta_title="Tìm kiếm sản phẩm";
        $url_canonical=$request->url();
        //--SEO
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $search_product=DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);
    }
    public function send_mail(){
        $to_name = "APP_NAME";
        $to_email = "nguyenniem0702@gmail.com";
        
        $data = array("name"=>"i love you","body"=>"are you love me?");
            
        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Test gmail');
            $message->from($to_email,$to_name);
        });
        //return view('admin_layout');//->with('message',' ');
    }
    // public function send_coupon(){
    //     $customer_vip = Customer::where('customer_vip',1)->get();
    //     $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
    //     $title_mail = "Mã khuyến mãi".' '.$now;
    //     $data = [];
    //     foreach($customer_vip as $vip){
    //         $data['email'][] = $vip->$customer_email;

    //     }
    //     Mail::send('pages.send_mail',$data,function($message) use ($title_mail,$data){
    //         $message->to($data['email'])->subject('$title_mail');
    //         $message->from($data['email'], $title_mail);
    //     });
    //     return redirect()->back()->with('message','Gửi mã cho khách thành công');;
    // }

}
