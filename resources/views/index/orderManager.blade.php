@extends('layout.home')
@section('title', '我的订单')
@section('content')
<!--右边-->
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span>
        <a><cite>我的订单</cite></a>
    </div>
    <div class="main_right_content">

        <!--费用发放页面开始-->
        <div class="ui_box">
            <div class="qy_fl">
                <a href="/home/orderManager">所有订单</a>
                <a href="/home/orderManager?orderType=4" >待支付</a>
            </div>
            <div class="qy_flsx">
                <div class="qy_sx layui-form">
                    <form action="/home/orderManager">
                    <div class="layui-input-inline">
                        <input type="text" id="orderNo_l" name="f_code_no" lay-verify="email" value="{{$f_code_no}}" autocomplete="off" class="layui-input" value="" placeholder="请输入订单号">
                    </div>
                    <div style=" margin-right: 15px;" class="fl">
                        <div class="layui-input-inline fl">
                            <input type="text" class="layui-input" id="test1" name="create_time" value="{{$create_time}}" placeholder="申请开始时间">
                        </div>
                        <div class="fl" style="float: left; line-height: 28px; margin: 0 10px; color: #666;">至</div>
                        <div class="layui-input-inline fl">
                            <input type="text" class="layui-input" id="test2" name="update_time" value="{{$update_time}}" placeholder="申请结束时间">
                        </div>
                    </div>
                    <div class="layui-input-inline" style=" margin:0 10px;">
                        <select  name="orderType" lay-verify="required" lay-search="">
                            @if($orderType == 0)   }
                            <option value="0" selected="selected">订单状态</option>
                            <option value="0" >全部</option>
                            <option value="1" >办理中（发放中）</option>
                            <option value="2" >已完成</option>
                            <option value="3" >已取消</option>
                            <option value="4" >待支付</option>
                            @elseif($orderType == 3)
                            <option value="0">订单状态</option>
                            <option value="0" >全部</option>
                            <option value="1" >办理中（发放中）</option>
                            <option value="2" >已完成</option>
                            <option value="3" selected="selected">已取消</option>
                            <option value="4" >待支付</option>
                            @elseif($orderType == 2)
                            <option value="0">订单状态</option>
                            <option value="0" >全部</option>
                            <option value="1" >办理中（发放中）</option>
                            <option value="2" selected="selected">已完成</option>
                            <option value="3" >已取消</option>
                            <option value="4" >待支付</option>
                            @elseif($orderType == 4)
                            <option value="0">订单状态</option>
                            <option value="0" >全部</option>
                            <option value="1" >办理中（发放中）</option>
                            <option value="2" >已完成</option>
                            <option value="3">已取消</option>
                            <option value="4" selected="selected">待支付</option>
                            @elseif($orderType == 1)
                            <option value="0">订单状态</option>
                            <option value="0" >全部</option>
                            <option value="1"selected="selected" >办理中（发放中）</option>
                            <option value="2" >已完成</option>
                            <option value="3" >已取消</option>
                            <option value="4">待支付</option>
                            @endif
                        </select>
                    </div>

                    <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="submitForm(this)" style=" margin-left: 5px;">查询</button><button onclick="clearSerch(this)" class="layui-btn layui-btn-primary layui-btn-sm">清空</button>
                    </form>
                    <script>
                        layui.use(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function() {
                            var laydate = layui.laydate //日期
                                ,
                                laypage = layui.laypage //分页
                                ,
                                layer = layui.layer //弹层
                                ,
                                table = layui.table //表格
                                ,
                                carousel = layui.carousel //轮播
                                ,
                                upload = layui.upload //上传
                                ,
                                element = layui.element //元素操作
                                ,
                                slider = layui.slider //滑块
                        });
                    </script>

                </div>
            </div>
            <div class="qy_sxfl1"><button class="layui-btn layui-btn-sm layui-btn-normal uploadSalary" style=" margin-bottom: 18px; float: right;margin-left:10px"><span style="font-size: 16px;">+</span> 新增订单</button></div>
            <div class="qy_sxfl1"><button class="layui-btn layui-btn-sm layui-btn-normal" onclick="uploadSalaryz()" style=" margin-bottom: 18px; float: right; display:none;"><span style="font-size: 16px;">+</span> 派发订单</button></div>
            <table class=" layui-table " lay-size="lg">

                <thead>
                <tr>
                    <th>订单号 </th>
                    <th>申请时间</th>
                    <th>完成时间</th>
                    <th>商户名称</th>
                    <th>发放清单</th>
                    <th>服务商名称</th>
                    <th>实发金额</th>
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($date as $d)
                <tr>
                    <td class="qy12">
                        {{$d->f_code_no}}
                    </td>
                    <td class="qy12">

                        {{date('Y-m-d',$d->f_create_time)}}

                    </td>
                    <td class="qy12">
                        @if($d->f_updata_time == '')
                        @else
                        {{date('Y-m-d',$d->f_update_time)}}
                        @endif
                    </td>
                    <td class="qy12">
                        {{$d->g_name}}
                    </td>
                    <td class="qy12">
                        <a href="http://img01.shuidashi.com/sdscus/lhyg/1582267042141fiek.xlsx">{{$d->f_ff}}</a>
                    </td>

                    <td class="qy12">
                        {{$d->z_fwsmc}}
                    </td>
                    <td class="qy12">

                        ￥{{$d->f_money}}元&nbsp;

                    </td>
                    <td class="qy12" style=" color: #1E9FFF;">
                        @if($d->f_status == 1) 未支付
                        @elseif($d->f_status == 2)已完成
                        @elseif($d->f_status == 3)发放中
                        @elseif($d->f_status == 4)已取消
                        @endif

                    </td>
                    <td class="qy12">
                        @if($d->f_status == 1) <a href="/home/confirmSalary?fid={{$d->f_id}}">查看详情</a>
                        @elseif($d->f_status == 3)<a href="/home/confirmSalarys?fid={{$d->f_id}}">查看详情</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tr class="td_normal" align="center">
                    <td colspan="20" align="center">
                        {{$date->links()}}
                    </td>
                </tr>
            </table>

        </div>
        <!--费用发放页面结束-->
        <script>
            layui.use(['laydate','form'],function(){
                var  laydate = layui.laydate
                    ,$ = layui.$;
                laydate.render({
                    elem: '#test1' //指定元素
                });
                laydate.render({
                    elem: '#test2' //指定元素
                });
                $('.uploadSalary').click(function(){
                    location.href='/home/uploadSalary';
                });
            })
        </script>

        @endsection
