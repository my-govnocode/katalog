<?php

namespace app\controllers;

use app\models\GroupProperty;
use app\models\Product;
use app\models\ProductForm;
use app\models\Property;
use yii\helpers\Url;
use app\models\PropertyProduct;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Yii;

class ProductController extends \yii\web\Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $products = Product::find();
        $data = \Yii::$app->request->get();

        if(Yii::$app->request->isAjax) {
            $product = new Product();
            $products = $product->filteringByPropertiesAndPrice($data);

            return $this->renderAjax('products', [
                'products' => $products,
            ]);
        }
        $products = $products->all();
        return $this->render('index', [
            'products' => $products,
            'session' => $session
        ]);
    }

    public function actionCreate()
    {
        $session = \Yii::$app->session;
        $groups = GroupProperty::find()->with('properties')->all();
        $product = new Product();
        $form = new ProductForm(['scenario' => ProductForm::SCENARIO_CREATE_PRODUCT]);
        $data = \Yii::$app->request->post();

        if ($form->load($data) && $form->validate()) {
            $product->imageFile = UploadedFile::getInstance($form, 'image');
            $product->name = $form->name;
            $product->price = $form->price;
            if ($product->save()) {
                $form->propertiesBinding($data, $product);
                if ($product->imageFile !== null) {
                    if ($product->image = $product->upload()) {
                        if ($product->save()){
                            $session->setFlash('success', 'Товар "' . $product->name. '" успешно добавлен!');
                            return $this->redirect(Url::toRoute('product/index'));
                        }
                        $session->setFlash('error', 'Продукт "' . $product->name . '" не удалось создать! Произошла ошибка при загрузе изображения.');
                        return $this->redirect(Url::toRoute('product/index'));
                    } 
                }
                $session->setFlash('success', 'Товар "' . $product->name. '" успешно добавлен!');
                return $this->redirect(Url::toRoute('product/index'));
            }
            $session->setFlash('error', 'Продукт "' . $product->name . '" не удалось создать!');
            return $this->redirect(Url::toRoute('product/index'));
        }
        return $this->render('create', [
            'model' => $form,
            'groups' => $groups,
        ]);
    }

    public function actionUpdate($id)
    {
        $session = \Yii::$app->session;
        $data = \Yii::$app->request->post();
        $groups = GroupProperty::find()->with('properties')->all();
        $product = Product::find()->with('properties')->where(['id' => $id])->one();
        $model = new ProductForm(['scenario' => ProductForm::SCENARIO_UPDATE_PRODUCT]);
        $model->afterFind($product);
        $product->imageFile = UploadedFile::getInstance($model, 'image');

        $propertiesSelected = [];
        foreach ($product->properties as $property) {
            $propertiesSelected[$property->id] = ['selected' => true];
        }

        if($model->load($data) && $model->validate()) {
            $product->name = $model->name;
            $product->price = $model->price;
            PropertyProduct::deleteAll(['product_id' => $product->id]);
            $propertyUpdate = $model->propertiesBinding($data, $product);
            if ($product->update() || $propertyUpdate) {
                if ($product->imageFile !== null) {
                    if ($product->image !== null) {
                        FileHelper::unlink(Product::IMAGE_PATH . $id . '/' . $product->image);
                    }
                    if ($product->image = $product->upload()) {
                        if( $product->save()) {
                            $session->setFlash('success', 'Продукт "' . $product->name . '" успешно обновлен!');
                            return $this->redirect(Url::toRoute('product/index'));
                        } 
                        $session->setFlash('error', 'Продукт "' . $product->name . '" не удалось обновить! Произошла ошибка при загрузе изображения.');
                        return $this->redirect(Url::toRoute('product/index'));
                    }
                }
                $session->setFlash('success', 'Продукт "' . $product->name . '" успешно обновлен!');
                return $this->redirect(Url::toRoute('product/index'));
            }
            $session->setFlash('error', 'Продукт "' . $product->name . '" не удалось обновить!');
            return $this->redirect(Url::toRoute('product/index'));
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
        $session = \Yii::$app->session;
        FileHelper::removeDirectory(Product::IMAGE_PATH . $id);
        $product = Product::findOne($id);
        $product->delete() ? 
        $session->setFlash('success', 'Продукт "' . $product->name . '" успешно удален!') :
        $session->setFlash('error', 'Продукт "' . $product->name . '" не удалось удалить!');
        return $this->redirect(Url::toRoute('admin/index'));
    }
}
