<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%agent_journal_line}}`.
 */
class m230105_100342_create_agent_journal_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agent_journal_line}}', [
            'id' => $this->primaryKey(),
            'trn_dt' => $this->dateTime()->notNull(),
            'journal_id' => $this->integer()->notNull(),
            'branch_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'money_in' => $this->decimal(20,2)->notNull(),
            'money_out' => $this->decimal(20,2)->notNull(),
            'trn_type' => $this->char(1)->notNull(),
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
        $this->dropTable('{{%agent_journal_line}}');
    }
}
