<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%commission}}`.
 */
class m210927_070723_create_commission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%commission}}', [
            'id' => $this->primaryKey(),
            'sales_agent_id' => $this->integer()->unique(),
            'commission_amount' => $this->decimal(20,2),
            'commission_account' => $this->string(200)->unique(),
            'maker' => $this->string(200),
            'maker_time' => $this->dateTime()
        ]);


        // creates index for column `sales_agent_id`
        $this->createIndex(
            'idx-commission-sales_agent_id',
            'commission',
            'sales_agent_id'
        );

        // add foreign key for table `service_type`
        $this->addForeignKey(
            'fk-commission-sales_agent_id',
            'commission',
            'sales_agent_id',
            'sales_agent',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%commission}}');
    }
}
