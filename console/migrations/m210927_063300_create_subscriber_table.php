<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber}}`.
 */
class m210927_063300_create_subscriber_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(200)->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'service_type_id' => $this->integer()->notNull(),
            'mobile_number' => $this->string(13)->notNull(),
            'email_address' => $this->string(200)->notNull(),
            'agent_code' => $this->string(200)->unique()->notNull(),
            'maker' => $this->string(200),
            'maker_time' => $this->dateTime(),
            'status' => $this->integer()
        ]);


        // creates index for column `service_type_id`
        $this->createIndex(
            'idx-subscriber-service_type_id',
            'subscriber',
            'service_type_id'
        );

        // add foreign key for table `service_type`
        $this->addForeignKey(
            'fk-subscriber-service_type_id',
            'subscriber',
            'service_type_id',
            'service_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriber}}');
    }
}
