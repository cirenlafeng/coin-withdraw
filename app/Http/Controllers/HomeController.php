<?php

namespace App\Http\Controllers;

use Request;
use DB;

class HomeController extends Controller
{
    //接口域名
    private $domain = 'http://up.kukuvideo.com';

    private $userToken = '140d7a33b5f31259d4d035dd3fb34b9118daf551';
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
        $id = Request::input('id','');
        $order = DB::table('task_list')->where('id',$id)->first();
        if(empty($order)) exit("异常提交");
        if($order->status == 0)
        {
            $post_data = array(
                "api_key" => env('API_KEY'),
                "coin" => $order->money,
                "order_number" => $order->order_number,
                "result_code" => 1,
                "uuid" => $order->uuid,
            );
            $url = $this->domain.'/api/apply/verify';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "user-token: ".$this->userToken,
                    ),
                CURLOPT_POSTFIELDS => $post_data,
            ));
            $response = curl_exec($curl);
            $response = json_decode($response,true);
            if(isset($response['data']) && $response['data']['code'] == 1)
            {
                DB::table('task_list')->where('id',$id)->update(['status'=>1]);
                return back()->with('statusTask', '列表ID :'.$id.' 提交成功！');
            }else{
                if(isset($response['data']))
                {
                    dd($response['data']);
                }else{
                    echo "任务处理异常，错误原因：<br>";
                    dd($response);
                }
            }
        }
        if(empty($order)) exit("异常提交");
    }

    //审核拒绝
    public function checkMiss()
    {
        $id = Request::input('id','');
        $order = DB::table('task_list')->where('id',$id)->first();
        if(empty($order)) exit("异常提交");
        if($order->status == 0)
        {
            
        }
        if(empty($order)) exit("异常提交");
    }

    //邀请人信息
    public function inviteInfo()
    {
        $id = Request::input('id','');
        $page = Request::input('page','1');
        $order = DB::table('task_list')->where('id',$id)->first();
        if(empty($order)) exit();
        $url = $this->domain.'/api/apply/offline/'.$order->uuid.'?page='.$page;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "user-token: ".$this->userToken,
                ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response,true);
        if(isset($response['data']['data']))
        {
            return view('inviteList',['list'=>$response['data']['data'],'page'=>$page,'id'=>$id,'phone'=>$order->phone]);
        }else{
            exit("NO DATA");
        }
    }
}
