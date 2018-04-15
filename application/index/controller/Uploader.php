<?php
namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Url;

class Uploader extends Controller {
    /**
     * 图片上传
     */
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $files = request()->file();
        if($files){
            // 移动到框架应用根目录/public/uploads/ 目录下
            foreach ($files as $file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    $url=Request::instance()->domain(). '/uploads/'.$info->getSaveName();
                    json_return($url);
                }else{
                    // 上传失败获取错误信息
                    json_return([],$file->getError(),300);
                }
            }
        }else{
            json_return([],'未接收到文件',300);
        }

    }
}