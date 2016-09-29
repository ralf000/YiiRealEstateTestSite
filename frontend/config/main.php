<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

//алиас для удобства при использовании тем
//\Yii::setAlias('theme_view', '@frontend/themes/advert/views');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-Ru',
    'defaultRoute' => 'main',//задаем открытие модуля main с главной страницы
    'controllerNamespace' => 'frontend\controllers',
    
//    добавили свой модуль при помощи gii
    'modules' => [
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'cabinet' => [
            'class' => 'app\modules\cabinet\Module',
        ],
    ],
    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/main/main/login',
        ],
//        подключаем пути для использования тем
//        'view' => [
//            'theme' => [
//                'class' => 'frontend\themes\advert\Theme',
//                'basePath' => '@app/',
//                'baseUrl' => '@web/',
//            ],
//        ],
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
        'mail' => [
            'class'            => 'zyx\phpmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,//если true то будет сохраняться ещё и локальная копия письма
            'config'           => [
                'mailer'     => 'smtp',
                'host'       => 'smtp.yandex.ru',
                'port'       => '465',
                'smtpsecure' => 'ssl',
                'smtpauth'   => true,
                'username'   => 'ralf000@yandex.ru',//своя почта на яндексе
                'password'   => '5eHB6V3Gyand',//пароль почты
                'ishtml' => true,
                'charset' => 'UTF-8',
            ],
        ],
        'common' => [
            'class' => 'frontend\components\Common',
         ],
     ],
    'params' => $params,
];
