<?php

namespace App\Http\Controllers\Login;

use App\Model\Gongsi;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use think\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function dologin()
    {
        $data = request()->input();
//        dd($data);
        $code = $data['vercode'];
        if($code != $data['codes']){
            return json_encode(['code'=>1,'message'=>"验证码错误"]);
        }
        $pass = md5($data['nuse']);
        $count = User::where(['u_name'=>$data['userName'],'u_password'=>$pass])->first();
//        dd($count);
        if(empty($count)){
            return json_encode(['code'=>3,'message'=>"用户名或密码错误"]);
        }else{
            $gong = Gongsi::where('u_id',$count->u_id)->first();
            session(['u_id'=>$count->u_id,'name'=>$count->u_name,'username'=>$count->u_username]);
            return json_encode(['code'=>2,'u_id'=>$gong['u_id'],'message'=>"登录成功"]);
        }

    }
}
