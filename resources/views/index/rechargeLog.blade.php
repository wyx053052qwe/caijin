@extends('layout.home')
@section('title', '充值记录')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="/index.html">首页</a>

        <a><cite>充值记录</cite></a>
    </div>
    <div class="main_right_content">
        <div class="ui_box">
            <div class="qy_flsx">
                <div class="qy_sx layui-form">



                    <script>
                        layui.use(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function(){
                            var laydate = layui.laydate //日期
                                ,laypage = layui.laypage //分页
                                ,layer = layui.layer //弹层
                                ,table = layui.table //表格
                                ,carousel = layui.carousel //轮播
                                ,upload = layui.upload //上传
                                ,element = layui.element //元素操作
                                ,slider = layui.slider //滑块
                        });
                    </script>

                </div>
            </div>
            <div class="qy_sxfl1">
                <a class="layui-btn layui-btn-sm layui-btn-primary add" href="/home/addRecharge" style=" margin-top: 25px; float: right; color: #999; line-height: 26px;  margin-bottom: 5px;">新增充值信息</a>
            </div>
            <table class=" layui-table " lay-size="lg">

                <thead>
                <tr>
                    <!-- <th><input type="checkbox" name=""> </th> -->
                    <th>商户名称</th>
                    <th>充值金额</th>
                    <th>服务商</th>
                    <th>转账凭证</th>
                    <th>备注</th>
                    <th>状态</th>
                </tr>
                </thead>
                @foreach($data as $d)
                <tr>
                    <!-- <td><input type="checkbox" name=""></td> -->

                    <td class="qy12">{{$d->g_name}}</td>
                    <td class="qy12">{{$d->p_money}} 元</td>
                    <td class="qy12">{{$d->z_fwsmc}}</td>
                    <td class="qy12"><div id="photo-list"><img width="40px;" src=".{{$d->p_img}}"></div></td>
                    <td class="qy12">{{$d->p_text}}</td>
                    <td class="qy12">
                        @if($d->p_status == 1)<b style="color: red;">待审核</b>
                        @elseif($d->p_status == 2) 已充值
                        @elseif($d->p_status == 3) 驳回
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="td_normal" align="right">
                    <td colspan="8">
                        <div class='pager'>
                            {{$data->links()}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        layui.use(['form'],function(){
            var $ = layui.$;
            $(function () {
                $('#photo-list img').on('click', function () {
                    layer.photos({
                        photos: '#photo-list',
                        shadeClose: false,
                        closeBtn: 2,
                        anim: 0
                    });
                })
            });
        });
    </script>
    @endsection
