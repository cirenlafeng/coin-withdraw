<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Request;
use DB;

class TaskController extends Controller
{
    //交易平台
    private $btcDomain = '';

    public function __construct()
    {
        $this->btcDomain = env('BTC_EXCHANGE_DOMAIN','');
    }

    public function index()
    {
        $API_KEY = Request::input('api_key','0');
        if(empty($API_KEY) || ($API_KEY !== env('API_KEY')))
        {
            return response()->json([
                'status' => 501,
                'data' => 'Permission denied'
            ]);
        }

        $postData = [];
        $postData['phone'] = Request::input('phone','');
        $postData['uuid'] = Request::input('uuid','');
        $postData['area'] = Request::input('country_code','');
        $postData['money'] = Request::input('coin','');
        $postData['order_number'] = Request::input('order_number','');
        $postData['invited_num'] = Request::input('share_count','');
        $postData['upexid'] = Request::input('upexid',0);
        foreach ($postData as $key => $value) {
            if(empty($value))
            {
                if($key == 'invited_num')
                {
                    continue;
                }
                return response()->json([
                    'status' => 502,
                    'data' => 'Missing parameters:'.$key
                ]);
            }
        }
        $moneyCount = DB::table('task_list')->where(['phone'=>$postData['phone'],'area'=>$postData['area']])->sum('money');
        if( $moneyCount >= 0.00054 || $postData['invited_num'] > 5 || $postData['money'] >= 0.00054 )
        {
            $postData['check_type'] = 2;//人工审核
        }else{
            $postData['check_type'] = 1;//自动审核
            $post_data = array(
                "api_key" => env('BTC_API_KEY',''),
                "ids" => $postData['upexid'].':'.$postData['money'],
                "type" => 100,
                "zsSymbol" => 'BTC',
            );
            $btcUrl = $this->btcDomain.'/operate-onem-api/present_coin_normal_submit.html';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $btcUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $post_data,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response,true);
            if($response['code'] != 0)
            {
                echo "自动审核异常，错误原因：<br>";
                dd($response);
            }
        }
        $postData['status'] = 0;
        $postData['create_time'] = time();
        $postData['check_time'] = 0;
        if(DB::table('task_list')->insert($postData))
        {
            return response()->json([
                'status' => 200,
                'check_type' => $postData['check_type'],
                'data' => 'save success'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'data' => 'save error'
            ]);
        }
    }
}
