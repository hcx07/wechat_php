<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 17:11
 */
namespace app\index\controller;
use Gregwar\Captcha\CaptchaBuilder;
use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller{

    /**登录
     * @return mixed
     */
    public function index(){
        if(Request::instance()->isPost()){
            $username=Request::instance()->post('username');
            $password=Request::instance()->post('password');
            $vertify=Request::instance()->post('vertify');
            if(!captcha_check($vertify)){
                $this->error('验证码错误');
            }
            $res=\db('user')->where(['username'=>$username,'type'=>1,'status'=>1])->find();
            if(!$res){
                $this->error('用户名错误');
            }
            if($res['password']!=encrypt($password)){
                $this->error('密码错误');
            }else{
                Session::set('user_id',$res['user_id']);
                $this->redirect('/index.html');
            }
        }
        return $this->fetch('index');
    }

    /**
     * 退出登陆
     */
    public function logout(){
        Session::clear();
        Session::destroy();
        $this->success("退出成功",'login/index');
    }
}