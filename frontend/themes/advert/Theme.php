<?php

namespace frontend\themes\advert;

class Theme extends \yii\base\Theme
{
    public $pathMap = [
        '@frontend/views'   => '@frontend/themes/advert/views',
        '@frontend/modules' => '@frontend/themes/advert/modules'
    ];

    public function init()
    {
        parent::init();
    }
}