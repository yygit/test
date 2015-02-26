<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 *
 * @property integer $id
 * @property string  $text
 * @property string  $title
 * @property integer $is_deleted
 * @method Post findByPk()
 * @method CActiveRecord removed() see SoftDeleteBehavior
 * @method CActiveRecord notRemoved() see SoftDeleteBehavior
 * @method CActiveRecord remove() see SoftDeleteBehavior
 * @method CActiveRecord restore() see SoftDeleteBehavior
 * @method bool isRemoved() see SoftDeleteBehavior
 */
class Post extends CActiveRecord{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_deleted', 'numerical', 'integerOnly' => TRUE),
            array('title', 'length', 'max' => 255),
            array('text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, text, title, is_deleted', 'safe', 'on' => 'search'),
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
            'text' => 'Text',
            'title' => 'Title',
            'is_deleted' => 'Is Deleted',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('text', $this->text, TRUE);
        $criteria->compare('title', $this->title, TRUE);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft-delete.SoftDeleteBehavior'
            ),
        );
    }
}
