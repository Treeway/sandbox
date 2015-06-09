<?php

namespace app\modules\panel\controllers;

class SecurityController extends \yii\web\Controller
{
    public function actionConfig()
    {
        return $this->render('config');
    }

}
