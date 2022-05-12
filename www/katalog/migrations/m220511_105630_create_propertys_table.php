<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%propertys}}`.
 */
class m220511_105630_create_propertys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%propertys}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'group_id' => $this->integer(),
            'code' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%propertys}}');
    }
}
