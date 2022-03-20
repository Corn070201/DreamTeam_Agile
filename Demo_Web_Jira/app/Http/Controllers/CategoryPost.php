<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Models\Category_Post;
//use App\Http\Request;
use Illuminate\Support\Facades\redirect;


session_start();
class CategoryPost extends Controller
{
    public function Authlogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_cate_post(){
        $this->Authlogin();
        return view('admin.category_post.add_cate_post');
    }

    public function all_cate_post(){
        $this->Authlogin();
        //paginate(5) : 5 danh mục bài viết một trang
        $category_post = Category_Post::orderBy('cate_post_id','DESC')->paginate(5);
        $all_category_product=DB::table('tbl_category_product')->get();
       
        return view('admin.category_post.all_cate_post')->with(compact('category_post'));
    }

    public function save_cate_post(Request $request){
        $this->Authlogin();
        $data=$request->all();
        $category_post = new Category_Post();
        $category_post->cate_post_name = $data['cate_post_name'] ;
        $category_post->cate_post_slug = $data['cate_post_slug'] ;
        $category_post->cate_post_desc = $data['cate_post_desc'] ;
        $category_post->cate_post_status = $data['cate_post_status'] ;
        $category_post->save();
        Session::put('message','Thêm bài viết thành công');
        return Redirect()->back();
    }
    public function edit_cate_post($cate_post_id){
        $this->Authlogin();
        $category_post =  Category_Post::find($cate_post_id);
        
        return view('admin.category_post.edit_cate_post')->with(compact('category_post'));
    }
    public function update_cate_post(Request $request, $cate_id){
        $data=$request->all();
        $category_post =  Category_Post::find($cate_id);
        $category_post->cate_post_name = $data['cate_post_name'] ;
        $category_post->cate_post_slug = $data['cate_post_slug'] ;
        $category_post->cate_post_desc = $data['cate_post_desc'] ;
        $category_post->cate_post_status = $data['cate_post_status'] ;
        $category_post->save();
        Session::put('message','Cập nhật bài viết thành công');
        return Redirect('/all-cate-post');
    }
    public function delete_cate_post($cate_post_id){
        $category_post =  Category_Post::find($cate_post_id);
        $category_post->delete();
        Session::put('message','Xóa danh mục thành công');
        return Redirect()->back();
    }
    //bài viết
}