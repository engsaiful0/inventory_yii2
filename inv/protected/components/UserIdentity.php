<?php

class UserIdentity extends CUserIdentity {

    private $_id;
    private $_username;

    public function authenticate() {
        $record = Users::model()->findByAttributes(array('username' => $this->username));
        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$record->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $record->id;
            $this->_username = $record->username;
            Yii::app()->session->add('role',$record->role);// Set Session Value as role
            if($_SERVER['SERVER_NAME'] == Yii::app()->params->servername || $_SERVER['HTTP_HOST']==Yii::app()->params->serverhost)
                $this->errorCode = self::ERROR_NONE;
        }
        return!$this->errorCode;
    }

    public function getId() {
            return $this->_id;
    }

    public function getName() {
        return $this->_username;
    }
    
    

}