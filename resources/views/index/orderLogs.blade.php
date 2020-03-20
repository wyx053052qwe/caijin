@extends('layout.home')
@section('title', '发放流水')
@section('content')
<div class="main_right">
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span> <a><cite>我的订单</cite></a>
    </div>
    <div class="main_right_content">
        <!--发放流水开始-->
        <div class="ui_box layui-form">
            <div class="ui_tit" style=" padding-bottom: 25px;"><i class="iconfont">&#xe668;</i>发放流水</div>
            <form action="/orderLogs">
            <div class="layui-input-inline">
                <input type="text" id="orderNo_l" value="{{$o_code_no}}" name="o_code_no" lay-verify="email" autocomplete="off" class="layui-input" placeholder="订单号">
            </div>
            <div class="layui-input-inline">
                <input type="text" id="accountName_l" value="{{$o_skfzhmc}}" name="o_skfzhmc" lay-verify="email" autocomplete="off" class="layui-input" placeholder="姓名">
            </div>
            <div class="layui-input-inline">
                <input type="text" id="receiverAccount_l" value="{{$o_skfzh}}" name="o_skfzh" lay-verify="email" autocomplete="off" class="layui-input" placeholder="收款账号">
            </div>
            <div style=" margin-right: 15px;" class="fl">
                <div class="layui-input-inline fl">
                    <input type="text" class="layui-input" id="test1" value="{{$create_time}}" name="create_time" placeholder="申请开始时间">
                </div>
                <div class="fl" style="float: left; line-height: 28px; margin: 0 10px; color: #666;">至</div>
                <div class="layui-input-inline fl">
                    <input type="text" class="layui-input" id="test2" value="{{$update_time}}" name="update_time" placeholder="申请结束时间">
                </div>
            </div>
            <div class="layui-input-inline" style=" margin:0 10px;">
                <select  name="status" lay-verify="required" lay-search="">
                    @if($status == 0)
                    <option value="0" id="optionOption" >交易状态</option>
                    <option value="0" selected="selected">所有</option>
                    <option value="1" >支付中</option>
                    <option value="2"  >支付完成</option>
                    <option value="3">支付失败</option>
                    @elseif($status == 1)
                    <option value="0" id="optionOption" >交易状态</option>
                    <option value="0">所有</option>
                    <option value="1" selected="selected">支付中</option>
                    <option value="1" >支付完成</option>
                    <option value="3">支付失败</option>
                    @elseif($status == 2)
                    <option value="0" id="optionOption" >交易状态</option>
                    <option value="0">所有</option>
                    <option value="1" >支付中</option>
                    <option value="2" selected="selected" >支付完成</option>
                    <option value="3">支付失败</option>
                    @elseif($status == 3)

                    <option value="0" id="optionOption" >交易状态</option>
                    <option value="0">所有</option>
                    <option value="1" >支付中</option>
                    <option value="2"  >支付完成</option>
                    <option value="3" selected="selected">支付失败</option>
                    @else
                    <option value="0" id="optionOption" >交易状态</option>
                    <option value="0" selected="selected">所有</option>
                    <option value="1" >支付中</option>
                    <option value="2"  >支付完成</option>
                    <option value="3">支付失败</option>
                    @endif
                </select>
            </div>
            <button class="layui-btn layui-btn-sm layui-btn-normal" style=" margin-left: 5px;">查询</button>
            <button type="reset" class="layui-btn layui-btn-primary" style="height: 30px;line-height: 30px;padding: 0 10px; font-size: 12px;">清空</button>
            </form>
            <div class="xz_ye">
                <ul>
                    <li style="width: 50%"><i class="iconfont">&#xe61f;</i><span>发放总金额<h2>

									    ￥{{$ls}}&nbsp;

								</h2></span></li>
                    <li style=" width: 50%"><i class="iconfont" style=" background: #6bdea5;">&#xe677;</i><span>发放成功金额<h2>

									    ￥{{$ls}}&nbsp;

								</h2></span></li>

                </ul>
            </div>
        </div>

        <div class="ui_box">
            <div class="qy_fl">
                <a href="/orderLogs?status=0" >全部</a>
                <a href="/orderLogs?status=1" >支付成功</a>
                <a href="/orderLogs?status=2" >支付中</a>
                <a href="/orderLogs?status=3" >支付失败</a>
                <button onclick="excelLogs()" class="layui-btn layui-btn-sm layui-btn-primary" style=" margin-top: 15px; float: right; color: #999; line-height: 26px;"><i class="iconfont">&#xedde;</i>导出xls</button></div>

            <table class=" layui-table " lay-size="lg">

                <thead>
                <tr>
                    <!-- <th>失败原因</th> -->
                    <th>商户名称</th>
                    <th>客户订单号</th>
                    <th>请求时间</th>
                    <th>收款人姓名</th>
                    <th>收款账号</th>
                    <th>交易金额</th>
                    <th>交易状态</th>
                    <th>备注</th>

                </tr>
                </thead>
                <tbody>
@foreach($order as $o)
                <tr>

                    <input type="hidden"   class="poId" value="495035">
                    <td class="qy12">{{$o->g_name}}</td>
                    <td class="qy12">{{$o->o_code_no}}</td>
                    <td class="qy12">

                       {{date('Y-m-d',$o->o_create_time)}}

                    </td>
                    <td class="qy12">{{$o->o_skfzhmc}}</td>
                    <td class="qy12">{{$o->o_skfzh}}</td>
                    <td class="qy12">

                        ￥{{$o->o_total}}元&nbsp;

                    </td>
                    <td class="qy12">
                       @if($o->o_status == 1 || $o->o_status == 3) 支付中
                        @elseif($o->o_status == 2) 支付完成
                        @elseif($o->o_status == 4) 支付失败
                        @endif


                    </td>
                    <td class="qy12"></td>

                </tr>
@endforeach
                </tbody>
                <tr class="td_normal" align="right">
                    <td colspan="20">

                        <div class='pager'>
                            {{$order->links()}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!--右边内容区-->
</div>
<!--右边-->
<script>
    layui.use(['form','laydate'],function(){
        var $ = layui.$
        ,laydate = layui.laydate;
        laydate.render({
            elem: '#test1' //指定元素
        });
        laydate.render({
            elem: '#test2' //指定元素
        });
    });
</script>
@endsection
