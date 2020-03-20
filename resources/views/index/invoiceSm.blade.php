@extends('layout.ge')
@section('title', '申请发票')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="">首页</a><span>-</span>
        <a><cite>开票申明</cite></a>
    </div>
    <div class="ui_box" id="sm">
        <div class="ui_tit"><i class="iconfont">&#xe668;</i>重要申明</div>
        <div class="ui_kp">
            <p>1、所有交易需真实存在。需要有真实存在的交易、合同、银行流水。虚假交易涉嫌违反相关法规。本系统仅提供代办服务，并尽到告知义务。本系统有权拒绝为涉嫌违法违规的客户提供服务，并对客户的一切行为免责。客户一经发生违法违规行为，即视为对本系统构成根本违约，本系统的服务即刻终止。您使用本功能，即代表您已经清楚知道本申明，并保证交易真实合法。</p>
            <p>2、请认真填写发票抬头、金额。发票一经开出，税务局就要征税。</p>
            <p>3、增值税普通发票，提供：公司名称、税号。</p>
            <p>4、增值税专用发票，提供：公司名称、税号、公司地址、电话、开户银行名称、开户网点名称、银行账号。</p>
            <p>5、请保证账户有充足余额用于纳税。开票申请系统会自动预扣应税额。如有疑问，请联系您的销售顾问人员。</p>
            <p>6、本系统，专业的税款代收代付及发票托管系统。全国多地园区机构指定使用。</p>
            <p style=" text-align:center; padding: 30px 0;"><a href="/home/invoiceApply" class="layui-btn layui-btn-normal layui-btn-radius" style="width: 220px;">已阅读重要申明，前往开票</a></p>
        </div>
    </div>

</div>

<!--<div id="addFpTt" style="display: none;">-->
<!--    <table class="ui_form xz">-->
<!--        <tbody>-->
<!--        <tr>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>公司名：</td>-->
<!--            <td width="300"><input type="text" class="text ui-autocomplete-input invoiceTitle" /></td>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>税务登记号：</td>-->
<!--            <td width="300"><input type="text" class="text ui-autocomplete-input swdjNum" /></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td align="right">公司地址：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input companyAddress"></td>-->
<!--            <td align="right">公司电话：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input companyTel"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td align="right">开户银行名：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input bankName"></td>-->
<!--            <td align="right">开户网点名：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input branchName"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td align="right">银行账号：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input bankAccount"></td>-->
<!--            <td align="right">开具类型：</td>-->
<!--            <td>-->
<!--                <label><input type="radio" name="kjlxType" value="0" checked="checked" class="text" style="width: 20px;">企业</label>-->
<!--                <label><input type="radio" name="kjlxType" value="1" class="text" style="width: 20px;">个人</label>-->
<!--            </td> -->-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->
<!---->
<!--<div style="display: none;" id="addExpress">-->
<!--    <table class="ui_form xz">-->
<!--        <tbody>-->
<!--        <tr>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>姓名：</td>-->
<!--            <td width="300"><input type="text" class="text ui-autocomplete-input rName" ></td>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>手机号：</td>-->
<!--            <td width="300"><input type="text" class="text ui-autocomplete-input rPhone"  maxlength="11"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>城市：</td>-->
<!--            <td>-->
<!--                <input type="text" class="text ui-autocomplete-input" id="city">-->
<!--                <input type="hidden" id="cityCode" />-->
<!--            </td>-->
<!--            <td align="right"><span style="color: #f00; margin-right: 5px;">*</span>地址：</td>-->
<!--            <td><input type="text" class="text ui-autocomplete-input rAddress"></td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->

@endsection
