@extends('layout.index')
@section('title', '添加税单')
@section('content')
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">客户名字</label>
        <div class="layui-input-block">
            <input type="text" name="s_name" required  lay-verify="required" placeholder="请输入客户名字"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">公司名字</label>
        <div class="layui-input-block">
            <select name="g_id" lay-verify="required">
                <option value=""></option>
                @foreach($gong as $g)
                <option value="{{$g->g_id}}">{{$g->g_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">服务商名字</label>
        <div class="layui-input-block">
            <select name="z_id" lay-verify="required">
                <option value=""></option>
                @foreach($data as $d)
                <option value="{{$d->z_id}}">{{$d->z_fwsmc}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">税单月份</label>
        <div class="layui-input-block">
            <input type="text" name="s_month" class="layui-input" placeholder="时间格式：yyy-mm-dd" id="text1">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">税单图片</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <img src="" alt="暂无图片" id="img" height="200" width="200">
            <input type="hidden" name="s_img" value="" class="s_img">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use(['form','upload'], function(){
        var form = layui.form
        , upload = layui.upload
        ,$ = layui.$;
        laydate.render({
            elem: '#text1' //指定元素
        });
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '{{url('add/upload')}}' //上传接口
            ,method: 'post'
            ,done: function(res){
            // console.log(res);
            if(res.code == 1){
                $('#img').attr('src',res.message);
                $('.s_img').val(res.message);
                layer.msg('上传成功');
            }else if(res.code == 3){
                layer.msg(res.message);
            }else if(res.code == 4){
                layer.msg(res.message);
            }
            //上传完毕回调
        }
    ,error: function(){
            //请求异常回调
            layer.msg(res.message);
        }
    });
    //监听提交
    form.on('submit(formDemo)', function(data){
        $.ajax({
            url:"/doaddsd",
            method:"post",
            dataType: "json",
            data:data.field,
            success: function(res){
                if(res.code==1){
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
