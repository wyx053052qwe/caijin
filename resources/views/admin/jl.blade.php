@extends('layout.index')
@section('title', '充值记录')
@section('content')
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>公司</th>
        <th>服务商</th>
        <th>充值金额</th>
        <th>上传凭证</th>
        <th>备注</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr pid="{{$d->p_id}}">
        <td>{{$d->g_name}}</td>
        <td>{{$d->z_fwsmc}}</td>
        <td>{{$d->p_money}}</td>
        <td>
            <img src="{{$d->p_img}}" alt="" width="100px">
        </td>
        <td>{{$d->p_text}}</td>
        <td class="status" pid="{{$d->p_id}}">
            @if($d->p_status == 1) 审核中
            @elseif($d->p_status == 2) 已充值
            @elseif($d->p_status == 3) 驳回
            @endif
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
</table>
<div id="modifyFpTt" class="layui-form" style="margin-top: 36px;display: none">
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <select name="city" class="f_status" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">审核中</option>
                <option value="2">已充值</option>
                <option value="3">驳回</option>
            </select>
        </div>
    </div>
</div>
<script>
    layui.use(['laydate','form'],function() {
        var laydate = layui.laydate
            , $ = layui.$
            , layer = layui.layer;
        $(document).on('click','.status',function(){
            var p_id = $(this).attr('pid');
            layer.open({
                type:1,
                area:['400px','300px'],
                title: '修改'
                ,content: $("#modifyFpTt"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var status = $('.f_status').val();
                    // console.log(f_id);
                    $.ajax({
                        url:'pstatus',
                        method:'post',
                        data:{status:status,pid:p_id},
                        dataType:'json',
                        success:function(res){
                            // console.log(res);
                            if(res.code == 2){
                                layer.msg(res.message);
                                window.location.reload();
                            }else{
                                layer.msg(res.message);
                            }
                        }
                    });

                },
                btn2: function(index, layero){
                    return false;
                },
                cancel: function(layero,index){
                    layer.closeAll();
                }

            });
        });
        $(document).on('click','.del',function(){
            var pid = $(this).parents('tr').attr('pid');
            // console.log(pid);
            $.ajax({
                url:"{{url('pdel')}}",
                method:'post',
                data:{pid:pid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
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
