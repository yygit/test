<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity{

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    /*public function authenticate_bak() {
        $users = array(
            // username => password
            'demo' => 'demo',
            'admin' => 'admin',
            'readerA' => '123',
            'authorB' => '123',
            'editorC' => '123',
            'adminD' => '123',
        );
        if (!isset($users[$this->username]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($users[$this->username] !== $this->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
            $this->errorCode = self::ERROR_NONE;
        return !$this->errorCode;
    }*/
    public function authenticate() {
        $user = User::model()->findByAttributes(array(
            'username' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($user->pass !== hash_hmac('sha256', $this->password, Yii::app()->params['encryptionKey'])) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->setState('email', $user->email);
            $this->setState('type', $user->type);
            $this->_id = $user->id;
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }

}
