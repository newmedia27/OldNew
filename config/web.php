<?php

$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\request\StartupBehavior'],
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'components' => [
        'i18n' => [
            'translations' => [
                'trans*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'forceTranslation' => true,
                ],
                'eauth' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ],
            ],
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => '',
            'password' => '',
        ],

        'request' => [
            'class' => 'app\components\request\LangRequest',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'm2U-A2yd4referfS1KvkCqSVwP7bfpzSsuZIBU',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
            'locale' => 'ru-RU'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ds109.mirohost.net',
                'username' => 'info@colormarket.online',
                'password' => 'y7G4Szr3g7fT',
                'port' => '587',
            ],
        ],
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ],
            'services' => [
                'google' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'app\modules\user\components\oauth\GoogleOAuth2Service',
                    'clientId' => '640118531337',
                    'clientSecret' => 'AIzaSyDlxw9jsstJHI5rOYJyF_IpkW5',
                    'title' => 'Google',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'app\modules\user\components\oauth\FacebookOAuth2Service',
                    'clientId' => '123214385017199',
                    'clientSecret' => '3c1b430f3c5101704f422d281e886b7d',
                    'title' => 'Facebook',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/eauth.log',
                    'categories' => ['nodge\eauth\*'],
                    'logVars' => [],
                ]
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'class' => 'app\components\request\LangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ]
            ],
        ]
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\UserModule',
        ],
        'shop' => [
            'class' => 'app\modules\shop\ShopModule',
        ],
        'rating' => [
            'class' => 'app\modules\rating\RatingModule',
        ],
        'cart' => [
            'class' => 'app\modules\cart\CartModule',
        ],
        'feedback' => [
            'class' => 'app\modules\feedback\FeedbackModule',
        ],
        'comments' => [
            'class' => 'app\modules\comments\CommentsModule',
        ],
        'coloring' => [
            'class' => 'app\modules\coloring\ColoringModule',
        ],
        'blog' => [
            'class' => 'app\modules\blog\BlogModule',
        ],
        'search' => [
            'class' => 'app\modules\search\SearchModule',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
