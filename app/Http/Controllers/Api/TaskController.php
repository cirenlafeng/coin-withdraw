<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Request;
use DB;

class TaskController extends Controller
{
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
        $postData['invited_num'] = Request::input('share_count','');
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
