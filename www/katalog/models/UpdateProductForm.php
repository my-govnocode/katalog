<?php

namespace app\models;

use yii\base\Model;
class UpdateProductForm extends Model
{
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
            [['name'], 'unique', 'targetClass' => Product::class, 'message' => 'Это название продукта уже занято', 'when' => function($model) {
                return $model->name !== $this->oldRecord->name;
            }],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'when' => function($model) {
                return $model->image !== null;
            }],
        ];
    }

    public function afterFind(Product $product)
    {
	    $this->oldRecord = clone $product;
    }
}