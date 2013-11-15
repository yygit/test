<?php
class m131115_234815_insert_admin extends TXDbMigration{

    public function up() {
        $this->insert('user',array(
            'username'=>'admin',
            'email'=>'admin@sample.com',
            'pass'=>'66af66db312bbea40fdb6caa8e74cee108983adb77141f9bb1a3c17fbf63588d',
            'type'=>'admin',
        ));
    }

    public function down() {
        $this->delete('user',"`username`= 'admin'");
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()		{
    }

    public function safeDown()		{
    }
    */
}
