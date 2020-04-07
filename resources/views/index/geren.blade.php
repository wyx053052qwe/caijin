@extends('layout.home')
@section('title', '首页')
@section('content')
<!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VqDngAaqnxzoQsYYiSRTPFX9tlwZ9mZz"></script>-->
<!-- 如果需要拖拽鼠标进行操作，可引入以下js文件 -->
<script type="text/javascript" src="http://api.map.baidu.com/library/RectangleZoom/1.2/src/RectangleZoom_min.js"></script>
<style type="text/css">
    body, html {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
</style>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-block">
            <input type="text" name="username" required  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">行动轨迹</label>
        <div  class="layui-input-block">
            <input type="text" id="inputid"  placeholder="请输入关键字"  class="layui-input">
        </div>
        <label class="layui-form-label">
            <span class="required ">*</span> 经度:
        </label>
        <div class="col-sm-8">
            <input type="text" id="siteAddressLon" name="siteAddressLon" maxlength="50" required  lay-verify="required" class="layui-input">
        </div>

        <label class="layui-form-label">
            <span class="required ">*</span> 纬度:
        </label>
        <div class="col-sm-8">
            <input type="text" id="siteAddressLat" name="siteAddressLat" maxlength="50" required  lay-verify="required" class="layui-input">
        </div>
        <div class="form-group" style="height:400px; width:70%;margin-left: 1%" id="allmap"  ></div>
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VqDngAaqnxzoQsYYiSRTPFX9tlwZ9mZz"></script>

<script>
    //Demo
    layui.use(['form','upload'], function(){
        var form = layui.form
            ,$  = layui.$
            ,upload = layui.upload;


        var longitude ='';
        var latitude ='';

        var map = new BMap.Map("allmap",{enableMapClick:false}); // 创建Map实例

        if (longitude == null || longitude == "") {
            var mPoint = new BMap.Point(115.488124, 35.244125);
        } else {
            var mPoint = new BMap.Point(longitude, latitude);
            var marker = new BMap.Marker(mPoint); // 创建标注
            map.addOverlay(marker); // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        }
        map.centerAndZoom(mPoint, 15); // 初始化地图,设置中心点坐标和地图级别
        map.setCurrentCity("菏泽"); // 设置地图显示的城市 此项是必须设置的
        map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放

        //单击获取点击的经纬度
        map.addEventListener("click", function(e) {
            var a = e.point.lng;
            var b = e.point.lat;
            var mPoint = new BMap.Point(a, b);
            var marker1 = new BMap.Marker(mPoint); // 创建标注
            map.clearOverlays();
            map.addOverlay(marker1);// 将标注添加到地图中
            document.getElementById("siteAddressLon").value = a;
            document.getElementById("siteAddressLat").value = b;
        });
        /*自动走索 */

        $("#inputid").on("input",function(e){
            var local = new BMap.LocalSearch(map, {
                renderOptions:{map: map}
            });
            local.search($("#inputid").val());
            console.log($("#inputid").val())
        });
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
            var path = $('#videopath').val();
            if(path == null){
                layer.msg("请上传视频");
                return false;
            }
            var jing = $('#siteAddressLon').val();
            var wei = $('#siteAddressLat').val();
            data.field.img = jing + ','+ wei;
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
