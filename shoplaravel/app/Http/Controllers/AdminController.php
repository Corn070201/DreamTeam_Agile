<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use App\Models\Login;
use App\Models\Social; //sử dụng model Social
use Socialite; //sử dụng Socialite
use Carbon\Carbon;
use App\Models\Statistical;
use App\Models\Visitors;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
//use App\Login; //sử dụng model Login

//use App\Http\Request;
use Illuminate\Support\Facades\redirect;
session_start();
class AdminController extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function indexx(){
        
        return view('admin_login');
    }
    public function show_dashboard(Request $request){
        $this->Authlogin();
        //return view('admin.dashboard');
        $user_ip_address = $request->ip();
        //$user_ip_address = '150.13.005.189';
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyears = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        //total last month
        $visitor_of_lastmonth = Visitors::whereBetween('date_visitor',[$early_last_month,$end_of_last_month])->get();
        $visitor_last_month_count = $visitor_of_lastmonth->count();
        
        //total this month
        $visitor_of_thismonth = Visitors::whereBetween('date_visitor',[$early_this_month,$now])->get();
        $visitor_this_month_count = $visitor_of_thismonth->count();

        //total in one year
        $visitor_of_year = Visitors::whereBetween('date_visitor',[$oneyears,$now])->get();
        $visitor_year_count = $visitor_of_year->count();
        //total visitors
        $visitor = Visitors::all();
        $visitor_total = $visitor->count();
        //current online
        $visitor_current = Visitors::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitor_current->count();
        if($visitor_count<1){
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();

        }
        
        //đếm sản phẩm
        $app_product = Product::all()->count();
        //đếm đơn hàng
        $app_order = Order::all()->count();
        //đếm khách hàng
        $app_customer = Customer::all()->count();
        //đếm bài viết
        $app_post = Post::all()->count();
        //$product_views = Product::orderBy('date_visitor','DESC')->take(20)->get();

        //$post_views = Post::orderBy('post_views','DESC')->take(20)->get();
        return view('admin.dashboard')->with(compact('visitor_total','visitor_count',
        'visitor_last_month_count','visitor_this_month_count','visitor_year_count',
        'app_product','app_order','app_customer','app_post'));
    }
    public function dashboard(Request $request){
        $data = $request->all();
        $admin_email = $data['admin_email'];
        $admin_password =md5($data['admin_password']);
        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai');
            return Redirect::to('/admin');
        }
        // $admin_email=$request->admin_email;
        // $admin_password=md5($request->admin_password);
        // $result = DB::table('tbl_admin')->where('admin_email',$admin_email) ->where('admin_password',$admin_password)->first();
        // if($result){
        //     Session::put('admin_name',$result->admin_name);
        //     Session::put('admin_id',$result->admin_id);
        //     return Redirect::to('/dashboard');
        // }else{
        //     Session::put('message','Tài khoản hoặc mật khẩu sai');
        //     return Redirect::to('/admin');
        // }
    } 
    public function logout(){
        $this->Authlogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
    public function login_facebook(){
        //return Socialite::driver('facebook')->redirect();
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/admin/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $bap = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => ''

                ]);
            }
            $bap->login()->associate($orang);
            $bap->save();

            $account_name = Login::where('admin_id',$bap->user)->first();
            Session::put('admin_name',$bap->admin_name);
            Session::put('admin_id',$bap->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }
    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistical::whereBetween('order_date',[$from_date, $to_date])->orderBy('order_date','ASC')->get();
            foreach($get as $key =>$val){
                $chart_data[] = array(
                    //thời gian
                    'period' => $val->order_date,
                    //tổng đơn hàng
                    'order' => $val->total_order,
                    //doanh số
                    'sales' => $val->sales,
                    //Lợi nhuận
                    'profit' => $val->profit,
                    //số lượng đã bán
                    'quantity' => $val->quantity
                );
            }
        echo $data =json_encode($chart_data);
    }
}
