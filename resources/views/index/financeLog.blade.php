@extends('layout.home')
@section('title', '费用明细')
@section('content')
<!--右边内容区-->
<div class="layui-breadcrumb page_mbx">
    <a href="javascript:;">首页</a>
    <a><cite>发起签约</cite></a>
</div>
<div class="main_right_content">
    <div class="ui_box">
        <div class="ui_tit" style=" padding-bottom: 25px;"><i class="iconfont">&#xe668;</i>流水明细</div>

        <div style=" clear: both;"></div>
        <div class="layui-form fl">
            <form action="{{url('/home/financeLog')}}">
                <div class="layui-input-inline" style=" margin:0 10px;">
                    <select name="g_id" lay-verify="required">

                        <option value="0">全部</option>
                        @foreach($gong as $g)
                        <option  @if($gid == $g->g_id ) selected @else  @endif value="{{$g->g_id}}">{{$g->g_name}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="layui-input-inline" style=" margin:0 10px;">
                    <select name="status" lay-verify="required" lay-search="" id="businessType">

                        @if($status == 1)
                        <option  value="0"  >操作</option>
                        <option  value="1" selected="selected">支出</option>
                        <option  value="2">收入</option>
                        @elseif($status == 2)
                        <option  value="0"  >操作</option>
                        <option  value="1" >支出</option>
                        <option  value="2" selected="selected">收入</option>
                        @else
                        <option  value="0" selected="selected" >操作</option>
                        <option  value="1">支出</option>
                        <option  value="2">收入</option>
                        @endif
                    </select>
                </div>
        </div>
        <button class="layui-btn layui-btn-sm layui-btn-normal search" style=" margin-left: 5px;">查询</button>
        <a href="/home/financeLog"><button class="layui-btn layui-btn-primary layui-btn-sm">清空</button></a>
        </form>

        <!-- <div class="xz_ye" style=" width: 100%;">
                                    <ul>
                                        <li><i class="iconfont" style=" background: #61d2f4;">&#xe678;</i><span>充值总金额<h2>￥0.01</h2></span></li>
                                        <li style=" border-left: 1px solid #e4e4e4;border-right: 1px solid #e4e4e4;"><i class="iconfont">&#xe61f;</i><span>发放总金额<h2>￥15745.01</h2></span></li>
                                        <li><i class="iconfont" style=" background: #6bdea5;">&#xe677;</i><span>发成功金额<h2>￥1025458.01</h2></span></li>

                                    </ul>
                                </div> -->
        <script>
            layui.use([ 'laypage', 'layer', 'table', 'carousel', 'upload', 'element'], function() {
                var laydate = layui.laydate //日期
                    ,
                    laypage = layui.laypage //分页
                    ,
                    table = layui.table //表格
                    ,
                    upload = layui.upload //上传
                    ,
                    element = layui.element //元素操作
            });
        </script>

        <table class=" layui-table " lay-size="lg">

            <thead>
            <tr>
                <th>商户</th>
                <th>服务商</th>
                <th>操作类型</th>
                <th>金额</th>
                <th>操作</th>
                <th>备注</th>
                <th>完成时间</th>

            </tr>
            </thead>
            <tbody>
            @foreach($data as $d)
            <tr>
                <td>
                    {{$d->g_name}}
                </td>
                <td>
                    {{$d->z_fwsmc}}
                </td>
                <td>
                    @if($d->f_status == 1 || $d->f_statuss == 2 || $d->f_status == 3)
                    支出
                    @else
                    收入
                    @endif
                </td>
                <td>
                    {{$d->f_money}}
                </td>
                <td>
                    @if($d->f_status == 4)
                    费用退还
                    @else
                    发放费用
                    @endif
                </td>
                <td>
                    @if($d->f_status == 4)
                    订单取消，费用退还
                    @else
                    费用发放:{{$d->f_code_no}}
                    @endif
                </td>
                <td>

                    {{date('Y-m-d',$d->f_create_time)}}

                </td>

            </tr>
            @endforeach
            <tr class="td_normal" align="right">
                <td colspan="8">

                    <div class='pager'>{{$data->links()}}</div>
                </td>
            </tr>

            </tbody>
        </table>
        <!-- <div class="pager"><input type="hidden" value="?name=&amp;type=&amp;appId=&amp;pname=&amp;" class="url"><input type="hidden" value="15" class="page_size"><input type="hidden" value="3" class="page_count"><input type="hidden" value="15" class="record_size">
            <a class="turn_page first_off" href="javascript:void(0)">上一页</a>
            <a class="dj_num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=1&amp;pageSize=15">1</a>
            <a class="num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=2&amp;pageSize=15">2</a>
            <a class="num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=3&amp;pageSize=15">3</a>
            <a class="turn_page last_on" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=2&amp;pageSize=15">下一页</a><span class="per_page">每页：<select><option selected="selected">15</option><option>30</option><option>50</option><option>75</option><option>100</option></select>条</span><span class="cur_page">1</span>/<span class="total_page">3</span>总计：<span class="total_rec">36</span><input class="page" type="text" value="1"> <input class="layui-btn layui-btn-primary layui-btn-sm" type="button" value="跳转"></div> -->

    </div>
    @endsection
