<?php

namespace app\models;

use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use Yii;

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
    const PRICE_MIN = 1;
    const PRICE_MAX = 2000;

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

    public function filteringByPropertiesAndPrice($data)
    {
        $products = Product::find();
        $priceFrom = ArrayHelper::remove($data, 'priceFrom');
        $priceTo = ArrayHelper::remove($data, 'priceTo');
        $products->andWhere(['between', 'price', $priceFrom, $priceTo]);

        $properties = Property::find()->select(['id', 'code'])->asArray()->all();
        foreach ($data as $key => $prop) {
            $propId = [];
            foreach ($properties as $element) {
                if (in_array($element['code'], $prop)) {
                    $propId[] = $element['id'];
                }
            }

            $arrPropId = [];
            array_walk_recursive($propId, function($v) use (&$arrPropId){
                $arrPropId[] = $v;
            });
            $products->innerJoin('property_product p' . $key, 'p' . $key . '.product_id = products.id')->andWhere(['in', 'p' . $key . '.property_id', $arrPropId]);
        }

        return $products->groupBy('products.id')->all();
    }
}
