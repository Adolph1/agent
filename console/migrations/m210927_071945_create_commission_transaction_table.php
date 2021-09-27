<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%commission_transaction}}`.
 */
class m210927_071945_create_commission_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%commission_transaction}}', [
            'id' => $this->primaryKey(),
            'transaction_date' => $this->dateTime(),
            'subscriber_id' => $this->integer(),
            'sales_agent_code' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%commission_transaction}}');
    }
}
