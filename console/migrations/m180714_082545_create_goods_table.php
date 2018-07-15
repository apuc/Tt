<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180714_082545_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
            'price' => $this->decimal(10,2),
            'image' => $this->string(),
            'category_id' => $this->integer(),
            'provider_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        //Индексы для таблицы товаров
        $this->createIndex('goods_category_idx', 'goods', 'category_id');
        $this->createIndex('goods_provider_idx', 'goods', 'provider_id');
        //Внешние ключи для таблицы товаров
        $this->addForeignKey('goods_category_fk', 'goods', 'category_id', 'categories', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('goods_provider_fk', 'goods', 'provider_id', 'providers', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //Удаление внешних улючей
        $this->dropForeignKey('goods_provider_fk', 'goods');
        $this->dropForeignKey('goods_category_fk', 'goods');
        //Удаление индексов
        $this->dropIndex('goods_provider_idx', 'goods');
        $this->dropIndex('goods_category_idx', 'goods');

        $this->dropTable('goods');
    }
}
