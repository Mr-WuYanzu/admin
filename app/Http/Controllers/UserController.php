<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function businessInfo(Request $request){
        $token = $request->post('token');
        //如果token为空让用户登录
        if(empty($token)){
            return ['status'=>102,'msg'=>'请登录'];
            die;
        }
        //接到token查询用户

    }
}
