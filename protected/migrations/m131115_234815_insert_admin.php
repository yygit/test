<?php
class m131115_234815_insert_admin extends TXDbMigration{

    public function up() {
        $this->insert('user',array(
            'username'=>'admin',
            'email'=>'admin@sample.com',
            'pass'=>'e930f7b5d9a984bdf1e0422344833e591345b34f704c1abdbb19b97d3aad5afc',
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
