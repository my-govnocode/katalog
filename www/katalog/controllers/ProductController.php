<?php

namespace app\controllers;

use app\models\CreateForm;
use app\models\GroupProperty;
use app\models\Product;
use app\models\CreateProductForm;
use yii\helpers\Url;
use app\models\Property;
use app\models\PropertyProduct;
use phpDocumentor\Reflection\Types\Integer;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

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

    public function actionCreate()
    {
        $groups = GroupProperty::find()->with('propertys')->all();
        $property_product = new PropertyProduct();
        $model = new Product();
        $form = new CreateProductForm();
        $data = \Yii::$app->request->post();

        if ($form->load($data) && $form->validate()) {
            $form->image = UploadedFile::getInstance($form, 'image');
            $model->name = $form->name;
            $model->price = $form->price;
            if ($model->save()) {
                $path = 'image/products/' . $model->id;
                FileHelper::createDirectory('image/products/' . $model->id);
                if ($form->image != null) {
                    if ($model->image = $form->upload($path)) {
                        if ($model->save()){
                            $value = [];
                            foreach ($data['CreateProductForm']['propertys'] as $property) {
                                $value[] = [$property->id, $model->id];
                            }
                            var_dump($value);
                            \Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id'], $value)->execute();
                            $property_product->product_id = $model->id;
                            $property_product->property_id = $data['CreateProductForm']['propertys'];
                            $property_product->save();
                            $this->redirect(Url::toRoute('product/index'));
                        }
                    } 
                } else {
                    $value = [];
                    foreach ($data['CreateProductForm']['propertys'] as $property) {
                        $value[] = [$property, $model->id];
                    }
                    \Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id'], $value)->execute();
                    $property_product->product_id = $model->id;
                    $property_product->property_id = $data['CreateProductForm']['propertys'];
                    $property_product->save();
                    $this->redirect(Url::toRoute('product/index'));
                }
                
            }
        } else {
            return $this->render('create', [
                'model' => $form,
                'groups' => $groups,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = Product::findOne($id);
        $model->delete();

        $this->redirect(Url::toRoute('admin/index'));
    }
}
