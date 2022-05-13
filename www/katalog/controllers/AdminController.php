<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $data = \Yii::$app->request->get();
        if ($data) {
        //var_dump($data);
            $priceFrom = ArrayHelper::remove($data, 'priceFrom');
            $priceTo = ArrayHelper::remove($data, 'priceTo');
            $groups = GroupProperty::find()->with('properties')->all();
            $products = Product::find()->joinWith('properties');
            //$products = Product::find()->joinWith('groups')->where(['group_propertys.code' => ['razmer', 'tkan']])->andWhere(['properties.code' => [ 'small', 'big']]);

            $arr = [];
            foreach ($data as $prop) {
                foreach ($prop as $p) {
                    $arr[] = $p;
                }
            }

            foreach ($data as $key => $prop) {
                $products->innerJoin('group_propertys group' . $key, 'properties.group_id = group' . $key . '.id')->where(['group' . $key . '.code' => $key])->andWhere(['in', 'properties.code', $arr]);
            }

            $products = $products->andWhere(['between', 'price', $priceFrom, $priceTo])->groupBy('products.id')->all();
            //$products = $products->createCommand()->getRawSql();

            //var_dump($products);
    
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
