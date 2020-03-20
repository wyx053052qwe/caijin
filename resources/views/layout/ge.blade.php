<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <link rel="stylesheet" href="/home/css/jquery-ui.css"/>
    <link rel="stylesheet" href="/home/css/common.css"/>
    <link rel="stylesheet" href="/home/css/iconfont.css"/>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="/home/css/font-awesome.min.css"/>
    <link href="/home/css/prism.css" rel="stylesheet">
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('layui/layui.js')}}"></script>
    <script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
    <link src="{{asset('home/common/jquery.dialog.css')}}">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="/home/index">灵活用工</a></li>
            <li class="layui-nav-item"><a href="/home/customerAccount">个独管理</a></li></ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{session('name')}}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('upass')}}">修改密码</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="/logout">臣退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item"><a href="/home/customerAccount">首页</a></li>
                <li class="layui-nav-item"><a href="/home/customerCompany">我的公司</a></li>
                <li class="layui-nav-item"><a href="/home/invoiceSm">申请发票</a></li>
                <li class="layui-nav-item"><a href="/home/invoiceRaised">发票抬头管理</a></li>
                <li class="layui-nav-item"><a href="/home/invoiceRecord">开票记录</a></li>
                <li class="layui-nav-item"><a href="/home/invoiceAddressee">收件地址</a></li>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;"> @yield('content')</div>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element'], function(){
        var element = layui.element
            , $ = layui.$
            ,layer = layui.layer;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // element.on('tab(demo)', function(data){
        //     var src=$(".layui-tab-item.layui-show").find("iframe").attr("src");
        //     $(".layui-tab-item.layui-show").find("iframe").attr("src",src);
        // });
    });
</script>
</body>
</html>
