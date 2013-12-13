<?php
/**
 * MyCDbAuthManager, customizing CDbAuthManager
 */
class MyCDbAuthManager extends CDbAuthManager{

    /**
     * Return true if current user is 'God' user.
     * Performs access check for the specified user.
     * @param string $itemName the name of the operation that need access check
     * @param mixed $userId the user ID. This should can be either an integer and a string representing
     * the unique identifier of a user. See {@link IWebUser::getId}.
     * @param array $params name-value pairs that would be passed to biz rules associated
     * with the tasks and roles assigned to the user.
     * Since version 1.1.11 a param with name 'userId' is added to this array, which holds the value of <code>$userId</code>.
     * @return boolean whether the operations can be performed by the user.
     */
    public function checkAccess($itemName, $userId, $params = array()) {
        if (Yii::app()->user->name == Yii::app()->params['God']) return true;
        return parent::checkAccess($itemName, $userId, $params);
    }

    /**
     * NO Bizrule execution, Performs access check for the specified user.
     * @param string $itemName the name of the operation that need access check
     * @param mixed $userId the user ID. This should can be either an integer and a string representing
     * the unique identifier of a user. See {@link IWebUser::getId}.
     * with the tasks and roles assigned to the user.
     * Since version 1.1.11 a param with name 'userId' is added to this array, which holds the value of <code>$userId</code>.
     * @return boolean whether the operations can be performed by the user.
     */
    public function checkAccessNoBizrule($itemName, $userId=null) {
        if (Yii::app()->user->name == Yii::app()->params['God']) return true;
        $userId = empty($userId) ? Yii::app()->user->id : $userId;
        $assignments = $this->getAuthAssignments($userId);
        return $this->checkAccessRecursiveNoBizrule($itemName, $assignments);
    }


    /**
     * NO Bizrule execution, Performs access check for the specified user.
     * @param string $itemName the name of the operation that need access check
     * the unique identifier of a user. See {@link IWebUser::getId}.
     * with the tasks and roles assigned to the user.
     * @param array $assignments the assignments to the specified user
     * @return boolean whether the operations can be performed by the user.
     */
    protected function checkAccessRecursiveNoBizrule($itemName, $assignments) {
        if (($item = $this->getAuthItem($itemName)) === null)
            return false;
        Yii::trace('Checking permission "' . $item->getName() . '"', 'system.web.auth.CDbAuthManager');
        if (in_array($itemName, $this->defaultRoles))
            return true;
        if (isset($assignments[$itemName])) {
            return true;
        }
        $parents = $this->db->createCommand()
            ->select('parent')
            ->from($this->itemChildTable)
            ->where('child=:name', array(':name' => $itemName))
            ->queryColumn();
        foreach ($parents as $parent) {
            if ($this->checkAccessRecursiveNoBizrule($parent, $assignments))
                return true;
        }
        return false;
    }
}
