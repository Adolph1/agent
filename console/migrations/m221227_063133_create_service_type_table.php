<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_type}}`.
 */
class m210927_063133_create_service_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            ''
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
