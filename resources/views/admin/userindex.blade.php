@extends('layout.index')
@section('title', '用户列表')
@section('content')
<table class="layui-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>客户名字</th>
        <th>用户名</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr u_id="{{$d->u_id}}">
        <td>{{$d->u_id}}</td>
        <td>{{$d->u_username}}</td>
        <td>{{$d->u_name}}</td>
        <td>{{date('Y-m-d H:i:s',$d->u_create_time)}}</td>
        <td>
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-sm update">
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
<td>{{$data->links()}}</td>
<form class="layui-form" action="" id="test">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="name" required  lay-verify="required" placeholder="请输入手机号"  value="{{$user['u_name']}}" class="layui-input name">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" value="{{$user['password']}}"  class="layui-input pass">
        </div>
    </div>
    <input type="hidden" name="u_id" class="uid" value="">
</form>
<script>
    layui.use('table',function() {
        var $ = layui.$;
        $('#test').hide();
        $(document).on('click', '.del', function () {
            var u_id = $(this).parents('tr').attr('u_id');
            layer.confirm("确认要删除吗，删除后不能恢复", {title: "删除确认"}, function (index) {
                $.ajax({
                    url: "udel",
                    method: 'post',
                    data: {u_id: u_id},
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 2) {
                            layer.msg(res.message);
                            window.location.reload();
                        } else {
                            layer.msg(res.message);
                            window.location.reload();
                        }
                    }
                });

            });

        });
        $(document).on('click', '.update', function () {
            var u_id = $(this).parents('tr').attr('u_id');
            $.ajax({
                url: "userindex",
                method: 'get',
                data: {u_id: u_id},
                dataType: 'json',
                success: function (res) {
                    console.log(res.data);
                    var user  = res.data;
                    $('.name').val(user.u_name);
                    $('.pass').val(user.u_password);
                    $('.gid').val(user.g_id);
                    $('.uid').val(user.u_id);

                }
            });
            layer.open({
                type: 1,
                area: ['400px', '500px'],
                title: '修改'
                , content: $("#test"),
                shade: 0,
                btn: ['提交', '重置']
                , btn1: function (index, layero) {
                    var name = $(".name").val();
                    alert(name);
                },
                btn2: function (index, layero) {
                    alert("2222");
                    return false;
                },
                cancel: function (layero, index) {
                    layer.closeAll();
                }
            });
        });
    });
</script>
@endsection
