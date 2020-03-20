@extends('layout.index')
@section('title', '发票列表')
@section('content')
<!--右边内容区-->
<div class="layui-breadcrumb page_mbx">
    <a href="">首页</a><span>-</span>
    <a><cite>开票记录</cite></a>
</div>
<div class="ui_box">
    <div class="ui_tit"><i class="iconfont">&#xe668;</i>开票记录</div>
    <div class="shaixuan">
        <ul class="shaixuan_ul">
            <li class="shaixuan_li">
                <div class="shaixuan_title">发票状态：</div>
                <div class="shaixuan_btn_list ml42px">
                    <a href="invioce" class="type  cur">全部</a>
                    <a href="invioce?invoiceStatus=1" class="type ">审核中</a>
                    <a href="invioce?invoiceStatus=2" class="type ">已开票</a>
                    <a href="invioce?invoiceStatus=3" class="type ">已寄送</a>
                    <a href="invioce?invoiceStatus=4" class="type ">已完成</a>
                    <a href="invioce?invoiceStatus=5" class="type ">已取消</a>
                </div></li>
        </ul></div>
    <div class="clear"></div>
    <table class="layui-table" lay-size="lg" style=" text-align: center;">
        <thead>
        <tr>
            <th style=" text-align: center;"><input type="checkbox" class="checkbox">全选<span>发票ID</span></th>
            <th style=" text-align: center;">发票号</th>
            <th style=" text-align: center;">发票抬头</th>
            <th style=" text-align: center;">金额</th>
            <th style=" text-align: center;">收件人</th>
            <th style=" text-align: center;">打款凭证</th>
            <th style=" text-align: center;">开票公司</th>
            <th style=" text-align: center;">发票照片</th>
            <th style=" text-align: center;">状态</th>
            <th style=" text-align: center;">操作</th>
        </tr>
        </thead>
        @foreach($data as $d)
        <tr i_id="{{$d->i_id}}">
            <td valign="top">
                <input type="checkbox" class="fu" >
                {{$d->i_id}}
            </td>
            <td valign="top" class="hao" style="cursor:pointer">
                <span> {{$d->i_invoicehao}}</span>
                <input type="text" class="i_invoicehao" value="{{$d->i_invoicehao}}" style="display: none;">

            </td>
            <td valign="top">{{$d->r_name}}</td>

            <td valign="top">{{$d->i_invoiceAmount}} 元</td>
            <td valign="top">{{$d->e_name}}<br/>{{$d->e_phone}}<br/>{{$d->e_address}}</td>
            <td valign="top">
                @if($d->i_img == '')
                <a href="javascript:;" class="cash" id="cash" data-id="{{$d->i_id}}">上传</a>
                @else
                <a href="javascript:;" class="img" src="{{$d->i_img}}">查看</a>
                @endif
            </td>
            <td valign="top">{{$d->g_name}}</td>
            <td valign="top">
                @if($d->i_invoiceimg == '')
                <a href="javascript:;" class="invoiceimg" id="invoiceimg" data-id="{{$d->i_id}}">上传</a>
                @else
                <a href="javascript:;" class="invoice" src="{{$d->i_invoiceimg}}" data-url=""">查看</a>
                @endif
            </td>
            <td valign="top" class="status" i_id="{{$d->i_id}}" style="cursor:pointer">
                @if($d->i_status == 1)
                审核中
                @elseif($d->i_status == 2)
                已开票
                @elseif($d->i_status == 3)
                已寄送
                @elseif($d->i_status == 4)
                已完成
                @elseif($d->i_status == 5)
                已取消
                @endif
            </td>
            <td valign="top">
                <a href="javascript:;" class="export">下载</a>
            </td>
        </tr>
        @endforeach

        <tr class="td_normal" align="right">
            <td colspan="10">

                <div class='pager'>{{$data->appends(['invoiceStatus' => $invoiceStatus])->links()}}</div>
            </td>
        </tr>
    </table>
    <div  class="layui-form-block sss">
        <button class="layui-btn layui-btn-normal exports">导出</button>
    </div>
</div>
</div>

<!--内容主体结束-->

<div id="modifyFpTt" class="layui-form" style="margin-top: 36px;display: none">
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <select name="city" class="i_status" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">审核中</option>
                <option value="2">已开票</option>
                <option value="3">已寄送</option>
                <option value="4">已完成</option>
                <option value="5">已取消</option>

            </select>
        </div>
    </div>
</div>
<script src="{{asset('layuiadmin/layui_exts/excel.js')}}"></script>
<script>
    layui.use(['form','upload','layer','excel'],function(){
        var $ = layui.$
            ,upload = layui.upload
            ,layer = layui.layer
        ,excel = layui.excel;
        var uploadInst = upload.render({
            elem: '#cash' //绑定元素
            ,url: "{{url('/home/imgs')}}" //上传接口
            ,data: {
                id: function(){
                    return $('#cash').attr('data-id');
                }
            }
            ,done: function(res){
                if(res.code == 1){
                    layer.msg("上传成功");
                    window.location.reload();
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
        $(document).on('click','.hao',function(){
           $(this).children('span').css('display:none');
           $(this).children('.i_invoicehao').removeAttr('style');
        });
        $(document).on('blur','.i_invoicehao',function(){
            var i_invoicehao = $(this).val();
            var i_id = $(this).parents('tr').attr('i_id');
            // console.log(i_id);
            $.ajax({
                url:'/clickEdit',
                method:'post',
                data:{i_id:i_id,i_invoicehao:i_invoicehao},
                dataType:'json',
                success:function(res){
                    if(res.code == 2){
                        layer.msg(res.message);
                        window.location.reload();
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
        });
        $(document).on('click','.status',function(){
            var i_id = $(this).parents('tr').attr('i_id');
            layer.open({
                type:1,
                area:['400px','300px'],
                title: '修改'
                ,content: $("#modifyFpTt"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var status = $('.i_status').val();
                    $.ajax({
                        url:'/invioce/istatus',
                        method:'post',
                        data:{status:status,i_id:i_id},
                        dataType:'json',
                        success:function(res){
                            // console.log(res);
                            if(res.code == 2){
                                layer.msg(res.message);
                                window.location.reload();
                            }else{
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
        var uploadInsts = upload.render({
            elem: '#invoiceimg' //绑定元素
            ,url: "{{url('/invoiceimg')}}" //上传接口
            ,data: {
                id: function(){
                    return $('#invoiceimg').attr('data-id');
                }
            }
            ,done: function(res){
                if(res.code == 1){
                    layer.msg("上传成功");
                    window.location.reload();
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
        })
        $(document).on('click','.img',function() {
            var url = $(this).attr('src');
            var img = "<img src='." + url + "' width='500px'>";
            layer.open({
                type: 1,
                shade: false,
                area: ['35%', '85%'],
                maxmin: true,
                content: img,
                cancel: function () {

                }
            });
            layer.photos({
                photos: '.img',
                shadeClose: false,
                closeBtn: 2,
                anim: 0
            });
        });
        $(document).on('click','.invoice',function() {
            var url = $(this).attr('src');
            if(url == ''){
                layer.open({
                    type: 0,
                    title: '提示',
                    content: "<p style='text-align: center;font-size: 25px;padding-bottom: 10px !important;margin-top: 59px;'>发票照片暂未上传</p>",
                    area: ["300px", "250px"],
                });
                return false;
            }
            var img = "<img src='." + url + "' width='500px'>";
            layer.open({
                type: 1,
                shade: false,
                area: ['35%', '85%'],
                maxmin: true,
                content: img,
                cancel: function () {

                }
            });
        });
        //全选
        //全选
        $(document).on('click', ".checkbox",function(){
            if($(this).prop('checked')){
                $('.fu').each(function(){
                    $('.fu').prop('checked',true);
                });
            }else{
                $('.fu').each(function(){
                    $('.fu').prop('checked',false);
                });
            }
        });
        //下载
        $(document).on('click','.export',function(){


                   var i_id =$(this).parents('tr').attr('i_id');


            $.ajax({
                url: '{{url('invoiceExport')}}',
                data:{i_id:i_id},
                dataType: 'json',
                success: function(res) {
                    // 假如返回的 res.data 是需要导出的列表数据
                    console.log(res.data);// [{name: 'wang', age: 18, sex: '男'}, {name: 'layui', age: 3, sex: '女'}]
                    // 1. 数组头部新增表头
                    res.data.unshift({
                        i_id: '序号',
                        i_invoiceType: '发票类型',
                        r_name: '购票方名称',
                        r_swdj: '购票方纳税人识别号',
                        r_gsdz: '购票方地址',
                        r_gsdh: '购票方电话',
                        r_khxhm: '购票方开户行',
                        r_yhjbhzh: '购票方账号',
                        i_serviceContent: '服务名称',
                        i_invoiceAmount: '开票金额',
                        g_name: '开票方名称',
                        g_sbh: '开票方纳税人识别号',
                        g_address: '开票方地址',
                        g_phone: '开票方法人电话',
                        g_bank: '开票方开户银行',
                        g_zh: '开票方银行账号',
                        e_name: '收件人',
                        e_phone: '收件人手机号',
                        e_address: '详细地址',
                        i_invoiceRemark: '备注',
                    });
                    // 2. 如果需要调整顺序，请执行梳理函数
                    var data = excel.filterExportData(res.data, {
                        i_id:'i_id',
                        i_invoiceType:'i_invoiceType',
                        r_name: 'r_name',
                        r_swdj:'r_swdj',
                        r_gsdz:'r_gsdz',
                        r_gsdh:'r_gsdh',
                        r_khxhm:'r_khxhm',
                        r_yhjbhzh:'r_yhjbhzh',
                        i_serviceContent:'i_serviceContent',
                        i_invoiceAmount:'i_invoiceAmount',
                        g_name:'g_name',
                        g_sbh:'g_sbh',
                        g_address:'g_address',
                        g_phone:'g_phone',
                        g_bank:'g_bank',
                        g_zh:'g_zh',
                        e_name:'e_name',
                        e_phone:'e_phone',
                        e_address:'e_address',
                        i_invoiceRemark:'i_invoiceRemark',
                    });
                    // 3. 执行导出函数，系统会弹出弹框
                    var timestart = Date.now();
                    layui.excel.exportExcel({
                        sheet1:data
                    }, _getRandomString(6)+'.xlsx', 'xlsx');
                    // var timeend = Date.now();
                    // var spent = (timeend - timestart) / 1000;
                    // layer.alert('单纯导出耗时 '+spent+' s');
                }
            });
        });
        //批量下载
        $(document).on('click','.exports',function(){

            var i_id='';
            $('.fu').each(function(){
                if($(this).prop('checked')){
                    i_id +=','+$(this).parents('tr').attr('i_id');
                }
            });
            if(i_id == ''){
                layer.alert('请选择数据',{icon:5,time:3000});return;
            }

            $.ajax({
                url: '{{url('invoiceExport')}}',
                data:{i_id:i_id},
                dataType: 'json',
                success: function(res) {
                    // 假如返回的 res.data 是需要导出的列表数据
                    console.log(res.data);// [{name: 'wang', age: 18, sex: '男'}, {name: 'layui', age: 3, sex: '女'}]
                    // 1. 数组头部新增表头
                    res.data.unshift({
                        i_id: '序号',
                        i_invoiceType: '发票类型',
                        r_name: '购票方名称',
                        r_swdj: '购票方纳税人识别号',
                        r_gsdz: '购票方地址',
                        r_gsdh: '购票方电话',
                        r_khxhm: '购票方开户行',
                        r_yhjbhzh: '购票方账号',
                        i_serviceContent: '服务名称',
                        i_invoiceAmount: '开票金额',
                        g_name: '开票方名称',
                        g_sbh: '开票方纳税人识别号',
                        g_address: '开票方地址',
                        g_phone: '开票方法人电话',
                        g_bank: '开票方开户银行',
                        g_zh: '开票方银行账号',
                        e_name: '收件人',
                        e_phone: '收件人手机号',
                        e_address: '详细地址',
                    });
                    // 2. 如果需要调整顺序，请执行梳理函数
                    var data = excel.filterExportData(res.data, {
                        i_id:'i_id',
                        i_invoiceType:'i_invoiceType',
                        r_name: 'r_name',
                        r_swdj:'r_swdj',
                        r_gsdz:'r_gsdz',
                        r_gsdh:'r_gsdh',
                        r_khxhm:'r_khxhm',
                        r_yhjbhzh:'r_yhjbhzh',
                        i_serviceContent:'i_serviceContent',
                        i_invoiceAmount:'i_invoiceAmount',
                        g_name:'g_name',
                        g_sbh:'g_sbh',
                        g_address:'g_address',
                        g_phone:'g_phone',
                        g_bank:'g_bank',
                        g_zh:'g_zh',
                        e_name:'e_name',
                        e_phone:'e_phone',
                        e_address:'e_address',
                    });
                    // 3. 执行导出函数，系统会弹出弹框
                    var timestart = Date.now();
                    layui.excel.exportExcel({
                        sheet1:data
                    }, _getRandomString(6)+'.xlsx', 'xlsx');
                    // var timeend = Date.now();
                    // var spent = (timeend - timestart) / 1000;
                    // layer.alert('单纯导出耗时 '+spent+' s');
                }
            });
        });
        // 获取长度为len的随机字符串
        function _getRandomString(len) {
            len = len || 32;
            var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'; // 默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1
            var maxPos = $chars.length;
            var pwd = '';
            for (i = 0; i < len; i++) {
                pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
            }
            return pwd;
        }

    });
</script>
@endsection
