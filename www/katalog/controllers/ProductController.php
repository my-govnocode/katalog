<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use app\models\Property;
use yii\db\Query;

class ProductController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $data = \Yii::$app->request->get();
        if ($data) {
            $groups = GroupProperty::find()->with('propertys')->all();
            $products = Product::find()->joinWith('propertys')->where(['url' => array_values($data)])->all();
    
            return $this->render('index', [
                'products' => $products,
                'groups' => $groups
            ]);
        } else {
            $groups = GroupProperty::find()->with('propertys')->all();
            $products = Product::find()->all();
    
            return $this->render('index', [
                'products' => $products,
                'groups' => $groups
            ]);
        }
    }

}
