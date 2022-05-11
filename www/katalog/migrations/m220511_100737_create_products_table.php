<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m220511_100737_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'photo' => $this->text(),
            'price' => $this->decimal()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
