<?php
/**
 * ProjectUserForm class.
 * ProjectUserForm is the data structure for keeping
 * the form data related to adding an existing user to a project. It is used by the 'Ad-duser' action of 'ProjectController'.
 */
class ProjectUserForm extends CFormModel{
    /**
     * @var string username of the user being added to the project
     */
    public $username;

    /**
     * @var string the role to which the user will be associated within the project
     */
    public $role;

    /**
     * @var Project object an instance of the Project AR model class
     */
    public $project;

    /**
     * @var User
     */
    private $_user;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated using the verify() method
     */
    public function rules() {
        return array(
            // username and role are required
            array('username', 'required'),
            array('role', 'required', 'on' => 'insert'),
            //username needs to be checked for existence
            array('username', 'exist', 'className' => 'User'),
            array('username', 'verify'),
        );
    }


    /**
     * Authenticates the existence of the user in the system.
     * If valid, it will also make the association between the user, role and project
     * This is the 'verify' validator as declared in rules().
     */
    public function verify($attribute, $params) {
        if (!$this->hasErrors()) { // we only want to authenticate when no other input errors are present
            $user = User::model()->findByAttributes(array('username' => $this->username));
            if ($this->project->isUserInProject($user) and $this->scenario == 'insert') {
                $this->addError('username', '"' . $this->username . '" has already been added to the project.');
            } elseif (!$this->project->isUserInProject($user) and $this->scenario !== 'insert') {
                $this->addError('username', '"' . $this->username . '" is not associated with the project.');
            } else {
                $this->_user = $user;
            }
        }
    }

    /**
     * 1) assign user to a certain project 2) assign user and bizrule to a certain AuthManager role
     * @return bool
     */
    public function assign() {
        if ($this->_user instanceof User) {

            $tr1 = Yii::app()->db->beginTransaction();
            $assignUser = $this->project->assignUser($this->_user->id, $this->role); //assign the user, in the specified role, to the project
            $auth = Yii::app()->authManager;
            $bizRule = 'return isset($params["project"]) && $params["project"]->allowCurrentUser("' . $this->role . '");';

            $tr2 = Yii::app()->db->beginTransaction();
            $assign = $auth->assign($this->role, $this->_user->id, $bizRule); //add the association, along with the RBAC biz rule, to our RBAC hierarchy
            if (!$assignUser or !$assign)
                throw new CException('DB insert or Auth assign failed');

            $tr1->commit();
            $tr2->commit();

            return true;
        } else {
            $this->addError('username', 'Error when attempting to assign this user to the project.');
            return false;
        }
    }

    /**
     * 1) dis-assign user from a certain project 2) dis-assign user from a certain AuthManager role
     * @return bool
     */
    public function disAssign() {
        if ($this->_user instanceof User) {

            $tr1 = Yii::app()->db->beginTransaction();
            $removeUser = $this->project->removeUser($this->_user->id); // dis-assign the user from the project
            $auth = Yii::app()->authManager;
            $role = end(array_keys(Yii::app()->authManager->getAuthAssignments($this->_user->id)));

            $tr2 = Yii::app()->db->beginTransaction();
            $revoke = $auth->revoke($role, $this->_user->id); // remove auth association, along with the RBAC biz rule from the RBAC hierarchy
            if (!$revoke or !$removeUser)
                throw new CException('DB removal or Auth revocation failed');

            $tr1->commit();
            $tr2->commit();

            return true;
        } else {
            $this->addError('username', 'Error when attempting to revoke this user from the project.');
            return false;
        }
    }

    /**
     * Generates an array of usernames to use for the autocomplete
     */
    public function createUsernameList() {
        $sql = "SELECT username FROM tbl_user";
        $command = Yii::app()->db->createCommand($sql);
        $rows = $command->queryAll();
        //format it for use with auto complete widget
        $usernames = array();
        foreach ($rows as $row) {
            $usernames[] = $row['username'];
        }
        return $usernames;
    }
}
