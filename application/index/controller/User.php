<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 13:52
 */
namespace app\index\controller;
use Ramsey\Uuid\Uuid;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Session;
use think\Url;

class User extends Base {
    public function index(){
        $user_id=Session::get('user_id');
        $res=\db('user')->where(['user_id'=>$user_id])->find();
        $result=\db('user')->where(['status'=>1])->order('user_id desc')->paginate(10);
        return $this->fetch('index',['result'=>$result,'res'=>$res]);
    }

    /**
     * @return mixed
     * 添加用户
     */
    public function add(){
        if(Request::instance()->isPost()){
            $post=Request::instance()->post();
            if($post['password'] != $post['re_password']){
                $this->error('两次输入密码不一致！');
                exit;
            }
            if(strlen($post['password']) < 6){
                $this->error('密码最少为6位数！');
                exit;
            }
            $result=preg_match('/^[\x{ff08}-\x{ff09}a-zA-Z\d\x{4e00}-\x{9fa5}]{3,50}$/u',$post['username'],$matches);
            if($result==0){
                $this->error('用户名由字母，数字，括号和汉字组成且在3-50字符内。！');
                exit;
            }
            $result=\db('user')->where(['username'=>$post['username']])->find();
            if($result){
                $this->error('用户名重复！');
                exit;
            }
            $data['username']=$post['username'];
            $data['password']=encrypt($post['password']);
            $data['uuid']=Uuid::uuid4()->toString();
            $res=\db('user')->insert($data);
            if($res){
                $this->success('添加成功！',Url('user/index'));exit;
            }
        }
        $user_id=Request::instance()->param('user_id');
        if($user_id){
            $result=\db('user')->where(['user_id'=>$user_id])->find();
//            var_dump($result);exit;
            $this->assign(['res'=>$result]);
        }
        return $this->fetch('add');
    }

    /**
     * @return mixed
     * 修改用户
     */
    public function edit(){
        $user_id=Request::instance()->param('user_id');
        $result=\db('user')->where(['user_id'=>$user_id])->find();
        $username=$result['username'];
        if(Request::instance()->isPost()) {
            $post=Request::instance()->post();
            if ($post['password'] != $post['re_password']) {
                $this->error('两次输入密码不一致！');
                exit;
            }
            if($username!=$post['username']){
                $result = \db('user')->where(['username' => $post['username']])->find();
                if ($result) {
                    $this->error('用户名重复！');
                    exit;
                }
            }
            if(strlen($post['password']) < 6){
                $this->error('密码最少为6位数！');
                exit;
            }
            $result=preg_match('/^[\x{ff08}-\x{ff09}a-zA-Z\d\x{4e00}-\x{9fa5}]{3,50}$/u',$post['username'],$matches);
            if($result==0){
                $this->error('用户名由字母，数字，括号和汉字组成且在3-50字符内。！');
                exit;
            }
            $data['username'] = $post['username'];
            $data['password'] = $post['password'];
            $res = \db('user')->where(['user'=>$user_id])->update($data);
            if ($res) {
                $this->success('修改成功！', Url('user/index'));exit;
            }
        }
        return $this->fetch('edit',['res'=>$result]);
    }

    /**
     * 删除用户
     */
    public function del(){
        $user_id=Request::instance()->param('user_id');
        $result=\db('user')->where(['user_id'=>$user_id])->update(['status'=>0]);
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
        exit;

    }
    public function info(){
        $user_id=Request::instance()->param('user_id');
        $result=\db('user')->where(['user_id'=>$user_id])->find();
        if(Request::instance()->isPost()){
            $post=Request::instance()->post();
            $files=\request()->file();
            if($files){
                foreach($files as $key=>$file) {
//                    var_dump($key);
                    $info = $file->validate(['ext'=>'pem'])->move(ROOT_PATH . 'public' . DS . 'pem');
                    if ($info) {
                        $path=$info->getSaveName();
                        $post[$key]='http://pay.cdnhxx.com/pem/'.$path;
                    } else {
                        // 上传失败获取错误信息
                        $error=$file->getError();
                        $this->error($error);
                    }
                }
            }
            if(!empty($post)){
                $res=\db('user')->where(['user_id'=>$user_id])->update($post);
                if($res){
                    $this->success('修改成功！',Url('user/index'));exit;
                }else{
                    $this->error('修改失败');
                    exit;
                }
            }
            $this->error('未输入数据',Url('user/index'));exit;
        }
        return $this->fetch('info',['res'=>$result]);
    }
}
