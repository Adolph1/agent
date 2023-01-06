<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pay_bills}}`.
 */
class m230104_143807_create_pay_bills_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pay_bills}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'branch_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(20,2)->notNull(),
            'service_type_id' => $this->integer()->notNull(),
            'trn_dt' => $this->date()->notNull(),
            'reference_no' => $this->string(200),
            'status' => $this->integer(),
            'created_by' => $this->string(200),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pay_bills}}');
    }
}
