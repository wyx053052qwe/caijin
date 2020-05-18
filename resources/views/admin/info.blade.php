@extends('layout.index')
@section('title', '个人管理')
@section('content')
<table class="layui-table">
    <thead>
    <tr>
        <th>姓名</th>
        <th>手机号</th>
        <th>地址</th>
        <th>身份证号</th>
        <th>身份证照片（正）</th>
        <th>身份证照片（反）</th>
        <th>合同照片</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr iid="{{$d->i_id}}">
        <td>{{$d->i_name}}</td>
        <td>{{$d->i_phone}}</td>
        <td>{{$d->i_address}}</td>
        <td>{{$d->i_id_cart}}</td>
        <td>
            <img src="{{$d->i_cart_user}}" alt="">
        </td>
        <td>
            <img src="{{$d->i_cart_guohui}}" alt="">
        </td>
        <td>
            <img src="{{$d->i_hetong}}" alt="">
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
        <td colspan="9">{{$data->links()}}</td>
    </tr>
</table>
<script>
    //Demo
    layui.use(['form','upload'], function(){
        var form = layui.form
            ,$  = layui.$;
        $(document).on('click','.del',function(){
            var iid = $(this).parents('tr').attr('iid');
            $.ajax({
                url:"{{url('/delinfo')}}",
                method:'post',
                data:{iid:iid},
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
