<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%propertys}}`.
 */
class m220511_105630_create_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%properties}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'group_id' => $this->integer(),
            'code' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%properties}}');
    }
}
