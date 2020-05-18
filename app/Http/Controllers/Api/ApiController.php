<?php

namespace App\Http\Controllers\Api;

use App\Model\Geren;
use App\Model\Info;
use App\Model\Order;
use App\Model\Tx;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ApiController extends Controller
{
    public function upload()
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['files']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["files"]["tmp_name"];
            $file_error = $_FILES["files"]["error"];
            $file_size = $_FILES["files"]["size"];
            $file_name_arr = explode('.', $file_name);
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 5242880) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于5MB";
            }else{
                $date = date('Ymd');

                $new_file_name = date('YmdHis') . '.' . $file_name_arr[3];
                $path = "./upload/weixin/images/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $file_path = trim($file_path,'.');
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
    //上传资料
    public function users()
    {
        $date = request()->input();
//        dd($date['openid']);
        $data = $date['data'];
        $aa = Info::where('openid',$date['openid'])->first();
        if($aa){
            return json_encode(['code'=>1,'message'=>"已经上传资料了",'data'=>$aa]);
        }
        $id_cart = $data['id_cart'];
        $id = '';
        foreach($id_cart as $k=>$v){
            $id.=$v;
        }
        $arr = [
            'openid'=>$date['openid'],
            'i_name'=>$data['name'],
            'i_phone'=>$data['phone'],
            'i_address'=>$data['address'],
            'i_email'=>$data['email'],
            'i_id_cart'=>$id,
            'i_cart_user'=>$data['card_user'],
            'i_cart_guohui'=>$data['card_guohui'],
            'i_hetong'=>$data['hetong'],
            'create_time'=>time(),
        ];
        $res = Info::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>3,'message'=>"失败"]);
        }
    }
    //检测用户资料
    public function jian()
    {
        $openid = request()->input('openid');
        $aa = Info::where('openid',$openid)->first();
        if($aa){
            return json_encode(['code'=>1,'message'=>"已经上传资料了",'data'=>$aa]);
        }

    }
    public function video()
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['files']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["files"]["tmp_name"];
            $file_error = $_FILES["files"]["error"];
            $file_size = $_FILES["files"]["size"];
            $file_name_arr = explode('.', $file_name);
                if ($file_error > 0) { // 出错
                    $status = 2;
                    $message = $file_error;
                } elseif($file_size > 5242880) { // 文件太大了
                    $status = 5;
                    $message = "上传文件不能大于5MB";
                }else{
                    $date = date('Ymd');

                    $new_file_name = date('YmdHis') . '.' . $file_name_arr[3];
                    $path = "./upload/weixin/video/".$date."/";
                    $file_path = $path . $new_file_name;
                    if (!file_exists($path)) {
                        //TODO 判断当前的目录是否存在，若不存在就新建一个!
                        mkdir($path,0777,true);
                    }
                    $upload_result = move_uploaded_file($file_tmp, $file_path);
                    $status = '';
                    //此函数只支持 HTTP POST 上传的文件
                    if ($upload_result) {
                        $file_path = trim($file_path,'.');
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
    //上传轨迹
    public function geren()
    {
        $date = request()->input();
        $d =  $date['data'];
        $g_img = $d['longitude'].','.$d['latitude'];
        $aa = Info::where('openid',$date['openid'])->first();
        if(empty($aa)){
            return json_encode(['code'=>4,'message'=>"请先上传个人资料"]);
        }
        $arr = [
            'g_username'=>$d['name'],
            'g_img'=>$g_img,
            'g_video'=>$d['video'],
            'g_desc'=>$d['desc'],
            'create_time'=>time(),
        ];
        $res = Geren::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    //获取用户头像
    public function user()
    {
        $openid = request()->input('openid');
        $data = DB::table('users')->where('openid',$openid)->first();
        return json_encode($data);
    }
    //提现
    public function money()
    {
        $data = request()->input();
        $info = Info::where('openid',$data['openid'])->first();
        if(empty($info)){
            return json_encode(['code'=>4,'message'=>"请先提交资料"]);
        }
        $order = Order::where('o_skfzhmc',$info['i_name'])->whereIN('o_status',[1,3])->first();
        if($order){
            return json_encode(['code'=>3,'message'=>"提现还未完成，订单号为：".$order['o_code_no']]);
        }
        $data['t_name'] = $info['i_name'];
        $data['create_time'] = time();
        $res = Tx::insert($data);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    //我的提现
    public function tx()
    {
        $openid = request()->input('openid');
//        dd($openid);
        $info = Info::where('openid',$openid)->first();
        if(empty($info)){
            return json_encode(['code'=>1,'message'=>"请先填写个人资料"]);
        }
        $order = Order::where('o_skfzhmc',$info['i_name'])
            ->join('tx','order.o_skfzhmc','=','tx.t_name')
            ->join('geren','order.o_skfzhmc','=','geren.g_username')
            ->get();
        if($order){
            return json_encode(['code'=>2,'message'=>$order]);
        }
    }
}
