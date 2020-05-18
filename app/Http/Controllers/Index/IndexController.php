<?php

namespace App\Http\Controllers\Index;

use App\Model\Contact;
use App\Model\Cz;
use App\Model\Express;
use App\Model\Fei;
use App\Model\Geren;
use App\Model\Gongsi;
use App\Model\Info;
use App\Model\Invoice;
use App\Model\Order;
use App\Model\Raised;
use App\Model\Sd;
use App\Model\Upload;
use App\Model\User;
use App\Model\Zh;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{

    public function home()
    {
        $id = User::getUid();
        $gong = Gongsi::where('u_id',$id)->get(['g_id']);
        $g_id = '';
        foreach($gong as $k=>$v){
            $g_id .= ','.$v['g_id'];
        }
        $g_id = explode(',',trim($g_id,','));
        $cz = Cz::whereIN('cz.g_id',$g_id)
            ->join('zh','cz.z_id','=','zh.z_id')
            ->join('gongsi','cz.g_id','=','gongsi.g_id')->get();

//        dd($cz);
        return view('index.home',[
            'cz'=>$cz
        ]);
    }
    public function contact()
    {
        $uid = User::getUid();
        $data = Contact::where('u_id',$uid)->first();
        if(empty($data)){
            $data = [
                'c_name'=>'',
                'c_phone'=>''
            ];
        }
        return view('index.contact',[
            'data'=>$data
        ]);
    }
    public function docontact()
    {
        $uid = User::getUid();
        $contact = Contact::where('u_id',$uid)->first();
        $data = request()->input();
//        dd($data);
        $arr = [
            'c_name'=>$data['c_name'],
            'u_id'=>$uid,
            'c_phone'=>$data['c_phone'],
            'c_create_time'=>time(),
        ];
        if($contact){
            $res = Contact::where('u_id',$uid)->update($arr);
        }else{
            $res = Contact::insert($arr);
        }
        if($res){
            return json_encode(['code'=>2,'message'=>'添加成功']);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function orderManager()
    {
        $uid = User::getUid();
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
            $where = ['f_create_time'=>$create_time];
        }
        if(!empty($data['update_time'])){
            $update_time = strtotime($data['update_time']);
            $where = ['f_update_time'=>$update_time];
        }
        if(empty($where)){
            $date = Fei::where('fei.u_id',$uid)
                ->join('gongsi','fei.g_id','=','gongsi.g_id')
                ->join('zh','fei.z_id','=','zh.z_id')
                ->Paginate(10);
        }else{
            $date = Fei::where('fei.u_id',$uid)
                ->where($where)
                ->join('gongsi','fei.g_id','=','gongsi.g_id')
                ->join('zh','fei.z_id','=','zh.z_id')
                ->Paginate(10);
        }

//        dd($date);
        return view('index.orderManager',[
            'date'=>$date,
            'orderType'=>$data['orderType'],
            'f_code_no'=>$data['f_code_no'],
            'create_time'=>$data['create_time'],
            'update_time'=>$data['update_time'],
        ]);
    }
    public function uploadSalary(){
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id','g_name']);
        return view('index.uploadSalary',[
            'gong'=>$gong
        ]);
    }
    public function getSupplierCompanys()
    {
        $data = request()->input();
//        dd($data);
        $cz = Cz::where('g_id',$data['customerCompanyId'])
            ->join('zh','zh.z_id','=','cz.z_id')->get();
        return json_encode(['list'=>$cz]);
    }
    public function getCustomerFinance()
    {
        $data = request()->input();
//        dd($data);
        $cz = Cz::where(['g_id'=>$data['customerCompanyId'],'z_id'=>$data['supplierCompanyId']])->first();
        if(empty($cz)){
            return json_encode(['success'=>1]);
        }
        return json_encode(['success'=>2,'cz'=>$cz]);
    }
    public function tax()
    {
        $uid = User::getUid();
        $gid = Gongsi::where('u_id',$uid)->get(['g_id']);
        $g_id = '';
        foreach($gid as $K=>$v){
            $g_id .= ','.$v['g_id'];
        }
        $g_id = explode(',',trim($g_id,','));
        $sd = Sd::whereIN('sd.g_id',$g_id)
            ->join('gongsi','sd.g_id','=','gongsi.g_id')
            ->join('zh','sd.z_id','=','zh.z_id')
            ->Paginate(10);
//        dd($g_id);
        return view('index.tax',[
            'sd'=>$sd
        ]);
    }
    public function download()
    {
//获取要下载的文件名
        $filename = $_GET['filename'];
//        dd($filename);
//设置头信
        header('Content-Disposition:attachment;filename=' . basename($filename));
//        header('Content-Length:' . filesize("http://www.caijin.com/home/".$filename));
//读取文件并写入到输出缓冲
        readfile(env('APP_URL')."/home/".$filename);
    }
    public function importData(Request $request)
    {
        $data = request()->input();
        $g_id = $data['g_id'];
        $z_id = $data['z_id'];
        $name = explode('.',$data['name']);
        $names = $name[0];
        if(empty($g_id)){
            return json_encode(['code'=>1,'message'=>"商户不存在"]);
        }
        if(empty($z_id)){
            return json_encode(['code'=>3,'message'=>"服务商不存在"]);
        }
        $arr = $data['data'][0];
//        dd($arr);
        $arrs = [];
        foreach($arr as $k=>$v){
            $num = count($v);
//            dump($num);
            for($i=1;$i<$num;$i++){
                $arrs[$i] = $v[$i];
            }
        }
//        dd($arrs);
        $uid = User::getUid();
        $order = [];
        $fei = [];
        $money = 0;
        $oid = [];
        foreach($arrs as $k=>$v){
            if(empty($v['o_skfzhmc'])){
                return json_encode(['code'=>4,'message'=>"收款方账户账户名称不能为空"]);
            }
            if(empty($v['o_khyh'])){
                return json_encode(['code'=>5,'message'=>"开户银行不能为空"]);
            }
            if(empty($v['o_id_cart'])){
                return json_encode(['code'=>7,'message'=>"身份证号不能为空"]);
            }
            if(empty($v['o_skfzh'])){
                return json_encode(['code'=>8,'message'=>"收款方账号不能为空"]);
            }
            if(empty($v['o_total'])){
                return json_encode(['code'=>9,'message'=>"实发金额不能为空"]);
            }
            if(empty($v['o_phone'])){
                return json_encode(['code'=>10,'message'=>"实名手机号不能为空"]);
            }
            $code_no = rand(100000,999999).$uid.$this->getRandomString(3);
            $code_nos = rand(100000,999999).$uid.$this->getRandomString(3);
            $order['u_id'] = $uid;
            $order['o_code_no'] = $code_nos;
            $order['g_id'] = $g_id;
            $order['z_id'] = $z_id;
            $order['o_skfzhmc'] = $v['o_skfzhmc'];
            $order['o_khhqc'] = $v['o_khhqc'];
            $order['o_id_cart'] = $v['o_id_cart'];
            $order['o_skfzh'] = $v['o_skfzh'];
            $order['o_total'] = $v['o_total'];
            $order['o_phone'] = $v['o_phone'];
            $order['o_khyh'] = $v['o_khyh'];
            $order['o_kxsx'] = $v['o_kxsx'];
            $order['o_ff'] = $v['o_ff'];
            $order['o_ms'] = $v['o_ms'];
            $order['o_status'] = 1;
            $order['o_name'] = $names;
            $order['o_create_time'] = strtotime(date("Y-m-d"), time());
            $oreder['o_update_time'] = NULL;
            $fei['f_code_no'] = $code_no;
            $fei['f_create_time'] = strtotime(date("Y-m-d"), time());
            $fei['f_update_time'] = NULL;
            $fei['g_id'] = $g_id;
            $fei['z_id'] = $z_id;
            $fei['f_ff'] = $names;
            $fei['f_status'] = 1;
            $fei['u_id'] = $uid;
            $money += $v['o_total'];
            $oid[$k] =  Order::insertGetId($order);
        }
        $fei['f_money'] = $money;
        $o_id = implode(',',$oid);
        $fei['o_id'] = $o_id;
//        dd($money);
        $res = Fei::insertGetId($fei);
//        dd($res);
        if($res){
            return json_encode(['code'=>2,'message'=>"上传成功",'fid'=>$res]);
        }else{
            Order::whereIN('o_id',$oid)->delete();
            return json_encode(['code'=>11,'message'=>"上传失败"]);
        }
    }
    public function confirmSalary(){
        $id = request()->input();
        $fid = $id['fid'];
        $fei = Fei::where('f_id',$fid)
            ->join('zh','fei.z_id','=','zh.z_id')->first();
//        dd($fei);
        $oid = explode(',',$fei['o_id']);
        $order = Order::whereIN('o_id',$oid)->Paginate(5);
        $count = Order::whereIN('o_id',$oid)->count();
//        dd($count);
        return view('index.confirmSalary',[
            'fei'=>$fei,
            'order'=>$order,
            'count'=>$count
        ]);
    }
    public function confirmSalarys(){
        $id = request()->input();
        $fid = $id['fid'];
        $fei = Fei::where('f_id',$fid)
            ->join('zh','fei.z_id','=','zh.z_id')->first();
//        dd($fei);
        $oid = explode(',',$fei['o_id']);
        $order = Order::whereIN('o_id',$oid)->Paginate(5);
        $count = Order::whereIN('o_id',$oid)->count();
//        dd($count);
        return view('index.confirmSalarys',[
            'fei'=>$fei,
            'order'=>$order,
            'count'=>$count
        ]);
    }
    public function confirmOrder()
    {
        $id = request()->input();
        $fid = $id['fid'];
        $fei = Fei::where('f_id',$fid)
            ->join('zh','fei.z_id','=','zh.z_id')->first();
//        dd($fei);
        $oid = explode(',',$fei['o_id']);
        $order = Order::whereIN('o_id',$oid)->Paginate(5);
        $count = Order::whereIN('o_id',$oid)->count();
//        dd($fei);
        return view('index.confirmOrder',[
            'fei'=>$fei,
            'order'=>$order,
            'count'=>$count
        ]);
    }
    public function qux()
    {
        $data = request()->input();
        $fid = $data['fid'];
        $fei = Fei::where('f_id',$fid)->first();
        $res = Fei::where('f_id',$fid)->update(['f_status'=>4]);
        if($res){
            $o_id = explode(',',$fei['o_id']);
            $order = Order::whereIN('o_id',$o_id)->update(['o_status'=>4]);
            if($order){
                return json_encode(['code'=>2,'message'=>"成功"]);
            }else{
                Fei::where('f_id',$fid)->update(['f_status'=>1]);
                return json_encode(['code'=>1,'message'=>"失败"]);
            }
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function checkMoney(){
        $data = request()->input();
//        dd($data);
        $fid = $data['fid'];
        $fei = Fei::where('f_id',$fid)->first();
        $zhang = Cz::where(['z_id'=>$fei['z_id'],'g_id'=>$fei['g_id']])->first();
//        dd($zhang['c_yue']);
        if($fei['f_money'] > $zhang['c_yue']){
            return json_encode(['code'=>1,'message'=>"余额不足请充值"]);
        }
        Fei::where('f_id',$fid)->update(['f_status'=>3]);
        $o_id = explode(',',$fei['o_id']);
        Order::whereIN('o_id',$o_id)->update(['o_status'=>3]);
        $yue = $zhang['c_yue'] - $fei['f_money'];
        if(empty($zhang['c_ls'])){
            Cz::where(['z_id'=>$fei['z_id'],'g_id'=>$fei['g_id']])->update(['c_yue'=>$yue,'c_ls'=>$fei['f_money']]);
        }else{
            $ls = $zhang['c_ls'] + $fei['f_money'];
            Cz::where(['z_id'=>$fei['z_id'],'g_id'=>$fei['g_id']])->update(['c_yue'=>$yue,'c_ls'=>$ls]);
        }
        return json_encode(['code'=>2,'message'=>"成功"]);

    }
    public function orderLogs()
    {
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id']);
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
        return view('index.orderLogs',[
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
    public function rechargeDesc()
    {
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id']);
//        dd($gong);
        $id = '';
        foreach($gong as $k=>$v){
            $id .= ','.$v['g_id'];
        }
        $id = explode(',',trim($id,','));
        $data = Cz::join('zh','cz.z_id','=','zh.z_id')
            ->join('gongsi','cz.g_id','=','gongsi.g_id')->whereIN('cz.g_id',$id)->get();
//        dd($data);
        if($data->isEmpty()){
            $data = Zh::get();
            foreach($data as $K=>$v){
                if(empty($v['g_id'])){
                    $v['g_id'] ='';
                }
                if(empty($v['g_name'])){
                    $v['g_name'] = '';
                }
            }
//            dd($data);
        }
        return view('index.rechargeDesc',[
            'data'=>$data
        ]);
    }
    public function finance(){
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id']);
//        dd($gong);
        $id = '';
        foreach($gong as $k=>$v){
            $id .= ','.$v['g_id'];
        }
        $id = explode(',',trim($id,','));
        $data = Cz::whereIN('cz.g_id',$id)->join('zh','cz.z_id','=','zh.z_id')
            ->join('gongsi','cz.g_id','=','gongsi.g_id')->Paginate(10);
//        dd($data);
        return view('index.finance',[
            'data'=>$data
        ]);
    }
    public function financeLog()
    {
        $uid = User::getUid();
        $odata = request()->input();
//        dd($odata);
        if(empty($odata)){
            $odata['g_id'] = '';
            $odata['status'] = '';
        }
        if(!empty($odata['page'])){
            $odata['g_id'] = '';
            $odata['status'] = '';
        }
        $where = [];
        if(!empty($odata['g_id'])){
            $where = ['fei.g_id'=>$odata['g_id']];
        }
        if(!empty($odata['status'])){
            if($odata['status'] == 1){
                $where = ['f_status'=>1,'f_status'=>2,'f_status'=>3];
            }
            if($odata['status'] == 2){
                $where = ['f_status'=>4];
            }

        }
        $gong = Gongsi::where('u_id',$uid)->get(['g_id','g_name']);
//        dd($gong);
        $id = '';
        foreach($gong as $k=>$v){
            $id .= ','.$v['g_id'];
        }
        $id = explode(',',trim($id,','));
        if(empty($where)){
            $data = Fei::whereIN('fei.g_id',$id)
                ->join('zh','fei.z_id','=','zh.z_id')
                ->join('gongsi','fei.g_id','=','gongsi.g_id')->Paginate(2);
        }else{
            $data = Fei::whereIN('fei.g_id',$id)
                ->join('zh','fei.z_id','=','zh.z_id')
                ->join('gongsi','fei.g_id','=','gongsi.g_id')->where($where)->Paginate(2);
        }

        return view('index.financeLog',[
            'data'=>$data,
            'gong'=>$gong,
            'gid'=>$odata['g_id'],
            'status'=>$odata['status'],
        ]);
    }
    public function rechargeLog()
    {
        $uid = User::getUid();
        $data = Upload::where('upload.u_id',$uid)
            ->join('gongsi','upload.g_id','=','gongsi.g_id')
            ->join('zh','upload.z_id','=','zh.z_id')
            ->Paginate(10);
        return view('index.rechargeLog',[
            'data'=>$data
        ]);
    }
    public function addRecharge()
    {
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get();
        return view('index.addRecharge',[
            'gong'=>$gong
        ]);
    }
    public function upload()
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
    public function doadd()
    {
        $uid = User::getUid();
        $data = request()->input();
//        dd($data);
        $arr = [
            'p_money'=>$data['money'],
            'p_img'=>$data['img'],
            'p_text'=>$data['text'],
            'u_id'=>$uid,
            'g_id'=>$data['gid'],
            'z_id'=>$data['zid'],
            'create_time'=>time(),
            'update_time'=>time()
        ];
        $res = Upload::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"上传成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function customerAccount()
    {
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id']);
        $gid = '';
        foreach($gong as $k=>$v){
            $gid .= ','.$v->g_id;
        }
        $gid = explode(',',trim($gid,','));
        $cz = Cz::whereIN('g_id',$gid)->get(['c_yue']);
        $money = 0;
        foreach($cz as $k=>$v){
            $money +=$v->c_yue;
        }
        $con = Contact::where('u_id',$uid)->first();
        $uu = User::where('u_id',$uid)->first();
//        dd($con);
        return view('index.customerAccount',[
            'money'=>$money,
            'user'=>$con,
            'uu'=>$uu
        ]);
    }
    public function update()
    {
        $data = request()->input();
//        dd($data);
        $res = Contact::where('c_id',$data['cid'])->update(['c_name'=>$data['name'],'c_phone'=>$data['phone']]);
        if($res){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改失败"]);
        }
    }
    public function customerCompany()
    {
        $uid = User::getUid();
        $gong  = Gongsi::where('u_id',$uid)->get();
//        dd($gong);
        return view('index.customerCompany',[
            'gong'=>$gong
        ]);
    }
    public function customerCompanyInfo()
    {
        $gid = request()->input('g_id');
        $gong = Gongsi::where('g_id',$gid)->join('user','gongsi.u_id','=','user.u_id')->first();
//        dd($gong);
        return view('index.customerCompanyInfo',[
            'gong'=>$gong
        ]);
    }
    public function invoiceRaised()
    {
        $uid = User::getUid();
        $data = Raised::where('u_id',$uid)->Paginate(10);
        return view('index.invoiceRaised',[
            'data'=>$data
        ]);
    }
    public function edit()
    {
        $rid = request()->input('rid');
        $data = Raised::where('r_id',$rid)->first();
        if($data){
            return json_encode(['code'=>2,'message'=>$data]);
        }else{
            return json_encode(['code'=>2,'message'=>"失败"]);
        }
    }
    public function doetid()
    {
        $data = request()->input();
//        dd($data);
        $r_id = $data['r_id'];
        $ra = Raised::where('r_name',$data['r_name'])->where('r_id','<>',$r_id)->first();
        if($ra){
            return json_encode(['code'=>1,'message'=>"当前已有该公司"]);
        }

        $arr = [
            'r_name'=>$data['r_name'],
            'r_swdj'=>$data['r_swdj'],
            'r_gsdz'=>$data['r_gsdz'],
            'r_gsdh'=>$data['r_gsdh'],
            'r_khxhm'=>$data['r_khxhm'],
            'r_khwd'=>$data['r_khwd'],
            'r_yhjbhzh'=>$data['r_yhjbhzh'],
            'r_yhjbhzh'=>$data['r_yhjbhzh'],
            'r_update_time'=>time(),
        ];
        $res = Raised::where('r_id',$r_id)->update($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function doraised()
    {
        $uid = User::getUid();
        $data = request()->input();
        $ra = Raised::where('r_name',$data['r_name'])->first();
        if($ra){
            return json_encode(['code'=>1,'message'=>"当前已有该公司"]);
        }
        $arr = [
            'r_name'=>$data['r_name'],
            'r_swdj'=>$data['r_swdj'],
            'r_gsdz'=>$data['r_gsdz'],
            'r_gsdh'=>$data['r_gsdh'],
            'r_khxhm'=>$data['r_khxhm'],
            'r_khwd'=>$data['r_khwd'],
            'r_yhjbhzh'=>$data['r_yhjbhzh'],
            'r_yhjbhzh'=>$data['r_yhjbhzh'],
            'u_id'=>$uid,
            'r_create_time'=>time(),
            'r_update_time'=>time(),
        ];
        $res = Raised::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>3,'message'=>"添加失败"]);
        }
    }
    public function del()
    {
        $r_id = request()->input('rid');
//        dd($r_id);
        $res = Raised::where('r_id',$r_id)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function invoiceAddressee()
    {
        $uid = User::getUid();
        $data = Express::where('u_id',$uid)->Paginate(10);
        return view('index.invoiceAddressee',[
            'data'=>$data
        ]);
    }
    public function doex()
    {
        $data = request()->input();
        $datas = Express::where('e_name',$data['e_name'])->first();
        if($datas){
            return json_encode(['code'=>3,'message'=>"该收件人已添加"]);
        }
        $uid = User::getUid();
        $arr = [
            'e_name'=>$data['e_name'],
            'e_phone'=>$data['e_phone'],
            'e_city'=>$data['e_city'],
            'e_address'=>$data['e_address'],
            'u_id'=>$uid,
            'e_create_time'=>time(),
            'e_update_time'=>time(),
        ];
        $res = Express::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"添加失败"]);
        }
//        dd($data);
    }
    public function doedit()
    {
        $eid = request()->input('eid');
        $data = Express::where('e_id',$eid)->first();
        if($data){
            return json_encode(['code'=>2,'message'=>$data]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }

    }
    public function updateEx()
    {
        $data = request()->input();
//        dd($data);
        $ex = Express::where('e_name',$data['e_name'])->where('e_id','<>',$data['e_id'])->first();
        if($ex){
            return json_encode(['code'=>3,'message'=>"该收件人已添加"]);
        }
        $arr = [
            'e_name'=>$data['e_name'],
            'e_phone'=>$data['e_phone'],
            'e_city'=>$data['e_city'],
            'e_address'=>$data['e_address'],
            'e_update_time'=>time(),
        ];
        $res = Express::where('e_id',$data['e_id'])->update($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"修改成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"修改失败"]);
        }
    }
    public function removeExpress()
    {
        $eid = request()->input('eid');
        $res = Express::where('e_id',$eid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"删除成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"删除失败"]);
        }
    }
    public function invoiceSm()
    {
        return view('index.invoiceSm');
    }
    public function invoiceApply()
    {
        $uid = User::getUid();
        $gong = Gongsi::where('u_id',$uid)->get(['g_id','g_name']);
        $gid = '';
        foreach($gong as $k=>$v){
            $gid .= ','.$v['g_id'];
        }
        $gid = explode(',',trim($gid,','));
        $cz = Cz::whereIN('g_id',$gid)->get(['c_yue']);
//        dd($cz);
        $money = 0;
        foreach($cz as $k=>$v){
            $money += $v['c_yue'];
        }
        $raised = Raised::where('u_id',$uid)->get(['r_id','r_name']);
        $ex = Express::where('u_id',$uid)->get(['e_name','e_id']);
//        dd($money);
        return view('index.invoiceApply',[
            'money'=>$money,
            'raised'=>$raised,
            'ex'=>$ex,
            'gongsi'=>$gong,
        ]);
    }
    public function invoiceTitle()
    {
        $rid = request()->input('rid');
        $invoiceTitle = Raised::where('r_id',$rid)->first();
        if($invoiceTitle){
            return json_encode(['code'=>2,'message'=>$invoiceTitle]);
        }else{
            return ijson_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function expressId()
    {
        $eid = request()->input('eid');
        $express = Express::where('e_id',$eid)->first();
        if($express){
            return json_encode(['code'=>2,'message'=>$express]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function companyId()
    {
        $gid = request()->input('gid');
        $gong = Gongsi::where('g_id',$gid)->first();
        $cz = Cz::where('g_id',$gid)
            ->join('zh','cz.z_id','=','zh.z_id')
            ->get();
//        dd($cz);
        if($gong){
            return json_encode(['code'=>2,'message'=>$gong,'cz'=>$cz]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function file()
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
//            dd($file_name);
            $file_type = $_FILES["file"]["type"];
//            dd($file_type);
            if($file_type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $file_type != "application/pdf" && $file_type != "application/msword"){
                return json_encode(['code'=>6,'message'=>"上传格式不支持,请上传word或PDF文件"]);
            }
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
                    $name = $file_name;
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message,'name'=>$name]);
    }
    public function doinvoiceApply()
    {
        $uid = User::getUid();
        $data = request()->input();
//        dd($data);
        $gid = $data['companyId'];
        $zid = $data['zid'];
        $yk = $data['yk'];
        $cz = Cz::where(['g_id'=>$gid,'z_id'=>$zid])->first();
        $yue = $cz['c_yue'];
        if($yk > $yue){
            return json_encode(['code'=>1,'message'=>"余额不足"]);
        }
        $money = $yue - $yk;
        $ls = $cz['c_ls'] + $yk;
        $res = Cz::where(['g_id'=>$gid,'z_id'=>$zid])->update(['c_yue'=>$money,'c_ls'=>$ls]);
        if(!$res){
            return json_encode(['code'=>3,'message'=>"失败"]);
        }
        $arr = [
            'i_invoiceType'=>$data['invoiceType'],
            'i_invoiceTitle'=>$data['invoiceTitle'],
            'i_expressId'=>$data['expressId'],
            'i_serviceContent'=>$data['serviceContent'],
            'i_invoiceAmount'=>$data['invoiceAmount'],
            'i_companyId'=>$data['companyId'],
            'i_file'=>$data['file'],
            'i_invoiceRemark'=>$data['invoiceRemark'],
            'i_img'=>$data['img'],
            'u_id'=>$uid,
            'i_yk'=>$yk,
            'i_create_time'=>strtotime($data['create_time']),
            'update_time'=>time(),
            'i_status'=>1,
        ];
        $result = Invoice::insert($arr);
        if($result){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>4,'message'=>"失败"]);
        }
    }
    public function invoiceRecord()
    {
        $uid = User::getUid();
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
        $data = Invoice::where('invoice.u_id',$uid)
            ->where($where)
            ->join('gongsi','invoice.i_companyId','gongsi.g_id')
            ->join('raised','invoice.i_invoiceTitle','=','raised.r_id')
            ->join('express','invoice.i_expressId','=','express.e_id')
            ->Paginate(10);
//        dd($data);
        return view('index.invoiceRecord',[
            'data'=>$data,
            'invoiceStatus'=>$invoiceStatus,
        ]);
    }
    public function imgs()
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
                    Invoice::where('i_id',$id)->update(['i_img'=>$file_path]);
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

    }    //生成订单号
    function getRandomString($len, $chars=null)
    {
        if (is_null($chars)) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }
    public function geren()
    {
        return view('index.geren');
    }
    public function video()
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
            } elseif($file_size > 52428800) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于10MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./video/".$date."/";
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
    public function dovideo()
    {
        $data = request()->input();
//        dd($data);
        $result = Geren::where('g_username',$data['username'])->first();
        if($result){
            return json_encode(['code'=>3,'message'=>"这个人已经添加了"]);
        }
        $video = trim($data['video'],'.');

        $arr = [
            'g_username'=>$data['username'],
            'g_img'=>$data['img'],
            'g_video'=> $video,
            'g_desc'=>$data['desc'],
            'create_time'=>time()
        ];
        $res = Geren::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function info()
    {
        $data = Info::paginate(10);
        return view('index.info',[
            'data'=>$data
        ]);
    }
    public function tx()
    {
        $data = Info::
        join('tx','info.i_name','=','tx.t_name')
            ->join('geren','info.i_name','=','geren.g_username')
            ->paginate(10);
        return view('index.tx',[
            'data'=>$data,
        ]);
    }
}
