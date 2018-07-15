<?php

namespace frontend\controllers;

use Yii;
use common\models\Category;
use frontend\models\search\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for Category model.
 */
class CategoriesController extends Controller
{
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['categories/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['categories/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Метод для включения категории
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionEnable($id)
    {
        $model = $this->findModel($id);

        if ($model->isEnabled()) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Category is already active'));
        }

        if ($model->enable()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Category successfully activated'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'An error has occurred'));
        }

        return $this->redirect(['categories/index']);
    }

    /**
     * Метод для выключения категории
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);

        if (!$model->isEnabled()) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Category is already deactivated'));
        }

        if ($model->disable()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Category successfully deactivated'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'An error has occurred'));
        }

        return $this->redirect(['categories/index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
