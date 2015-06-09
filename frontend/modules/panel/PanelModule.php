<?php

namespace app\modules\panel;


class PanelModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\panel\controllers';

    public function init()
    {
        parent::init();
        $this->layout = 'menu';
        // custom initialization code goes here
    }
}
