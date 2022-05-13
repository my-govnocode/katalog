<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "propertys".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $group_id
 *
 * @property PropertyProduct[] $propertyProducts
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
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
            'group_id' => 'Group ID',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(GroupProperty::class, ['id' => 'group_id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->viaTable('property_product', ['property_id' => 'id']);
    }
}
