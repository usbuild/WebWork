<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    public function getId() {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        return $user->id;
    }
    public function getName() {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        return $user->name;
    }
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        if (empty($user)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (Common::validatePass($this->password, $user->salt, $user->password)) {
            $this->errorCode = self::ERROR_NONE;
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        return !$this->errorCode;
    }
}