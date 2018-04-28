<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 2016/12/13
 * Time: 9:44
 */
namespace backend\assets;

use yii\web\AssetBundle;

class JqueryAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'jquery/dist/jquery.min.js'
    ];
}
