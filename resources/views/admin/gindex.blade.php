@extends('layout.index')
@section('title', '公司列表')
@section('content')
<table class="layui-table" lay-size="sm">
    <!--    <colgroup>-->
    <!--        <col width="150">-->
    <!--        <col width="200">-->
    <!--        <col>-->
    <!--    </colgroup>-->
    <thead>
    <tr>
        <th>ID</th>
        <th>公司名字</th>
        <th>纳税人识别号</th>
        <th>公司类型</th>
        <th>法人姓名</th>
        <th>法人电话</th>
        <th>法人身份证</th>
        <th>银行账号</th>
        <th>服务类型</th>
        <th>征税类型</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr g_id="{{$d->g_id}}">
        <td>{{$d->g_id}}</td>
        <td>{{$d->g_name}}</td>
        <td>{{$d->g_sbh}}</td>
        <td>{{$d->g_gtype}}</td>
        <td>{{$d->u_username}}</td>
        <td>{{$d->g_phone}}</td>
        <td>{{$d->g_id_cart}}</td>
        <td>{{$d->g_zh}}</td>
        <td>{{$d->g_type}}</td>
        <td>{{$d->g_types}}</td>
        <td>{{date('Y-m-d H:i:s',$d->create_time)}}</td>
        <td>
            <div class="layui-btn-group">
                <a href="/edit?g_id={{$d->g_id}}" type="button" class="layui-btn layui-btn-sm edit">
                    <i class="layui-icon">&#xe642;</i>
                </a>
                <button type="button" class="layui-btn layui-btn-sm del" id="del">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
    {{$data->links()}}
    </tbody>
</table>
<script>
    layui.use('table',function(){
        var $ = layui.$;
        $(document).on('click','.del',function(){
            var g_id = $(this).parents('tr').attr('g_id');
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"delete",
                    method:'post',
                    data:{g_id:g_id},
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




