@extends('layout.ge')
@section('title', '申请发票')
@section('content')
<div class="main_right">
    <div class="layui-breadcrumb page_mbx">
        <a href="">首页</a><span>-</span>
        <a><cite>申请发票</cite></a>
    </div>
    <div class="ui_box">
        <div class="ui_tit"><i class="iconfont">&#xe668;</i>开发票</div>

        <table class="ui_fatit">
            <tr>
                <td style="border: 0;"><p>账户总余额：<span class="ui_l"><span id="finance">{{$money}}</span>元</span></p>
                </td>
                <td style="border: 0;" align="center">
                    <div class="styled-select" >
                        <select id="invoiceType" style="color: #3160d8; padding: 0px;">
                            <option>请选择发票类型</option>
                            <option value ="0">增值税普通发票</option>
                            <option value ="1">代开增值税专用发票</option>
                            <option value ="2">增值税专用发票</option>
                        </select>
                    </div>
                    <div class="ui_line"></div>
                    <p class="ui_fatext">发 票 联</p>
                </td>
                <td class="ui_h" align="right" style="border: 0;">申请日期：<span class="ui_l time">{{date('Y-m-d',time())}} </span></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ui_fa1">
            <tr>
                <td rowspan="4" width="30px" style=" border-bottom: 0;">购买方</td>
                <td style="padding-left: 15px;" width="150">名 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;　称：</td>
                <td>
                    <div class="styled-select1" style=" width:320px;">
                        <select id="invoiceTitle"  style="color: #3160d8;width:348px">
                            <option >请选择发票抬头</option>
                            @foreach($raised as $r)
                            <option value ="{{$r->r_id}}">{{$r->r_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td rowspan="4" width="30px" style=" border-bottom: 0;">收件人</td>
                <td style="padding-left: 15px;" width="130">姓 &nbsp;&nbsp;　名：</td>
                <td><div class="styled-select1">
                        <select id="expressId"  style="color: #3160d8;">
                            <option>请选择收件人</option>
                            @foreach($ex as $e)
                            <option value ="{{$e->e_id}}">{{$e->e_name}}</option>
                            @endforeach
                        </select>
                    </div></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">纳税人识别号：</td>
                <td><input type="text" id="sh"  style="color: #3160d8;" /></td>
                <td style="padding-left: 15px;">手 机 号：</td>
                <td><input type="text" id="sjh" style="color: #3160d8;" /></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">地 址、电 话：</td>
                <td><input type="text" id="dz" style="color: #3160d8;" /></td>
                <td style="padding-left: 15px;">收件地址：</td>
                <td><input type="text" id="sjdz" style="color: #3160d8;" /></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;">开户行及账号</td>
                <td style=" border-bottom: 0;"><input type="text" id="yh" style="color: #3160d8;" /></td>
                <td style=" border-bottom: 0;">&nbsp;</td>
                <td style=" border-bottom: 0;">&nbsp;</td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ui_fa1">
            <tr align="center">
                <td>货物或应税劳务、服务名称</td>
                <td>金额（元）</td>
                <td>综合税率</td>
                <td>综合税费（元）</td>
            </tr>
            <tr height="120" valign="top" align="center">
                <td><input id="serviceContent" type="text"  style="border-bottom: 1px solid #3160d8; height: 59px; width: 90%; color: #3160d8;"  /></td>
                <td><input type="text" id="invoiceAmount" maxlength="11"  style="border-bottom: 1px solid #3160d8; height: 59px; width: 90%; color: #3160d8;"/></td>
                <td id="sl"  style="color: #3160d8;"></td>
                <td id="yk"  style="color: #3160d8;"></td>
            </tr>
            <tr>
                <td align="center">价 税 合 计（大 写）</td>
                <td colspan="2"><span class="ui_l ">￥<span class="dxje"></span></span></td>
                <td style="border-left: 1px solid #fff;">（小写）<span class="ui_l xxje"></span></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ui_fa1">
            <tr>
                <td rowspan="4" width="30px" style=" border-bottom: 0;">销售方</td>
                <td style="padding-left: 15px;" width="150">名 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;　称：</td>
                <td>
                    <div class="styled-select1">
                        <select id="companyId"  style="color: #3160d8;">
                            <option value="0">请选择开票方</option>
                            @foreach($gongsi as $g)
                            <option value ="{{$g->g_id}}">{{$g->g_name}}</option>
                            @endforeach

                        </select>
                    </div>
                </td>
                <td rowspan="4" width="30px" style=" border-bottom: 0;">凭证</td>
                <td style="padding-left: 15px;" width="130">业务合同：</td>
                <td style="padding-left: 15px;" >
                    <a href="javascript:;" style=" text-decoration: underline; display: none;"><span class="ui_l">查看</span></a>
                    <div class="upimg" style="width:200px;">
                        <div class="setUpimg">
						<span id="ht"><a href="javascript:;" style=" text-decoration: underline;"><span class="ui_l" id="upload">上传</span></a>
                                <input type="hidden" id="cashPic" />
						<span style="font-size: 12px; color: #999; margin-left: 3px;">必需上传</span></span>
                            <br/><span style="color: red; padding-top: 10px; ">上传word文件或者pdf文件</span>
                            <input type="hidden" id="contractPic"/>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">纳税人识别号：</td>
                <td><input type="text" id="tax"  style="color: #3160d8;" /></td>
                <td style="padding-left: 15px;">打款凭证：</td>
                <td style="padding-left: 15px;" >
                    <a href="javascript:;" style=" text-decoration: underline; display: none;" id="cashPicPic1"><span class="ui_ls">查看</span></a>
                    <img src="" alt="" class="img" id="img" style="display: none">
                    <div class="upimg" style="width:180px;">
                        <div class="setUpimg">
                            <a href="javascript:;" style=" text-decoration: underline;"><span class="ui_l" id="uploads">上传</span></a><span style="font-size: 12px; color: #999; margin-left: 3px;">可后置上传</span>
                            <input type="hidden" id="cashPic" />
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">地 址、电 话：</td>
                <td><input type="text" id="dzdh"  style="color: #3160d8;" /><input type="hidden" id="slip"></td>
                <td style="padding-left: 15px;">发票备注：</td>
                <td style="padding-left: 15px;" ><input type="text" id="invoiceRemark"  style="color: #3160d8;" /></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;">开户行及账号</td>
                <td style=" border-bottom: 0;"><input type="text" id="cyh"  style="color: #3160d8;" /></td>
                <td style=" border-bottom: 0;"></td>
                <td style=" border-bottom: 0; padding-left: 15px;;"><span class="ui_l"></span></td>
            </tr>
        </table>
        <table class="ui_fa1" width="100%" height="80">
            <tr>
                <td width="65" style="border-right: 0; color: #be8f00;"><a href="javascript:history.back();" style=" color: #be8f00;">«返回</a></td>
                <td align="center" style="border-left: 0;"><button type="button" class="layui-btn layui-btn-normal btn">提 交</button></td>
            </tr>
        </table>
    </div>
</div>
<div id="addFpTt" style="display: none;">
    <table class="ui_form xz">
        <div class="layui-form-item ">
            <label class="layui-form-label"  style="width: 500px; margin-top: 20px;">请选择服务商</label>
            <div class="layui-input-block ui_form xz">
                <select name="city" id="zh" lay-verify="required" style="width: 500px; margin-top: 20px;">
                </select>
            </div>
        </div>
    </table>
</div>
<script>
    layui.use(['form','upload','layer'],function(){
        var $ = layui.$
            ,upload = layui.upload
            ,layer = layui.layer;
        $('#invoiceType').change(function(){
            var companyId = $('#companyId').val();
            // console.log(companyId);
            if(companyId == 0){
                $('#sl').text("0%");
                $('#yk').text("0.00");
            }else{
                $.ajax({
                    url: '/home/companyId',
                    method: 'post',
                    data: {gid: companyId},
                    dataType: 'json',
                    success: function (res) {
                        if(res.code == 2){
                            var gong = res.message;
                            var mon = $('#invoiceAmount').val();
                            var money = 0;
                            var invoiceType = $('#invoiceType').val();
                            if(invoiceType == '请选择发票类型'){
                                $('#sl').text("0%");
                                $('#yk').text("0.00");
                            }else if(invoiceType == 0){
                                $('#sl').text(gong.g_ppzhsl+"%");
                                money = mon*parseFloat(gong.g_ppzhsl);
                                // console.log(money);
                                $('#yk').text(money);
                            }else if(invoiceType == 1){
                                $('#sl').text(gong.g_dkzhsl+"%");
                                money = mon*parseFloat(gong.g_dkzhsl);
                                // console.log(money);
                                $('#yk').text(money);
                            }else if(invoiceType == 2){
                                $('#sl').text(gong.g_zpzhsl+"%");
                                money = mon*parseFloat(gong.g_zpzhsl);
                                // console.log(money);
                                $('#yk').text(money);
                            }
                        }
                    }
                });
            }

        });
        $('#invoiceTitle').change(function(){
            var rid = $(this).val();
            $.ajax({
                url:'/home/invoiceTitle',
                method:'post',
                data:{rid:rid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code == 2) {
                        var data = res.message;
                        $('#sh').val(data.r_swdj);
                        $('#dz').val(data.r_gsdz + '-' + data.r_gsdh);
                        $('#yh').val(data.r_khxhm + '-' + data.r_yhjbhzh);
                    }else{
                        $('#sh').val('');
                        $('#dz').val('');
                        $('#yh').val('');
                        layer.msg(res.message);
                    }
                }
            });
        });
        $('#expressId').change(function(){
            var eid = $(this).val();
            $.ajax({
                url:"/home/expressId",
                method:'post',
                data:{eid:eid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code == 2){
                        var ex = res.message;
                        $('#sjh').val(ex.e_phone);
                        $('#sjdz').val(ex.e_address);
                    }else{
                        $('#sjh').val('');
                        $('#sjdz').val('');
                        layer.msg(res.message);
                    }
                }
            });
        });
        $('#invoiceAmount').change(function(){
            var money = $(this).val();
            var type = $('#invoiceType').val();
            var dmon = Arabia_to_Chinese(money);
            $('.dxje').text(dmon);
            $('.xxje').text('￥'+money);
            var companyId = $('#companyId').val();
            // console.log(companyId);
            if(companyId == 0){
                $('#sl').text("0%");
                $('#yk').text("0.00");
            }else{
                $.ajax({
                    url: '/home/companyId',
                    method: 'post',
                    data: {gid: companyId},
                    dataType: 'json',
                    success: function (res) {
                        if(res.code == 2){
                            var mon = $('#invoiceAmount').val();
                            var money = 0;
                            var gong = res.message;
                            $('#tax').val(gong.g_sbh);
                            $('#dzdh').val(gong.g_address+'-'+gong.g_phone);
                            $('#cyh').val(gong.g_bank+'-'+gong.g_zh);
                            var invoiceType = $('#invoiceType').val();
                            mon = mon;
                            if(type == '请选择发票类型'){
                                $('#sl').text("0%");
                                $('#yk').text("0.00");
                            }else if(type == 0){
                                $('#sl').text(gong.g_ppzhsl+"%");
                                money = mon*parseFloat(gong.g_ppzhsl);
                                // console.log(money);
                                $('#yk').text(money);
                            }else if(type == 1){
                                $('#sl').text(gong.g_dkzhsl+"%");
                                money = mon*parseFloat(gong.g_dkzhsl);
                                $('#yk').text(money);
                            }else if(type == 2){
                                $('#sl').text(gong.g_zpzhsl+"%");
                                money = mon*parseFloat(gong.g_zpzhsl);
                                $('#yk').text(money);
                            }
                        }
                    }
                });
            }
        });
        $('#companyId').change(function(){
            var gid = $(this).val();
            $.ajax({
                url:'/home/companyId',
                method:'post',
                data:{gid:gid},
                dataType:'json',
                success:function(res){
                    console.log(res);
                    if(res.code == 2){
                        if(gid == 0){
                            $('#sl').text("0%");
                            $('#yk').text("0.00");
                        }else {
                            var mon = $('#invoiceAmount').val();
                            var money = 0;
                            var gong = res.message;
                            mon = mon;
                            $('#tax').val(gong.g_sbh);
                            $('#dzdh').val(gong.g_address + '-' + gong.g_phone);
                            $('#cyh').val(gong.g_bank + '-' + gong.g_zh);
                            var invoiceType = $('#invoiceType').val();
                            // console.log(invoiceType);
                            if (invoiceType == '请选择发票类型') {
                                $('#sl').text("0%");
                                $('#yk').text("0.00");
                            } else if (invoiceType == 0) {
                                $('#sl').text(gong.g_ppzhsl + "%");
                                money = mon * parseFloat(gong.g_ppzhsl);
                                // console.log(money);
                                $('#yk').text(money);
                            } else if (invoiceType == 1) {
                                $('#sl').text(gong.g_dkzhsl + "%");
                                money = mon * parseFloat(gong.g_dkzhsl);
                                $('#yk').text(money);
                            } else if (invoiceType == 2) {
                                $('#sl').text(gong.g_zpzhsl + "%");
                                money = mon * parseFloat(gong.g_zpzhsl);
                                $('#yk').text(money);
                            }
                        }

                    }else{
                        $('#sl').text("0%");
                        $('#yk').text("0.00");
                        $('#tax').val('');
                        $('#dzdh').val('');
                        $('#cyh').val('');
                        layer.msg(res.message);
                    }
                }
            });
        });
        var uploadInst = upload.render({
            elem: '#upload' //绑定元素
            ,url: "{{url('home/file')}}" //上传接口
            ,accept:'file'
            ,done: function(res){
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('#upload').text(res.name);
                    $('#contractPic').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }else if(res.code == 6){
                    layer.msg(res.message);
                }
                //上传完毕回调
            }
            ,error: function(){
                //请求异常回调
            }
        });
        var uploadInst = upload.render({
            elem: '#uploads' //绑定元素
            ,url: "{{url('home/upload')}}" //上传接口
            ,done: function(res){
                if(res.code == 1){
                    layer.msg("上传成功");
                    $("#cashPicPic1").removeAttr("style");
                    $('.ui_ls').attr('src','.'+res.message);
                    $('#cashPic').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }else if(res.code == 6){
                    layer.msg(res.message);
                }
                //上传完毕回调
            }
            ,error: function(){
                //请求异常回调
            }
        });
        $(document).on('click','.ui_ls',function(){
            var url = $(this).attr('src');
            var img = "<img src='"+url+"' width='500px'>";
            layer.open({
                type:1,
                shade:false,
                area:['35%','85%'],
                maxmin:true,
                content:img,
                cancel:function(){

                }
            });
            layer.photos({
                photos: '.ui_ls',
                shadeClose: false,
                closeBtn: 2,
                anim: 0
            });

        });

        $(document).on('click','.btn',function(){
            var invoiceType = $('#invoiceType').val();
            var invoiceTitle = $('#invoiceTitle').val();
            var expressId = $('#expressId').val();
            var serviceContent = $('#serviceContent').val();
            var invoiceAmount = $('#invoiceAmount').val();
            var companyId = $('#companyId').val();
            var file = $('#contractPic').val();
            var invoiceRemark = $('#invoiceRemark').val();
            var img = $('#cashPic').val();
            var yk = $('#yk').text();
            var create_time = $('.time ').text();
            var sh = $('#sh').val();
            var dz = $('#dz').val();
            var yh = $('#yh').val();
            if(invoiceType == "请选择发票类型"){
                layer.msg("请选择发票类型");
                return false;
            }
            if(invoiceTitle == "请选择发票抬头"){
                layer.msg("请选择发票抬头");
                return false;
            }
            if(sh == ''){
                layer.msg("纳税人识别号不全不能开票");
                return false;
            }
            if(invoiceType != 0){
                if(dz == '' || yh == ''){
                    layer.msg("发票抬头信息不全只能开普票");
                    return false;
                }
            }
            if(expressId == "请选择收件人"){
                layer.msg("请选择收件人");
                return false;
            }
            if(serviceContent == ""){
                layer.msg("请填写服务内容");
                return false;
            }
            if(invoiceAmount == ""){
                layer.msg("请填写开票金额");
                return false;
            }
            if(companyId == 0){
                layer.msg("请填写开票方");
                return false;
            }
            if(file == ''){
                layer.msg("请上传对应合同");
                return false;
            }
            $('#zh').empty();
            $.ajax({
                url:"/home/companyId",
                method:'post',
                data:{gid:companyId},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    var zh = res.cz;
                    if(res.code == 2){
                        var op = "<option>请选择服务商</option>";
                        for(var i in zh){
                            op += "<option  value='"+zh[i].z_id+"'>"+zh[i].z_fwsmc+"</option>";
                        }
                        $('#zh').append(op);
                        // console.log(op);
                    }
                }
            });
            layer.open({
                type:1,
                area:['200','100'],
                title: '选择要扣费的服务商'
                ,content: $("#addFpTt"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var zid = $('#zh').val();
                    console.log(zid);
                    var data = {
                        invoiceType:invoiceType,
                        invoiceTitle:invoiceTitle,
                        expressId:expressId,
                        serviceContent:serviceContent,
                        invoiceAmount:invoiceAmount,
                        companyId:companyId,
                        file:file,
                        invoiceRemark:invoiceRemark,
                        img:img,
                        yk:yk,
                        create_time:create_time,
                        zid:zid,
                    };
                    $.ajax({
                        url:"/home/doinvoiceApply",
                        method:'post',
                        data:data,
                        dataType:'json',
                        success:function(res){
                            console.log(res);
                            if(res.code == 2){
                                layer.msg(res.message);
                                location.href='/home/invoiceRecord';
                            }else if(res.code == 1){
                                layer.msg(res.message);
                            }else if(res.code == 3){
                                layer.msg(res.message);
                            }else if(res.code == 4){
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
        //数字转换
        function Arabia_to_Chinese(Num) {
            for (i = Num.length - 1; i >= 0; i--) {
                Num = Num.replace(",", "")//替换tomoney()中的“,”
                Num = Num.replace(" ", "")//替换tomoney()中的空格
            }
            Num = Num.replace("￥", "")//替换掉可能出现的￥字符
            if (isNaN(Num)) { //验证输入的字符是否为数字
                alert("请检查小写金额是否正确");
                return;
            }
            //---字符处理完毕，开始转换，转换采用前后两部分分别转换---//
            part = String(Num).split(".");
            newchar = "";
            //小数点前进行转化
            for (i = part[0].length - 1; i >= 0; i--) {
                if (part[0].length > 10) { alert("位数过大，无法计算"); return ""; } //若数量超过拾亿单位，提示
                tmpnewchar = ""
                perchar = part[0].charAt(i);
                switch (perchar) {
                    case "0": tmpnewchar = "零" + tmpnewchar; break;
                    case "1": tmpnewchar = "壹" + tmpnewchar; break;
                    case "2": tmpnewchar = "贰" + tmpnewchar; break;
                    case "3": tmpnewchar = "叁" + tmpnewchar; break;
                    case "4": tmpnewchar = "肆" + tmpnewchar; break;
                    case "5": tmpnewchar = "伍" + tmpnewchar; break;
                    case "6": tmpnewchar = "陆" + tmpnewchar; break;
                    case "7": tmpnewchar = "柒" + tmpnewchar; break;
                    case "8": tmpnewchar = "捌" + tmpnewchar; break;
                    case "9": tmpnewchar = "玖" + tmpnewchar; break;
                }
                switch (part[0].length - i - 1) {
                    case 0: tmpnewchar = tmpnewchar + "元"; break;
                    case 1: if (perchar != 0) tmpnewchar = tmpnewchar + "拾"; break;
                    case 2: if (perchar != 0) tmpnewchar = tmpnewchar + "佰"; break;
                    case 3: if (perchar != 0) tmpnewchar = tmpnewchar + "仟"; break;
                    case 4: tmpnewchar = tmpnewchar + "万"; break;
                    case 5: if (perchar != 0) tmpnewchar = tmpnewchar + "拾"; break;
                    case 6: if (perchar != 0) tmpnewchar = tmpnewchar + "佰"; break;
                    case 7: if (perchar != 0) tmpnewchar = tmpnewchar + "仟"; break;
                    case 8: tmpnewchar = tmpnewchar + "亿"; break;
                    case 9: tmpnewchar = tmpnewchar + "拾"; break;
                }
                newchar = tmpnewchar + newchar;
            }
            //小数点之后进行转化
            if (Num.indexOf(".") != -1) {
                if (part[1].length > 2) {
                    alert("小数点之后只能保留两位,系统将自动截段");
                    part[1] = part[1].substr(0, 2)
                }
                for (i = 0; i < part[1].length; i++) {
                    tmpnewchar = ""
                    perchar = part[1].charAt(i)
                    switch (perchar) {
                        case "0": tmpnewchar = "零" + tmpnewchar; break;
                        case "1": tmpnewchar = "壹" + tmpnewchar; break;
                        case "2": tmpnewchar = "贰" + tmpnewchar; break;
                        case "3": tmpnewchar = "叁" + tmpnewchar; break;
                        case "4": tmpnewchar = "肆" + tmpnewchar; break;
                        case "5": tmpnewchar = "伍" + tmpnewchar; break;
                        case "6": tmpnewchar = "陆" + tmpnewchar; break;
                        case "7": tmpnewchar = "柒" + tmpnewchar; break;
                        case "8": tmpnewchar = "捌" + tmpnewchar; break;
                        case "9": tmpnewchar = "玖" + tmpnewchar; break;
                    }
                    if (i == 0) tmpnewchar = tmpnewchar + "角";
                    if (i == 1) tmpnewchar = tmpnewchar + "分";
                    newchar = newchar + tmpnewchar;
                }
            }
            //替换所有无用汉字
            while (newchar.search("零零") != -1)
                newchar = newchar.replace("零零", "零");
            newchar = newchar.replace("零亿", "亿");
            newchar = newchar.replace("亿万", "亿");
            newchar = newchar.replace("零万", "万");
            newchar = newchar.replace("零元", "元");
            newchar = newchar.replace("零角", "");
            newchar = newchar.replace("零分", "");

            if (newchar.charAt(newchar.length - 1) == "元" || newchar.charAt(newchar.length - 1) == "角")
                newchar = newchar + "整"
            //  document.write(newchar);
            return newchar;

        }

    });
</script>
@endsection
