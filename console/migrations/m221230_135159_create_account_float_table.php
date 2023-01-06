<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account_float}}`.
 */
class m221230_135159_create_account_float_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account_float}}', [
            'id' => $this->primaryKey(),
            'trn_dt' => $this->date()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'branch_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'float_amount' => $this->decimal()->notNull(),
            'status' => $this->integer(),
            'maker' => $this->string(200),
            'maker_time' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account_float}}');
    }
}
