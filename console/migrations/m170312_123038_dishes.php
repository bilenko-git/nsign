<?php
use yii\db\Schema;
use yii\db\Migration;

class m170312_123038_dishes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0';
        }

        $this->createTable('{{%dishes}}', [
            'id' => Schema::TYPE_PK,
            'dish' => Schema::TYPE_STRING . ' NOT NULL',
            'dish_active' => "enum('0', '1') NOT NULL DEFAULT '1'",
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%dishes}}');
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
