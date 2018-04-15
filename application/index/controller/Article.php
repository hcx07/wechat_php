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
            var_dump($post);exit;
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

}