<?php

/**
 * This is the model class for table "tbl_project".
 *
 * The followings are the available columns in table 'tbl_project':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Issue $issues
 * @property User $updateUser
 * @property User $createUser
 * @property User $users array of User models type AR
 * @method array() assignedUsers() defined in scopes()
 */
class Project extends TrackStarAR{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_project';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description', 'required'),
            array('name', 'filter', 'filter' => 'strip_tags'),
            array('name', 'filter', 'filter' => 'trim'),
            array('create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, create_time, create_user_id, update_time, update_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'issues' => array(self::HAS_MANY, 'Issue', 'project_id'),
            'users' => array(self::MANY_MANY, 'User', 'tbl_project_user_assignment(project_id, user_id)'),
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_user_id', $this->update_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array of valid users for this project, indexed by user IDs
     */
    public function getUserOptions() {
        $usersArray = CHtml::listData($this->users, 'id', 'username');
        return $usersArray;
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
            )
        );
    }

    /**
     * print attribute(s) of related models that are in MANY_MANY relation
     * @param $model CActiveRecord parent model
     * @param string $relation
     * @param null $attr
     * @return string
     */
    public static function printNames($model, $relation = 'users', $attr = null) {
        if (empty($model->$relation)) return '';
        $names = '';
        foreach ($model->$relation as $v) {
            if ($attr)
                $names .= print_r($v->$attr, true);
            else
                $names .= print_r($v->attributes, true);
            $names .= ', ';
        }
        return CHtml::encode(rtrim($names, ', '));
    }

    /**
     * list attribute(s) of related models that are in MANY_MANY relation; used in ProjectController::accessRules()
     * @param $model CActiveRecord parent model
     * @param string $relation
     * @param null|string $attr
     * @return array
     */
    public static function listRelatedAttr($model, $relation = 'users', $attr = null) {
        $ids = array();
        if (empty($model->$relation)) return $ids;
        foreach ($model->$relation as $v) {
            if ($attr AND isset($v->$attr))
                $ids[] = $v->$attr;
            else
                $ids[] = print_r($v->attributes, true);
        }
        return $ids;
    }

    /**
     * @return array
     */
    public function scopes() {
        $user = Yii::app()->user;
        if (empty($user->id) OR empty($user->name) OR $user->name === Yii::app()->params['God'])
            return array(
                'assignedUsers' => array(),
            );

        return array(
            'assignedUsers' => array(
                'join' => 'JOIN ' . ProjectUserAssignment::tableName() . ' t1 ON t1.project_id=t.id AND t1.user_id=' . $user->id,
            )
        );
    }

    /**
     * Assigns a user, in a specific role, to the project
     * @param int $userId the primary key for the user
     * @param string $role the role assigned to the user for the project
     * @return boolean
     */
    public function assignUser($userId, $role) {
        $command = Yii::app()->db->createCommand();
        return (boolean)$command->insert('tbl_project_user_assignment', array(
            'role' => $role,
            'user_id' => $userId,
            'project_id' => $this->id,
        ));
    }

    /**
     * Removes a user from being associated with the project
     * @param int $userId the primary key for the user
     */
    public function removeUser($userId) {
        $command = Yii::app()->db->createCommand();
        return (boolean)$command->delete('tbl_project_user_assignment', 'user_id=:userId AND project_id=:projectId', array(':userId' => $userId, ':projectId' => $this->id));
    }

    /**
     * Determines whether or not the current application user is in the role for the project
     * @param string $role the role assigned to the user for the project
     * @return boolean whether or not the user is in the role for this project
     */
    public function allowCurrentUser($role) {
        $sql = "SELECT * FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId AND role=:role";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":projectId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
        $command->bindValue(":role", $role, PDO::PARAM_STR);
        return $command->execute() == 1 ? true : false;
    }

    /** get user role for the given project
     * @param $userId int
     * @return string|null
     */
    public function getProjectUserRole($userId) {
        $sql = "SELECT role FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":projectId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", $userId, PDO::PARAM_INT);
        $r = $command->queryRow();
        return !empty($r) ? reset($command->queryRow()) : null;
    }

    public function sameRoleLeft($userId, $role, $count=0) {
        $sql = "SELECT * FROM tbl_project_user_assignment WHERE user_id=:userId AND role=:role";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":userId", $userId, PDO::PARAM_INT);
        $command->bindValue(":role", $role, PDO::PARAM_STR);
        return ($command->execute() > $count) ? true : false;
    }

    /**
     * Returns an array of available roles in which a user can be placed when being added to a project
     */
    public static function getUserRoleOptions() {
        return CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name');
    }

    /**
     * Determines whether or not a user is already part of a project
     */
    public function isUserInProject($user) {
        $sql = "SELECT user_id FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":projectId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", $user->id, PDO::PARAM_INT);
        return $command->execute() == 1;
    }


}
