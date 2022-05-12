<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group_propertys}}`.
 */
class m220511_105249_create_group_propertys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group_propertys}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%group_propertys}}');
    }
}
