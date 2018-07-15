<?php

namespace frontend\models\search;

use common\models\Category;
use common\models\Provider;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    public $category;
    public $provider;
    public $group;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'provider_id'], 'integer'],
            [['category', 'provider', 'name', 'description', 'image', 'created_at', 'updated_at', 'group'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'group' => Yii::t('app', 'Group By')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goods::find()->joinWith(['category', 'provider']);
        $categoryProperty = Category::tableName() . '.name';
        $providerProperty = Provider::tableName() . '.name';
        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['category'] = [
            'asc' => [$categoryProperty => SORT_ASC],
            'desc' => [$categoryProperty => SORT_DESC],
        ];

        $dataProvider->sort->attributes['provider'] = [
            'asc' => [$providerProperty => SORT_ASC],
            'desc' => [$providerProperty => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.price' => $this->price,
            self::tableName() . '.category_id' => $this->category,
            self::tableName() . '.provider_id' => $this->provider,
            self::tableName() . '.created_at' => $this->created_at,
            self::tableName() . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', self::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', self::tableName() . '.image', $this->image]);

        return $dataProvider;
    }
}
