<?php
/**
 *
 */

namespace common\models\traits;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

trait TimestampBehaviorsTrait
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}