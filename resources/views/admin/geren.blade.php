@extends('layout.index')
@section('title', '个人管理')
@section('content')
<style type="text/css">
    body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
</style>
<table class="layui-table">
    <thead>
    <tr>
        <th>姓名</th>
        <th>行动轨迹</th>
        <th>工作视频</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr gid="{{$d->g_id}}">
        <td>{{$d->g_username}}</td>
        <td>
            <div class="form-group" style="height:100px; width:100%;margin-left: 1%" id="allmap{{$d->g_id}}"></div>
        </td>
        <input type="hidden" class="img" value="{{$d->g_img}}">
        <td>
            <video width="200" height="100" controls>

                <source src="{{$d->g_video}}"  type="video/mp4">

                <source src="{{$d->g_video}}"  type="video/ogg">

                您的浏览器不支持 HTML5 video 标签。

            </video>
        </td>
        <td>{{date('Y-m-d H:i:s',$d->create_time)}}</td>
        <td>
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-sm del">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tr>
        <td colspan="5">{{$data->links()}}</td>
    </tr>
</table>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VqDngAaqnxzoQsYYiSRTPFX9tlwZ9mZz"></script>
<script>
    //Demo
    layui.use(['form','upload'], function(){
        var form = layui.form
            ,$  = layui.$;
        //处理地图id
        var cs = '';
        $('.form-group').each(function(){
            cs += $(this).attr('id')+',';
        })
        var arr = cs.split(',');
        for(var i in arr){
            arr[i]
        }
        var aaa = arr.filter(s => $.trim(s).length > 0);
        //处理地图坐标
        var xy = '';
        $('.img').each(function(){
            xy +=$(this).val()+';';
        })
        xy = xy.split(';');
        xy =  xy.filter(s => $.trim(s).length > 0);

        for(var i=0;i<aaa.length;i++){
            var map = aaa[i];
            var point = aaa[i]+i;
            var marker = aaa[i]+i;
            var a =i ;
            a = xy[i];
            var a = a.split(',');
            map = new BMap.Map(aaa[i]);//在地图容器中创建一个地图
            point = new BMap.Point(a[0],a[1]);//定义一个中心点坐标
            console.log(point)
            map.centerAndZoom(point, 15);//设定地图的中心点和坐标并将地图显示在地图容器中
            marker = new BMap.Marker(point); // 创建标注
            map.addOverlay(marker); // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放
        }



        $(document).on('click','.del',function(){
            var gid = $(this).parents('tr').attr('gid');
            $.ajax({
                url:"{{url('/delvideo')}}",
                method:'post',
                data:{gid:gid},
                dataType:"json",
                success:function(res){
                    console.log(res);
                    if(res.code == 2){
                        layer.msg(res.message);
                        window.location.reload();
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
        });

    });
</script>
@endsection
