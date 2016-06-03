<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/5/12
 * Time: 11:45
 */

namespace frontend\controllers;

use OAuth2\Autoloader;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\Server;
use OAuth2\Storage\Pdo;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;


class OauthController extends Controller
{
    protected $_server;
    public $enableCsrfValidation = false;

    /*public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                ]
            ],
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
        ]);
    }*/

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return false;

        $dsn = 'mysql:dbname=yii2advanced;host=localhost';
        $username = 'root';
        $password = '';

        //Autoloader::register();

        //$storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
        $storage = new Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
        $server = new Server($storage, array('enforce_state' => false));
        $server->addGrantType(new ClientCredentials($storage));
        $server->addGrantType(new AuthorizationCode($storage));
        $this->_server = $server;

        return true;
    }


    /**
     * 生成token
     * @param $model
     */
    public function actionToken($model)
    {
        $this->_server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
    }


    public function actionResource()
    {
        if (!$this->_server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            return $this->_server->getResponse()->send();
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }

    /**
     * 1 通过此方法来生成code，授权客户端，
     * @return string|void
     */
    public function actionAuthorize()
    {
        $request = \OAuth2\Request::createFromGlobals();
        $response = new \OAuth2\Response();
        if (!$this->_server->validateAuthorizeRequest($request, $response)) {
            return $response->send();
        }
        if (empty($_POST)) {
            return ' <form method="post">
					<label>Do You Authorize TestClient?</label><br />
					<input type="submit" name="authorized" value="yes">
					<input type="submit" name="authorized" value="no"> </form>';
        }
        $is_authorized = ($_POST['authorized'] === 'yes');

        $this->_server->handleAuthorizeRequest($request, $response, $is_authorized);
        if ($is_authorized) {
            //echo '<pre>';print_r($response);exit;
            $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
            //exit("SUCCESS! Authorization Code: $response $code");
            //return $this->redirect($response->getHttpHeaders()['Location']);
            return $this->redirect('token');
        }
        return false;
    }

}