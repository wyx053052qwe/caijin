@extends('layout.ge')
@section('title', '充值记录')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="javascript:;">首页</a><span>-</span> <a><cite>我的公司</cite></a>
    </div>
    <div class="ui_box">
        <div class="ui_tit">
            <i class="iconfont">&#xe668;</i>我的公司
        </div>
        <div class="ui_product ui_my">
            <table class="layui-table" lay-size="lg">
                <colgroup>
                    <col width="320">
                    <col width="150">
                </colgroup>
                <thead>
                <tr>
                    <th style="text-align: center;">公司名</th>
                    <th style="text-align: center;">状态</th>
                    <th style="text-align: center;">公司详情</th>
                    <th style="text-align: center;">开票记录</th>
                    <!-- <th style="text-align: center;">服务套餐</th> -->
                    <!-- <th style="text-align: center;">操作</th> -->
                </tr>
                </thead>
                <tbody>
@foreach($gong as $g)
                <tr>
                    <td>{{$g->g_name}}&nbsp;</td>
                    <td>
                        @if($g->g_status == 2) 已启动
                        @else 已取消
                        @endif
                    </td>
                    <td>
                        <a href="/home/customerCompanyInfo?g_id={{$g->g_id}}">查看</a>
                    </td>
                    <td><a href="/home/customerCompanyInvoice.html?id=844">0</a>&nbsp;</td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
<div id="sj_style" title="请选择升级类型" style="display: none;">
    <div style="text-align: center;color: rgb(255,87,34);">
        专票:<input name="tp" type="radio" checked="checked" value="7"/>
        代开专票:<input name="tp" type="radio" value="10"/>
    </div>
</div>
@endsection
