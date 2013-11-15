<?php
class m131114_000001_base_data extends TXDbMigration{

    public function up() {
        $filePath = Yii::app()->basePath . '/data/sakila_0_up_migration.sql';
        $this->executeFile($filePath);
    }

    public function down() {
        $filePath = Yii::app()->basePath . '/data/sakila_0_down_migration.sql';
        $this->executeFile($filePath);
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()		{
    }

    public function safeDown()		{
    }
    */
}
