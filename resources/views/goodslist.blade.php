


@extends('layouts')

@section('title', 'Laravel学院')

@section('sidebar')
@parent
@endsection

@section('content')
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        审核表: <select name="" id="sel">

            @if($num==1)
            <option value="1" selected>一表</option>
            <option value="2">二表</option>
            <option value="3">三表</option>
            <option value="4">四表</option>
            <option value="0">五表</option>
            @elseif($num==2)
                <option value="1">一表</option>
                <option value="2" selected>二表</option>
                <option value="3">三表</option>
                <option value="4">四表</option>
                <option value="0">五表</option>
            @elseif($num==3)
                <option value="1">一表</option>
                <option value="2">二表</option>
                <option value="3" selected>三表</option>
                <option value="4">四表</option>
                <option value="0">五表</option>
            @elseif($num==4)
                <option value="1">一表</option>
                <option value="2">二表</option>
                <option value="3">三表</option>
                <option value="4" selected>四表</option>
                <option value="0">五表</option>
            @else
                <option value="1">一表</option>
                <option value="2">二表</option>
                <option value="3">三表</option>
                <option value="4">四表</option>
                <option value="0" selected>五表</option>
            @endif
        </select>
        <script>
            $('#sel').change(function () {
                var num = $(this).val();
                location.href='/goods_examine?num='+num;
            })
        </script>
        @if(empty($data))
            暂无商品
        @else
        <table border="1">
            <tr align="center">
                <td>id</td>
                <td>商品名称</td>
                <td>商品价格</td>
                <td>商品库存</td>
                <td>商品介绍</td>
                <td>商品图片</td>
                <td>操作</td>
            </tr>
            @foreach($data as $k=>$v)
            <tr align="center">
                <td>{{$v['goods_id']}}</td>
                <td>{{$v['goods_name']}}</td>
                <td>{{$v['goods_price']}}</td>
                <td>{{$v['goods_stock']}}</td>
                <td>{{$v['goods_desc']}}</td>
                <td><img src="http://img.com/{{$v['goods_img']}}" alt="" width="80" height="80"></td>
                <td goods_id="{{$v['goods_id']}}" shop_id="{{$v['shop_id']}}"><button id="btn1">通过</button><button id="btn2">驳回</button></td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
    <script>
        //点击通过
        $(document).on('click','#btn1',function () {
            var _this = $(this);
            //获取商品id和商家id
            var goods_id = _this.parent('td').attr('goods_id');
            var shop_id = _this.parent('td').attr('shop_id');
            $.ajax({
                url:'/goodsGo',
                type:'post',
                data:{goods_id:goods_id,shop_id:shop_id},
                dataType:'json',
                async:false,
                success:function (res) {
                    if(res.status==1000){
                        alert(res.msg);
                        _this.parents('tr').remove();
                    }else{
                        alert(2);
                        alert(res.msg);
                    }
                }
            })
        })
        //点击驳回   重复上边的步骤
        $(document).on('click','#btn2',function () {
            var _this = $(this);
            var goods_id = _this.parent('td').attr('goods_id');
            var shop_id = _this.parent('td').attr('shop_id');
            $.ajax({
                url:'/goodsStop',
                type:'post',
                data:{goods_id:goods_id,shop_id:shop_id},
                dataType:'json',
                async:false,
                success:function (res) {
                    if(res.status==1000){
                        alert(res.msg);
                        //通过以后，将这一行删除
                        _this.parents('tr').remove();
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
    </script>
</div>
@endsection

