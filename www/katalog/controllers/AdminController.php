<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use yii\helpers\ArrayHelper;
use app\models\Property;
use Yii;


class AdminController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $session = Yii::$app->session;
        $groups = GroupProperty::find()->with('propertiesProducts')->all();
        $products = Product::find();
        $data = Yii::$app->request->get();

        if($data) {
            $priceFrom = ArrayHelper::remove($data, 'priceFrom');
            $priceTo = ArrayHelper::remove($data, 'priceTo');
            $products->andWhere(['between', 'price', $priceFrom, $priceTo]);

            foreach ($data as $key => $prop) {
                $propId = Property::find()->select('id')->where(['code' => $prop])->asArray()->all();
                $arrPropId = [];
                array_walk_recursive($propId, function($v) use (&$arrPropId){
                    $arrPropId[] = $v;
                });
                $products->innerJoin('property_product p' . $key, 'p' . $key . '.product_id = products.id')->andWhere(['in', 'p' . $key . '.property_id', $arrPropId]);
            }

            $products = $products->groupBy('products.id')->all();

            return $this->render('index', [
                'products' => $products,
                'session' => $session,
                'groups' => $groups
            ]);
        } 
        $products = $products->all();
        return $this->render('index', [
            'products' => $products,
            'session' => $session,
            'groups' => $groups
        ]);
    }
}
