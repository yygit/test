<?php
class GodUserIdentity extends CUserIdentity{

    private $_id;

    public function authenticate($substUser = 'demo') {
        $user = User::model()->findByAttributes(array('username' => $substUser));
        if (empty($user)) throw new CException('cannot find user "'.$substUser.'"');
        $this->_id = $user->id;
        return true;
    }

    public function getId() {
        return $this->_id;
    }
}
