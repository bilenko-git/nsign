<?php
use yii\db\Schema;
use yii\db\Migration;

class m170312_123155_ingredients extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0';
        }

        $this->createTable('{{%ingredients}}', [
            'id' => Schema::TYPE_PK,
            'ingredient' => Schema::TYPE_STRING . ' NOT NULL',
            'ingredient_active' => "enum('0', '1') NOT NULL DEFAULT '1'",
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%ingredients}}');
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


      