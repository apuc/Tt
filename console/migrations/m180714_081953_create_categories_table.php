<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m180714_081953_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'description' => $this->text(),
            'sort' => $this->integer()->unique(),
            'status' => $this->string(50),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
