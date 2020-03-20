@extends('layout.index')
@section('title', '余额明细')
@section('content')
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>商户名称</th>
        <th>服务商名称</th>
        <th>充值总额</th>
        <th>累计发放</th>
        <th>账户总余额</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr>
        <td>{{$d->g_name}}</td>
        <td>{{$d->z_fwsmc}}</td>
        <td>{{$d->c_money}}</td>
        <td>{{$d->c_ls}}</td>
        <td>{{$d->c_yue}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
