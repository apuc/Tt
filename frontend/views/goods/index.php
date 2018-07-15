<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories \common\models\Category[]*/
/* @var $providers \common\models\Provider[]*/

$this->title = Yii::t('app', 'Goods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Goods'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->image, ['width' => 100]);
                }
            ],
            [
                'attribute' => 'name',
                'format' => 'ntext',
                'value' => function ($model) {
                    return wordwrap($model->name, 30);
                }
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'value' => function ($model) {
                    return wordwrap($model->description, 50);
                }
            ],
            'price',
            [
                'attribute' => 'category',
                'label' => Yii::t('app', 'Category'),
                'value' => 'category.name',
                'filter' => $categories
            ],
            [
                'attribute' => 'provider',
                'label' => Yii::t('app', 'Provider'),
                'value' => 'provider.name',
                'filter' => $providers
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
