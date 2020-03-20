@extends('layout.index')
@section('title', '修改密码')
@section('content')

<style>
    .green{
        color: green;
    }
    .red{
        color: red;
    }
</style>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">原密码</label>
        <div class="layui-input-inline">
            <input type="password" name="pass" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input yuan">
        </div>
        <div class="layui-form-mid layui-word-aux a"></div>
    </div>
    <input type="hidden" value="{{session('u_id')}}" class="u_id">
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-inline">
            <input type="password" name="newpass" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input new">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-inline">
            <input type="password" name="quepass" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input que">
        </div>
        <div class="layui-form-mid layui-word-aux q"></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn qwe" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form
            ,$ = layui.$;
        $(document).on('blur','.yuan',function(){
            var yuan = $('.yuan').val();
            var uid = $('.u_id').val();
            $.ajax({
                url:"yuan",
                method:'post',
                data:{yuan:yuan,uid:uid},
                dataType:'json',
                success:function(res){
                    if(res.code==2){
                        $('.a').html("<p class='green'>密码正确</p>");
                        $(".new").removeAttr("disabled");
                        $(".que").removeAttr("disabled");
                        $(".qwe").removeAttr("disabled");
                    }else{
                        $('.a').html("<p class='red'>密码错误</p>");
                        $(".new").attr("disabled","disabled");
                        $(".que").attr("disabled","disabled");
                        $(".qwe").attr("disabled","disabled");
                    }
                }
            });
        });
        $('.new').on('input propertychange', function() {
            var yuan = $('.yuan').val();
            if(yuan == ''){
                layer.msg('请输入原密码');
                $(".new").attr("disabled","disabled");
                $(".que").attr("disabled","disabled");
                $(".qwe").attr("disabled","disabled");
            }

        });
        $('.que').on('input propertychange',function(){
            var a = $('.new').val();
            var que = $('.que').val();
            if(a != que){
                $('.q').html("<p class='red'>密码不一致</p>");
                $(".new").attr("disabled","disabled");
                $(".que").attr("disabled","disabled");
                $(".qwe").attr("disabled","disabled");
            }else{
                $('.q').html("<p class='green'>密码正确</p>");
            }
        })
        //监听提交
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));
            $.ajax({
                url:"pass",
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    if(res.code==2){
                        layer.msg(res.message);
                    }else if(res.code==1){
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
