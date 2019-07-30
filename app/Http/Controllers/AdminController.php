<?php

namespace App\Http\Controllers;

use App\goods\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
class AdminController extends CommonController
{
    //首页
    public function index(){


        return view('admin');
    }

    //商品审核页面
    public function goods_examine(Request $request){
        $num = intval($request->get('num')??1);
        $table = 'shop_goods_'.$num;
        $goods_model=new Goods();
        $goods_model->table=$table;
        $data = $goods_model->where(['goods_status'=>3])->get();
        $data = collect($data)->toArray();
        return view('goodslist',['data'=>$data,'num'=>$num]);
    }

    //商家管理页面
    public function business(){
        echo '商家管理';
//        return view('');
    }

}
