@extends('layout.ge')
@section('title', '我的账户')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span>
        <a><cite>我的账户</cite></a>
    </div>
    <div class="main_right_content">
        <div class="ui_box">
            <div class="ui_tit"><i class="iconfont">&#xe668;</i>我的账户</div>

            <div class="ui_zh">
                <div class="fl ui_tx"><img src="/home/images/zh1.png" width="80"></div>
                <div class="fl ui_xin">
                    <h3>{{$uu->u_username}}<span>{{$uu['u_name']}}</span></h3>
                    <p>常用联系人：{{$user['c_name']}} {{$user['c_phone']}}  <a href="javascript:;" class="modify">修改</a>
                </div>
                <div class="fl ui_je">
                    <ul>
                        <li><h3>可用余额</h3><b>{{$money}}</b>元 </li>

                    </ul>
                </div>
            </div>
            <div id="modifyDiv" style="display: none;">
                <table class="ui_form xz">
                    <tbody>
                    <tr>
                        <td align="right" style="width: 110px;"><span style="color: #f00; margin-right: 5px;">*</span>联系人姓名：</td>
                        <td width="300"><input type="text" class="text ui-autocomplete-input contactsName" value="{{$user['c_name']}}"/></td>
                        <td align="right" style="width: 132px;"><span style="color: #f00; margin-right: 5px;">*</span>联系人手机号：</td>
                        <td width="300"><input type="text" class="text ui-autocomplete-input contactsPhone" maxlength="11	" value="{{$user['c_phone']}}"/></td>
                        <input type="hidden" class="cid" value="{{$user['c_id']}}">
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['form','layer'],function(){
        var $ = layui.$
        layer = layui.layer;
        $(document).on('click','.modify',function(){
            layer.open({
                type:1,
                area:['200','100'],
                title: 'tianxie'
                ,content: $("#modifyDiv"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var name=$(".contactsName").val();
                    var phone=$(".contactsPhone").val();
                    var cid=$(".cid").val();
                   $.ajax({
                       url:"/home/update",
                       method:'post',
                       dataType:'json',
                       data:{name:name,phone:phone,cid:cid},
                       success:function(res){
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
    });

</script>
@endsection
