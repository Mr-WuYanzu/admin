


@extends('layouts')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">

            <form class="layui-form" action="">
                <input type="hidden" name="token" value="{{$_COOKIE['token']??null}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">商品名称</label>
                    <div class="layui-input-block" style="width:300px">
                        <input type="text" name="goods_name" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商品库存</label>
                    <div class="layui-input-block" style="width:300px">
                        <input type="text" name="goods_stock" required  lay-verify="required" placeholder="请输入库存" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商品单价</label>
                    <div class="layui-input-block" style="width:300px">
                        <input type="text" name="goods_price" required  lay-verify="required" placeholder="请输入价格" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">商品图片</label>
                    <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <input type="hidden" name="goods_img">
                    <div id="goods_img"></div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">商品介绍</label>
                    <div class="layui-input-block">
                        <textarea name="goods_desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">添加</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>

            <script>
                //Demo
                layui.use(['form','upload'], function(){
                    var form = layui.form;
                    var upload = layui.upload;
                    //执行实例
                    var uploadInst = upload.render({
                            elem: '#test1' //绑定元素
                            ,url: '/upload' //上传接口
                            ,done: function(res){
                                if(res.status==1000){
                                    $img='<img src="http://img.com/'+res.path+'" width="60px" height="60px">';
                                    $('#goods_img').empty();
                                    $('#goods_img').append($img);
                                    $('[name=goods_img]').val(res.path);
                                    alert('上传成功');
                                }else{
                                    alert('上传失败');
                                }
                            }
                            ,error: function(){
                                //请求异常回调
                            }
                        });
                    //监听提交
                    form.on('submit(formDemo)', function(data){
                        // layer.msg(JSON.stringify(data.field));
                        $.ajax({
                            url:'/goodsAdd',
                            data:data.field,
                            type:'post',
                            success:function (res) {
                                if(res.status==1000){
                                    alert(res.msg);
                                    history.go(0);
                                }else{
                                    alert(res.msg);
                                }
                            }
                        })

                        return false;
                    });
                });
            </script>

        </div>
    </div>
@endsection

