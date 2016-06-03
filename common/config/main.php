<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        "urlManager" => [
            //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，
            // Yii2.0中改称美化。
            // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。
            "enablePrettyUrl" => true,
            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
            // 否则认为是无效路由。
            // 这个选项仅在 enablePrettyUrl 启用后才有效。
            "enableStrictParsing" => false,
            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
            "showScriptName" => false,
            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
            "suffix" => "",
            "rules" => [
                "<controller:\w+>/<id:\d+>" => "<controller>/view",
                "<controller:\w+>/<action:\w+>" => "<controller>/<action>"
            ],
        ],
        'response' => [
            //'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'acceptMimeType'=>false,
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    if(isset($response->data['code'])&&$response->data['code']==0){
                        $response->data=[
                            'code'=>$response->data['code'],
                            'message'=>$response->data['message'],
                        ];
                    }else{
                        $response->data;
                    }
                    $response->statusCode = 200;
                }
            },
        ],
       /* 'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/
        /*"view" => [
            "theme" => [
                "pathMap" => [
                    "@app/views" => "@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app"
                ],
            ],
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',//允许访问的节点，可自行添加
            'admin/*',//允许所有人访问admin节点及其子节点
        ]
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'language'=>'zh-CN',
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true,
                    'refresh_token_lifetime' => '3600',
                ]
            ]
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//yii2-admin的导航菜单
        ]
    ]
];
