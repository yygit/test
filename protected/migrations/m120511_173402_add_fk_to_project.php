<?php
class m120511_173402_add_fk_to_project extends CDbMigration{
    public function up() {
        //the tbl_project.create_user_id is a reference to tbl_user.id
        $this->addForeignKey("fk_project_create_user", "tbl_project", "create_user_id", "tbl_user", "id", "CASCADE", "RESTRICT");

        //the tbl_project.update_user_id is a reference to tbl_user.id
        $this->addForeignKey("fk_project_update_user", "tbl_project", "update_user_id", "tbl_user", "id", "CASCADE", "RESTRICT");

    }

    public function down() {
        $this->dropForeignKey('fk_project_update_user', 'tbl_project');
        $this->dropForeignKey('fk_project_create_user', 'tbl_project');
    }

}
