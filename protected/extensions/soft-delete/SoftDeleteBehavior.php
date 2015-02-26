<?php
/**
 * Class SoftDeleteBehavior
 * @method CActiveRecord getOwner()
 */
class SoftDeleteBehavior extends CActiveRecordBehavior{
    public $flagField = 'is_deleted';

    public function remove() {
        $this->getOwner()->{$this->flagField} = 1;
        return $this->getOwner();
    }

    public function restore() {
        $this->getOwner()->{$this->flagField} = 0;
        return $this->getOwner();
    }

    public function notRemoved() {
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->compare($this->flagField, 0);
        return $this->getOwner();
    }

    public function removed() {
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->compare($this->flagField, 1);
        return $this->getOwner();
    }

    public function isRemoved() {
        return (boolean)$this->getOwner()->{$this->flagField};
    }

    /**
     * see 'CActiveRecordBehavior and CModelBehavior' of yii-application-cookbook-2nd-edition-code-master\08\creating_model_behaviors\
     * this is to test behavior event; change to array(2,1) or array(0,3) etc and notice 'SoftDeleteBehaviorTest' error
     *
     * @param CEvent $event
     */
    /*public function beforeCount($event) {
        parent::beforeCount($event);
        $this->getOwner()->getDbCriteria()->addInCondition($this->flagField, array(0, 1));
    }*/

    /**
     * see 'Yii 1.1: How to implement an event and attach it in a behavior' http://www.yiiframework.com/wiki/481/how-to-implement-an-event-and-attach-it-in-a-behavior/
     * this is to test event inside a behavior; change to array(2,1) or array(0,3) etc and notice 'SoftDeleteBehaviorTest' error
     *
     * Declares events and the corresponding event handler methods.
     * If you override this method, make sure you merge the parent result to the return value.
     *
     * @return array events (array keys) and the corresponding event handler methods (array values).
     * @see CBehavior::events
     */
    public function events() {
        return array_merge(parent::events(), array(
            'onBeforeCount' => 'onBeforeCountHandler1',
        ));
    }

    /**
     * @param CEvent $event
     */
    public function onBeforeCountHandler1($event) {
        $this->getOwner()->getDbCriteria()->addInCondition($this->flagField, array(0, 1));
    }

}
