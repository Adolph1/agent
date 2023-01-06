<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%agent}}`.
 */
class m230104_143732_create_agent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agent}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'name' => $this->string(200)->notNull(),
            'phone_number' => $this->string(200),
            'location' => $this->string(200),
            'created_by' => $this->string(200),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%agent}}');
    }
}
