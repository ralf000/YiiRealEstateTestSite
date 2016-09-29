<?php

namespace app\modules\cabinet;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\cabinet\controllers';

    public function init()
    {
        parent::init();

        $this->setLayoutPath('@frontend/views/layouts');
//        $this->setLayoutPath('@theme_view/layouts');//это путь для layouts с применением алиаса заданного в main для использования тем
    }
}
