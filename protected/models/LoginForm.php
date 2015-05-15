<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel{
    public $username;
    public $password;
    public $rememberMe;

    /**
     * @var UserIdentity
     */
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('username, password', 'filter', 'filter' => 'trim'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me next time',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate())
                $this->addError('password', 'Incorrect username or password.');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            $login = Yii::app()->user->login($this->_identity, $duration);
            $this->setLastlogintime($login, 'User', 'last_login_time');
            return true;
        } else
            return false;
    }

    /**
     * Gets the approprate timestamp depending on the column type $attribute is
     *
     * @param string $arModel
     * @param string $attribute
     * @param boolean $login
     * @return mixed timestamp (eg unix timestamp or a mysql function)
     */
    private function setLastlogintime($login = FALSE, $arModel = 'User', $attribute = 'last_login_time') {
        if (!$login) return FALSE;
        $model = $arModel::model()->findByPk($this->_identity->getId());
        if (empty($model)) return FALSE;
        $columnType = $model->getTableSchema()->getColumn($attribute)->dbType;
        Yii::app()->user->setState('lastLogin', $model->$attribute); // previous session login time
        $model->$attribute = $this->getTimestampByColumnType($columnType);
        return $model->saveAttributes(array($attribute));
    }

    /**
     * @var array Maps column types to database method
     */
    private static $map = array(
        'datetime' => 'NOW()',
        'timestamp' => 'NOW()',
        'date' => 'NOW()',
    );

    /**
     * Returns the approprate timestamp depending on $columnType
     *
     * @param string $columnType $columnType
     * @return mixed timestamp (eg unix timestamp or a mysql function)
     */
    private function getTimestampByColumnType($columnType) {
        return isset(self::$map[$columnType]) ? new CDbExpression(self::$map[$columnType]) : time();
    }


}
