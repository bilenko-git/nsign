<?php

use yii\db\Migration;

class m170312_123258_dishes_and_ingredients extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';
        }

        $this->createTable('{{%dishes_and_ingredients}}', [
            'dish_id' => $this->integer(11)->notNull(),
            'ingredient_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('ix_dish',
            'dishes_and_ingredients', 
            ['dish_id', 'ingredient_id'], 
            true
        );
    }

    public function down()
    {

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
