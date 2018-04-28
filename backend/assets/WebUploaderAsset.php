<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 2017/3/7
 * Time: 14:47
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

    class WebUploaderAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'webuploader/dist/webuploader.min.js'
    ];

    public $jsOptions = [
        "position" => View::POS_HEAD
    ];

    public $css = [
        'webuploader/dist/webuploader.css'
    ];

    public $depends = [
        'backend\assets\JqueryAsset'
    ];

}
