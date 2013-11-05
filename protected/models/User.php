<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $pass
 * @property string $type
 * @property string $date_entered
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property File[] $files
 * @property Page[] $pages
 */
class User extends CActiveRecord{

    public $passCompare; // Needed for registration!

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
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, pass, type, date_entered', 'required'),
            array('passCompare', 'required', 'on' => 'insert, update'),
            array('username', 'length', 'max' => 45),
            array('email', 'length', 'max' => 60),
            array('pass', 'length', 'max' => 64),
            array('type', 'length', 'max' => 6),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, email, pass, type, date_entered', 'safe', 'on' => 'search'),
            array('pass', 'compare', 'compareAttribute' => 'passCompare', 'on' => 'insert, update'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
            'files' => array(self::HAS_MANY, 'File', 'user_id'),
            'pages' => array(self::HAS_MANY, 'Page', 'user_id'),
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
            'pass' => 'Pass',
            'passCompare' => 'passCompare',
            'type' => 'Type',
            'date_entered' => 'Date Entered',
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
        $criteria->select = array('*', new CDbExpression('DATE_FORMAT(t.date_entered,"%Y-%m-%d") AS date_entered'));

        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('pass', $this->pass, true);
        $criteria->compare('type', $this->type, true);
//      $criteria->compare('date_entered', $this->date_entered, true);
        if (isset($this->date_entered) && preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $this->date_entered)) {
            $criteria->condition = 'DATE_FORMAT(date_entered,"%Y-%m-%d") = :de';
            $criteria->params = array(':de' => $this->date_entered);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function init() {
        $this->attachEventHandler('onBeforeSave', array($this, 'encodePass'));
    }

    public function encodePass() {
//        if (!$this->isNewRecord) {
//            $this->pass = new CDbExpression('SHA2(:pass, 256)', array(':pass' => $this->pass));
        $this->pass = hash_hmac('sha256', $this->pass, Yii::app()->params['encryptionKey']);
//        }
    }

    public function defaultScope() {
        if (empty(Yii::app()->user->id) OR empty(Yii::app()->user->name) OR Yii::app()->user->name === Yii::app()->params['God']) {
            return array();
        }
        return array(
            'condition' => 'id=' . Yii::app()->user->id,
        );
    }
}
