<?php

class UserStore extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return UserStore the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_store';
    }
    
    const ACTIVE=1;
    const INACTIVE=2;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, store_id, is_active', 'required'),
            array('user_id, store_id, is_active', 'numerical', 'integerOnly' => true),
//            array('store_id', 'unique', 'caseSensitive' => FALSE, 'message' => 'This store has already assigned to this user!'),
            array('store_id', 'isAlreadyAssigned'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, store_id, is_active', 'safe', 'on' => 'search'),
        );
    }
    
     public function isAlreadyAssigned() {
        $data=self::model()->findByAttributes(array('user_id'=>  $this->user_id, 'store_id'=>  $this->store_id));
        if ($data) {
            $this->addError('store_id', 'This store has already assigned to this user!');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }
    
    public function getStore_name(){
        $data=Stores::model()->findByPk($this->store_id);
        if($data)
            return $data->store_name;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'store_id' => 'Store',
            'is_active' => 'Is Active',
        );
    }
    
    public function assignedActiveStoresOfThisLoggedInUser($user_id){
        
        if(Rights::getAuthorizer()->isSuperuser($user_id)===true ){
            $stores = Stores::model()->findAll();
        }else{
            $stores=array();
            $condition = "user_id=" . $user_id." AND is_active=".self::ACTIVE;
            $data = self::model()->findAll(array('condition' => $condition,), 'id');
            foreach($data as $d):
                $stores[]=Stores::model()->findByPk($d->store_id);
            endforeach;
        }
        
        return CHtml::listData($stores, 'id', 'store_name');
    }

    public function assignedStoresOfThisUser($user_id) {
        if(Rights::getAuthorizer()->isSuperuser($user_id)===true ){
            echo "<font style='color: red; font-weight: bold;'>All Stores</font>";
        }else{
            $condition = "user_id=" . $user_id;
            $data = self::model()->findAll(array('condition' => $condition,), 'id');
            if ($data) {
                foreach ($data as $d):
                    echo Stores::model()->storeName($d->store_id);
                    echo " <img src='".Yii::app()->theme->baseUrl."/images/this.ico'/> ";
                    echo self::model()->statusColor($d->is_active);
                    echo "<br>";
                endforeach;
            }
        }
    }
    
    public function isThisStoreAssignedToThisUser($storeId){
        $userId=Yii::app()->user->getId();
        $data = self::model()->findByAttributes(array('user_id' => $userId, 'store_id'=>$storeId, 'is_active'=>self::ACTIVE));
        if($data)
            $isExist=1;
        else
            $isExist=0;
        
        return $isExist;
    }
    
    public function assignedActiveStoresOfThisLoggedInUserAllStores(){
        $userId=Yii::app()->user->getId();
        if(Rights::getAuthorizer()->isSuperuser($userId)===true ){
            $data = Stores::model()->findAll();
        }else{
            $condition = "user_id=" . $userId." AND is_active=".self::ACTIVE;
            $data = self::model()->findAll(array('condition' => $condition,), 'id');
        }
        
        return $data;
    }
    
    public function forSearchCondition(){
        $stores=array();
        $userId=Yii::app()->user->getId();
        if(Rights::getAuthorizer()->isSuperuser($userId)===true ){
            $data = Stores::model()->findAll();
            if($data){
                foreach($data as $d):
                    $stores[]=$d->id;
                endforeach;
            }
        }else{
            $condition = "user_id=" . $userId." AND is_active=".self::ACTIVE;
            $data = self::model()->findAll(array('condition' => $condition,), 'id');
            
            if($data){
                foreach($data as $d):
                    $stores[]=$d->store_id;
                endforeach;
            }
        }
        return $stores;
    }
    
    public function statusColor($is_active){
        if($is_active==self::ACTIVE)
            echo "<font style='color: green; font-weight: bold'>ACTIVE</font>";
        else
            echo "<font style='color: red; font-weight: bold'>INACTIVE</font>";
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('is_active', $this->is_active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}