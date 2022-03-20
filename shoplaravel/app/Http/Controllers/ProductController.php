<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
//use App\Http\Request;
use App\Imports\ImportProduct;
use App\Exports\ExportProduct;
use App\Models\Product;
use App\Models\Category_Post;
use App\Models\Post;
use App\Models\Gallery;
use File;
use Excel;
use Auth;
use Illuminate\Support\Facades\redirect;
session_start();
class ProductController extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product(){
        $this->Authlogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }

    public function all_product(){
        $this->Authlogin();
        $all_product=DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(5);
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.all_product',$manager_product);
    }

    public function save_product(Request $request){
        $this->Authlogin();
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_quantity']=$request->product_quantity;
        $data['product_sold']=$request->product_sold;
        $data['product_price']=$request->product_price;
        $data['product_desc']=$request->product_desc;
        $data['product_content']=$request->product_content;
        $data['category_id']=$request->product_cate;
        $data['brand_id']=$request->product_brand;
        $data['product_status']=$request->product_status;
        $data['product_image']=$request->product_image;
        $get_image=$request->file('product_image');
        $path ='public/upload/product/';
        $path_gallery = 'public/upload/gallery/';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            $data['product_image']=$new_image;
            
        }
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('all-product');
        // $data['product_image']='';
        // DB::table('tbl_product')->insert($data);
        // Session::put('message','Thêm sản phẩm thành công');
        // return Redirect::to('all-product');
    }

    public function active_product($product_id){
        $this->Authlogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
        Session::put('message','Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
        $this->Authlogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
        Session::put('message','Kích hoạt sản phẩm không thành công');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id){
        $this->Authlogin();
        $cate_product = DB::table('tbl_category_product') ->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        $edit_product=DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product',$edit_product)
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product',$manager_product);
    }
    public function update_product(Request $request,$product_id){
        $this->Authlogin();
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_quantity']=$request->product_quantity;
        $data['product_sold']=$request->product_sold;
        $data['product_price']=$request->product_price;
        $data['product_desc']=$request->product_desc;
        $data['product_content']=$request->product_content;
        $data['category_id']=$request->product_cate;
        $data['brand_id']=$request->product_brand;
        $data['product_status']=$request->product_status;
        $get_image=$request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $new_image = $get_name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product',$new_image);
            $data['product_image']=$new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);;
        Session::put('message','Cập nhật nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->Authlogin();
        $product = Product::find($product_id);
        unlink('public/upload/product/'.$product->product_image);
        $product->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect()->back();
    }
    //end admin pages
    public function details_product($product_id, Request $request){
        //category_post
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $product=DB::table('tbl_product')->where('product_status',1)->orderby('brand_id','desc')->get();
        $details_product=DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();
       
        foreach ($details_product as $key=>$value){
            $category_id=$value->category_id;
            $product_id=$value->product_id;
            //SEO
            $meta_desc=$value->product_desc;
            $meta_keywords=$value->product_content;
            $meta_title=$value->product_name;
            $url_canonical=$request->url();
            //--SEO
        }
        //gallery
        $gallery = Gallery::where('product_id',$product_id)->get();
        $related_product=DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();
        return view('pages.sanpham.show_details')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('product_details', $details_product)->with('relate',$related_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('cate_post',$cate_post) ->with('gallery',$gallery);

    }
    public function export_csv_product(){
        return Excel::download(new ExportProduct , 'product.xlsx');
    }
    public function import_csv_product(Request $request){
        if(  $request->file('file') ) {
            $path = $request->file('file')->getRealPath();
            Excel::import(new ImportProduct, $path);
            return back();
        }
    }
}