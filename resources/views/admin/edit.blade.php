@extends('layout.index')
@section('title', '添加公司')
@section('content')
<div class="layui-fluid">
    <form class="layui-form layui-form-pane" action="" >
        <div style="float: left;margin-left: 20px;">
            <div class="layui-form-item">
                <label class="layui-form-label">公司名字</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_name" required value="{{$gong->g_name}}"  lay-verify="required" placeholder="公司名字"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">纳税人识别号</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_sbh"  required value="{{$gong->g_sbh}}" lay-verify="required" placeholder="纳税人识别号"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">落户园区</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_lhyq" required value="{{$gong->g_lhyq}}" lay-verify="required" placeholder="落户园区"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">注册地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_address" required value="{{$gong->g_address}}" lay-verify="required" placeholder="注册地址"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司类型</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_gtype" required value="{{$gong->g_gtype}}" lay-verify="required" placeholder="公司类型"    class="layui-input">
                </div>
            </div>
            <!--            <div class="layui-form-item">-->
            <!--                <label class="layui-form-label">法人姓名</label>-->
            <!--                <div class="layui-input-inline">-->
            <!--                    <input type="text" name="g_username" required lay-verify="required" placeholder="法人姓名"    class="layui-input">-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="layui-form-item">
                <label class="layui-form-label">法人姓名</label>
                <div class="layui-input-inline">
                    <select name="u_id" lay-verify="required">
                        <option value="">请选择</option>
                        @foreach($user as $u)
                        <option value="{{$u->u_id}}" @if($gong->u_id == $u->u_id) selected @else @endif>{{$u->u_username}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">法人电话</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_phone" required value="{{$gong->g_phone}}" lay-verify="required|phone|number" placeholder="法人电话"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">法人身份证号</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_id_cart" required value="{{$gong->g_id_cart}}" lay-verify="required|identity|number" placeholder="法人身份证号"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户银行</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_bank" required value="{{$gong->g_bank}}" lay-verify="required" placeholder="开户银行"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户网点</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_wd" required value="{{$gong->g_wd}}" lay-verify="required" placeholder="开户网点"    class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">银行账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_zh" required value="{{$gong->g_zh}}" lay-verify="required|number" placeholder="银行账号"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">服务类型</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_type" value="{{$gong->g_type}}"  lay-verify="" placeholder="服务类型"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">征税类型</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_types" required value="{{$gong->g_types}}" lay-verify="required" placeholder="征税类型"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">增值税类型</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_zzzlx" required value="{{$gong->g_zzzlx}}" lay-verify="required" placeholder="增值税类型"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">增值税税率</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_zzsl" required value="{{$gong->g_zzsl}}" lay-verify="required" placeholder="增值税税率"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">普通综合税率</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_ppzhsl" required value="{{$gong->g_ppzhsl}}" lay-verify="required" placeholder="普通综合税率"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">代开综合税率</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_dkzhsl" required value="{{$gong->g_dkzhsl}}" lay-verify="required" placeholder="代开综合税率"    class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">专票综合税率</label>
                <div class="layui-input-inline">
                    <input type="text" name="g_zpzhsl" required value="{{$gong->g_zpzhsl}}" lay-verify="required" placeholder="专票综合税率"    class="layui-input">
                </div>
            </div>
        </div>
        <div style="float: left;margin-left: 50px;">
            <div class="layui-form-item">
                <label class="layui-form-label">启动办理时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="{{date('Y-m-d',$gong->g_bl)}}" name="g_bl" placeholder="yyyy-mm-dd" id="test1">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">执照办结时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="{{date('Y-m-d',$gong->g_zzbj)}}" name="g_zzbj" placeholder="yyyy-mm-dd" id="test2">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">开户办结时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="{{date('Y-m-d',$gong->g_kubj)}}" name="g_kubj" placeholder="yyyy-mm-dd" id="test3">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">核税办结时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="{{date('Y-m-d',$gong->g_hsbj)}}" name="g_hsbj" placeholder="yyyy-mm-dd" id="test4">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">营业执照</label>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn" id="upload">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <img src="{{$gong->g_yyzz}}" alt="暂无图片" id="img" height="200" width="200">
                    <input type="hidden" name="g_yyzz" value="{{$gong->g_yyzz}}" class="g_yyzz">
                </div>
            </div>
            <input type="hidden" name="g_id" value="{{$gong->g_id}}">
            <div class="layui-form-item">
                <label class="layui-form-label">公章</label>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn" id="uploads">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <img src="{{$gong->g_gz}}" alt="暂无图片" id="imgs" height="200" width="200">
                    <input type="hidden" name="g_gz" value="{{$gong->g_gz}}" class="g_gz">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">银行开户许可证</label>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn" id="uploadss">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <img src="{{$gong->g_yhkhxkz}}" alt="暂无图片" id="imgss" height="200" width="200">
                    <input type="hidden" name="g_yhkhxkz" value="{{$gong->g_yhkhxkz}}" class="g_yhkhxkz">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">核税回执</label>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn" id="uploadsss">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <img src="{{$gong->g_hshz}}" alt="暂无图片" id="imgsss" height="200" width="200">
                    <input type="hidden" name="g_hshz" value="{{$gong->g_hshz}}" class="g_hshz">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">修改</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    //Demo
    layui.use(['form','laydate','upload'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,upload = layui.upload
            ,$ = layui.$;
        laydate.render({
            elem: '#test1'
        });
        laydate.render({
            elem: '#test2'
        });
        laydate.render({
            elem: '#test3'
        });
        laydate.render({
            elem: '#test4'
        });
        //执行实例
        var uploadInst = upload.render({
            elem: '#upload' //绑定元素
            ,url: '{{url('add/upload')}}' //上传接口
            ,method: 'post'
            ,done: function(res){
            // console.log(res);
            if(res.code == 1){
                $('#img').attr('src',res.message);
                $('.g_yyzz').val(res.message);
                layer.msg('上传成功');
            }else if(res.code == 3){
                layer.msg(res.message);
            }else if(res.code == 4){
                layer.msg(res.message);
            }
            //上传完毕回调
        }
    ,error: function(){
            //请求异常回调
            layer.msg(res.message);
        }
    });
        var uploadIns = upload.render({
            elem: '#uploads' //绑定元素
            ,url: '{{url('add/uploads')}}' //上传接口
            ,method: 'post'
            ,done: function(res){
            // console.log(res);
            if(res.code == 1){
                $('#imgs').attr('src',res.message);
                $('.g_gz').val(res.message);
                layer.msg('上传成功');
            }else if(res.code == 3){
                layer.msg(res.message);
            }else if(res.code == 4){
                layer.msg(res.message);
            }
            //上传完毕回调
        }
    ,error: function(){
            //请求异常回调
            layer.msg(res.message);
        }
    });
        var uploadIn = upload.render({
            elem: '#uploadss' //绑定元素
            ,url: '{{url('add/uploadss')}}' //上传接口
            ,method: 'post'
            ,done: function(res){
            // console.log(res);
            if(res.code == 1){
                $('#imgss').attr('src',res.message);
                $('.g_yhkhxkz').val(res.message);
                layer.msg('上传成功');
            }else if(res.code == 3){
                layer.msg(res.message);
            }else if(res.code == 4){
                layer.msg(res.message);
            }
            //上传完毕回调
        }
    ,error: function(){
            //请求异常回调
            layer.msg(res.message);
        }
    });
        var uploadI = upload.render({
            elem: '#uploadsss' //绑定元素
            ,url: '{{url('add/uploadsss')}}' //上传接口
            ,method: 'post'
            ,done: function(res){
            // console.log(res);
            if(res.code == 1){
                $('#imgsss').attr('src',res.message);
                $('.g_hshz').val(res.message);
                layer.msg('上传成功');
            }else if(res.code == 3){
                layer.msg(res.message);
            }else if(res.code == 4){
                layer.msg(res.message);
            }
            //上传完毕回调
        }
    ,error: function(){
            //请求异常回调
            layer.msg(res.message);
        }
    });
        // 监听提交
        form.on('submit(formDemo)', function(data){
            console.log(data.field);
            $.ajax({
                url:'/gong/update',
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    if(res.code == 2){
                        layer.msg(res.message);
                        location.href='/gongindex';
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
            return false;
        });

    });
</script>
@endsection

