<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use app\models\CreateProductForm;
use app\models\Property;
use yii\helpers\Url;
use app\models\PropertyProduct;
use app\models\UpdateProductForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class ProductController extends \yii\web\Controller
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
                $arrPropId = [];
                array_walk_recursive($propId, function($v) use (&$arrPropId){
                    $arrPropId[] = $v;
                });
                $products->innerJoin('property_product p' . $key, 'p' . $key . '.product_id = products.id')->andWhere(['in', 'p' . $key . '.property_id', $arrPropId]);
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

    public function actionCreate()
    {
        $groups = GroupProperty::find()->with('properties')->all();
        $property_product = new PropertyProduct();
        $model = new Product();
        $form = new CreateProductForm();
        $data = \Yii::$app->request->post();

        if ($form->load($data) && $form->validate()) {
            
            $model->imageFile = UploadedFile::getInstance($form, 'image');
            $model->name = $form->name;
            $model->price = $form->price;

                if ($model->save()) {
                    $validProp = [];
                    foreach ($data['CreateProductForm']['properties'] as $prop) {
                        $validProp[] = (int)$prop;
                    }
                    $properties = Property::find()->where(['in', 'id', $validProp])->all();
                    //var_dump($data);
                    $value = [];
                    foreach ($properties as $property) {
                        $value[] = [$property->id, $model->id, $property->group_id];
                    }
                    \Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id', 'group_id'], $value)->execute();

                    if ($model->imageFile !== null) {
                        if ($model->image = $model->upload()) {
                            if ($model->save()){
                                $this->redirect(Url::toRoute('product/index'));
                            }
                        } 
                    } else {
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

    public function actionUpdate($id)
    {
        $model = new UpdateProductForm();
        $product = Product::find()->with('properties')->where(['id' => $id])->one();
        $groups = GroupProperty::find()->with('properties')->all();
        $product->imageFile = UploadedFile::getInstance($model, 'image');

        $propertiesSelected = [];
        foreach ($product->properties as $property) {
            $propertiesSelected[$property->id] = ['selected' => true];
        }

        $data = \Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $product->name = $model->name;
            $product->price = $model->price;
            PropertyProduct::deleteAll(['product_id' => $product->id]);

            $value = [];
            foreach ($data['UpdateProductForm']['properties'] as $property) {
                $value[] = [$property, $product->id];
            }
            \Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id'], $value)->execute();
            if ($product->imageFile !== null) {
                $product->update();
                if ($product->image !== null) {
                    FileHelper::unlink(Product::IMAGE_PATH . $id . '/' . $product->image);
                }
                if ($product->image = $product->upload()) {
                    $product->save();
                    return $this->redirect(Url::toRoute('product/index'));
                }
            } else {
                $product->update();
                return $this->redirect(Url::toRoute('product/index'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'product' => $product,
            'groups' => $groups,
            'propertiesSelected' => $propertiesSelected
        ]);
    }

    public function actionDelete($id)
    {
        FileHelper::removeDirectory(Product::IMAGE_PATH . $id);
        $model = Product::findOne($id);
        $model->delete();

        $this->redirect(Url::toRoute('admin/index'));
    }
}
