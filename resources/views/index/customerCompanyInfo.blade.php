@extends('layout.ge')
@section('title', '我的公司')
@section('content')
<div class="main_right">

    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="">首页</a><span>-</span>
        <a><cite>我的公司</cite></a>
    </div>
    <div class="ui_box">
        <div class="ui_tit"><i class="iconfont">&#xe668;</i>公司详情</div>

        <table class="ui_fatit">
            <tr>
                <td style="border: 0;"><p>公司代码：<span class="ui_l">{{$gong->g_sbh}}</span></p>
                </td>
                <td style="border: 0;" align="center">
                    <span class="ui_h" style=" font-size: 16px; line-height: 30px; color: #3160d8;">{{$gong->g_name}}</span>
                    <div class="ui_line"></div>
                    <p class="ui_fatext"  style="color: #3160d8;">
                        @if(empty($gong->g_gtype)) 暂无服务类型
                        @else {{$gong->g_gtype}}
                        @endif
                    </p>
                </td>
                <td class="ui_h" align="right" style="border: 0;">注册日期：<span class="ui_l">{{date('Y-m-d',$gong->g_bl)}}</span></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ui_fa1">
            <tr>
                <td rowspan="6" width="30" style=" border-bottom: 0;" align="center">公司信息</td>
                <td style="padding-left: 15px;" width="150" >公 司  全 称：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_name}}</span> </td>
                <td rowspan="9" width="30" style=" border-bottom: 0;" align="center">税务信息</td>
                <td style="padding-left: 15px;" width="150">征 税  类 型：</td>
                <td><span class="ui_l" style="padding-left: 15px;">
                        {{$gong->g_types}}
	</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">纳税人识别号：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_sbh}}</span></td>
                <td style="padding-left: 15px;">增 值 税类型： </td>
                <td><span class="ui_l" style="padding-left: 15px;">
                        {{$gong->g_zzzlx}}
	</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;">落 户  园 区：</td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;">{{$gong->g_lhyq}}</span></td>
                <td style="padding-left: 15px;">增 值 税税率：  </td>
                <td><span class="ui_l" style="padding-left: 15px;"> {{$gong->g_zzsl}}%</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;">注 册  地 址：</td>
                <td style=" border-bottom: 0; width: 37%"><span class="ui_l" style="padding-left: 15px;">{{$gong->g_address}}</span></td>

                <td style=" border-bottom: 0;padding-left: 15px;">普票综合税率： </td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;">0.0%</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;">公 司  类 型：</td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;">

			个人独资



	</span></td>
                <td style=" border-bottom: 0;padding-left: 15px;">代开综合税率： </td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;">{{$gong->g_ppzhsl}}%</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style=" border-bottom: 0;padding-left: 15px;">专票综合税率： </td>
                <td style=" border-bottom: 0; width: 37%"><span class="ui_l" style="padding-left: 15px;">{{$gong->g_zpzhsl}}%</span></td>
            </tr>
            <tr>
                <td rowspan="3" width="30" style=" border-bottom: 0;" align="center">法人信息</td>
                <td style="padding-left: 15px;">法 人  姓 名：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->u_username}}</span></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">法 人 电话：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_phone}}</span></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">法 人 身份证：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_id_cart}}</span></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="8" width="30" style=" border-bottom: 0;" align="center">银行信息</td>
                <td style="padding-left: 15px;" width="150" >开户银行：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_bank}}</span> </td>
                <td rowspan="8" width="30" style=" border-bottom: 0;" align="center">办理信息</td>
                <td style="padding-left: 15px;" width="130">启动办理：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{date('Y-m-d',$gong->g_bl)}}</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">开户网点：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_wd}}</span></td>
                <td style="padding-left: 15px;">执照办结：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{date('Y-m-d',$gong->g_zzbj)}}</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">银行账号：</td>
                <td><span class="ui_l" style="padding-left: 15px;">{{$gong->g_zh}}</span></td>
                <td style="padding-left: 15px;">开户办结： </td>
                <td><span class="ui_l" style="padding-left: 15px;">{{date('Y-m-d',$gong->g_kubj)}}</span></td>
            </tr>
            <tr>
                <td style="padding-left: 15px; border-bottom: 0;"></td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;"></span></td>
                <td style=" border-bottom: 0;padding-left: 15px;">核税办结：</td>
                <td style=" border-bottom: 0;"><span class="ui_l" style="padding-left: 15px;">{{date('Y-m-d',$gong->g_hsbj)}}</span></td>
            </tr>
        </table>
        <table class="ui_fa1" width="100%">
            <tr>
                <td rowspan="2" width="30" align="center">证照照片</td>
                <td align="center">营业执照</td>
                <td align="center">公章</td>
                <td align="center">银行开户许可证</td>
                <td align="center">核税回执</td>
            </tr>
            <tr>
                <td  id="yyzzIMG" align="center"><img src=".{{$gong->g_yyzz}}" width="150"></td>
                <td  id="gzIMG" align="center"><img src=".{{$gong->g_gz}}" width="150"></td>
                <td  id="yhkhIMG" align="center"><img src=".{{$gong->g_yhkhxkz}}" width="150"></td>
                <td  id="hsIMG" align="center"><img src=".{{$gong->g_hshz}}" width="150"></td>
            </tr>
        </table>
        <table class="ui_fa1" width="100%" height="80">
            <tr>
                <td align="center" style="border-top: 0;"><a href="javascript:history.back();" style=" color: #be8f00;">«返回</a></td>

            </tr>
        </table>
    </div>
</div>
<script>
    layui.use(['form','layer'],function(){
        var $ = layui.$;
        $(function(){
            $('#yyzzIMG img').on('click', function () {
                layer.photos({
                    photos: '#yyzzIMG',
                    shadeClose: false,
                    closeBtn: 2,
                    anim: 0
                });
            })
        });
        $('#gzIMG img').on('click', function () {
            layer.photos({
                photos: '#gzIMG',
                shadeClose: false,
                closeBtn: 2,
                anim: 0
            });
        });
        $('#yhkhIMG img').on('click', function () {
            layer.photos({
                photos: '#yhkhIMG',
                shadeClose: false,
                closeBtn: 2,
                anim: 0
            });
        });
        $('#hsIMG img').on('click', function () {
            layer.photos({
                photos: '#hsIMG',
                shadeClose: false,
                closeBtn: 2,
                anim: 0
            });
        });
    });
</script>
@endsection
