<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Session;
use App\Imports\ImportCoupon;
use App\Exports\ExportCoupon;
use Excel;
use Illuminate\Support\Facades\redirect;
session_start();
class CouponController extends Controller
{
    public function insert_coupon(){
        return view('admin.coupon.insert_coupon');
    }
    //Xóa all mã giảm
    public function del_all_coupon(){
        $coupon = Session::get('coupon');
        if($coupon==true){
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa mã khuyến mãi thành công');
        }
    }
    //Xóa từng mã giảm
    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('list-coupon');

    }
    //Thêm mã giảm
    public function insert_coupon_code(Request $request){
       $data = $request->all();
       $coupon = new Coupon;
       $coupon->coupon_name = $data['coupon_name'];
       $coupon->coupon_number = $data['coupon_number'];
       $coupon->coupon_code = $data['coupon_code'];
       $coupon->coupon_times = $data['coupon_times'];
       $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();
        Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('insert-coupon');    
    }
    //danh sách mã giảm
    public function list_coupon(){
        $coupon =Coupon::orderby('coupon_id','DESC')->paginate(5);
        return view('admin.coupon.list_coupon')->with(compact('coupon'));

    }
    public function export_csv_coupon(){
        return Excel::download(new ExportCoupon , 'coupon.xlsx');
    }
    public function import_csv_coupon(Request $request){
        if(  $request->file('file') ) {
            $path = $request->file('file')->getRealPath();
            Excel::import(new ImportCoupon, $path);
            return back();
        }
    }
}
