<?php
class m120511_173403_add_sample_data extends CDbMigration{

    public function up() {
        $this->insert('tbl_user', array(
            'id' => '1',
            'username' => 'admin',
            'email' => 'admin@sample.com',
            'password' => '21232f297a57a5a743894a0e4a801fc3',
            'create_user_id' => '1',
            'update_user_id' => '1',
        ));
        $this->insert('tbl_user', array(
            'id' => '2',
            'username' => 'demo',
            'email' => 'demo@sample.com',
            'password' => 'fe01ce2a7fbac8fafaed7c982a04e229',
            'create_user_id' => '1',
            'update_user_id' => '1',
        ));
        $this->insert('tbl_user', array(
            'id' => '3',
            'username' => 'user3',
            'email' => 'test3@notanaddress.com',
            'password' => '92877af70a45fd6a2ed7fe81e1236b78',
            'create_user_id' => '1',
            'update_user_id' => '1',
        ));
        $this->insert('tbl_project', array(
            'id' => '4',
            'name' => 'Project 1',
            'description' => 'description for project #1',
            'create_user_id' => '1',
            'update_user_id' => '2',
        ));
        $this->insert('tbl_issue', array(
            'id' => '3',
            'name' => 'Issue 1',
            'description' => 'description for issue #1',
            'project_id' => '4',
            'type_id' => '0',
            'status_id' => '0',
            'owner_id' => '1',
            'requester_id' => '2',
            'create_user_id' => '1',
            'update_user_id' => '1',
        ));
        $this->insert('tbl_project_user_assignment', array(
            'project_id' => '4',
            'user_id' => '1',
        ));
        $this->insert('tbl_project_user_assignment', array(
            'project_id' => '4',
            'user_id' => '2',
        ));
        $this->insert('tbl_project_user_assignment', array(
            'project_id' => '4',
            'user_id' => '3',
        ));
    }

    public function down() {
        $this->delete('tbl_user', "`id`= 1");
        $this->delete('tbl_user', "`id`= 2");
        $this->delete('tbl_user', "`id`= 3");
        $this->delete('tbl_project', "`id`= 4");
        $this->delete('tbl_issue', "`id`= 3");
        $this->delete('tbl_project_user_assignment', "`project_id`= 4");
    }
}
