<?php

/**
 * This is the model class for table "confirm".
 *
 * The followings are the available columns in table 'confirm':
 *
 * @property string  $id
 * @property string  $url
 * @property string  $code
 * @property integer $isconfirmed
 */
class Confirm extends CActiveRecord{

    const CONFIRMED = 1;
    public static $confirmedMessage = 'URL NOT confirmed !';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'confirm';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        $confirmArr = Yii::app()->request->getParam('Confirm');
        $url = empty($confirmArr) ? NULL : $confirmArr['url'];
        $code = empty($confirmArr) ? NULL : $confirmArr['code'];
        return array(
            array('url, code', 'required'),
            array('url', 'filter', 'filter' => 'strip_tags'),
            array('url', 'filter', 'filter' => 'CHtml::encode'),
            array('url, code', 'filter', 'filter' => 'trim'),
            array('url', 'length', 'max' => 128, 'skipOnError' => TRUE),
            array('url', 'exist', 'className' => 'Confirm', 'message' => '{value} does not exist', 'skipOnError' => TRUE),
            array('code', 'length', 'max' => 64, 'skipOnError' => TRUE),
            array('code', 'exist', 'className' => 'Confirm', 'criteria' => array('condition' => 't.url = "' . $url . '"'), 'message' => '{value} does not exist', 'skipOnError' => TRUE),
            array('url', 'RemoteFileValidator', 'code' => $code, 'message' => 'you must upload verify file first', 'skipOnError' => TRUE),
            // The following rule is used by search().
            array('id, url, code, isconfirmed', 'safe', 'on' => 'search'),
            array('isconfirmed', 'numerical', 'integerOnly' => TRUE, 'skipOnError' => TRUE),
            array('isconfirmed', 'checkConfirmed', 'value' => '1', 'message' => 'URL already confirmed.', 'searchAttr' => 'url', 'searchVal' => $url, 'skipOnError' => FALSE),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'code' => 'Code',
            'isconfirmed' => 'Isconfirmed',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, TRUE);
        $criteria->compare('url', $this->url, TRUE);
        $criteria->compare('code', $this->code, TRUE);
        $criteria->compare('isconfirmed', $this->isconfirmed);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Confirm the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * check if a given domain has already been confirmed
     *
     * @param $attribute
     * @param $params
     */
    public function checkConfirmed($attribute, $params) {
        if ($this->hasErrors() && $params['skipOnError'] == TRUE)
            return;
        $model = self::model()->findByAttributes(array($params['searchAttr'] => $params['searchVal']));
        if (empty($model))
            return;
        if ($model->{$attribute} == $params['value']) {
            /*
             * other errors are not important if this domain has been already confirmed
             */
            $this->clearErrors();
            $this->addError($attribute, $params['message']);
        }
    }

    public function setConfirmed() {
        if (!$this->getIsNewRecord())
            $this->saveAttributes(array('isconfirmed' => Confirm::CONFIRMED));
    }
}
