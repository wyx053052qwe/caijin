<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cz;
use App\Model\Geren;
use App\Model\Gongsi;
use App\Model\Order;
use App\Model\Sd;
use App\Model\Upload;
use App\Model\User;
use App\Model\Zh;
use App\Model\Fei;
use App\Model\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function adduser()
    {
        return view('admin.adduser');
    }
    public function douser()
    {
        $data = request()->input();
//        dd($data);
        $user = User::where('u_name',$data['name'])->first();
        if($user){
            return json_encode(['code'=>3,'message'=>"该用户已添加"]);
        }
        $password = md5($data['password']);
        $arr = [
            'u_username'=>$data['username'],
            'u_name'=>$data['name'],
            'u_password'=>$password,
//            'g_id'=>$data['g_id'],
            'u_create_time'=>time(),
            'u_update_time'=>time(),
        ];
        $res = User::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"添加失败"]);
        }
    }
    public function userindex()
    {
        $u_id = request()->input('u_id');
//        dd($u_id);
        $user = User::where('u_id',$u_id)->first();
        $gong = Gongsi::get(['g_id','g_name']);
        $data = User::paginate(10);
//        dd($data);
        if(request()->ajax()){
            return json_encode(['data'=>$user]);
        }
        return view('admin.userindex',[
            'data'=>$data,
            'gong'=>$gong,
            'user'=>$user
        ]);
    }
    public function index()
    {
        $leji = Cz::join('gongsi', 'cz.g_id', '=', 'gongsi.g_id')
            ->join('zh', 'cz.z_id', '=', 'zh.z_id')
            ->get(['g_name', 'z_fwsmc', 'c_money','c_yue','c_ls'])->toArray();
//        dd($leji);

        return view('admin.index', [
            'leji'=>$leji
        ]);

    }
    public function udel()
    {
        $u_id = request()->input('u_id');
//        dd($u_id);
        $res = User::where('u_id',$u_id)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"删除成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"删除失败"]);
    }
    }
    public function order()
    {
        $data = request()->input();
//        dd($data);
        if(empty($data['orderType'])){
            $data['orderType'] = '';
        }
        if(empty($data['f_code_no'])){
            $data['f_code_no'] = '';
        }
        if(empty($data['create_time'])){
            $data['create_time'] = '';
        }
        if(empty($data['update_time'])){
            $data['update_time'] = '';
        }
        $where = [];
        if(!empty($data['orderType'])){
//            dd($data['orderType']);
            if($data['orderType'] == 1){
                $where = ['f_status'=>3];
            }
            if($data['orderType'] == 2){
                $where = ['f_status'=>2];
            }
            if($data['orderType'] == 3){
                $where = ['f_status'=>4];
            }
            if($data['orderType'] == 4){
                $where = ['f_status'=>1];
            }
            if($data['orderType'] == 0){
                $where = [];
            }
        }
        if(!empty($data['f_code_no'])){
            $where = ['f_code_no'=>$data['f_code_no']];
        }
        if(!empty($data['create_time'])){
            $create_time = strtotime($data['create_time']);
//            dd($create_time);
            $where = ['f_create_time'=>$create_time];
        }
        if(!empty($data['update_time'])){
            $update_time = strtotime($data['update_time']);
            $where = ['f_update_time'=>$update_time];
        }
        if(empty($where)){
            $date = Fei::
                join('gongsi','fei.g_id','=','gongsi.g_id')
                ->join('zh','fei.z_id','=','zh.z_id')
                ->Paginate(10);
        }else{
            $date = Fei::
                where($where)
                ->join('gongsi','fei.g_id','=','gongsi.g_id')
                ->join('zh','fei.z_id','=','zh.z_id')
                ->Paginate(10);
        }
        return view('admin.order',[
            'date'=>$date,
            'orderType'=>$data['orderType'],
            'f_code_no'=>$data['f_code_no'],
            'create_time'=>$data['create_time'],
            'update_time'=>$data['update_time'],
        ]);
    }
    public function status()
    {
        $data = request()->input();
//        dd($data);
        $status = $data['status'];
        $fid = $data['fid'];
        $fei = Fei::where('f_id',$fid)->first();
        $oid = explode(',',$fei['o_id']);
        if($status == 2){

            $res = Fei::where('f_id',$fid)->update(['f_status'=>$status,'f_update_time'=>strtotime(date("Y-m-d"), time())]);
            if($res){
                Order::whereIN('o_id',$oid)->update(['o_status'=>$status,'o_update_time'=>strtotime(date("Y-m-d"), time())]);
                return json_encode(['code'=>2,'message'=>"修改成功"]);
            }else{
                return json_encode(['code'=>1,'message'=>"修改失败"]);
            }
        }else{
            $res = Fei::where('f_id',$fid)->update(['f_status'=>$status,'f_update_time'=>0]);
            if($res){
                Order::whereIN('o_id',$oid)->update(['o_status'=>$status,'o_update_time'=>0]);
                return json_encode(['code'=>2,'message'=>"修改成功"]);
            }else{
                return json_encode(['code'=>1,'message'=>"修改失败"]);
            }
        }
    }
    public function dels()
    {
        $fid = request()->input('fid');
        $fei = Fei::where('f_id',$fid)->first();
        $oid = explode(',',$fei['o_id']);
        $res = Fei::where('f_id',$fid)->delete();
        if($res){
            Order::whereIN('o_id',$oid)->delete();
            return json_encode(['code'=>2,'message'=>"删除成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"删除失败"]);
        }
    }
    public function orderLogs()
    {
        $gong = Gongsi::get(['g_id']);
//        dd($gong);
        $id = '';
        foreach($gong as $k=>$v){
            $id .= ','.$v['g_id'];
        }
        $id = explode(',',trim($id,','));
        $cz = Cz::whereIN('g_id',$id)->get();
        $ls = 0;
        foreach($cz as $k=>$v){
            $ls += $v['c_ls'];
        }
        $data = request()->input();
//        dd($data);
        if(empty($data)){
            $data['o_code_no'] = '';
            $data['o_skfzhmc'] = '';
            $data['o_skfzh'] = '';
            $data['create_time'] = '';
            $data['update_time'] = '';
        }
        if(!empty($data['page'])){
            $data['o_code_no'] = '';
            $data['o_skfzhmc'] = '';
            $data['o_skfzh'] = '';
            $data['create_time'] = '';
            $data['update_time'] = '';
        }
        if(empty($data['status'])){
            $data['status'] = 0;
        }
        $status = $data['status'];
        $where = [];
        if($status == 1){
            $data['o_code_no'] = '';
            $data['o_skfzhmc'] = '';
            $data['o_skfzh'] = '';
            $data['create_time'] = '';
            $data['update_time'] = '';
            $where = ['o_status'=>2];
        }
        if($status == 2){
            $data['o_code_no'] = '';
            $data['o_skfzhmc'] = '';
            $data['o_skfzh'] = '';
            $data['create_time'] = '';
            $data['update_time'] = '';
            $where = ['o_status'=>1,'o_status'=>3];
        }
        if($status == 3){
            $data['o_code_no'] = '';
            $data['o_skfzhmc'] = '';
            $data['o_skfzh'] = '';
            $data['create_time'] = '';
            $data['update_time'] = '';
            $where = ['o_status'=>4];
        }
        if(!empty($data['o_code_no'])){
            $where = ['o_code_no'=>$data['o_code_no']];
        }
        if(!empty($data['o_skfzhmc'])){
            $where = ['o_skfzhmc'=>$data['o_skfzhmc']];

        }
        if(!empty($data['o_skfzh'])){
            $where = ['o_skfzh'=>$data['o_skfzh']];

        }
        if(!empty($data['create_time'])){
            $create_time = strtotime($data['create_time']);
            $where = ['o_create_time'=>$create_time];

        }
        if(!empty($data['update_time'])){
            $update_time = strtotime($data['update_time']);
            $where = ['o_update_time'=>  $update_time ];
        }
        if(empty($where)){
            $order = Order::whereIN('order.g_id',$id)
                ->join('zh','order.z_id','=','zh.z_id')
                ->join('gongsi','order.g_id','=','gongsi.g_id')->Paginate(10);
        }else{
            $order = Order::where($where)->whereIN('order.g_id',$id)
                ->join('zh','order.z_id','=','zh.z_id')
                ->join('gongsi','order.g_id','=','gongsi.g_id')->Paginate(10);
        }

//        dd($order);
//        dd($ls);
        return view('admin.orderLogs',[
            'ls'=>$ls,
            'order'=>$order,
            'status'=>$status,
            'o_code_no'=>$data['o_code_no'],
            'o_skfzhmc'=>$data['o_skfzhmc'],
            'o_skfzh'=>$data['o_skfzh'],
            'create_time'=>$data['create_time'],
            'update_time'=>$data['update_time'],
        ]);
    }
    public function export()
    {
        $fid = request()->input('fid');
        $fei = Fei::where('f_id',$fid)->first();
        $oid = explode(',',$fei['o_id']);
        $order = Order::whereIN('o_id',$oid)->get();
        return json_encode(['data'=>$order]);
    }
    public function odels()
    {
        $oids = request()->input('oid');
        $res = Order::where('o_id',$oids)->delete();
        if($res){
            $fei = Fei::where('o_id','like',"%$oids%")->first();
            $oid = explode(',',$fei['o_id']);
            foreach( $oid as $k=>$v) {
                if($oids == $v) unset($oid[$k]);
            }
            $oid = implode(',',$oid);
            Fei::where('f_id',$fei['f_id'])->update(['o_id'=>$oid]);
            return json_encode(['code'=>2,'message'=>"删除成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"删除失败"]);
        }
    }
    public function invioce()
    {
        $invoiceStatus = request()->input('invoiceStatus');
//        dd($invoiceStatus);
        $where = [];
        if($invoiceStatus == ''){
            $where = [];
        }
        if($invoiceStatus == 1){
            $where = ['i_status' => 1];
        }
        if($invoiceStatus == 2){
            $where = ['i_status' => 2];
        }
        if($invoiceStatus == 3){
            $where = ['i_status' => 3];
        }
        if($invoiceStatus == 4){
            $where = ['i_status' => 4];
        }
        if($invoiceStatus == 5){
            $where = ['i_status' => 5];
        }
        $data = Invoice::
             where($where)
            ->join('gongsi','invoice.i_companyId','gongsi.g_id')
            ->join('raised','invoice.i_invoiceTitle','=','raised.r_id')
            ->join('express','invoice.i_expressId','=','express.e_id')
            ->Paginate(10);
//        dd($data);
        return view('admin.invoice',[
            'data'=>$data,
            'invoiceStatus'=>$invoiceStatus,
        ]);
    }
    public function invoiceimg()
    {
        $id = request()->input('id');
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 5242880) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = $file_path;
                    Invoice::where('i_id',$id)->update(['i_invoiceimg'=>$file_path]);
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }

        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function clickEdit()
    {
        $data = request()->input();
//        dd($data);
        $res = Invoice::where('i_id',$data['i_id'])->update(['i_invoicehao'=>$data['i_invoicehao']]);
        if($res){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改失败"]);
        }
//        dd($data);
    }
    public function istatus()
    {
        $data = request()->input();
//        dd($data);
        $res = Invoice::where('i_id',$data['i_id'])->update(['i_status'=>$data['status']]);
        if($res){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改失败"]);
        }
//        dd($data);
    }
    public function invoiceExport()
    {
        $i_id = request()->input('i_id');
        $i_id = explode(',',trim($i_id,','));
//        dd($i_id);
        $invoice = Invoice::whereIN('i_id',$i_id)
            ->join('gongsi','invoice.i_companyId','=','gongsi.g_id')
            ->join('raised','invoice.i_invoiceTitle','=','raised.r_id')
            ->join('express','invoice.i_expressId','=','express.e_id')
            ->get();
        foreach($invoice as $k=>$v){
            if($v['i_invoiceType'] == 0){
                $v['i_invoiceType'] = "增值税普通发票";
            }
            if($v['i_invoiceType'] == 1){
                $v['i_invoiceType'] = "代开增值税专用发票 ";
            }
            if($v['i_invoiceType'] == 2){
                $v['i_invoiceType'] = "增值税专用发票 ";
            }
    }
//        dd($invoice);
       return json_encode(['data'=>$invoice]);
    }

    public function yue()
    {
        $data = Cz::join('gongsi', 'cz.g_id', '=', 'gongsi.g_id')
            ->join('zh', 'cz.z_id', '=', 'zh.z_id')
            ->paginate(10);
        return view('admin.yue',[
            'data'=>$data
        ]);
    }
    public function addgong()
    {
        $user = User::get();
        return view('admin.addgong',[
            'user'=>$user
        ]);
    }
    public function doadd()
    {
        $data = request()->post();
//        dd($data);
        $g_bl = strtotime($data['g_bl']);
        $g_zzbj = strtotime($data['g_zzbj']);
        $g_kubj = strtotime($data['g_kubj']);
        $g_hsbj = strtotime($data['g_hsbj']);
        $arr = [
            'g_name'=>$data['g_name'],
            'g_sbh'=>$data['g_sbh'],
            'g_lhyq'=>$data['g_lhyq'],
            'g_address'=>$data['g_address'],
            'g_gtype'=>$data['g_gtype'],
            'u_id'=>$data['u_id'],
            'g_phone'=>$data['g_phone'],
            'g_id_cart'=>$data['g_id_cart'],
            'g_bank'=>$data['g_bank'],
            'g_wd'=>$data['g_wd'],
            'g_zh'=>$data['g_zh'],
            'g_type'=>$data['g_type'],
            'g_types'=>$data['g_types'],
            'g_zzzlx'=>$data['g_zzzlx'],
            'g_zzsl'=>$data['g_zzsl'],
            'g_ppzhsl'=>$data['g_ppzhsl'],
            'g_dkzhsl'=>$data['g_dkzhsl'],
            'g_zpzhsl'=>$data['g_zpzhsl'],
            'g_bl'=>$g_bl,
            'g_zzbj'=>$g_zzbj,
            'g_kubj'=>$g_kubj,
            'g_hsbj'=>$g_hsbj,
            'g_yyzz'=>$data['g_yyzz'],
            'g_gz'=>$data['g_gz'],
            'g_yhkhxkz'=>$data['g_yhkhxkz'],
            'g_hshz'=>$data['g_hshz'],
            'create_time'=>time(),
        ];
        $res = Gongsi::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改成功"]);
        }

    }
    public function gongindex()
    {
        $data = Gongsi::join('user','gongsi.u_id','=','user.u_id')->paginate(10);
        return view('admin.gindex',[
            'data'=>$data,
        ]);
    }
    public function edit()
    {
        $g_id = request()->input('g_id');
        $user = User::get();
        $gong = Gongsi::where('g_id',$g_id)->first();
        return view('admin.edit',[
            'user'=>$user,
            'gong'=>$gong
        ]);
    }
    public function update()
    {
        $data = request()->post();
//        dd($data);
        $g_bl = strtotime($data['g_bl']);
        $g_zzbj = strtotime($data['g_zzbj']);
        $g_kubj = strtotime($data['g_kubj']);
        $g_hsbj = strtotime($data['g_hsbj']);
        $arr = [
            'g_name'=>$data['g_name'],
            'g_sbh'=>$data['g_sbh'],
            'g_lhyq'=>$data['g_lhyq'],
            'g_address'=>$data['g_address'],
            'g_gtype'=>$data['g_gtype'],
            'u_id'=>$data['u_id'],
            'g_phone'=>$data['g_phone'],
            'g_id_cart'=>$data['g_id_cart'],
            'g_bank'=>$data['g_bank'],
            'g_wd'=>$data['g_wd'],
            'g_zh'=>$data['g_zh'],
            'g_type'=>$data['g_type'],
            'g_types'=>$data['g_types'],
            'g_zzzlx'=>$data['g_zzzlx'],
            'g_zzsl'=>$data['g_zzsl'],
            'g_ppzhsl'=>$data['g_ppzhsl'],
            'g_dkzhsl'=>$data['g_dkzhsl'],
            'g_zpzhsl'=>$data['g_zpzhsl'],
            'g_bl'=>$g_bl,
            'g_zzbj'=>$g_zzbj,
            'g_kubj'=>$g_kubj,
            'g_hsbj'=>$g_hsbj,
            'g_yyzz'=>$data['g_yyzz'],
            'g_gz'=>$data['g_gz'],
            'g_yhkhxkz'=>$data['g_yhkhxkz'],
            'g_hshz'=>$data['g_hshz'],
            'create_time'=>time(),
        ];
        $res = Gongsi::where('g_id',$data['g_id'])->update($arr);
        if($res){
           return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改成功"]);
        }
    }
    public function delete()
    {
        $id = request()->input();
        if(empty($id['z_id'])){
            $gong = Gongsi::where('g_id',$id['g_id'])->first();
            $res = Gongsi::where('g_id',$id['g_id'])->delete();
            Storage::delete([$gong['g_yyzz'],$gong['g_gz'],$gong['g_yhkhxkz'],$gong['g_hshz']]);
        }else{
            $res = Zh::where('z_id',$id['z_id'])->delete();
        }

        if($res){
            return json_encode(['code'=>1,'message'=>'删除成功']);
        }else{
            return json_encode(['code'=>2,'message'=>'删除失败']);
        }
    }
    public function addtj()
    {
        $Hzdata = Gongsi::get(['g_id','g_name']);
        $fu = Zh::get(['z_id','z_fwsmc']);
        return view('admin.addtj',[
            'hzdata'=>$Hzdata,
            'fu'=>$fu
        ]);
    }
    public function doaddtj()
    {
        $data  = request()->input();
//        dd($data);
        $zh = Cz::where(['g_id'=>$data['hz'],'z_id'=>$data['fu']])->first();
        if($zh){
            $money = $data['money']+$zh->c_money;
            $yue = $data['money']+$zh->c_yue;
           $res = Cz::where(['g_id'=>$data['hz'],'z_id'=>$data['fu']])->update(['c_money'=>$money,'c_yue'=>$yue]);
        }else{
            $arr = [
                'g_id'=>$data['hz'],
                'z_id'=>$data['fu'],
                'c_money'=>$data['money'],
                'c_yue'=>$data['money'],
            ];
            $res = Cz::insert($arr);
        }

        if($res){
            return json_encode(['code'=>1,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>2,'message'=>"添加失败"]);
        }
    }
    public function jl()
    {
        $data = Upload::
        join('gongsi','upload.g_id','=','gongsi.g_id')
            ->join('zh','upload.z_id','=','zh.z_id')
            ->get(['zh.z_fwsmc','gongsi.g_name','p_money','p_img','p_status','p_text','upload.create_time','p_id']);
//        dd($data);
        return view('admin.jl',[
            'data'=>$data
        ]);
    }
    public function pstatus()
    {
        $data = request()->input();
//        dd($data);
        $res = Upload::where('p_id',$data['pid'])->update(['p_status'=>$data['status']]);
        if($res){
            return json_encode(['code'=>2,'message'=>'成功']);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function pdel()
    {
        $pid = request()->input('pid');
//        dd($pid);
        $res = Upload::where('p_id',$pid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function addsd()
    {
        $data = Zh::get();
        $gong = Gongsi::get(['g_id','g_name']);
        return view('admin.addsd',[
            'data'=>$data,
            'gong'=>$gong
        ]);
    }
    public function doaddsd()
    {
        $data = request()->input();
//        dd($data);
        $month = strtotime($data['s_month']);
        $arr = [
            's_name'=>$data['s_name'],
            'g_id'=>$data['g_id'],
            'z_id'=>$data['z_id'],
            's_month'=>$month,
            's_img'=>$data['s_img']
        ];
        $res = Sd::insert($arr);
        if($res){
            return json_encode(['code'=>1,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>2,'message'=>"添加失败"]);
        }
    }
    public function zh()
    {
        $data = Zh::paginate(10);
//        dd($data);
        return view('admin.zh',[
            'data'=>$data
        ]);
    }
    public function addzh()
    {
        return view('admin.addzh');
    }
    public function doaddzh()
    {
        $data = request()->input();
        $zh = Zh::where('z_fwsmc',$data['z_fwsmc'])->first();
        if($zh){
            echo "<script>alert('已经有该公司账户');location.href='/addzh'</script>";
        }
        $arr = [
            'z_fwsmc'=>$data['z_fwsmc'],
            'z_gszch'=>$data['z_gszch'],
            'z_khyh'=>$data['z_khyh'],
            'z_zhmc'=>$data['z_zhmc'],
            'z_yhzh'=>$data['z_yhzh'],
            'z_create_time'=>time(),
            'z_update_time'=>time(),
        ];
        $res = Zh::insert($arr);
        if($res){
            echo "<script>alert('添加成功');location.href='/zh'</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/addzh'</script>";
        }
    }
    public function sdindex()
    {
        $data = Sd::join('gongsi','sd.g_id','=','gongsi.g_id')
            ->join('zh','sd.z_id','=','zh.z_id')->paginate(10);
//        dd($data);
        return view('admin.sdindex',[
            'data'=>$data
        ]);
    }
    public function del()
    {
        $sid = request()->input('s_id');
        $s = Sd::where('s_id',$sid)->first();
        $res = Sd::where('s_id',$sid)->delete();
        if($res){
            Storage::delete($s->s_img);
            return json_encode(['code'=>1,'message'=>'删除成功']);
        }else{
            return json_encode(['code'=>2,'message'=>'删除失败']);
        }
    }
    public function upload(Request $request)
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = $file_path;
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function uploads(Request $request)
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = $file_path;
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function uploadss(Request $request)
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = $file_path;
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function uploadsss(Request $request)
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = $file_path;
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function upass()
    {
        return view('admin.upass');
    }
    public function yuan(){
        $data = request()->input();
//        dd($data);
        $pass = md5($data['yuan']);
        $res = User::where(['u_id'=>$data['uid'],'u_password'=>$pass])->first();
//        dd($res);
        if($res){
            return json_encode(['code'=>2]);
        }else{
            return json_encode(['code'=>1]);
        }
    }
    public function pass()
    {
        $uid = User::getUid();
        $data = request()->input();
//        dd($data);
        $password = md5($data['pass']);
        $newpass = md5($data['newpass']);
        $res = User::where(['u_id'=>$uid,'u_password'=>$password])->first();
        if(!$res){
            return json_encode(['code'=>1,'message'=>"密码错误"]);
        }
        $result = User::where('u_id',$uid)->update(['u_password'=>$newpass]);
        if($result){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改失败"]);
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
    //删除数组中的一个元素
    public function array_remove_value(&$arr, $var){
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                array_remove_value($arr[$key], $var);
            } else {
                $value = trim($value);
                if ($value == $var) {
                    unset($arr[$key]);
                } else {
                    $arr[$key] = $value;
                }
            }
        }
    }
    public function geren()
    {
        $data = Geren::paginate(10);
        return view('admin.geren',[
            'data'=>$data
        ]);
    }
    public function delvideo()
    {
        $gid = request()->input('gid');
        dd($gid);
        $res = Geren::where('g_id',$gid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
}
