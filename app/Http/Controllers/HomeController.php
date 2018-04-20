<?php

namespace App\Http\Controllers;

use Request;
use DB;

class HomeController extends Controller
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
        $where = [];
        $check_type = Request::input('check_type','off');
        $status = Request::input('status','off');
        if($check_type == 1 || $check_type == 2)
        {
            $where['check_type'] = $check_type;
        }
        if($status == '0' || $status == '1' || $status == '-1')
        {
            $where['status'] = $status;
        }

        $taskList = DB::table('task_list')->where($where)->orderBy('create_time')->orderBy('money','desc')->paginate(20);
        return view('home',['taskList'=>$taskList]);
    }

    //审核通过
    public function checkPass()
    {

    }

    //审核拒绝
    public function checkMiss()
    {
        
    }
}
