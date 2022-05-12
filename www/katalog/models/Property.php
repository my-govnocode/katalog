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
        return 'propertys';
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

    /**
     * Gets query for [[PropertyProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyProducts()
    {
        return $this->hasMany(PropertyProduct::className(), ['property_id' => 'id']);
    }

    public function getGroup()
    {
        return $this->hasOne(GroupProperty::class, ['id' => 'group_id']);
    }
}
