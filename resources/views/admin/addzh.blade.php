@extends('layout.index')
@section('title', '添加账户')
@section('content')
<form class="layui-form" action="{{url('doaddzh')}}" method="post">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">公司名称</label>
        <div class="layui-input-block">
            <input type="text" name="z_fwsmc" required  lay-verify="required" placeholder="请输入公司名称"     class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">工商注册号</label>
        <div class="layui-input-block">
            <input type="text" name="z_gszch" required  lay-verify="required" placeholder="请输入工商注册号"     class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开户银行</label>
        <div class="layui-input-block">
            <input type="text" name="z_khyh" required  lay-verify="required" placeholder="请输入开户银行"     class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">账户名称</label>
        <div class="layui-input-block">
            <input type="text" name="z_zhmc" required  lay-verify="required" placeholder="请输入账户名称"     class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">银行账号</label>
        <div class="layui-input-block">
            <input type="text" name="z_yhzh" required  lay-verify="required" placeholder="请输入银行账号"     class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn submit" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        // //监听提交
        // form.on('submit(formDemo)', function(data){
        //     layer.msg(JSON.stringify(data.field));
        //     return false;
        // });
    });
</script>
@endsection
