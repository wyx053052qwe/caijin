@extends('layout.home')
@section('title', '设置联系人')
@section('content')
<div class="layui-breadcrumb page_mbx">
    <a href="/">首页</a><span>-</span>
    <a><cite>设置联系人</cite></a>
</div>
<div class="layui-fluid">
<form class="layui-form layui-form-pane" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">姓名：</label>
        <div class="layui-input-inline">
            <input type="text" name="c_name" required  value="{{$data['c_name']}}" lay-verify="required|name" placeholder="请输入姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号：</label>
        <div class="layui-input-inline">
            <input type="text" name="c_phone" required value="{{$data['c_phone']}}" lay-verify="required|phone" placeholder="请输入手机号" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
</div>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form
            ,layer = layui.layer
        ,$ = layui.$;

        //监听提交
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));
            $.ajax({
                url:"/home/docontact",
                method:'post',
                data:data.field,
                dataType:"json",
                success:function(res){
                        if(res.code==2){
                            layer.msg(res.message);
                        }else{
                            layer.msg(res.message);
                        }
                }
            });
            return false;
        });
    });
</script>
@endsection
