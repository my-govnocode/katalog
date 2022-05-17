<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\FileHelper;
class CreateProductForm extends Model
{
    public $image;
    public $name;
    public $price;
    public $properties;

    public function rules()
    {
        return [
            [['name', 'price'], 'required', 'message' => 'Заполните поле'],
            [['price'], 'number', 'message' => 'Поле должно содержать числа'],
            [['price'], 'number', 'min' => Product::PRICE_MIN, 'tooSmall' => 'Мин цена {min}', 'max' => Product::PRICE_MAX, 'tooBig' => 'Макс цена {max}'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Product::class, 'message' => 'Это название продукта уже занято'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'when' => function($model) {
                return $model->image !== null;
            }],
        ];
    }
}