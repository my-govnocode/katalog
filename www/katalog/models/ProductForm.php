<?php

namespace app\models;

use yii\base\Model;
use Yii;

class ProductForm extends Model
{
    const SCENARIO_CREATE_PRODUCT = 'create_product';
    const SCENARIO_UPDATE_PRODUCT = 'update_product';

    public $image;
    public $name;
    public $price;
    public $properties;
    public $oldRecord;

    public function rules()
    {
        return [
            [['name', 'price'], 'required', 'message' => 'Заполните поле'],
            [['price'], 'number', 'message' => 'Поле должно содержать числа'],
            [['price'], 'number', 'min' => Product::PRICE_MIN, 'tooSmall' => 'Мин цена {min}', 'max' => Product::PRICE_MAX, 'tooBig' => 'Макс цена {max}'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Product::class, 'message' => 'Это название продукта уже занято', 'on' => self::SCENARIO_CREATE_PRODUCT],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'on' => self::SCENARIO_CREATE_PRODUCT, 'when' => function($model) {
                return $model->image !== null;
            }],

            [['name'], 'unique', 'targetClass' => Product::class, 'message' => 'Это название продукта уже занято', 'on' => self::SCENARIO_UPDATE_PRODUCT, 'when' => function($model) {
                return $model->name !== $this->oldRecord->name;
            }],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'on' => self::SCENARIO_UPDATE_PRODUCT, 'when' => function($model) {
                return $model->image !== null;
            }],
        ];
    }

    public function afterFind(Product $product)
    {
	    $this->oldRecord = clone $product;
    }

    public function propertiesBinding($data, $product)
    {
        $validProp = array_map('intval', $data['ProductForm']['properties']);
        $properties = Property::find()->where(['in', 'id', $validProp])->all();
        $value = [];
        foreach ($properties as $property) {
            $value[] = [$property->id, $product->id, $property->group_id];
        }
        return Yii::$app->db->createCommand()->batchInsert('property_product', ['property_id', 'product_id', 'group_id'], $value)->execute();
    }
}