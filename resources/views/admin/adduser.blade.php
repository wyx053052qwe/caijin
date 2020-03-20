@extends('layout.index')
@section('title', '添加用户')
@section('content')
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">客户名字</label>
        <div class="layui-input-block">
            <input type="text" name="username" required  lay-verify="required" placeholder="请输入名字"   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="name" required  lay-verify="required|phone" placeholder="请输入手机号"   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="password" name="password" required lay-verify="required" placeholder="请输入密码"   class="layui-input">
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
    layui.use(['form','layer'], function(){
        var form = layui.form
            ,$ = layui.$
            ,layer = layui.layer;
        // $('.div').hide();
        // $(document).on('click','.go',function(){
        //     $('.div').show();
        // });
        //监听提交
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));
          //   var g_id='';
          //   $('.ch').each(function() {
          //       if ($(this).prop('checked')) {
          //           g_id += ',' + $(this).val();
          //       }
          //   });
          // data.field['g_id'] = g_id;
            $.ajax({
                url:"douser",
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    if(res.code==2){
                        layer.msg(res.message);
                    }else if(res.code==3){
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
