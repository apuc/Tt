<?php

namespace common\models;

use common\models\traits\TimestampBehaviorsTrait;
use Yii;

/**
 * This is the model class for table "providers".
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Goods[] $goods
 */
class Provider extends \yii\db\ActiveRecord
{
    use TimestampBehaviorsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'providers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['sort'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Goods::className(), ['provider_id' => 'id']);
    }
}
