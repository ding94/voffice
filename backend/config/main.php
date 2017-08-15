<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'X MailBox',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'finance' => [
            'class' => 'backend\modules\finance\finance',
        ],
        'logistics' => [
            'class' => 'backend\modules\logistics\logistics',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

       
         'urlManager' => [
              'enablePrettyUrl' => false,
              'showScriptName' => false,
              'rules'=>[
                "/admin" => 'admin/index',
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
              ],
        ],
        
    ],

    /*
     *deny all guest to view page
    */
    'as beforeRequest' =>[
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
    'params' => $params,
];
