@extends('layout.home')
@section('title', '费用管理')
@section('content')
<!--右边内容区-->
<div class="layui-breadcrumb page_mbx">
    <a href="/home">首页</a>
    <a><cite>充值信息</cite></a>
</div>
<div class="main_right_content">
    <div class="ui_box">
        <div class="ui_tit" style=" padding-bottom: 25px;"><i class="iconfont">&#xe668;</i>充值信息</div>
        <div style="color:red;background-color: #fffbe6;border: 1px solid #ffe58f;font-weight: bold;padding: 10px;border-radius: 3px;">
            提示：请在工作日15:00前完成公对公转账，15:00之后银行大额转账需隔天到账。
        </div>
        <table class=" layui-table " lay-size="lg">

            <thead>
            <tr>
                <th>商户名称  </th>
                <th>服务商名称</th>
                <th>服务商公司信息</th>
                <th>服务商银行信息</th>
                <th>商户费率信息</th>

            </tr>
            </thead>
            <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{$d->g_name}}</td>
                <td>{{$d->z_fwsmc}}</td>
                <td style="width: 200px;">
                    <b>公司名称：</b>{{$d->z_fwsmc}}<br>
                    <b>工商注册号：</b>{{$d->z_gszch}}<br>
                    <b>税务登记号：</b>{{$d->z_gszch}}<br>
                    <b>组织机构代码：</b>{{$d->z_gszch}} </td>
                <td>
                    <b>开户（网点）银行：</b>{{$d->z_khyh}}<br>
                    <b>账户名称：</b>{{$d->z_zhmc}}<br>
                    <b>银行账号：</b>{{$d->z_yhzh}}
                </td>
                <td>
                    <b>服务费率：</b>7.5%<br>
                    <b>最大薪水：</b>30000元<br>
                    <b>最小薪水：</b>1元
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <!-- <div class="pager"><input type="hidden" value="?name=&amp;type=&amp;appId=&amp;pname=&amp;" class="url"><input type="hidden" value="15" class="page_size"><input type="hidden" value="3" class="page_count"><input type="hidden" value="15" class="record_size"><a class="turn_page first_off" href="javascript:void(0)">上一页</a><a class="dj_num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=1&amp;pageSize=15">1</a><a class="num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=2&amp;pageSize=15">2</a><a class="num" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=3&amp;pageSize=15">3</a><a class="turn_page last_on" href="?name=&amp;type=&amp;appId=&amp;pname=&amp;pageNo=2&amp;pageSize=15">下一页</a><span class="per_page">每页：<select><option selected="selected">15</option><option>30</option><option>50</option><option>75</option><option>100</option></select>条</span><span class="cur_page">1</span>/<span class="total_page">3</span>总计：<span class="total_rec">36</span><input class="page" type="text" value="1"> <input class="layui-btn layui-btn-primary layui-btn-sm" type="button" value="跳转"></div> -->
    </div>
</div>
</div>
</div>
@endsection
