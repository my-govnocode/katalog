<?php

namespace app\models;

use yii\helpers\FileHelper;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property  $image
 * @property float $price
 */
class Product extends \yii\db\ActiveRecord
{
    const IMAGE_PATH = 'image/products/';

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'photo' => 'Photo',
            'price' => 'Price',
        ];
    }

    public function upload()
    {
        $path = self::IMAGE_PATH . $this->id;
        FileHelper::createDirectory($path);
        $fileName = $this->imageFile->name;
        $this->imageFile->saveAs($path . '/' . $fileName);
        return $fileName;
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['id' => 'property_id'])
            ->viaTable('property_product', ['product_id' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasMany(GroupProperty::class, ['id' => 'group_id'])
            ->via('properties');
    }
}
