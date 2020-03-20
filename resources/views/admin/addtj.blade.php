@extends('layout.index')
@section('title', '添加充值')
@section('content')
<form  class="addvoteform layui-form" action="" id="form_">
    <div class="layui-form-item">
        <label class="layui-form-label">合作公司</label>
        <div class="layui-input-block">
            <select name="hz" lay-verify="required">
                <option value="">请选择</option>
                @foreach($hzdata as $h)
                <option value="{{$h->g_id}}">{{$h->g_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">服务商</label>
        <div class="layui-input-block">
            <select name="fu" lay-verify="required">
                <option value=""></option>
                @foreach($fu as $f)
                <option value="{{$f->z_id}}">{{$f->z_fwsmc}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">充值金额</label>
        <div class="layui-input-block">
            <input type="text" name="money" required lay-verify="required" placeholder="请输入充值金额"      class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-sm" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form
            ,$ = layui.$;
        //监听提交
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));
            $.ajax({
                url:"/doaddtj",
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
