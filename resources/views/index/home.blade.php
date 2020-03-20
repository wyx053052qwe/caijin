@extends('layout.home')
@section('title', '首页')
@section('content')
<style>
    .ui-flex{display: -webkit-box;display: -webkit-flex;display: flex; }
    .ui-flex-wrap{-webkit-flex-wrap:wrap;flex-wrap:wrap;}
    .ui-flex-1{-webkit-box-flex:1;-webkit-flex: 1;flex: 1;}

    .box-title{ font-size: 18px; margin-bottom: 20px; }
    .box{background: #fff;border-radius: 3px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.01); margin-bottom: 16px;}
    .apfn a{ display: block; text-align: center; padding: 28px;background: #fff;border:1px solid #e7e9ee; border-radius: 6px; color: #666;transition: all 0.2s;}
    .apfn a p{ font-size: 15px; }
    .apfn .cz .fa{color: #e84242;}
    .apfn .fq .fa{color: #f58d48;}
    .apfn .kp .fa{color: #6643d6;}
    .apfn .tjyg .fa{color: #51ca73;}
    .apfnbox{ margin: 0 -10px; }
    .apfnbox .apfn{ margin: 0 10px; }

    .apfn a:hover{background: #fbfbfb;transform:translateY(-10px); border-color: #d9d9dc;box-shadow: 0 6px 12px rgba(0,0,0,0.08);}
    .apfn-icon{ margin-bottom: 14px; }
    .apfn-icon i{ margin-right: 0; }

    .qyc{border:1px solid #dddee2;border-top: 4px solid #1679e9;border-radius: 3px;margin-bottom: 20px;}
    .qyc-head{border-bottom: 1px solid #dde4ec; padding: 16px;background: #f4f6f9; }
    .qyc h4{ margin-bottom: 5px; font-size: 18px; font-weight: bold;}
    .zhdata-val{font-size: 20px;}
    .zhdata-name{ margin-bottom: 8px; color: #888; }
    .zhdata-val span{ font-size: 16px; }
    .zhdata{border-right: 1px solid #eee; margin:22px; border-right:1px solid #eee;}
    .layui-row .layui-col-md3:last-child .zhdata{border-right: none;}
    .zhye a{ color: #1679e9;font-weight: bold;}
    .zhdata-val a:hover{ color: #1679e9;}
    .ui-dialog-titlebar-close{display: none;}
</style>
<!--右边-->
<div class="main_right">
    <div class="box">
        <h2 class="box-title">常用功能</h2>
        <div class="apfnbox ui-flex">
            <div class="ui-flex-1">
                <div class="apfn">
                    <a class="cz" href="/home/capital/rechargeDesc.html">
                        <div class="apfn-icon">
                            <i class="fa fa-credit-card fa-2x" aria-hidden="true"></i>
                        </div>
                        <p>充值</p>
                    </a>
                </div>
            </div>
            <div class="ui-flex-1">
                <div class="apfn">
                    <a class="fq" href="/home/uworkSalary/uploadSalary.html">
                        <div class="apfn-icon">
                            <i class="fa fa-rmb fa-2x" aria-hidden="true"></i>
                        </div>
                        <p>佣金发放</p>
                    </a>
                </div>
            </div>
            <div class="ui-flex-1">
                <div class="apfn">
                    <a class="kp" href="/uwork/cus/sup/invoice/list.html">
                        <div class="apfn-icon">
                            <i class="fa fa-ticket fa-2x" aria-hidden="true"></i>
                        </div>
                        <p>开发票</p>
                    </a>
                </div>
            </div>
            <div class="ui-flex-1">
                <div class="apfn">
                    <a class="tjyg" href="/home/uwork/serviceProvider.html">
                        <div class="apfn-icon">
                            <i class="fa fa-user-plus fa-2x" aria-hidden="true"></i>
                        </div>
                        <p>电子签约</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <h2 class="box-title">我的账户</h2>
@foreach($cz as $c)
        <div class="qyc">
            <div class="qyc-head">
                <h4>{{$c->g_name}}</h4>
                <div>服务商：{{$c->z_fwsmc}}</div>
            </div>
            <div class="ui-flex">
                <div class="ui-flex-1">
                    <div class="zhdata">
                        <div class="zhdata-name">账户余额</div>
                        <div class="zhdata-val zhye">
                            <a href="/home/capital/finance.html"><span>¥</span>
                                {{$c->c_yue}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="ui-flex-1">
                    <div class="zhdata">
                        <div class="zhdata-name">累计充值</div>
                        <div class="zhdata-val">
                            <a href="/home/capital/finance.html"><span>¥</span>
                                {{$c->c_money}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="ui-flex-1">
                    <div class="zhdata">
                        <div class="zhdata-name">累计发放</div>
                        <div class="zhdata-val">
                            <a href="/home/capital/finance.html"><span>¥</span>
                               {{$c->c_ls}}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <div class="ui-flex-1">
                    <div class="zhdata">
                        <div class="zhdata-name">发送失败</div>
                        <div class="zhdata-val">
                            <a href="/home/uworkSalary/orderLogs.html?payStatus=3"><span>¥</span>800.00</a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        @endforeach

    </div>
</div>
</div>
<div id="verifyDiv" style="display:none;text-align: center;font-size: 16px;"></div></div>
@endsection
