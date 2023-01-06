<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cash_book}}`.
 */
class m221212_113323_create_cash_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cash_book}}', [
            'id' => $this->primaryKey(),
            'branch_id' => $this->integer()->notNull(),
            'trn_dt' => $this->dateTime()->notNull(),
            'amount' => $this->decimal(20,2)->notNull(),
            'dr_glcode'  => $this->string(200),
            'dr_amount' => $this->decimal(20,2)->notNull(),
            'cr_amount' => $this->decimal(20,2)->notNull(),
            'cr_glcode' => $this->string(200),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cash_book}}');
    }
}
