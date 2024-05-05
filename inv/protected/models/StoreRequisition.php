<?php

class StoreRequisition extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StoreRequisition the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'store_requisition';
    }
    
    public $maxSINo;
    public $startDate;
    public $endDate;
    public $category;
    public $sumOfQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, department, from_store, store, item, req_by, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            array('sl_no, remarks', 'length', 'max' => 255),
            array('req_date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sl_no, max_sl_no, remarks, department, from_store, store, item, qty, req_date, req_by, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'sl_no' => 'Store Requisition No',
            'max_sl_no' => 'Max Sl No',
            'remarks' => 'Remarks',
            'department' => 'Department',
            'from_store'=>'Req. From',
            'store' => 'Req. To',
            'item' => 'Item',
            'qty' => 'Requisition Qty',
            'req_date' => 'Requisition Date',
            'req_by' => 'Requisition By',
            'approve_by' => 'Approve By',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->getId();
        } else {
            
        }
        return parent::beforeSave();
    }
    
    public function itemOfThis($id){
        $data=self::model()->findByPk($id);
        if($data){
            $itemInfo = Items::model()->item($data->item);
            return $itemInfo;
        }else{
            echo "<font color='red'>Removed from SR</font>";
        }
    }
    
    public function update($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/editBtnBg.png'), array('/storeRequisition/update', 'sl_no' => $sl_no));
    }
    
    public function delete($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/deleteBtnBg.png'), array('/storeRequisition/delete', 'sl_no' => $sl_no));
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
        $criteria->addInCondition('store', $assignedStores);
        
        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('department', $this->department);
        $criteria->compare('from_store', $this->from_store);
        $criteria->compare('store', $this->store);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('req_date', $this->req_date, true);
        $criteria->compare('req_by', $this->req_by);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'sl_no DESC',
            ),
        ));
    }

}