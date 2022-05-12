<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\FileHelper;
class CreateProductForm extends Model
{
    public $image;
    public $name;
    public $price;
    public $propertys;

    public function rules()
    {
        return [
            [['name', 'price'], 'required', 'message' => 'Заполнте поле'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            
        ];
    }
    
    public function upload()
    {
        $path = Product::IMAGE_PATH . $this->id;
        FileHelper::createDirectory($path);
        if ($this->image != null) {
            $fileName = $this->image->name;
            $this->image->saveAs($path . '/' . $fileName);
            return $fileName;
        }
    }

    public function sync($p)
    {
        $value = [];
        var_dump($this->propertysArr);
        foreach ($this->propertys as $property) {
            $value[] = [];
        }
    }
}