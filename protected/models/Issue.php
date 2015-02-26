<?php

/**
 * This is the model class for table "tbl_issue".
 *
 * The followings are the available columns in table 'tbl_issue':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $project_id
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $owner_id
 * @property integer $requester_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property User $requester
 * @property User $owner
 * @property Project $project
 * @property Comment $comments
 * @property int $commentCount
 * @method array owners() defined in scopes()
 * @method array assignedUsers() defined in scopes()
 */
class Issue extends TrackStarAR{

    const TYPE_BUG = 0;
    const TYPE_FEATURE = 1;
    const TYPE_TASK = 2;

    const STATUS_NOT_STARTED = 0;
    const STATUS_STARTED = 1;
    const STATUS_FINISHED = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Issue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_issue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'filter', 'filter' => 'strip_tags'),
            array('name', 'filter', 'filter' => 'CHtml::encode'),
            array('name', 'filter', 'filter' => 'trim'),
            array('project_id, type_id, status_id, owner_id, requester_id, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('type_id', 'in', 'range' => self::getAllowedTypeRange()),
            array('status_id', 'in', 'range' => self::getAllowedStatusRange()),
            array('owner_id', 'in', 'range' => Project::listRelatedAttr(Project::model()->findByPk($this->project_id), 'users', 'id'), 'on' => 'insert,update'),
            array('name', 'length', 'max' => 255),
            array('description, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, project_id, type_id, status_id, owner_id, requester_id, create_time, create_user_id, update_time, update_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'requester' => array(self::BELONGS_TO, 'User', 'requester_id'),
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
            'creator' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updator' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'issue_id'),
            'commentCount' => array(self::STAT, 'Comment', 'issue_id'),
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
            'project_id' => 'Project',
            'type_id' => 'Type',
            'status_id' => 'Status',
            'owner_id' => 'Owner',
            'requester_id' => 'Requester',
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
        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('owner_id', $this->owner_id);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_user_id', $this->update_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * Retrieves a list of issue types
     * @return Array an array of available issue types.
     */
    public function getTypeOptions() {
        return array(
            self::TYPE_BUG => 'Bug',
            self::TYPE_FEATURE => 'Feature',
            self::TYPE_TASK => 'Task',
        );
    }

    public function getAllowedTypeRange() {
        /*return array(
            self::TYPE_BUG,
            self::TYPE_FEATURE,
            self::TYPE_TASK,
        );*/
        return array_keys($this->getTypeOptions());
    }

    /**
     * Retrieves a list of issue statuses
     * @return Array an array of available issue statuses.
     */
    public function getStatusOptions() {
        return array(
            self::STATUS_NOT_STARTED => 'Not Yet Started',
            self::STATUS_STARTED => 'Started',
            self::STATUS_FINISHED => 'Finished',
        );
    }

    public function getAllowedStatusRange() {
        /*return array(
            self::STATUS_NOT_STARTED,
            self::STATUS_STARTED,
            self::STATUS_FINISHED,
        );*/
        return array_keys($this->getStatusOptions());
    }

    /**
     * @return string the status text display for the current issue
     */
    public function getStatusText() {
        $statusOptions = $this->getStatusOptions();
        return isset($statusOptions[$this->status_id]) ? $statusOptions[$this->status_id] : "unknown status ({$this->status_id})";
    }

    /**
     * @return string the type text display for the current issue
     */
    public function getTypeText() {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type_id]) ? $typeOptions[$this->type_id] : "unknown type ({$this->type_id})";
    }

    /**
     * @return array
     */
    public function scopes() {
        $user = Yii::app()->user;
        if (empty($user->id) OR empty($user->name) OR $user->name === Yii::app()->params['God'])
            return array(
                'owners' => array(),
                'assignedUsers' => array(),
            );

        return array(
            'owners' => array(
                'condition' => 't.owner_id=' . $user->id,
            ),
            'assignedUsers' => array(
                'join' => 'JOIN ' . ProjectUserAssignment::tableName() . ' t1 ON t1.project_id=t.project_id AND t1.user_id=' . $user->id,
            ),
        );
    }

    /**
     * Adds a comment to this issue
     * @param Comment $comment AR model for issue comment
     * @return bool
     */
    public function addComment(Comment $comment) {
        $comment->issue_id = $this->id;
        return $comment->save();
    }


}
