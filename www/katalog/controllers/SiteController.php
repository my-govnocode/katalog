<?php

namespace app\controllers;

class SiteController extends \yii\web\Controller
{
    public $layout = 'main';
    
    public function actionError()
    {
        return $this->render('error');
    }

}
