@extends('layout.index')
@section('title', '个人管理')
@section('content')
<table class="layui-table">
    <colgroup>
    </colgroup>
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
            <a href="{{$d->g_img}}">
            <img src="{{$d->g_img}}" alt="" width="200px" id="download">
            </a>
        </td>
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
    <tr>
        <td colspan="5">{{$data->links()}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<script>
    //Demo
    layui.use(['form','upload'], function(){
        var form = layui.form
            ,$  = layui.$;
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
