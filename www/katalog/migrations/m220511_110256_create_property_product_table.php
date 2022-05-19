<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_product}}`.
 */
class m220511_110256_create_property_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_product}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(),
            'product_id' => $this->integer(),
            'group_id' => $this->integer()
        ]);


        $this->createIndex(
            'idx-property_product-property_id',
            'property_product',
            ['property_id', 'product_id'],
            true
        );

        $this->addForeignKey(
            'fk-property_product-property_id',
            'property_product',
            'property_id',
            'properties',
            'id',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-property_product-product_id',
            'property_product',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-property_product-group_id',
            'property_product',
            'group_id',
            'group_properties',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-property_product-property_id',
            'property_product',
        );

        $this->dropForeignKey(
            'fk-property_product-property_id',
            'property_product',
        );

        $this->dropForeignKey(
            'fk-property_product-product_id',
            'property_product',
        );

        $this->dropForeignKey(
            'fk-property_product-group_id',
            'property_product',
        );

        $this->dropTable('{{%property_product}}');
    }
}
