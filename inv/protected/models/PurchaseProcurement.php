<?php

class PurchaseProcurement extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return PurchaseProcurement the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'purchase_procurement';
    }

    public $maxSINo;
    public $sumQty;
    
    const LOCAL=16;
    const IMPORT=17;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('req_id, max_sl_no, supplier_id, store, item, department, order_type, order_sub_type, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty, cost', 'numerical'),
            array('req_no, sl_no, remarks', 'length', 'max' => 255),
            array('date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, req_no, sl_no, max_sl_no, date, supplier_id, store, item, department, qty, cost, remarks, order_type, order_sub_type, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'req_id'=>'PR ID',
            'req_no' => 'PR No',
            'sl_no' => 'PP No',
            'max_sl_no' => 'Max Sl No',
            'date' => 'Date',
            'store' => 'Store',
            'item' => 'Item',
            'department' => 'Department',
            'qty' => 'Requisition Qty',
            'cost' => 'Cost',
            'remarks' => 'Remarks',
            'supplier_id' => 'Supplier',
            'order_type'=>'LOCAL/IMPORT',
            'order_sub_type'=>'LOCAL/IMPORT(Types)',
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
            $this->updated_time = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->getId();
        }
        return parent::beforeSave();
    }
    
    public function itemOfThis($id){
        $data=self::model()->findByPk($id);
        if($data){
            $item = Items::model()->item($data->item);
            return $item;
        }else{
            echo "<font color='red'>Removed From PP</font>";
        }
    }
    
    public function update($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/editBtnBg.png'), array('/purchaseProcurement/update', 'sl_no' => $sl_no));
    }
    
    public function delete($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/deleteBtnBg.png'), array('/purchaseProcurement/delete', 'sl_no' => $sl_no));
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $assignedStores=  UserStore::model()->forSearchCondition();
        $criteria->addInCondition('store', $assignedStores);
        $criteria->compare('id', $this->id);
        $criteria->compare('req_no', $this->req_no);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('store', $this->store);
        $criteria->compare('item', $this->item);
        $criteria->compare('department', $this->department);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('order_sub_type', $this->order_sub_type);
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