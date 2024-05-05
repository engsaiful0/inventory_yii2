<?php

class Users extends CActiveRecord {

    public $password2;
    public $userLevel;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'users';
    }

    public function rules() {
        return array(
            array('employee_id, username, password, password2', 'required'),
            array('username', 'unique', 'caseSensitive' => FALSE, 'message' => 'Username already exist! Please choose another.'),
            array('id, employee_id, is_pos_user, is_authorizer', 'numerical', 'integerOnly' => true),
            array('username, password, password2', 'length', 'max' => 20, 'min' => 6),
            array('pin_code', 'length', 'max' => 6, 'min' => 4),
            array('password', 'compare', 'compareAttribute' => 'password2'),
            array('real_password, real_pin_code', 'length', 'max' => 255),
            array('pin_code', 'isPinCodeEmpty'),
            array('id, employee_id, username, is_pos_user, is_authorizer, create_by, create_time, update_by, update_time', 'safe', 'on' => 'search'),
        );
    }
    
    public function isPinCodeEmpty() {

        if ($this->is_authorizer == 1) {
            if ($this->pin_code == '')
                $this->addError('pin_code', 'PIN is required for Authorizer !');
        }else {
            if ($this->pin_code != '')
                $this->addError('pin_code', 'PIN is only required for Authorizer !');
        }
    }

    public function relations() {
        return array(
           
        );
    }
    
    public function getFullName(){
        $empInfo = Employees::model()->findByPk($this->employee_id);
        if ($empInfo)
            return $empInfo->full_name;
    }

    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
    }

    public function hashPassword($password) {
        return md5($password);
    }

    public function beforeSave() {
        $this->real_password=$this->password;
        $this->real_pin_code=$this->pin_code;
        $this->password = md5($this->password);
        $this->pin_code = md5($this->pin_code);
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
            $this->create_by = Yii::app()->user->getName();
        } else {
            $this->update_time = new CDbExpression('NOW()');
            $this->update_by = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }
    
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        self::model()->rrmdir($dir . "/" . $object); else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'userLevel' => 'User Level',
            'employee_id' => 'Employee',
            'username' => 'User Name',
            'password' => 'Password',
            'password2' => 'Repeat Password',
            'real_password'=>'Password',
            'is_pos_user' => 'Is POS User',
            'is_authorizer' => 'Is POS Authorizer',
            'pin_code' => 'PIN',
            'real_pin_code' => 'PIN',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'update_by' => 'Update By',
            'update_time' => 'Update Time',
        );
    }
    
    public function isPosAuthorizer($is_authorizer) {
        if ($is_authorizer == 1)
            echo "<font style='color: red; font-weight: bold;'>YES</font>";
    }

    public function isPosUser($is_pos_user) {
        if ($is_pos_user == 1)
            echo "<font style='color: red; font-weight: bold;'>YES</font>";
    }

    public function posUsers() {
        $condition = "is_pos_user=1";
        $data = self::model()->findAll(array('condition' => $condition));
        return $data;
    }
    
    public function fullEmpInfoOfThis($id) {
        $data = self::model()->findByPk($id);
        if ($data) {
            $empInfo = Employees::model()->findByPk($data->employee_id);
            if ($empInfo)
                return $empInfo;
        }
    }

    public function fullNameOfThis($id) {
        $data = self::model()->findByPk($id);
        if ($data) {
            $empInfo = Employees::model()->findByPk($data->employee_id);
            if ($empInfo)
                return $empInfo->full_name."(".Designations::model()->infoOfThis($empInfo->designation_id).")";
        }
    }
    
    public function fullNameOfThisOnlyName($id) {
        $data = self::model()->findByPk($id);
        if ($data) {
            $empInfo = Employees::model()->findByPk($data->employee_id);
            if ($empInfo)
                return $empInfo->full_name;
        }
    }
    
    public function userNameOfThis($id){
        $data = self::model()->findByPk($id);
        if ($data) {
            return $data->username;
        }
    }

    public function findAllRolesOfThisUser($id) {
        echo "
            <style>
                span.userLevelSpan{
                    color: #FFFFFF;
                    display: block;
                    float: left;
                    height: 100%;
                    padding: 2px;
                    width: 98%;
                }
            </style>
        ";
        if(Rights::getAuthorizer()->isSuperuser($id)===true ){
            $roles = Rights::getAssignedRoles($id);
            foreach ($roles as $role):
                echo "<span class='userLevelSpan' style='background-color: red;'>".$role->name . "</span><br>";
            endforeach;
        }else{
            $roles = Rights::getAssignedRoles($id);
            foreach ($roles as $role):
                echo "<span class='userLevelSpan' style='background-color: seagreen;'>".$role->name . "</span><br>";
            endforeach;
        }
    }

    public function allAvailableRoles() {
        Yii::import("application.modules.rights.components.dataproviders.RAuthItemDataProvider");
        $all_roles = new RAuthItemDataProvider('roles', array(
                    'type' => 2, // type 2 means all roles;
                ));
        $data = $all_roles->fetchData();
        return CHtml::dropDownList("Type", '', CHtml::listData($data, 'name', 'name'), array('prompt' => ''));
    }

    public function allUsersOfAParticularRole($roleName) {
        $data_entry_users = Yii::app()->getAuthManager()->getAssignmentsByItemName($roleName);
        $data_entry_users_id = array();
        foreach ($data_entry_users as $id => $assignment):
            $data_entry_users_id[] = $id;
        endforeach;
        
        return $data_entry_users_id;
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('is_pos_user', $this->is_pos_user);
        $criteria->compare('is_authorizer', $this->is_authorizer);
        $criteria->compare('create_by', $this->create_by, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_by', $this->update_by, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'username ASC',
            ),
        ));
    }

}