<?php

namespace app\models;

/**
 * This is the model class for table "group_propertys".
 *
 * @property int $id
 * @property string|null $name
 */
class GroupProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['group_id' => 'id']);
    }

    public function getPropertiesProducts()
    {
        return $this->hasMany(Property::class, ['id' => 'property_id'])
            ->viaTable('property_product', ['group_id' => 'id']);
    }
}
