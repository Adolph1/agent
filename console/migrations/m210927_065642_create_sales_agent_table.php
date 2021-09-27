<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sales_agent}}`.
 */
class m210927_065642_create_sales_agent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sales_agent}}', [
            'id' => $this->primaryKey(),
            'agent_name' => $this->string(200)->notNull(),
            'agent_code' => $this->string(200)->unique()->notNull(),
            'mobile_number' => $this->string(13)->notNull(),
            'email_address' => $this->string(200)->notNull(),
            'maker' => $this->string(200),
            'maker_time' => $this->dateTime(),
            'status' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sales_agent}}');
    }
}
