<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%money_transfer}}`.
 */
class m230102_042654_create_money_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%money_transfer}}', [
            'id' => $this->primaryKey(),
            'trn_dt' => $this->dateTime()->notNull(),
            'from_branch_id' => $this->integer()->notNull(),
            'to_branch_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(20,2)->notNull(),
            'description' => $this->string(200),
            'requested_by' => $this->string(200),
            'requested_time' => $this->dateTime(),
            'accepted_by' => $this->string(200),
            'accepted_time' => $this->dateTime()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%money_transfer}}');
    }
}
