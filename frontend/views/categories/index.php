<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\Category */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'value' => function ($model) {
                    return wordwrap($model->description);
                }
            ],
            'sort',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    /**@var $model \common\models\Category*/
                    if ($model->isEnabled()) {
                        return Html::a(
                                Yii::t('app', 'Disable'),
                                ['categories/disable', 'id' => $model->id], ['class' => 'btn btn-danger']
                        );
                    } else {
                        return Html::a(
                                Yii::t('app', 'Enable'),
                                ['categories/enable', 'id' => $model->id], ['class' => 'btn btn-success']
                        );
                    }
                },
                'filter' => \common\models\Category::getStatuses()
            ],
            'created_at',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>
</div>
