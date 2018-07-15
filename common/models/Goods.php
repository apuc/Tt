<?php

namespace common\models;

use common\models\traits\TimestampBehaviorsTrait;
use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property string $image
 * @property int $category_id
 * @property int $provider_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property Provider $provider
 */
class Goods extends \yii\db\ActiveRecord
{
    use TimestampBehaviorsTrait;

    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['price'], 'number'],
            [['category_id', 'provider_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file'], 'image', 'extensions' => ['jpg', 'png', 'jpeg']],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['provider_id' => 'id']],
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
            'price' => Yii::t('app', 'Price'),
            'image' => Yii::t('app', 'Image'),
            'file' => Yii::t('app', 'File'),
            'category_id' => Yii::t('app', 'Category'),
            'provider_id' => Yii::t('app', 'Provider'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::className(), ['id' => 'provider_id']);
    }
}
