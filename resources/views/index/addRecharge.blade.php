@extends('layout.home')
@section('title', '充值记录')
@section('content')
<style>
    .ce li i{ width: 24px;display: inline-block;}
    .ce li a{ position: relative;}
    .ce li.icon_jian a span{right: 0;top: 4px;position: absolute;}
    .er li a{font-size:14px;padding: 10px 10px 10px 58px;}
    .app-title{ color:#fff; font-size:18px;padding: 22px 0 20px 26px;font-weight: bold;color:#0aa770}
</style>
<div class="ui_box">
    <div class="ui_tit"><i class="iconfont"></i>新增转账凭证</div>
    <div style="padding:10px 0 0 15px;">
        <table class="ui_form">
            <form>
                <tr>
                    <td align="right">转账金额：</td>
                    <td>
                        <input style="width:100%;" type="text" id="account" placeholder="请输入金额（元）" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td align="right">转账商户：</td>
                    <td>
                        <select style="width:100%" id="companyId" class="gid"">
                        <option value="0">全部</option>
                        @foreach($gong as $g)
                        <option value="{{$g->g_id}}">{{$g->g_name}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">服务商：</td>
                    <td>
                        <select style="width:100%" id="supplierCompanySelect" class="zid">
                            <option value="0">服务商</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">转账凭证：</td>
                    <td>
                        <div class="upimg" style="width:366px;">
                            <div class="setUpimg">
                                <img width="120" id="cashPicPic" src="{{asset('images/upimg.png')}}">
                                <input type="hidden" id="cashPic" />
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <div class="upPic">
                                        <input type="hidden" name="contextPath" value="" id="yhkhxkPicPath">
                                        <input type="hidden" name="refererPage" value=""/>
                                        <div class="uphead mt10 ml10" >
                                            <input type="file" name="cashPic_f" data-name="cash_pic" id="cashPic_f"  size="1"  class="input_file" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>备注：</td>
                    <td>
                        <textarea name="" placeholder="请输入" class="layui-textarea text"></textarea>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:" class="layui-btn layui-btn-normal add">提 交</a>
                    </td>
                </tr>
            </form>
            </tbody>
        </table>

    </div>

</div>
<script>
    layui.use(['form','upload'],function(){
        var $ = layui.$
            ,upload = layui.upload;
        $(document).on('change','.gid',function(){
            var gid = $(this).val();
            $('#supplierCompanySelect').empty();
            $.ajax({
                url:"/home/getSupplierCompanys",
                method:'post',
                data:{customerCompanyId:gid},
                dataType:'json',
                success:function(res){
                    var data = res.list;
                    // console.log(data);
                    var id = '<option>服务商</option>';
                    for(var i in data){
                        id += "<option class='zid' value='"+data[i].z_id+"'>"+data[i].z_fwsmc+"</option>";
                    }
                    $('#supplierCompanySelect').append(id);
                    console.log(id);
                }
            });
        });
        var uploadInst = upload.render({
            elem: '#cashPicPic' //绑定元素
            ,url: "{{url('home/upload/')}}" //上传接口
            ,done: function(res){
                //上传完毕回调
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('#cashPicPic').attr('src','.'+res.message);
                    $('#yhkhxkPicPath').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });
        $(document).on('click','.add',function(){
            var money = $('#account').val();
            var gid = $('.gid').val();
            var zid = $('.zid').val();
            var img = $('#yhkhxkPicPath').val();
            var text = $('.text').val();
            if(money == ''){
                layer.msg("请填写充值金额");
            }
            if(gid == ''){
                layer.msg("请选择商户");
            }
            if(zid == ''){
                layer.msg("请选择服务商");
            }
            if(img == ''){
                layer.msg("请上传转账凭证");
            }
            $.ajax({
                url:"/home/doadd",
                method:"post",
                data:{money:money,gid:gid,zid:zid,img:img,text:text},
                dataType:"json",
                success:function(res){
                    if(res.code ==2){
                        layer.msg(res.message);
                        location.href='/home/rechargeLog';
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
        });
    });
</script>
@endsection
