@extends('layout.home')
@section('title', '首页')
@section('content')
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-block">
            <input type="text" name="username" required  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">行动轨迹</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
        </div>
        <img src="" alt="" id="img" width="100px">
        <input type="hidden" name="img" id="imgpath">
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">工作视频</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="video">
                <i class="layui-icon">&#xe67c;</i>上传视屏
            </button>
        </div>
        <input type="text" class="video">
        <input type="hidden" name="video" id="videopath">
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
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
        ,$  = layui.$
        ,upload = layui.upload;

        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: "{{url('home/upload/')}}" //上传接口
            ,done: function(res){
                //上传完毕回调
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('#img').attr('src','.'+res.message);
                    $('#imgpath').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });
        var uploadInst = upload.render({
            elem: '#video' //绑定元素
            ,url: "{{url('home/video')}}" //上传接口
            ,accept:'video'
            ,done: function(res){
                //上传完毕回调
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('.video').val(res.message);
                    $('#videopath').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
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
                url:"{{url('/home/dovideo')}}",
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    console.log(res);
                    if(res.code == 2){
                        layer.msg(res.message);
                    }else if(res.code == 1){
                        layer.msg(res.message)
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
