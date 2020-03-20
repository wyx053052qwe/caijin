@extends('layout.index')
@section('title', '订单列表')
@section('content')
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
                <a href="/order">所有订单</a>
                <a href="/order?orderType=4" >待支付</a>
            </div>
            <div class="qy_flsx">
                <div class="qy_sx layui-form">
                    <form action="/order">
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

                        <button class="layui-btn layui-btn-sm layui-btn-normal" style=" margin-left: 5px;">查询</button><button class="layui-btn layui-btn-primary layui-btn-sm">清空</button>
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
                <tr fid="{{$d->f_id}}">
                    <td class="qy12">
                        {{$d->f_code_no}}
                    </td>
                    <td class="qy12">

                        {{date('Y-m-d',$d->f_create_time)}}

                    </td>
                    <td class="qy12">
                        @if($d->f_update_time == '')
                        @else
                        {{date('Y-m-d',$d->f_update_time)}}
                        @endif
                    </td>
                    <td class="qy12">
                        {{$d->g_name}}
                    </td>
                    <td class="qy12">
                        <a href="javascript:;" class="export">{{$d->f_ff}}</a>
                    </td>

                    <td class="qy12">
                        {{$d->z_fwsmc}}
                    </td>
                    <td class="qy12">

                        ￥{{$d->f_money}}元&nbsp;

                    </td>
                    <td class="qy12 status" fid="{{$d->f_id}}" style=" color: #1E9FFF;cursor:pointer;">
                        @if($d->f_status == 1) 未支付
                        @elseif($d->f_status == 2)已完成
                        @elseif($d->f_status == 3)发放中
                        @elseif($d->f_status == 4)已取消
                        @endif

                    </td>
                    <td class="qy12">
                        <div class="layui-btn-group">
                            <button type="button" class="layui-btn layui-btn-sm del">
                                <i class="layui-icon">&#xe640;</i>
                            </button>
                        </div>
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
        <div id="modifyFpTt" class="layui-form" style="margin-top: 36px;display: none">
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <select name="city" class="f_status" lay-verify="required">
                        <option value="">请选择</option>
                        <option value="1">待支付</option>
                        <option value="3">办理中</option>
                        <option value="2">已完成</option>
                        <option value="4">已取消</option>

                    </select>
                </div>
            </div>
        </div>
        <!--费用发放页面结束-->
        <script src="{{asset('layuiadmin/layui_exts/excel.js')}}"></script>
        <script>
            layui.use(['laydate','form','excel'],function(){
                var  laydate = layui.laydate
                    ,$ = layui.$
                    ,layer = layui.layer
                ,excel = layui.excel;
                laydate.render({
                    elem: '#test1' //指定元素
                });
                laydate.render({
                    elem: '#test2' //指定元素
                });
                $('.uploadSalary').click(function(){
                    location.href='/home/uploadSalary';
                });
                $(document).on('click','.status',function(){
                    var f_id = $(this).attr('fid');
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
                                url:'/order/status',
                                method:'post',
                                data:{status:status,fid:f_id},
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
                    var fid = $(this).parents('tr').attr('fid');
                    $.ajax({
                        url:'/dels',
                        method:'post',
                        data:{fid:fid},
                        dataType:'json',
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
                //下载
                $(document).on('click','.export',function(){

                    var fid = $(this).parents('tr').attr('fid');


                    $.ajax({
                        url: '{{url('export')}}',
                        data:{fid:fid},
                        dataType: 'json',
                        success: function(res) {
                            // 假如返回的 res.data 是需要导出的列表数据
                            console.log(res.data);// [{name: 'wang', age: 18, sex: '男'}, {name: 'layui', age: 3, sex: '女'}]
                            // 1. 数组头部新增表头
                            res.data.unshift({
                                o_id: '序号',
                                o_skfzhmc: '收款方账户名称',
                                o_khyh: '开户银行',
                                o_khhqc: '开户银行全称',
                                o_id_cart: '身份证',
                                o_skfzh: '收款方账号',
                                o_total: '实发金额',
                                o_phone: '手机号',
                                o_kxsx: '款项属性',
                                o_ff: '任务标题',
                                o_ms: '任务描述',
                            });
                            // 2. 如果需要调整顺序，请执行梳理函数
                            var data = excel.filterExportData(res.data, {
                                o_id:'o_id',
                                o_skfzhmc: 'o_skfzhmc',
                                o_khyh:'o_khyh',
                                o_khhqc:'o_khhqc',
                                o_id_cart:'o_id_cart',
                                o_skfzh:'o_skfzh',
                                o_total:'o_total',
                                o_phone:'o_phone',
                                o_kxsx:'o_kxsx',
                                o_ff:'o_ff',
                                o_ms:'o_ms',
                            });
                            // 3. 执行导出函数，系统会弹出弹框
                            var timestart = Date.now();
                            layui.excel.exportExcel({
                                sheet1:data
                            }, _getRandomString(6)+'.xlsx', 'xlsx');
                            // var timeend = Date.now();
                            // var spent = (timeend - timestart) / 1000;
                            // layer.alert('单纯导出耗时 '+spent+' s');
                        }
                    });
                });
                // 获取长度为len的随机字符串
                function _getRandomString(len) {
                    len = len || 32;
                    var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'; // 默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1
                    var maxPos = $chars.length;
                    var pwd = '';
                    for (i = 0; i < len; i++) {
                        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
                    }
                    return pwd;
                }
            })
        </script>

        @endsection
