<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group_propertys}}`.
 */
class m220511_105249_create_group_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group_properties}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%group_properties}}');
    }
}
