<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use app\models\CreateProductForm;
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
                    $value = [];
                    foreach ($data['CreateProductForm']['properties'] as $property) {
                        $value[] = [$property, $model->id];
                    }
                    \Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id'], $value)->execute();
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
