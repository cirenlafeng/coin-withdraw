<?php

namespace App\Http\Controllers;

use Request;
use DB;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!(Auth::user()->level >= 1))
        {
            exit('没有权限');
        }
        $user = DB::table('users')->select('id','name','email','created_at','level')->get();
        return view('user.index',['user' => $user]);
    }

    public function edit($id)
    {
        if(!(Auth::user()->level == 99))
        {
            echo "<script>alert('没有权限')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        $userInfo = DB::table('users')->where('id',$id)->select('id','name','email','created_at','level')->first();
        return view('user.edit',['userInfo' => $userInfo]);
    }

    public function update($id)
    {
        if(!(Auth::user()->level == 99))
        {
            exit('没有权限');
        }
        $email = Request::input('email','');
        $pwd = Request::input('password','');
        $pwdRe = Request::input('password_re','');
        $level = Request::input('level','0');
        if($level > 1)
        {
            $level = 1;
        }
        if(empty($email) || $pwd !== $pwdRe)
        {
            echo "<script>alert('资料填写不正确')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        if(DB::table('users')->where('email',$email)->where('id','<>',$id)->count())
        {
            echo "<script>alert('邮箱已存在')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        $update = [];
        $update['email'] = $email;
        if(!empty($pwd))
        {
            $update['password'] = bcrypt($pwd);
        }
        $update['level'] = $level;
        DB::table('users')->where('id',$id)->update($update);
        echo "<script>alert('success !')</script>";
        echo "<script>history.go(-1)</script>";
        exit();
    }

    public function destroy($id)
    {
        if(!(Auth::user()->level == 99))
        {
            exit('没有权限');
        }
        DB::table('users')->where('id',$id)->delete();
        return redirect('/user');
    }

    public function create()
    {
        if(!(Auth::user()->level == 99))
        {
            echo "<script>alert('没有权限')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        return view('user.add');
    }

    public function store()
    {
        if(!(Auth::user()->level == 99))
        {
            exit('没有权限');
        }
        $email = Request::input('email','');
        $pwd = Request::input('password','');
        $pwdRe = Request::input('password_re','');
        $level = Request::input('level','0');
        $name = Request::input('name','');
        if($level > 1)
        {
            $level = 1;
        }
        if(empty($name) || empty($email) || $pwd !== $pwdRe)
        {
            echo "<script>alert('资料填写不正确')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        if(DB::table('users')->where('email',$email)->count())
        {
            echo "<script>alert('邮箱已存在')</script>";
            echo "<script>history.go(-1)</script>";
            exit();
        }
        $save = [];
        $save['name'] = $name;
        $save['email'] = $email;
        if(!empty($pwd))
        {
            $save['password'] = bcrypt($pwd);
        }
        $save['level'] = $level;
        $save['created_at'] = date('Y-m-d H:i:s',time());
        $save['updated_at'] = date('Y-m-d H:i:s',time());
        DB::table('users')->insert($save);
        return redirect('/user');
    }
}
