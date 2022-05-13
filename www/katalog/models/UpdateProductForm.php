<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UpdateProductForm extends Model
{
    public $image;
    public $name;
    public $price;
    public $properties;

    public function rules()
    {
        return [
            [['name', 'price'], 'required', 'message' => 'Заполнте поле'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            
        ];
    }
}