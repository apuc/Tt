<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Provider;
use frontend\services\FileUploadService;
use Yii;
use common\models\Goods;
use frontend\models\search\GoodsSearch;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    private $fileService;

    public function __construct($id, Module $module, FileUploadService $service, array $config = [])
    {
        $this->fileService = $service;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categories   = Category::find()->select(['id', 'name'])->asArray()->all();
        $providers    = Provider::find()->select(['id', 'name'])->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => ArrayHelper::map($categories, 'id', 'name'),
            'providers' => ArrayHelper::map($providers, 'id', 'name')
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model      = new Goods();
        $categories = Category::find()->select(['id', 'name'])->asArray()->all();
        $providers  = Provider::find()->select(['id', 'name'])->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {
            try {
                $imagePath = $this->fileService->upload($model, 'file', 'goods');

                if ($imagePath) {
                    $model->image = $imagePath;
                }

                $model->save();

                return $this->redirect(['goods/index']);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'name'),
            'providers' => ArrayHelper::map($providers, 'id', 'name')
        ]);
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = Category::find()->select(['id', 'name'])->asArray()->all();
        $providers = Provider::find()->select(['id', 'name'])->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {

            try {
                $imagePath = $this->fileService->upload($model, 'file', 'goods');

                if ($imagePath) {
                    $model->image = $imagePath;
                }

                $model->save();

                return $this->redirect(['goods/index']);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'name'),
            'providers' => ArrayHelper::map($providers, 'id', 'name')
        ]);
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
