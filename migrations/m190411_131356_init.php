<?php

use yii\db\Migration;

/**
 * Class m190411_131356_init
 */
class m190411_131356_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency_rate', [
            'from' => $this->string(3),
            'to' => $this->string(3),
            'rate' => $this->float(3),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('undx', 'currency_rate', ['from', 'to', 'rate', 'created_at'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190411_131356_init cannot be reverted.\n";

        return false;
    }

}
