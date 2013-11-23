<?php
abstract class TrackStarAR extends CActiveRecord{

    public function init() {
        $this->attachEventHandler('onBeforeSave', array($this, 'assignIds'));
    }

    /**
     * assign creator and updator user ids to the model
     */
    public function assignIds() {
        $id = Yii::app()->user->id;
        if ($id === null)
            throw new CHttpException(404, 'The associated user is NOT authenticated.');
        $this->update_user_id = $id;
        if ($this->isNewRecord)
            $this->create_user_id = $id;
    }

    /**
     * Attaches the timestamp behavior to update our create and update
    times
     */
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
            ),
        );
    }
}
