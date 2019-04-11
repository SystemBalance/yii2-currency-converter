<?php

namespace imanilchaudhari\CurrencyConverter\Cache\Model;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "currency_rate".
 *
 * @property string $from
 * @property string $to
 * @property double $rate
 * @property string $created_at
 */
class CurrencyRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate'], 'number'],
            [['created_at'], 'safe'],
            [['from', 'to'], 'string', 'max' => 3],
            [['from', 'to', 'rate', 'created_at'], 'unique', 'targetAttribute' => ['from', 'to', 'rate', 'created_at']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'from' => 'From',
            'to' => 'To',
            'rate' => 'Rate',
            'created_at' => 'Created At',
        ];
    }
}