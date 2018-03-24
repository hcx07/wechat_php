<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 16:08
 */
namespace app\index\controller;

use think\Request;

class Article extends Base{
    /**
     * 文章列表
     */
    public function article_list(){
        $data=\db('article')->where(['status'=>0])->order('add_time desc')->paginate(10);
        return $this->fetch('article_list',['data'=>$data]);
    }
    /**
     * 添加文章
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
        return $this->fetch('add',['banner'=>[]]);
    }
    /**
     * 图片上传
     */
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('Images');
        var_dump($file);exit;

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                jsonReturn(200,$info->getExtension());
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}