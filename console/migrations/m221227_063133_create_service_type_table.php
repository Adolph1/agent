<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_type}}`.
 */
class m221227_063133_create_service_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'branch_id' => $this->integer()->notNull(),
            'created_by' => $this->string(200),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_type}}');
    }
}
