<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $last_login_time
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property TblIssue[] $tblIssues
 * @property TblIssue[] $tblIssues1
 * @property TblProject[] $tblProjects
 * @property TblProject[] $tblProjects1
 * @property Project $userProjects
 *
 * @method array() myself() defined in @link self::scopes()
 *
 */
class User extends TrackStarAR{

    public $oldPassword = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email', 'required'),
            array('password, username', 'required', 'on' => 'insert'),
            array('username, email, password', 'filter', 'filter' => 'trim'),
            array('email', 'email'),
            array('username, email', 'length', 'max' => 255),
            array('password', 'length', 'max' => 255, 'allowEmpty' => true),
            array('username, email', 'unique'),
            array('last_login_time', 'unsafe'),
            array('username', 'unsafe', 'on' => 'update'),
            // Please remove those attributes that should not be searched.
            array('id, username, email, password, last_login_time, create_time, create_user_id, update_time, update_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tblIssues' => array(self::HAS_MANY, 'TblIssue', 'requester_id'),
            'tblIssues1' => array(self::HAS_MANY, 'TblIssue', 'owner_id'),
            'tblProjects' => array(self::HAS_MANY, 'TblProject', 'update_user_id'),
            'tblProjects1' => array(self::HAS_MANY, 'TblProject', 'create_user_id'),
            'userProjects' => array(self::MANY_MANY, 'TblProject', 'tbl_project_user_assignment(user_id, project_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'last_login_time' => 'Last Login Time',
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('last_login_time', $this->last_login_time, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_user_id', $this->update_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function init() {
        parent::init();
        $this->attachEventHandler('onBeforeSave', array($this, 'encodePass'));
    }

    public function encodePass() {
        if (!empty($this->password))
            $this->password = md5($this->password);
        elseif (empty($this->oldPassword))
            throw new CException('old pass is empty'); else
            $this->password = $this->oldPassword;
    }

    /**
     * @return array
     */
    public function scopes() {
        if (empty(Yii::app()->user->id) OR empty(Yii::app()->user->name) OR Yii::app()->user->name === Yii::app()->params['God'])
            return array(
                'myself' => array(),
            );

        return array(
            'myself' => array(
                'condition' => 'id=' . Yii::app()->user->id,
            )
        );
    }
}
