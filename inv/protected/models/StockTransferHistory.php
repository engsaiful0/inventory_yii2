<?php

class StockTransferHistory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StockTransferHistory the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'stock_transfer_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_store, to_store, item, created_by, updated_by, rcv_by', 'numerical', 'integerOnly' => true),
            array('send_qty, rcv_qty', 'numerical'),
            array('send_date, rcv_date, created_time, updated_time, rcv_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, from_store, to_store, item, send_qty, rcv_qty, send_date, rcv_date, created_by, created_time, updated_by, updated_time, rcv_by, rcv_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'from_store' => 'Send From',
            'to_store' => 'Rcv To',
            'item' => 'Item',
            'send_qty' => 'Send Qty',
            'rcv_qty' => 'Rcv Qty',
            'send_date' => 'Send Date',
            'rcv_date' => 'Rcv Date',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'rcv_by' => 'Rcv By',
            'rcv_time' => 'Rcv Time',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria->addInCondition('to_store', $assignedStores);
        $criteria->addCondition(array('created_by'=>Yii::app()->user->getId()));
        $criteria->compare('id', $this->id);
        $criteria->compare('from_store', $this->from_store);
        $criteria->compare('to_store', $this->to_store);
        $criteria->compare('item', $this->item);
        $criteria->compare('send_qty', $this->send_qty);
        $criteria->compare('rcv_qty', $this->rcv_qty);
        $criteria->compare('send_date', $this->send_date, true);
        $criteria->compare('rcv_date', $this->rcv_date, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('rcv_by', $this->rcv_by);
        $criteria->compare('rcv_time', $this->rcv_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchForReceive(){
        $criteria = new CDbCriteria;
        $criteria->condition="send_qty > rcv_qty";
        $criteria->addCondition(array('created_by'=>Yii::app()->user->getId()));
//        $assignedStores = UserStore::model()->forSearchCondition();
//        $criteria->addInCondition('to_store', $assignedStores);
        $criteria->compare('id', $this->id);
        $criteria->compare('from_store', $this->from_store);
        $criteria->compare('to_store', $this->to_store);
        $criteria->compare('item', $this->item);
        $criteria->compare('send_qty', $this->send_qty);
        $criteria->compare('rcv_qty', $this->rcv_qty);
        $criteria->compare('send_date', $this->send_date, true);
        $criteria->compare('rcv_date', $this->rcv_date, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('rcv_by', $this->rcv_by);
        $criteria->compare('rcv_time', $this->rcv_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}