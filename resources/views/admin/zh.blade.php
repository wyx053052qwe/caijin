@extends('layout.index')
@section('title', '充值账户列表')
@section('content')
<div>
    <a href="{{url('/addzh')}}" class="layui-btn layui-btn-radius">添加</a>
</div>
<table class="layui-table">
    <thead>
    <tr>
        <th>服务商名称</th>
        <th>服务商公司信息</th>
        <th>服务商银行信息</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
@foreach($data as $d)
    <tr z_id ="{{$d->z_id}}">
        <td>{{$d->z_fwsmc}}</td>
        <td>
            公司名称：{{$d->z_fwsmc}}</br>
            工商注册号：{{$d->z_gszch}}</br>
            税务登记号：{{$d->z_gszch}}</br>
            组织机构代码：{{$d->z_gszch}}
        </td>
        <td>
            开户（网点）银行：{{$d->z_khyh}}</br>
            账户名称：{{$d->z_zhmc}}</br>
            银行账号：{{$d->z_yhzh}}
        </td>
        <td>{{date('Y-m-d H:i:s')}}</td>
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
            var z_id = $(this).parents('tr').attr('z_id');
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"delete",
                    method:'post',
                    data:{z_id:z_id},
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
