<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_provider}}`.
 */
class m221212_113147_create_service_provider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_provider}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'created_by' => $this->string(200),
            'created_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_provider}}');
    }
}
