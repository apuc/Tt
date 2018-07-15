<?php

namespace console\controllers;

use console\services\SeedService;
use yii\console\Controller;
use yii\base\Module;
use yii\db\Exception;
use yii\helpers\Console;

/**
 * Контроллер для заполнения БД
 *
 * Class SeedController
 * @package console\controllers
 */
class SeedController extends Controller
{
    private $service;

    public function __construct($id, Module $module, SeedService $service, array $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    /**
     * Action для заполнения базы данных начальными данными
     */
    public function actionIndex()
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $this->service->seedCategories();
            $this->service->seedProviders();
            $this->service->seedGoods();
            $transaction->commit();
            $this->stdout('Data has been saved to database', Console::FG_GREEN);
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->stdout($e->getMessage(), Console::FG_RED);
        }
    }
}
