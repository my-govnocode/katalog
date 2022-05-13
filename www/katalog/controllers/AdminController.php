<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use yii\helpers\ArrayHelper;
use app\models\Property;

class AdminController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $data = \Yii::$app->request->get();
        if ($data) {
            $priceFrom = ArrayHelper::remove($data, 'priceFrom');
            $priceTo = ArrayHelper::remove($data, 'priceTo');
            $groups = GroupProperty::find()->with('properties')->all();
            $products = Product::find()->andWhere(['between', 'price', $priceFrom, $priceTo]);

            foreach ($data as $key => $prop) {
                $propId = Property::find()->select('id')->where(['code' => $prop])->asArray()->all();
                $result = [];
                array_walk_recursive($propId, function($v) use (&$result){
                    $result[] = $v;
                });
                $products->innerJoin('property_product p' . $key, 'p' . $key . '.product_id = products.id')->andWhere(['in', 'p' . $key . '.property_id', $result]);
            }

            $products = $products->groupBy('products.id')->all();
    
            return $this->render('index', [
                'products' => $products,
                'groups' => $groups
            ]);
        } else {
            $groups = GroupProperty::find()->with('properties')->all();
            $products = Product::find()->all();
    
            return $this->render('index', [
                'products' => $products,
                'groups' => $groups
            ]);
        }
    }
}
