<?php

namespace app\widgets;

use app\models\GroupProperty;

class Categories extends \yii\bootstrap4\Widget
{
    public $layout = 'main';
    public $url;

    public function run()
    {
        $groups = GroupProperty::find()->with('propertiesProducts')->all();
        return $this->render('categories', [
            'groups' => $groups,
            'url' => $this->url
        ]);
    }
}
