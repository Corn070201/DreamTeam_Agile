<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Imports\ImportBrand;
use App\Exports\ExportBrand;
use App\Models\Category_Post;
use Excel;
use Auth;
use App\Models\Brand;
//use App\Http\Request;
use Illuminate\Support\Facades\redirect;
session_start();

class BrandProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->Authlogin();
        return view('admin.add_brand_product');
    }

    public function all_brand_product(){
        $this->Authlogin();
        $all_brand_product=DB::table('tbl_brand')->paginate(5);
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);
    }

    public function save_brand_product(Request $request){
        $this->Authlogin();
        $data=array();
        $data['brand_name']=$request->brand_product_name;
        $data['meta_keywords']=$request->category_product_keyword;
        $data['brand_desc']=$request->brand_product_desc;
        $data['brand_status']=$request->brand_product_status;
        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('add-brand-product');
    }

    public function active_brand_product($brand_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function unactive_brand_product($brand_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm không thành công');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($actegory_product_id){
        $this->Authlogin();
        $edit_brand_product=DB::table('tbl_brand')->where('brand_id',$actegory_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request,$actegory_product_id){
        $this->Authlogin();
        $data=array();
        $data['brand_name']=$request->brand_product_name;
        $data['meta_keywords']=$request->category_product_keyword;
        $data['brand_desc']=$request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id', $actegory_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($actegory_product_id){
        $this->Authlogin();
        DB::table('tbl_brand')->where('brand_id', $actegory_product_id)->delete();
        Session::put('message','Xóa danh mục thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    ////end function admin page
    public function show_brand_home(Request $request,$brand_id){
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
        ->where ('tbl_product.brand_id',$brand_id)->get();
        foreach($brand_product as $key =>$val){
            //SEO
            $meta_desc=$val->brand_desc;
            $meta_keywords=$val->meta_keywords;
            $meta_title=$val->brand_name;
            $url_canonical=$request->url();
            //--SEO
        }
        $brand_name = DB::table('tbl_brand')->where ('tbl_brand.brand_id',$brand_id)->limit(1)->get();
        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('cate_post',$cate_post);

      
    }
    public function export_csv_brand(){
        return Excel::download(new ExportBrand , 'brand.xlsx');
    }
    public function import_csv_brand(Request $request){
        if(  $request->file('file') ) {
            $path = $request->file('file')->getRealPath();
            Excel::import(new ImportBrand, $path);
            return back();
        }
    }
}
