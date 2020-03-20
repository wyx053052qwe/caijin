@extends('layout.index')
@section('title', '税单列表')
@section('content')
<table class="layui-table">
    <thead>
    <tr>
        <th>客户名字</th>
        <th>公司名字</th>
        <th>服务商名字</th>
        <th>税单月份</th>
        <th>税单图片</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr s_id="{{$d->s_id}}">
        <td>{{$d->s_name}}</td>
        <td>{{$d->g_name}}</td>
        <td>{{$d->z_fwsmc}}</td>
        <td>{{date('Y-m-d',$d->s_month)}}</td>
        <td>
            <img src="{{$d->s_img}}" alt="暂无图片" width="50">
        </td>
        <td>
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-sm">
                    <i class="layui-icon">&#xe642;</i>
                </button>
                <button type="button" class="layui-btn layui-btn-sm del">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<script>
    layui.use('table',function(){
        var $ = layui.$;
        $(document).on('click','.del',function(){
            var s_id = $(this).parents('tr').attr('s_id');
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"del",
                    method:'post',
                    data:{s_id:s_id},
                    dataType:'json',
                    success:function(res){
                        if(res.code==1){
                            layer.msg(res.message);
                            window.location.reload();
                        }else{
                            layer.msg(res.message);
                            window.location.reload();
                        }
                    }
                });

            });

        });
    });

</script>
@endsection
