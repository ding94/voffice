<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        /* 'i18n' => [
            'translations' => [
                'kvgrid' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/kartik-v/yii2-grid/messages',
                ],
          ],
        ],*/
         'formatter' => [
            'dateFormat' => 'php:d-M-Y',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'timeZone' => 'Asia/Kuala_Lumpur',
        ],
        
    ],
    'modules' => [
       // 'gridview' =>  [
       //      'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        // ]
        'notifications' => [
            'class' => '\machour\yii2\notifications\NotificationsModule',
            'notificationClass' => 'common\widgets\Notification',
            'allowDuplicate' => false,
            'dbDateFormat' => 'Y-m-d H:i:s',
            'userId' => function() {
                return \Yii::$app->user->id;
            }
        ]
    ],
];
