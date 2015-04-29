<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/index.css',
        'css/chosen.css',
        'css/jquery-ui.css',
        'css/flat-ui.min.css',
    ];
    public $js = [
        'js/jquery.js',
        'js/jquery-ui.js',
        'js/index.js',
        'js/chosen.jquery.js',
        'js/flat-ui.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}