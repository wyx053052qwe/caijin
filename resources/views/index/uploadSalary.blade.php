@extends('layout.home')
@section('title', '设置联系人')
@section('content')
<script type="text/javascript">
    layui.config({
        base: 'layui_exts/'
    }).extend({
        excel: 'excel'
    });
</script>
<style>

    .btndome p{ padding-top:10px; color:#666; font-size:12px;}
    .ui-dialog-titlebar-close{display: none;}
    .loader {
        width: 150px;
        margin: 50px auto 70px;
        position: relative;
    }
    .loader .loading-1 {
        position: relative;
        width: 300px;
        height: 10px;
        border: 1px solid #69d2e7;
        border-radius: 10px;
        animation: turn 2s linear 1s infinite;
    }
    .loader .loading-1:before {
        content: "";
        display: block;
        position: absolute;
        width: 0%;
        height: 100%;
        background: #69d2e7;
        box-shadow: 10px 0px 15px 0px #69d2e7;
        animation: load 1s linear infinite;
    }
    .loader .loading-2 {
        width: 200px;
        position: absolute;
        top: 10px;
        color: #69d2e7;
        font-size: 18px;
        text-align: center;
        animation: bounce 2s  linear infinite;
    }
    @keyframes load {
        0% {
            width: 0%;
        }
        87.5%, 100% {
            width: 100%;
        }
    }

    @keyframes bounce {
        0%,100% {
            top: 10px;
        }
        12.5% {
            top: 30px;
        }
    }
</style>
<script>
    layui.use(['laydate','form', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function() {
        var form = layui.form
            ,$ = layui.$;

        form.on('select(modules)', function(data){
            // console.log(data.elem); //得到select原始DOM对象
            // console.log(data.value); //得到被选中的值
            // console.log(data.othis); //得到美化后的DOM对象
            var customerCompanyId =  data.value;
            $("#ableAccount").text("￥0");
            $.ajax({
                type: "POST",
                url: "getSupplierCompanys",
                data: {"customerCompanyId":customerCompanyId},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",
                async:true,
                success: function(data){
                    $("#supplierCompanySelect").html("<option value='0'>服务商</option>");
                    if ( data.list != null ){
                        // console.log(data.list);
                        for(var i = 0;i<data.list.length;i++){
                            var supplierCompanyId =  data.list[i].z_id;
                            var supplierCompanyName =  data.list[i].z_fwsmc;
                            $("#supplierCompanySelect").append('<option value="'+supplierCompanyId+'">'+supplierCompanyName+'</option>');
                        }
                    }

                    form.render('select');
                }
            });



        });

        form.on('select(account)', function(data){
            // console.log(data.elem); //得到select原始DOM对象
            // console.log(data.value); //得到被选中的值
            // console.log(data.othis); //得到美化后的DOM对象
            var customerCompanyId =  $('#customerCompanySelect').val();
            var supplierCompanyId = data.value;
            $.ajax({
                type: "POST",
                url: "getCustomerFinance",
                data: {"customerCompanyId":customerCompanyId,"supplierCompanyId":supplierCompanyId},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",
                async:true,
                success: function(data){
                    // console.log(data);
                    if(data.success==2){
                        $("#ableAccount").text("￥"+data.cz['c_yue']);
                        form.render('select');
                    }else{
                        $("#ableAccount").text("￥0");
                        form.render('select');
                    }

                }
            });



        });

    });

</script>
<div id="main">

    <!--右边-->
    <div class="main_right">
        <!--右边内容区-->
        <div class="layui-breadcrumb page_mbx">
            <a href="javascript:;">首页</a><span>-</span>
            <a><cite>我的订单/上传明细</cite></a>
        </div>
        <div class="main_right_content">
            <!--新增订单开始-->
            <div class="ui_box layui-form">
                <div class="ui_tit"><i class="iconfont">&#xe668;</i>选择发放渠道</div>
                <div class="layui-input-inline" style=" margin:20px 10px 10px 240px;  ">
                    <select lay-filter="modules"  name="modules" id="customerCompanySelect" lay-filter="category" lay-verify="required" lay-search="">
                        <option value="0">商户</option>
                        @foreach($gong as $g)
                        <option value="{{$g->g_id}}">{{$g->g_name}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="layui-input-inline" style=" margin:20px 10px 10px 20px;  ">
                    <select lay-filter="account"  id="supplierCompanySelect" name="modules" lay-verify="required" lay-search="">
                        <option value="0">服务商</option>
                    </select>

                </div>

                <p style=" margin-left: 240px;">渠道余额：
                    <span id="ableAccount" class="danger">
								 ￥0
							</span>
                </p>
                <div style=" clear: both; height: 40px;"></div>
                <div class="ui_tit"><i class="iconfont">&#xe668;</i>上传费用明细表<span style=" margin-left:25px;"><a style="color:#f00; font-size:14px; display:none" id="failureReason">点击下载失败原因</a></span></div>
                <table class="qy_tc" style=" width: 1000px;">

                    <tr>
                        <td></td>
                        <td></td>
                        <td rowspan="4" width="100"></td>
                        <td rowspan="4" width="550">
                            <div style="line-height: 26px; color: #666;">
                                <h3 style=" color: #466; line-height: 38px;"><b>提示：</b></h3>
                                <!-- 1.单次上传表格：身份证、银行卡号、手机号不可以重复。<br> -->
                                1.上传表格条数不超过2万条。<br>
                                2.单人单次发放金额需小于30,000元。<br>
                                3.单人单月发放金额需小于99,300元。<br>
                                4.预计2小时内到账，具体发放时间以银行通知为准。<br>
                                5.由于银行对公转账的相关限制，费用发放在工作日内：周一 至 周五 09:30 ~ 15:00 之间进行，超过该时间顺延到第二个工作日办理，如需按时发放请提前做好相关工作准备。<br>


                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="200"></td>
                        <td width="400" style=" font-size: 12px;"><span class="layui-btn layui-btn-primary layui-btn-sm"><a href="http://www.caijin.com/sign/demo.xlsx" style="display: block;"><i class="iconfont">&#xe676;</i>下载模板</a></span>&nbsp;&nbsp;&nbsp;请按照模板填写人员费用数据</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td valign="top" style=" padding-top: 35px;"></td>
                        <td width="300">
                            <div class="qy_sc">
                                <div class="layui-form-block block">
                                    <input type="file" class="layui-btn layui-btn-primary upload" id="LAY-excel-import-excel" multiple="multiple">
                                </div><i class="iconfont">&#xedde;</i>
                                <p>点击这里上传</p>
                                <p>请上传小于5M的xls或xlsx格式文件</p>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style=" text-align: center;">
                            <button class="layui-btn layui-btn-primary layui-btn-sm btn" style=" padding: 0 20px;">取消</button>
                            <button  class="layui-btn layui-btn-sm layui-btn-normal confirmSalary" style=" padding: 0 20px;">下一步</button></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <input type="hidden" class="fid" value="">
            </div>
            <!--新增订单结束-->


        </div>
    </div>
</div>
<div class="loader" style="display:none" id="loading">
    <div class="loading-1"></div>
    <div class="loading-2" style="margin-center" id="content">上传中，请稍后...</div>
</div>
<!--右边内容区-->
</div>
<!--右边-->
</div>
<!--内容主体结束-->
</body>
<script src="{{asset('layuiadmin/layui_exts/excel.js')}}"></script>
<script>
    layui.use(['form','upload','layer','excel'],function(){
        var layer = layui.layer
            ,form = layui.form
            ,upload = layui.upload
            ,excel = layui.excel
            ,$ = layui.$;
//上传$
        //导入
        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        // 监听上传文件的事件
        $('#LAY-excel-import-excel').change(function(e) {
            var files = e.target.files;
            uploadExcel(files);
        });
        // 文件拖拽
        $('body')[0].ondragover = function(e) {
            e.preventDefault();
        };
        $('body')[0].ondrop = function(e) {
            e.preventDefault();
            var files = e.dataTransfer.files;
            uploadExcel(files);
        };
        /**
         * 上传excel的处理函数，传入文件对象数组
         * @param  {[type]} files [description]
         * @return {[type]}       [description]
         */
        function uploadExcel(files) {
            var xlsx = files[0].name;
            var g_id = $('#customerCompanySelect').val();
            var z_id = $('#supplierCompanySelect').val();
            try {
                excel.importExcel(files, {
                    // 读取数据的同时梳理数据
                    fields: {
                        'u_id': 'A'
                        ,'o_skfzhmc': 'B'
                        ,'o_khyh': 'C'
                        ,'o_khhqc': 'D'
                        ,'o_id_cart': 'E'
                        ,'o_skfzh': 'F'
                        ,'o_total': 'G'
                        ,'o_phone': 'H'
                        ,'o_kxsx': 'I'
                        ,'o_ff': 'J'
                        ,'o_ms': 'K'

                    }
                }, function(data) {
                    // 还可以再进行数据梳理
                    //    data = excel.filterImportData(data, {
                    //      'id': 'A'
                    //      ,'username': 'B'
                    //      ,'experience': 'C'
                    //      ,'sex': 'D'
                    //      ,'score': 'E'
                    //      ,'city': 'F'
                    //      ,'classify': 'G'
                    //      ,'wealth': 'H'
                    //      ,'sign': 'I'
                    //    });
                    // 如果不需要展示直接上传，可以再次 $.ajax() 将JSON数据通过 JSON.stringify() 处理后传递到后端即可
                    $.ajax({
                        url: '/home/importData'
                        ,method:"post"
                        , data:{data:data,g_id:g_id,z_id:z_id,name:xlsx}
                        , dataType: 'json'
                        , success: function (res) {
                            if(res.code == 1){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 2){
                                layer.alert(res.message,{icon:1});
                                $('.fid').val(res.fid);

                            }else if(res.code == 3){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 4){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 5){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 6){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 7){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 8){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 9){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 10){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }else if(res.code == 11){
                                layer.alert(res.message,{icon:5});
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },1000);
                            }
                        }
                    });
                    //展示表格文件转换成的json数据格式
                    // layer.open({
                    //     title: '文件转换结果'
                    //     ,area: ['799px', '399px']
                    //     ,tipsMore: true
                    //     ,content: laytpl($('#LAY-excel-export-ans').html()).render({data: data, files: files})
                    //     ,success: function() {
                    //         element.render('tab');
                    //         layui.code({
                    //         });
                    //     }
                    // });
                });
            } catch (e) {
                layer.alert(e.message);
            }
        };

        $(document).on('click','.confirmSalary',function() {
            var upload = $('#LAY-excel-import-excel').val();
            var  fid = $('.fid').val();
            if(upload == ''){
                layer.alert('请上传费用明细表！',{icon:5});
            }else{
                location.href='/home/confirmSalary?fid='+fid;
            }
        });
        $(document).on('click','.btn',function(){
            var fid = $('.fid').val();
            $.ajax({
                url:"/home/qux",
                method:'post',
                data:{fid:fid},
                dataType:'json',
                success:function(res){
                    if(res.code == 2){
                        location.href='/home/orderManager';
                    }else if(res.code == 1){
                        layer.msg(res.message);
                        location.href='/home/confirmOrder?fid='+fid;
                    }
                }
            });
        });
    });

</script>
@endsection
