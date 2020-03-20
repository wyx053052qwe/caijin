@extends('layout.ge')
@section('title', '收件地址管理')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="">首页</a><span>-</span>
        <a><cite>收件人管理</cite></a>
    </div>


    <div class="ui_box">
        <div class="ui_tit" style=" position: absolute;"><i class="iconfont">&#xe668;</i>收件人管理</div>
        <p style="text-align: right; position: relative;"><a href="javascript:;" class="danger addEx" ><i class="iconfont">&#xe66c;</i>新增收件人</a></p>
        <table class="layui-table" lay-size="lg">
            <thead>
            <tr>
                <th>姓名</th>
                <th>手机号</th>
                <th>区域</th>
                <th>地址</th>
                <th>操作</th>
            </tr>
            </thead>
@foreach($data as $d)
            <tr>
                <td>{{$d->e_name}}</td>
                <td>{{$d->e_phone}}</td>
                <td>{{$d->e_city}}</td>
                <td>{{$d->e_address}}</td>
                <td><button class="layui-btn layui-btn-xs modifyExpress" data-id="{{$d->e_id}}"><i class="iconfont" style="font-size: 11px;">&#xe674;</i>编辑</button>
                    <button class="layui-btn layui-btn-xs layui-btn-normal removeExpress" data-id="{{$d->e_id}}"><i class="iconfont" style="font-size: 11px;">&#xe671;</i>删除</button></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div style="display: none;" id="addExpress">
    <table class="ui_form xz">
        <tbody>
        <tr>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>姓名：</td>
            <td width="300"><input type="text" class="text ui-autocomplete-input e_name" ></td>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>手机号：</td>
            <td width="300"><input type="text" class="text ui-autocomplete-input e_phone"  maxlength="11"></td>
        </tr>
        <tr>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>城市：</td>
            <td>
                <input type="text" class="text ui-autocomplete-input e_city" id="e_city">
                <input type="hidden" id="e_city" />
            </td>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>详细地址：</td>
            <td><input type="text" id="rAddress" class="text ui-autocomplete-input e_address" maxlength="50"></td>
        </tr>
        </tbody>
    </table>
</div>

<div style="display: none;" id="modifyExpress">
    <table class="ui_form xz">
        <tbody>
        <tr>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>姓名：</td>
            <td width="300"><input type="text" class="text ui-autocomplete-input rName2" ></td>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>手机号：</td>
            <td width="300"><input type="text" class="text ui-autocomplete-input rPhone2" maxlength="11" ></td>
        </tr>
        <tr>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>城市：</td>
            <td>
                <input type="text" class="text ui-autocomplete-input city2" id="city2">
                <input type="hidden" id="cityCode2" />
            </td>
            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>详细地址：</td>
            <td><input type="text" id="rAddress2" class="text ui-autocomplete-input rAddress2" maxlength="50"></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    layui.use(['form','layer'],function() {
        var $ = layui.$
            , layer = layui.layer;
        $(document).on('click', '.addEx', function () {
            layer.open({
                type: 1,
                area: ['200', '100'],
                title: '添加'
                , content: $("#addExpress"),
                shade: 0,
                btn: ['提交', '重置']
                , btn1: function (index, layero) {
                    var e_name = $(".e_name").val();
                    var e_phone = $(".e_phone").val();
                    var e_city = $(".e_city").val();
                    var e_address = $(".e_address").val();
                    if (e_name == '') {
                        layer.msg("请填写姓名");
                        return false;
                    }
                    if (e_phone == '') {
                        layer.msg("请填写手机号");
                        return false;
                    }
                    if (!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(e_phone)) {
                        layer.msg('固定电话有误，请重填');
                        return false;
                    }
                    if(e_city == ''){
                        layer.msg("请填写城市");
                        return false;
                    }
                    if(e_address == ''){
                        layer.msg("请填写地址");
                        return false;
                    }

                    var data = {
                        e_name: e_name,
                        e_phone: e_phone,
                        e_city: e_city,
                        e_address: e_address,
                    };
                    $.ajax({
                        url: "/home/doex",
                        method: 'post',
                        dataType: 'json',
                        data: data,
                        success: function (res) {
                            if (res.code == 2) {
                                layer.msg(res.message);
                                window.location.reload();
                            } else if (res.code == 1) {
                                layer.msg(res.message);
                            } else if (res.code == 3) {
                                layer.msg(res.message);
                            }
                        }
                    });
                },
                btn2: function (index, layero) {
                    return false;
                },
                cancel: function (layero, index) {
                    layer.closeAll();
                }

            });
        });
        $(document).on('click','.modifyExpress',function(){
            var eid = $(this).attr('data-id');
            $.ajax({
                url:'/home/doedit',
                method:'post',
                data:{eid:eid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    var data = res.message;
                    if(res.code == 2){
                        $('.rName2').val(data.e_name);
                        $('.rPhone2').val(data.e_phone);
                        $('.city2').val(data.e_city);
                        $('.rAddress2').val(data.e_address);
                    }
                }
            });
            layer.open({
                type: 1,
                area: ['200', '100'],
                title: '添加'
                , content: $("#modifyExpress"),
                shade: 0,
                btn: ['提交', '重置']
                , btn1: function (index, layero) {
                    var eid = $('.modifyExpress').attr('data-id');
                    var e_name = $(".rName2").val();
                    var e_phone = $(".rPhone2").val();
                    var e_city = $(".city2").val();
                    var e_address = $(".rAddress2").val();
                    if (e_name == '') {
                        layer.msg("请填写姓名");
                        return false;
                    }
                    if (e_phone == '') {
                        layer.msg("请填写手机号");
                        return false;
                    }
                    if (!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(e_phone)) {
                        layer.msg('固定电话有误，请重填');
                        return false;
                    }
                    if(e_city == ''){
                        layer.msg("请填写城市");
                        return false;
                    }
                    if(e_address == ''){
                        layer.msg("请填写地址");
                        return false;
                    }

                    var data = {
                        e_name: e_name,
                        e_phone: e_phone,
                        e_city: e_city,
                        e_address: e_address,
                        e_id: eid,
                    };
                    $.ajax({
                        url: "/home/updateEx",
                        method: 'post',
                        dataType: 'json',
                        data: data,
                        success: function (res) {
                            if (res.code == 2) {
                                layer.msg(res.message);
                                window.location.reload();
                            } else if (res.code == 1) {
                                layer.msg(res.message);
                            } else if (res.code == 3) {
                                layer.msg(res.message);
                            }
                        }
                    });
                },
                btn2: function (index, layero) {
                    return false;
                },
                cancel: function (layero, index) {
                    layer.closeAll();
                }

            });
        });
        $(document).on('click','.removeExpress',function(){
            var eid = $(this).attr('data-id');
            $.ajax({
                url:"/home/removeExpress",
                method:'post',
                data:{eid:eid},
                dataType:'json',
                success:function(res){
                    if (res.code == 2) {
                        layer.msg(res.message);
                        window.location.reload();
                    } else if (res.code == 1) {
                        layer.msg(res.message);
                    }
                }
            });
        });
    });
</script>
@endsection
