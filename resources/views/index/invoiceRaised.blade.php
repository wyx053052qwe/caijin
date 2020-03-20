@extends('layout.ge')
@section('title', '发票抬头管理')
@section('content')
<div class="main_right">
    <!--右边内容区-->
    <div class="layui-breadcrumb page_mbx">
        <a href="">首页</a><span>-</span> <a><cite>发票抬头管理</cite></a>
    </div>
    <div class="ui_box">
        <div class="ui_tit" style="position: absolute;">
            <i class="iconfont">&#xe668;</i>发票抬头管理
        </div>
        <p style="text-align: right; position: relative;">
            <a href="javascript:;" class="danger addTitle"><i
                    class="iconfont">&#xe66c;</i>新增抬头</a>
        </p>
        <table class="layui-table" lay-size="lg">
            <thead>
            <tr>
                <th>公司名</th>
                <th>税务登记号</th>
                <th>开户网点</th>
                <th>银行基本户账号</th>
                <th>开户银行名</th>
                <th>公司地址</th>
                <th>公司电话</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $d)
            <tr rid="{{$d->r_id}}">
                <td>{{$d->r_name}}</td>
                <td>{{$d->r_swdj}}</td>
                <td>{{$d->r_khwd}}</td>
                <td>{{$d->r_yhjbhzh}}</td>
                <td>{{$d->r_khxhm}}</td>
                <td>{{$d->r_gsdz}}</td>
                <td>{{$d->r_gsdh}}</td>
                <td>
                    <button class="layui-btn layui-btn-xs modifyTitle"
                            data-id="230">
                        <i class="iconfont" style="font-size: 11px;"">&#xe674;</i>编辑
                    </button>
                    <button
                        class="layui-btn layui-btn-xs layui-btn-normal removeITitle"
                        data-id="230">
                        <i class="iconfont" style="font-size: 11px;">&#xe671;</i>删除
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <tr>
            <td>{{$data->links()}}</td>
        </tr>
    </div>

</div>
<div id="addFpTt" style="display: none;">
    <table class="ui_form xz">
        <tbody>
        <tr>
            <td align="right"><span
                    style="color: #f00; margin-right: 5px;" >*</span>公司名：</td>
            <td width="300"><input type="text"
                                   class="text ui-autocomplete-input r_name" maxlength="30"/></td>
            <td align="right"><span
                    style="color: #f00; margin-right: 5px;">*</span>税务登记号：</td>
            <td width="300"><input type="text"
                                   class="text ui-autocomplete-input r_swdj" maxlength="20" /></td>
        </tr>
        <tr>
            <td align="right">公司地址：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input r_gsdz" maxlength="50"></td>
            <td align="right">公司电话：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input r_gsdh" maxlength="12"></td>
        </tr>
        <tr>
            <td align="right">开户银行名：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input r_khxhm" maxlength="30"></td>
            <td align="right">开户网点名：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input r_khwd" maxlength="30"></td>
        </tr>
        <tr>
            <td align="right">银行账号：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input r_yhjbhzh" maxlength="25"></td>
            <!-- <td align="right">开具类型：</td>
  <td>
      <label><input type="radio" name="kjlxType" value="0" checked="checked" class="text" style="width: 20px;">企业</label>
      <label><input type="radio" name="kjlxType" value="1" class="text" style="width: 20px;">个人</label>
  </td> -->
        </tr>
        </tbody>
    </table>
</div>

<div id="modifyFpTt" style="display: none;">
    <table class="ui_form xz">
        <tbody>
        <tr>
            <td align="right"><span
                    style="color: #f00; margin-right: 5px;" >*</span>公司名：</td>
            <td width="300"><input type="text"
                                   class="text ui-autocomplete-input name" maxlength="30"/></td>
            <td align="right"><span
                    style="color: #f00; margin-right: 5px;">*</span>税务登记号：</td>
            <td width="300"><input type="text"
                                   class="text ui-autocomplete-input swdj" maxlength="20" /></td>
        </tr>
        <tr>
            <td align="right">公司地址：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input gsdz" maxlength="50"></td>
            <td align="right">公司电话：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input gsdh" maxlength="12"></td>
        </tr>
        <input type="hidden" class="rid" val="">
        <tr>
            <td align="right">开户银行名：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input khxhm" maxlength="30"></td>
            <td align="right">开户网点名：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input khwd" maxlength="30"></td>
        </tr>
        <tr>
            <td align="right">银行账号：</td>
            <td><input type="text"
                       class="text ui-autocomplete-input yhjbhzh" maxlength="25"></td>
            <!-- <td align="right">开具类型：</td>
  <td>
      <label><input type="radio" name="kjlxType" value="0" checked="checked" class="text" style="width: 20px;">企业</label>
      <label><input type="radio" name="kjlxType" value="1" class="text" style="width: 20px;">个人</label>
  </td> -->
        </tr>
        </tbody>
    </table>
</div>
<script>
    layui.use(['form','layer'],function(){
        var $ = layui.$
            ,layer = layui.layer;
        $(document).on('click','.addTitle',function(){
            layer.open({
                type:1,
                area:['200','100'],
                title: '添加'
                ,content: $("#addFpTt"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var r_name=$(".r_name").val();
                    var r_swdj=$(".r_swdj").val();
                    var r_gsdz=$(".r_gsdz").val();
                    var r_gsdh=$(".r_gsdh").val();
                    var r_khxhm=$(".r_khxhm").val();
                    var r_khwd=$(".r_khwd").val();
                    var r_yhjbhzh=$(".r_yhjbhzh").val();
                    if(r_name == ''){
                        layer.msg("请填写公司名");return false;
                    }
                    if(r_swdj == ''){
                        layer.msg("请填写税务登记号");return false;
                    }
                    if(!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(r_gsdh)){
                        layer.msg('固定电话有误，请重填');
                        return false;
                    }
                    var pattern = /^([1-9]{1})(\d{14}|\d{18})$/;
                    if (!pattern.test(r_yhjbhzh)) {
                        layer.msg("银行账号有误");
                        return false;
                    }
                    var data = {r_name:r_name,r_swdj:r_swdj,r_gsdz:r_gsdz,r_gsdh:r_gsdh,r_khxhm:r_khxhm,r_khwd:r_khwd,r_yhjbhzh:r_yhjbhzh};
                    $.ajax({
                        url:"/home/doraised",
                        method:'post',
                        dataType:'json',
                        data:data,
                        success:function(res){
                            if(res.code == 2){
                                layer.msg(res.message);
                                window.location.reload();
                            }else if(res.code == 1){
                                layer.msg(res.message);
                            }else if(res.code == 3){
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
        $(document).on('click','.modifyTitle',function(){
            var rid = $(this).parents('tr').attr('rid');
            $.ajax({
                url:"/home/edit",
                method:'post',
                data:{rid:rid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code == 2){
                        var data = res.message;
                        console.log(data);
                        $('.name').val(data.r_name);
                        $('.swdj').val(data.r_swdj);
                        $('.gsdz').val(data.r_gsdz);
                        $('.gsdh').val(data.r_gsdh);
                        $('.khxhm').val(data.r_khxhm);
                        $('.khwd').val(data.r_khwd);
                        $('.yhjbhzh').val(data.r_yhjbhzh);
                        $('.rid').val(data.r_id);
                    }else{
                        larer.msg(res.message);
                    }
                }

            });
            layer.open({
                type:1,
                area:['200','100'],
                title: '修改'
                ,content: $("#modifyFpTt"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var r_name=$(".name").val();
                    var r_swdj=$(".swdj").val();
                    var r_gsdz=$(".gsdz").val();
                    var r_gsdh=$(".gsdh").val();
                    var r_khxhm=$(".khxhm").val();
                    var r_khwd=$(".khwd").val();
                    var r_yhjbhzh=$(".yhjbhzh").val();
                    var r_id=$(".rid").val();
                    if(r_name == ''){
                        layer.msg("请填写公司名");return false;
                    }
                    if(r_swdj == ''){
                        layer.msg("请填写税务登记号");return false;
                    }
                    if(!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(r_gsdh)){
                        layer.msg('固定电话有误，请重填');
                        return false;
                    }
                    var pattern = /^([1-9]{1})(\d{14}|\d{18})$/;
                    if (!pattern.test(r_yhjbhzh)) {
                        layer.msg("银行账号有误");
                        return false;
                    }
                    var data = {r_name:r_name,r_swdj:r_swdj,r_gsdz:r_gsdz,r_gsdh:r_gsdh,r_khxhm:r_khxhm,r_khwd:r_khwd,r_yhjbhzh:r_yhjbhzh,r_id:r_id};
                    $.ajax({
                        url:"/home/doetid",
                        method:'post',
                        dataType:'json',
                        data:data,
                        success:function(res){
                            if(res.code == 2){
                                layer.msg(res.message);
                                window.location.reload();
                            }else if(res.code == 1){
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
        })
        $(document).on('click','.removeITitle',function(){
            var rid = $(this).parents('tr').attr('rid');
            $.ajax({
                url:"/home/del",
                method:'post',
                data:{rid:rid},
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
        });
    });
</script>
@endsection
