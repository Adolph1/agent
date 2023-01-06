<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m221229_071159_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'account_no' => $this->string(200)->unique()->notNull(),
            'agent_no' => $this->string(200)->notNull(),
            'service_provider_id' => $this->integer()->notNull(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'initial_balance' => $this->decimal(20,2),
            'maker' => $this->string(200),
            'maker_time' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }
}
