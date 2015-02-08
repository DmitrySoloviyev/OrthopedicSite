<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id = null;
    private $_login = null;
    private $_password = null;

    public function __construct($name, $password)
    {
        $this->_login = $name;
        $this->_password = $password;
    }

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = null;
        $user = User::model()->findByAttributes([
            'login' => $this->_login,
            'is_deleted' => 0,
        ]);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (md5($this->_password) !== $user->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
//            $this->setState('role', $user->role);
            $this->setState('id', $user->id);
            $this->setState('login', $user->login);
            $this->username = $user->name;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

}
