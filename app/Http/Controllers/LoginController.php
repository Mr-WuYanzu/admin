<?php

namespace App\Http\Controllers;

use App\Token;
use App\user\Admin;
use App\user\Business;
use App\user\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登录视图
    public function login(){
        return view('login');
    }
//    发送登录
    public function sendLogin(Request $request){
        $user_name = $request->post('user_name');
        $user_pwd = $request->post('user_pwd');
        //登录接口地址
        $url='http://www.admin.com/loginDo';
        $ch = curl_init();
        $data = [
            'user_name'=>$user_name,
            'user_pwd'=>$user_pwd
        ];
        $str = http_build_query($data);
        //设置参数
        $arr=[
            CURLOPT_URL=>$url,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$str,
            CURLOPT_RETURNTRANSFER=>true
        ];
        curl_setopt_array($ch,$arr);
        //发起请求
        $res = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($res,true);
        if($data['status']==1000){
            setcookie('admin_token',$data['token'],time()+60*60*2,'/','www.admin.com',0);
            return $res;
        }else{
            return $res;
        }
    }
    //登录执行
    public function loginDo(Request $request){
        $user_name = $request->post('user_name');
        $user_pwd = $request->post('user_pwd');
        //验证参数完整性
        if(empty($user_name)||empty($user_pwd)){
            return ['status'=>100,'msg'=>'参数不能为空'];die;
        }
        $where=[
            'admin_name'=>$user_name
        ];
        //验证用户
        $userInfo = Admin::where($where)->first();
        if(empty($userInfo)){
            return ['status'=>101,'msg'=>'用户名或密码不正确'];die;
        }
        if($userInfo->admin_pwd!=$user_pwd){
            return ['status'=>101,'msg'=>'用户名或密码不正确'];die;
        }
            //将查到的结果处理成数组
            $businessInfo = collect($userInfo)->toArray();
            //生成token
            $token = md5(json_encode($businessInfo).time());
            //查询此用户有没有登陆过
            $tokenInfo = Token::where(['user_id'=>$userInfo['user_id']])->first();
            //登录成功生成token
            if($tokenInfo){
                $res = Token::where('id',$tokenInfo->id)->update(['token'=>$token,'expire'=>time()+7200]);
            }else{
                $res = Token::insert(['token'=>$token,'user_id'=>$userInfo['user_id'],'expire'=>time()+7200]);
            }
            //返回提示信息
            if($res){
                return ['status'=>1000,'token'=>$token];
            }else{
                return ['status'=>103,'msg'=>'登录失败'];
            }



    }
}
