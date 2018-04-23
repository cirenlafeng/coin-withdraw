<?php

namespace App\Http\Controllers;

use Request;
use DB;

class HomeController extends Controller
{
    private $domain = 'http://up.kukuvideo.com';
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

    //邀请人信息
    public function inviteInfo()
    {
        $id = Request::input('id','');
        $order = DB::table('task_list')->where('id',$id)->first();
        if(empty($order)) exit();
        $url = $this->domain.'/api/apply/offline/'.$order->uuid;
        $headers = array(
            'user-token:140d7a33b5f31259d4d035dd3fb34b9118daf55'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        dd($data);
    }
}
