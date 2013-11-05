<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property string $user_id
 * @property string $page_id
 * @property string $comment
 * @property string $date_entered
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Page $page
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, page_id, comment, date_entered', 'required'),
			array('user_id, page_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, page_id, comment, date_entered', 'safe', 'on'=>'search'),
			array('comment', 'filter', 'filter'=>'strip_tags'),
			array('comment', 'filter', 'filter'=>'trim'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'page_id' => 'Page',
			'comment' => 'Comment',
			'date_entered' => 'Date Entered',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('date_entered',$this->date_entered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function init() 	{
		// $this->attachEventHandler('onBeforeSave', array($this,'addSig1'));
		// $this->attachEventHandler('onBeforeSave', array($this,'addSig2'));
		// $this->attachEventHandler('onBeforeSave', array($this,'trimComment'));		
	} 
	
	protected function addSig1($event){
		$this->comment .= ' ----- Signature #1 added at '.time().' called by '.get_class($event->sender);
		$event->handled = true;
	} 
	protected function addSig2($event){
		$this->comment .= ' ----- Signature #2 added at '.time();
	} 
	protected function trimComment($event){
		$this->comment = trim($this->comment);
	} 
	
	
	
}