<?php

use yii\db\Migration;

/**
 * Handles the creation of table `providers`.
 */
class m180714_082404_create_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('providers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'sort' => $this->integer()->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('providers');
    }
}
