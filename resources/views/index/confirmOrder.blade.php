@extends('layout.home')
@section('title', '费用发放')
@section('content')
<!--右边-->
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span> <a><cite>我的订单/确认订单</cite></a>
    </div>
    <div class="main_right_content">
        <!--费用发放下一步 确认订单页开始-->
        <div class="ui_box layui-form">
            <div class="ui_tit" style="padding-bottom: 25px;">
                <i class="iconfont">&#xe668;</i>订单费用
            </div>
            <div class="xz_jy">
                <p>
                    发放渠道：{{$fei->z_fwsmc}} -

                    银行卡
                    <br/>  总 笔 数：<span class="blue">{{$count}}</span>
                    <br/> 订单金额：<span class="blue">{{$fei->f_money}}</span>
                    <br/> 实发金额：<span class="blue" style=" font-size: 16px;">30</span>
                    <br />订单状态：<span class="danger">@if($fei['f_status'] == 1) 待支付 @endif</span>

                    <input type="hidden" class="fid" value="{{$fei['f_id']}}">
                </p>
            </div>
        </div>
        <div class="ui_box">
            <div class="ui_tit" style="padding-bottom: 25px;">
                <i class="iconfont">&#xe668;</i>上传明细
            </div>



            <table class=" layui-table " lay-size="lg">

                <thead>
                <tr>
                    <th>校验结果</th>
                    <th>收款方账户名称</th>
                    <th>收款方账户</th>
                    <th>手机号</th>
                    <th>身份证</th>
                    <th>实发金额</th>
                    <th>款项属性</th>
                    <th>备注</th>
                    <!-- <th>操作</th> -->

                </tr>
                </thead>
                <tbody>
                @foreach($order as $o)
                <tr>

                    <td class="qy12 danger" align="center" >
                        <i class="iconfont" style="color: green;">&#xe691;</i>
                    </td>
                    <td class="qy12" >{{$o->o_skfzhmc}}</td>
                    <td class="qy12" >{{$o->o_skfzh}}</td>
                    <td class="qy12" >{{$o->o_phone}}</td>
                    <td class="qy12" >{{$o->o_id_cart}}</td>
                    <td class="qy12" >

                        {{$o->o_total}}元&nbsp;

                    </td>
                    <td class="qy12">{{$o->o_ff}}</td>
                    <td class="qy12">{{$o->o_ms}}</td>

                </tr>
                @endforeach

                </tbody>
                <tr class="td_normal" align="right">
                    <td colspan="20">

                        <div class='pager'>
                            {{ $order->appends(['fid' => $fei['f_id']])->links() }}
                        </div></td>
                </tr>
            </table>
            <div class="tip">
								<span style=" float: left; line-height: 30px; text-align: left; padding-top: 20px;">支付费用： <b class="danger">

									    ￥30&nbsp;

								</b><br/>
								当前余额：<b class="danger">

									    ￥0&nbsp;

								</b>
								<span style="font-size: 12px; margin-left: 20px;">余额不足 ，<a href="/home/rechargeDesc">去充值</a></span></span>

                <button onclick="" class="layui-btn layui-btn-primary btn" style=" margin-left: 15px;">取消订单</button>
            </div>
        </div>


    </div>
</div>
</div>

<!--右边内容区-->
</div>
<script>
    layui.use(['form','layer'],function(){
        var layer = layui.layer
            ,$ = layui.$;
        $(document).on('click','.btn',function(){
            var fid = $('.fid').val();
            $.ajax({
                url:"/home/qux",
                method:'post',
                data:{fid:fid},
                dataType:'json',
                success:function(res){
                    if(res.code == 2){
                        location.href='/home/orderManager';
                    }else if(res.code == 1){
                        layer.msg(res.message);
                        location.href='/home/confirmOrder?fid='+fid;
                    }
                }
            });
        });
    });
</script>
@endsection

