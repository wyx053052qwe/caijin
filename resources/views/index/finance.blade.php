@extends('layout.home')
@section('title', '余额明细')
@section('content')
<div class="layui-breadcrumb page_mbx">
    <a href="/home">首页</a>
    <a><cite>余额明细</cite></a>
</div>
<div class="main_right_content">
    <div class="ui_box">
        <div class="ui_tit" style=" padding-bottom: 25px;"><i class="iconfont">&#xe668;</i>余额明细</div>
        <table class=" layui-table " lay-size="lg">

            <thead>
            <tr>
                <th>商户名称  </th>
                <th>服务商名称  </th>
                <th>充值总额（元）</th>
                <th>累计发放（元）</th>
                <th>账户总余额（元）</th>

            </tr>
            </thead>
            <tbody>
@foreach($data as $d)
            <tr>
                <td>{{$d->g_name}}</td>
                <td>{{$d->z_fwsmc}}</td>
                <td>￥{{$d->c_money}}.00</td>
                <td>￥{{$d->c_ls}}</td>
                <td class="blue">￥{{$d->c_yue}} </td>
            </tr>
@endforeach
            </tbody>
        </table>
         <div class="pager"></div>
    </div>
</div>
@endsection
