@extends('layout.ge')
@section('title', '开票记录')
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
                    <a href="invoiceRecord" class="type  cur">全部</a>
                    <a href="invoiceRecord?invoiceStatus=1" class="type ">审核中</a>
                    <a href="invoiceRecord?invoiceStatus=2" class="type ">已开票</a>
                    <a href="invoiceRecord?invoiceStatus=3" class="type ">已寄送</a>
                    <a href="invoiceRecord?invoiceStatus=4" class="type ">已完成</a>
                    <a href="invoiceRecord?invoiceStatus=5" class="type ">已取消</a>
                </div></li>
        </ul></div>
    <div class="clear"></div>
    <table class="layui-table" lay-size="lg" style=" text-align: center;">
        <thead>
        <tr>
            <th style=" text-align: center;">发票ID</th>
            <th style=" text-align: center;">发票号</th>
            <th style=" text-align: center;">发票抬头</th>

            <th style=" text-align: center;">金额</th>
            <th style=" text-align: center;">收件人</th>
            <th style=" text-align: center;">打款凭证</th>
            <th style=" text-align: center;">开票公司</th>
            <th style=" text-align: center;">进度</th>
            <th style=" text-align: center;">发票照片</th>
            <th style=" text-align: center;">状态</th>
        </tr>
        </thead>
        @foreach($data as $d)
        <tr>
            <td valign="top">{{$d->i_id}}</td>
            <td valign="top">{{$d->i_invoicehao}}</td>
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
            <td style=" text-align: left;">
                <a href="javascript:;" class="ckjd" data-id="4319">查看</a>
            </td>
            <td valign="top">
                <a href="javascript:;" class="invoice" src="{{$d->i_invoiceimg}}" data-url=""">查看</a>
            </td>
            <td valign="top">
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
        </tr>
        @endforeach

        <tr class="td_normal" align="right">
            <td colspan="10">

                <div class='pager'>{{$data->appends(['invoiceStatus' => $invoiceStatus])->links()}}</div>
            </td>
        </tr>
    </table>
</div>
</div>
<!--内容主体结束-->

<div id="zpDiv" style="display: none;">
    <img id="img" style="width: 500px;" src="">
</div>

<div id="invoiceDiv" style="display: none;">
    <img id="img" style="width: 500px;" src="">
</div>


<input type="hidden" class="i_img">

<div id="cashDiv" style="display: none;">
    <div class="upimg" style="width:366px;">
        <div class="setUpimg">
            <img width="120" id="cashPicPic" src="/images/upimg.png" >
            <input type="hidden" id="cashPic" />
        </div>
        <form action="/fileUpload"
              method="post" enctype="multipart/form-data" target="uploadIframe" id="upload_cash_pic_form">
            <div class="form-group">
                <div class="col-sm-9">
                    <div class="upPic">
                        <input type="hidden" name="contextPath" value="sdscus/" id="yhkhxkPicPath">
                        <input type="hidden" name="refererPage" value=""/>
                        <div class="uphead mt10 ml10" >
                            <input type="file" name="cashPic_f" data-name="cash_pic" id="cashPic_f" onchange="uploadSubmit2(this)"   size="1"  class="input_file" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </tbody>
</div>
<script>
    layui.use(['form','upload','layer'],function(){
        var $ = layui.$
            ,upload = layui.upload
        ,layer = layui.layer;
        var uploadInst = upload.render({
            elem: '#cash' //绑定元素
            ,url: "{{url('home/imgs')}}" //上传接口
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

    });
</script>
@endsection
