<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories \common\models\Category[]*/
/* @var $providers \common\models\Provider[]*/

$this->title = Yii::t('app', 'Home');

$groupCategories = $categories;
$groupProviders = $providers;

?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $form = ActiveForm::begin([
        'id'     => 'group',
        'method' => 'GET',
        'action' => Url::to(['site/index'])
    ])?>

        <?= $form->field($searchModel, 'group')->dropDownList([
                'provider' => Yii::t('app', 'Provider'),
                'category' => Yii::t('app', 'Category')
        ], ['onchange' => '$("#group").submit()'])?>

    <?php ActiveForm::end()?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'name',
                'format' => 'html',
                'label' => Yii::t('app', 'Goods'),
                'value' => function ($model) {
                    return Html::a($model->name, ['goods/update', 'id' => $model->id]);
                }
            ],
            'price',

            [
                'attribute' => 'category',
                'label' => Yii::t('app', 'Category'),
                'format' => 'html',
                'filter' => $categories,
                'contentOptions' => function ($model) use (&$groupCategories, $dataProvider) {
                    if ((isset($_GET['GoodsSearch']['group']) && $_GET['GoodsSearch']['group'] === 'category')
                        && $_GET['sort'] === 'category') {

                        if (in_array($model->category_id, array_keys($groupCategories))) {
                            $count = count(array_filter($dataProvider->getModels(), function ($item) use ($model) {
                                return $item->category_id === $model->category_id;
                            }));
                            return [
                                'rowspan' => $count,
                                'style' => 'text-align: center; vertical-align:middle'
                            ];
                        }
                        return ['style' => 'display:none'];
                    }

                    return [];
                },
                'value' => function ($model) use (&$groupCategories) {
                    if ((isset($_GET['GoodsSearch']['group']) && $_GET['GoodsSearch']['group'] === 'category')
                        && $_GET['sort'] === 'category') {
                        if (in_array($model->category_id, array_keys($groupCategories))) {
                            unset($groupCategories[$model->category_id]);

                            return Html::a($model->category->name, ['categories/update', 'id' => $model->category_id]);
                        }
                        return false;
                    }

                    return Html::a($model->category->name, ['categories/update', 'id' => $model->category_id]);
                },
            ],
            [
                'attribute' => 'provider',
                'format' => 'html',
                'label' => Yii::t('app', 'Provider'),
                'contentOptions' => function ($model) use (&$groupProviders, $dataProvider) {
                    if ((isset($_GET['GoodsSearch']['group']) && $_GET['GoodsSearch']['group'] === 'provider')
                        && $_GET['sort'] === 'provider') {
                        if (in_array($model->provider_id, array_keys($groupProviders))) {
                            $count = count(array_filter($dataProvider->getModels(), function ($item) use ($model) {
                                return $item->provider_id === $model->provider_id;
                            }));
                            return [
                                'rowspan' => $count,
                                'style' => 'text-align: center; vertical-align:middle'
                            ];
                        }
                        return ['style' => 'display:none'];
                    }

                    return [];
                },
                'value' => function ($model) use (&$groupProviders) {
                    if ((isset($_GET['GoodsSearch']['group']) && $_GET['GoodsSearch']['group'] === 'provider')
                        && $_GET['sort'] === 'provider') {
                        if (in_array($model->provider_id, array_keys($groupProviders))) {
                            unset($groupProviders[$model->provider_id]);

                            return Html::a($model->provider->name, ['providers/update', 'id' => $model->provider_id]);
                        }
                        return false;
                    }

                    return Html::a($model->provider->name, ['providers/update', 'id' => $model->provider_id]);
                },
                'filter' => $providers,
            ],
        ],
    ]); ?>
</div>
