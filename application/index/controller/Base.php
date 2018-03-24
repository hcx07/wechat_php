<?php
namespace app\index\controller;
use think\Controller;
use think\Session;

class Base extends Controller {

    protected static $user;
    protected static $user_id;

    public function _initialize() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods:GET,HEAD,POST,TRACE,OPTIONS");
        header("Access-Control-Allow-Headers:accept, content-type");
        $this->checkAuthority();
    }

    /**
     * 检测用户登录和权限
     */
    public function checkAuthority(){
        $user_id=Session::get('user_id');
        if(!$user_id){
            $this->error('请先登录','login/index');
        }
    }
}