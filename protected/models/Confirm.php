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
        return array(
            array('url, code', 'required'),
            array('url', 'filter', 'filter' => 'strip_tags'),
            array('url', 'filter', 'filter' => 'CHtml::encode'),
            array('url, code', 'filter', 'filter' => 'trim'),
            array('url', 'exist', 'className' => 'Confirm', 'message' => '{value} does not exist'),
//            array('code', 'exist', 'className' => 'Confirm', 'criteria' => array('condition'=>'t.url = "prohor"'), 'message' => '{value} does not exist'),
            array('code', 'exist', 'className' => 'Confirm', 'criteria' => array('condition' => 't.url = "' . $url . '"'), 'message' => '{value} does not exist'),
            array('isconfirmed', 'numerical', 'integerOnly' => TRUE),
            array('isconfirmed', 'checkConfirmed', 'value' => '1', 'message' => 'URL already confirmed.' ),
            array('url', 'length', 'max' => 128),
            array('code', 'length', 'max' => 64),
            // The following rule is used by search().
            array('id, url, code, isconfirmed', 'safe', 'on' => 'search'),
//            array('url', 'confirmUrl'),
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

    public function confirmUrl($attribute, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        if (trim($output) != '12345')
            $this->addError($attribute, 'Please upload file first.');
    }

    public function checkConfirmed($attribute, $params) {
        if ($this->{$attribute} == $params['value']) {
            $this->addError($attribute, $params['message']);
        }
    }

    public function setConfirmed() {
        if (!$this->getIsNewRecord())
            $this->saveAttributes(array('isconfirmed' => Confirm::CONFIRMED));
    }
}
