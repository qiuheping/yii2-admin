<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        /*'css/AdminLTE.min.css',
        'statics/plugins/animate/list-item.css',
        'statics/plugins/bootstrap/css/bootstrap.css',
        'statics/plugins/font/css/font-awesome.css',
        'statics/plugins/app/css/AdminLTE.css',
        'statics/plugins/animate/animate.css',
        'statics/plugins/animate/jquery-ui.css',
        'statics/plugins/animate/list-item.css',
        'statics/plugins/animate/main.css',
        'statics/plugins/app/css/AdminLTE.css',
        'statics/plugins/app/css/AdminLTE.min.css',
        'statics/plugins/bootstrap/css/bootstrap.css',
        'statics/plugins/bootstrap/css/bootstrap.min.css',
        'statics/plugins/bootstrap/css/bootstrap-theme.css',
        'statics/plugins/bootstrap/css/bootstrap-theme.min.css',
        'statics/plugins/font/css/font-awesome.css',
        'statics/plugins/font/css/font-awesome.min.css',
        'statics/plugins/gii/main.css',
        'statics/plugins/toolbar/main.css',
        'statics/plugins/toolbar/toolbar.css',*/
    ];
    public $js = [
        /*'js/app.min.js',
        'statics/plugins/jquery/jquery.js',
        'statics/plugins/yii/yii.gridView.js',
        'statics/plugins/yii/yii.js',
        'statics/plugins/bootstrap/js/bootstrap.js',
        'statics/plugins/app/app.min.js',
        'statics/plugins/animate/jquery-ui.js',
        'statics/plugins/app/app.js',
        'statics/plugins/app/app.min.js',
        'statics/plugins/app/demo.js',
        'statics/plugins/app/pages/dashboard.js',
        'statics/plugins/app/pages/dashboard2.js',
        'statics/plugins/blood/bloodhound.js',
        'statics/plugins/blood/bloodhound.min.js',
        'statics/plugins/blood/typeahead.bundle.js',
        'statics/plugins/blood/typeahead.bundle.min.js',
        'statics/plugins/blood/typeahead.jquery.js',
        'statics/plugins/blood/typeahead.jquery.min.js',
        'statics/plugins/bootstrap/js/bootstrap.js',
        'statics/plugins/bootstrap/js/bootstrap.min.js',
        'statics/plugins/gii/gii.js',
        'statics/plugins/jquery/jquery.min.js',
        'statics/plugins/jquery/jquery.slim.js',
        'statics/plugins/jquery/jquery.slim.min.js',
        'statics/plugins/pjax/jquery.pjax.js',
        'statics/plugins/toolbar/toolbar.js',
        'statics/plugins/yii/yii.activeForm.js',
        'statics/plugins/yii/yii.captcha.js',

        'statics/plugins/yii/yii.validation.js',*/
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile)
    {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);
    }
}
