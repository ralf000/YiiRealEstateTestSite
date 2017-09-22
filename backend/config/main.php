<?php

use kartik\datecontrol\Module;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'ru-Ru',
    'modules' => [
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'php:d.m.Y',
                Module::FORMAT_TIME => 'php:H:i',
                Module::FORMAT_DATETIME => 'php:d-m-Y H:i',
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d H:i:s', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            //'displayTimezone' => 'Europe/Moscow',

            // set your timezone for date saved to db
            //'saveTimezone' => 'UTC',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion' => true,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false
                    ]
                ], // example
                Module::FORMAT_DATETIME => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false
                    ]
                ], // setup if needed
                Module::FORMAT_TIME => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false
                    ]
                ], // setup if needed
            ],

            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class' => 'form-control'],
                    ]
                ]
            ]
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'formatter' => [
            'class' => \yii\i18n\Formatter::className(),
            'dateFormat' => 'php: d.m.Y',
            'datetimeFormat' => "php: H:i:s d-m-Y"
        ]
    ],
    'params' => $params,
];
