<?php


namespace console\services;


use Faker\Factory;
use common\models\Category;
use common\models\Goods;
use common\models\Provider;
use yii\db\Exception;

/**
 * Сервис для заполнения таблиц начальными данными
 *
 * Class SeedService
 * @package console\services
 */
class SeedService
{
    /**
     * Генератор данных
     *
     * @var \Faker\Generator
     */
    private $factory;

    public function __construct()
    {
        $this->factory = Factory::create('ru_RU');
    }

    /**
     * Метод для заполнения таблицы categories(категории)
     *
     * @param int $count
     * @throws Exception
     */
    public function seedCategories(int $count = 40): void
    {
        for ($i = 0 ; $i < $count; $i++) {
            $category = new Category();

            $category->name = $this->factory->unique()->streetName;
            $category->sort = $this->factory->numberBetween(1, 100);
            $category->description = $this->factory->text(300);
            $category->status = $this->factory->randomElement([
                $category::STATUS_DISABLED, $category::STATUS_ENABLED
            ]);

            if (!$category->save()) {
                throw new Exception(implode(', ', $category->errors));
            }
        }
    }

    /**
     * Метод для заполнения таблицы providers(поставщики)
     *
     * @param int $count
     * @throws Exception
     */
    public function seedProviders(int $count = 40): void
    {
        for ($i = 0 ; $i < $count; $i++) {
            $provider = new Provider();

            $provider->name = $this->factory->company;
            $provider->sort = $this->factory->numberBetween(1, 100);

            if (!$provider->save()) {
                throw new Exception(implode(', ', $provider->errors));
            }
        }
    }

    /**
     * Метод для заполнения таблицы goods (товары)
     *
     * @param int $count
     * @throws Exception
     */
    public function seedGoods(int $count = 100): void
    {
        for ($i = 0 ; $i < $count; $i++) {
            $goods = new Goods();

            $goods->name = $this->factory->name;
            $goods->description = $this->factory->text(300);
            $goods->price = $this->factory->randomFloat(2, 1000, 100000);
            $goods->image = $this->factory->imageUrl();
            $goods->category_id = $this->factory->randomElement(
                Category::find()->select('id')->asArray()->column()
            );
            $goods->provider_id = $this->factory->randomElement(
                Provider::find()->select('id')->asArray()->column()
            );

            if (!$goods->save()) {
                throw new Exception(implode(', ', $goods->errors));
            }
        }
    }
}