<?php

namespace App\Http\Controllers;

use App\Cart;
use App\goods\Goods;
use App\model\Order;
use App\Token;
use App\user\Business;
use App\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    //商品审核通过
    public function goodsGo(Request $request){
        $goods_id = $request->post('goods_id');
        $shop_id = $request->post('shop_id');
        if(empty($goods_id) || empty($shop_id)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $where=[
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id
        ];
//        根据shopid确定商品在那个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where($where)->first();
        if(empty($goodsInfo)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $res = $goods_model->where($where)->update(['goods_status'=>1]);
        if($res){
            return ['status'=>1000,'msg'=>'操作成功'];
        }else{
            return ['status'=>1001,'msg'=>'操作失败'];
        }

    }

    //商品审核驳回
    public function goodsDown(Request $request){
        $goods_id = $request->post('goods_id');
        $shop_id = $request->post('shop_id');
        if(empty($goods_id) || empty($shop_id)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $where=[
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id
        ];
//        根据shopid确定商品在那个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where($where)->first();
        if(empty($goodsInfo)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $res = $goods_model->where($where)->update(['goods_status'=>4]);
        if($res){
            return ['status'=>1000,'msg'=>'操作成功'];
        }else{
            return ['status'=>1001,'msg'=>'操作失败'];
        }

    }
    public function test(){
        $order_son_id = Redis::get('order:son:id');
        //查询商家订单子表中的最大的id
        if(empty($order_son_id)){
            $o_id = DB::selectOne('select max(o_id) o_id from (select max(o_id) o_id from shop_order_son_00 UNION All
                                    select max(o_id) o_id from shop_order_son_business_01 union all
                                    select max(o_id) o_id from shop_order_son_business_02 union all
                                    select max(o_id) o_id from shop_order_son_business_03 union all
                                    select max(o_id) o_id from shop_order_son_business_04 union all
                                    select max(o_id) o_id from shop_order_son_business_05 union all
                                    select max(o_id) o_id from shop_order_son_business_06 union all
                                    select max(o_id) o_id from shop_order_son_business_07 union all
                                    select max(o_id) o_id from shop_order_son_business_08 union all
                                    select max(o_id) o_id from shop_order_son_business_09) tt limit 1');
            $order_sonId = $o_id->o_id??0;
            //存入redis中
            
        }else{
            //查
            $order_son_id = Redis::incr('order:son:id');
        }


        $orderInfo = Order::get()->toArray();
        $cart_model = new Cart();
        dd($orderInfo);
        $cartInfo = $cart_model->with('goods')->get()->toArray();
        dd($cartInfo);
    }
}
