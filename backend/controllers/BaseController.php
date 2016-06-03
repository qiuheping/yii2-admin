<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/5/30
 * Time: 16:53
 */
namespace backend\controllers;

use yii\web\Controller;
use yii;

class BaseController extends Controller
{
    public function error()
    {
        $exception = Yii::$app->errorHandler->exception;

        if($exception != null){
            return ['code'=>0,'message'=>$exception->getMessage()];
        }
        return true;
    }
}
