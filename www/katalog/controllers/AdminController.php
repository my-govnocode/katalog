<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use yii\helpers\ArrayHelper;
use app\models\Property;
use app\models\User;
use yii\filters\AccessControl;
use Yii;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'matchCallback' => function($rule, $action) {
                            return Yii::$app->user->identity->role === User::ROLE_ADMIN;
                        },
                    ],

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;
        $groups = GroupProperty::find()->with('propertiesProducts')->all();
        $products = Product::find();
        $data = Yii::$app->request->get();

        if(Yii::$app->request->isAjax) {
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

            return $this->renderAjax('products', [
                'products' => $products,
            ]);
        }
        $products = $products->all();
        return $this->render('index', [
            'products' => $products,
            'session' => $session,
            'groups' => $groups
        ]);
    }

    public function actionUsers()
    {
        $users = User::find()->all();
        return $this->render('users', [
            'users' => $users,
        ]);
    }
}
