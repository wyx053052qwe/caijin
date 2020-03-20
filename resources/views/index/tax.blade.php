@extends('layout.home')
@section('title', '税单管理')
@section('content')
<!--右边-->
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span>
        <a><cite>我的税单</cite></a>
    </div>
    <div class="main_right_content">

        <div class="ui_box">
            <div class="qy_flsx">
                <form action="">
                <div class="qy_sx layui-form">
                    <div class="layui-input-inline">
                        <input type="text" id="customerName_l" name="s_name" lay-verify="email" autocomplete="off" class="layui-input" value="" placeholder="请输入客户名称">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" id="customerCompanyName_l" name="g_name" lay-verify="email" autocomplete="off" class="layui-input" value="" placeholder="请输入公司名称">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" id="supplierCompanyName_1" name="z_fwsmc" lay-verify="email" autocomplete="off" class="layui-input" value="" placeholder="请输入服务商名称">
                    </div>

                    <button class="layui-btn layui-btn-sm layui-btn-normal" style=" margin-left: 5px;">查询</button><button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">清空</button>
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
                <table class=" layui-table " lay-size="lg">

                    <thead>
                    <tr>
                        <th>客户名字</th>
                        <th>公司名字 </th>
                        <th>服务商名字</th>
                        <th>税单图片</th>
                        <th>税单月份</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
@foreach($sd as $s)
                    <tr>
                        <td class="qy12">
                            {{$s->s_name}}
                        </td>
                        <td class="qy12">
                            {{$s->g_name}}
                        </td>
                        <td class="qy12">
                            {{$s->z_fwsmc}}
                        </td>
                        <td class="qy12">
                            <img alt="" src=".{{$s->s_img}}" width="50px;">
                        </td>
                        <td class="qy12">
                            {{date('Y-m-d',$s->s_month)}}
                        </td>
                        <td class="qy12">

                            <a href="/home/download?filename=.{{$s->s_img}}">下载税单</a>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tr class="td_normal" align="right">
                        <td colspan="20">

                            <div class='pager'>{{$sd->links()}}</div></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
