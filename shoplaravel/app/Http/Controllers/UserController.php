<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Roles;
use App\Models\Admin;
use Auth;
use Session;
class UserController extends Controller
{
    public function index()
    {
        $admin = Admin::with('roles')->orderBy('admin_id','DESC')->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
    }
    public function add_users(){
        return view('admin.users.add_users');
    }
    public function assign_roles(Request $request){
        if(Auth::id() == $request->admin_id){
            return redirect()->back()->with('message','Bạn không được phân quyền chính mình');
        }
        $data = $request->all();
        $user = Admin::where('admin_email',$data['admin_email'])->first();
        $user->roles()->detach();
        if($request['user_role']){
           $user->roles()->attach(Roles::where('name','user')->first());     
        }
        if($request['admin_role']){
           $user->roles()->attach(Roles::where('name','admin')->first());     
        }
        return redirect()->back()->with('message','Cấp quyền thành công');
    }
    public function store_users(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        $admin->roles()->attach(Roles::where('name','user')->first());
        Session::put('message','Thêm users thành công');
        return Redirect::to('add-users');
    }
    public function delete_users_roles($admin_id){
        if(Auth::id() == $admin_id){
            return redirect()->back()->with('message','Bạn không được quyền xóa');
        }
        $admin = Admin::find($admin_id);
        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xóa user thành công');
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }



}
