<?php

namespace common\models;

use common\models\traits\TimestampBehaviorsTrait;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $sort
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Goods[] $goods
 */
class Category extends \yii\db\ActiveRecord
{
    use TimestampBehaviorsTrait;

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['status'], 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
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
            'description' => Yii::t('app', 'Description'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Goods::className(), ['category_id' => 'id']);
    }

    /**
     * Метод проверяет включена ли категория
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->status === self::STATUS_ENABLED;
    }

    /**
     * Метод включения категории
     *
     * @return bool
     */
    public function enable(): bool
    {
        $this->status = self::STATUS_ENABLED;

        return $this->update(true, [
            'status'
        ]);
    }

    /**
     * Метод выключения категории
     *
     * @return bool
     */
    public function disable(): bool
    {
        $this->status = self::STATUS_DISABLED;

        return $this->update(true, [
            'status'
        ]);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DISABLED => Yii::t('app','Disabled'),
            self::STATUS_ENABLED => Yii::t('app', 'Enabled')
        ];
    }
}
