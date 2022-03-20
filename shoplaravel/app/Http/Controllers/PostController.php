<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;

//use App\Http\Request;
use Illuminate\Support\Facades\redirect;
use App\Models\Category_Post;
use App\Models\Post;
use App\Imports\ExcelImports;
use App\Exports\ExcelExports;
use Excel;
use Auth;
session_start();
class PostController extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_post(){
        $this->Authlogin();
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
        return view('admin.post.add_post')->with(compact('cate_post'));
    }

    public function all_post(Request $request){
        $this->Authlogin();
        $data = $request->all();
        $all_post= Post::orderby('post_id')->paginate(5);
        return view('admin.post.all_post')->with(compact('all_post',$all_post));
    }

    public function save_post(Request $request){
        $this->Authlogin();
        $data = $request->all();
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];
        $get_image=$request->file('post_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/post',$new_image);
            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Thêm bài viết thành công');
            return redirect()->back();
        }else{
            Session::put('message','Vui lòng thêm ảnh');
            return redirect()->back();
        }
        

        
    }

    public function active_post($post_id){
        $this->Authlogin();
        DB::table('tbl_posts')->where('post_id', $post_id)->update(['post_status'=>1]);
        Session::put('message','Kích hoạt bài viết thành công');
        return Redirect::to('all-post');
    }

    public function unactive_post($post_id){
        $this->Authlogin();
        DB::table('tbl_posts')->where('post_id', $post_id)->update(['post_status'=>0]);
        Session::put('message','Kích hoạt bài viết không thành công');
        return Redirect::to('all-post');
    }
    public function delete_post($post_id){
        $this->Authlogin();
        $post = Post::find($post_id);
        unlink('public/upload/post/'.$post->post_image);
        $post->delete();
        Session::put('message','Xóa bài viết thành công');
        return Redirect()->back();
    }
    public function danh_muc_bai_viet($post_slug, Request $request){
        //category_post
        $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $catepost = Category_Post::where('cate_post_slug',$post_slug)->take(1)->get();
        foreach($catepost as $key =>$cate){ 
        //SEO
         $meta_desc = $cate->cate_post_desc;
         $meta_keywords = $cate->cate_post_slug;
         $meta_title = $cate->cate_post_name;
         $cate_id = $cate->cate_post_id;
         $url_canonical = $request->url();
         //--SEO
        }
        $post = Post::with('cate_post')->where('post_status',1)->where('cate_post_id',$cate_id)->paginate(5);
        return view('pages.baiviet.danhmucbaiviet')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('post',$post)->with('cate_post',$cate_post);
    }
    public function bai_viet(Request $request, $post_slug){
         //category_post
         $cate_post = Category_Post::orderby('cate_post_id','DESC')->get();
         $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
         $brand_product=DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
         $post = Post::with('cate_post')->where('post_status',1)->where('post_slug',$post_slug)->take(1)->get();
        //  $catepost = Category_Post::where('cate_post_slug',$post_slug)->take(1)->get();
         foreach($post as $key =>$p){ 
         //SEO
          $meta_desc = $p->post_meta_desc;
          $meta_keywords = $p->post_meta_keywords;
          $meta_title = $p->post_title;
          $cate_id = $p->cate_post_id;
          $url_canonical = $request->url();
          $cate_post_id = $p->cate_post_id;
          //--SEO
         }
        $related = Post::with('cate_post')->where('post_status',1)->where('cate_post_id',$cate_post_id)
        ->whereNotIn('post_slug',[$post_slug])->take(5)->get();
         return view('pages.baiviet.bai_viet')->with('category',$cate_product)->with('brand',$brand_product)
         ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
         ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('post',$post)
         ->with('cate_post',$cate_post)->with('related',$related);
    }
}
