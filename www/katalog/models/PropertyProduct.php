<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_product".
 *
 * @property int $id
 * @property int|null $property_id
 * @property int|null $product_id
 * @property int|null $group_id
 *
 * @property Products $product
 * @property Propertys $property
 */
class PropertyProduct extends \yii\db\ActiveRecord
{
    public $group_id;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'product_id' => 'Product ID',
            'group_id' => 'Group Id'
        ];
    }
}
