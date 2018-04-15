<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 16:08
 */
namespace app\index\controller;

use think\Request;
use think\Session;

class Article extends Base{
    /**
     * 文章列表
     */
    public function article_list(){
        $data=\db('article')
            ->join('user','user.user_id=article.user_id')
            ->field('article.*,user.username')
            ->where(['article.status'=>0])->order('add_time desc')->paginate(10);
        return $this->fetch('article_list',['data'=>$data]);
    }
    /**
     * 添加文章
     */
    public function add(){
        if(Request::instance()->isPost()){
            $post=Request::instance()->post();
            $post['img']=$post['vi'];
            unset($post['vi']);
            $post['add_time']=time();
            $post['user_id']=Session::get('user_id');
            $res=\db('article')->insert($post);
            if($res){
                $this->success('添加成功！', Url('article/index'));exit;
            }else{
                $this->error('添加失败！');
                exit;
            }
        }
        return $this->fetch('add');
    }
    /**
     * 修改文章
     */
    public function edit(){
        $article_id=input('article_id');
        $data=db('article')->where(['article_id'=>$article_id,'status'=>0])->find();
        if(Request::instance()->isPost()){
            $post=Request::instance()->post();
            $article_id=$post['article_id'];
            $data=[
                'img'=>$post['vi'],
                'title'=>$post['title'],
                'content'=>$post['content'],
            ];
            $res=db('article')->where(['article_id'=>$article_id])->update($data);
            if($res){
                $this->success('修改成功！', Url('article/index'));exit;
            }else{
                $this->error('修改失败！');
                exit;
            }
        }


        return $this->fetch('edit',['data'=>$data]);
    }

}