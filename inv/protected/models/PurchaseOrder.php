<?php

class PurchaseOrder extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return PurchaseOrder the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'purchase_order';
    }
    
    public $maxSINo;
    public $startDate;
    public $endDate;
    public $store;
    public $supplier_id;
    public $item;
    public $category;
    
    const NON_VERIFIED=0;
    const VERIFIED=1;
    
    public $sumQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('issue_date, order_qty,name_of_unit','required', 'on'=>'update'),
            array('max_sl_no, procurement_id, created_by, updated_by, is_verified', 'numerical', 'integerOnly' => true),
            array('order_qty', 'numerical'),
            array('sl_no, ref_no, subj, procurement_no,name_of_unit', 'length', 'max' => 255),
            array('issue_date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sl_no, max_sl_no, ref_no, procurement_no,name_of_unit, issue_date, procurement_id, order_qty, subj, created_by, created_time, updated_by, updated_time, is_verified', 'safe', 'on' => 'search'),
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
            'sl_no' => 'PO No',
            'max_sl_no' => 'Max Sl No',
            'ref_no' => 'Ref No',
            'issue_date' => 'Issue Date',
            'procurement_id' => 'Item',
            'procurement_no'=>'PP No',
            'name_of_unit'=>'Unit',
            'order_qty' => 'Order Qty',
            'purchase_order_by'=>'Purchase Order By',
            'approved_by'=>'Approved By',
            'subj' => 'Subject',
            'is_ordered'=>'Is Order Complete',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'is_verified'=>'isVerified',
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
    
    public function poNoOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->sl_no;
    }
    
    public function totalPOQtyForThis($id) {
        $criteria=new CDbCriteria();
        $criteria->select="sum(order_qty) as sumQty";
        $criteria->addColumnCondition(array("procurement_id"=>$id), "AND", "AND");
        $data=self::model()->findAll($criteria);
        $sumQty=0;
        if($data){
            $sumQty=end($data)->sumQty;
        }
        return $sumQty;
    }
    
    public function itemOfThis($id){
        $data=self::model()->findByPk($id);
        if($data){
            $item=PurchaseProcurement::model()->itemOfThis($data->procurement_id);
            return $item;
        }else{
            echo "<font color='red'>Removed From PO</font>";
        }
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
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data = PurchaseProcurement::model()->findAll($criteria2);
        $req_id = array();
        if ($data) {
            foreach ($data as $d):
                $req_id[] = $d->id;
            endforeach;
        }
        $criteria->addInCondition('procurement_id', $req_id);
        $criteria->compare('procurement_id', $this->procurement_id);
        $criteria->compare('procurement_no', $this->procurement_no);
        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('ref_no', $this->ref_no, true);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('order_qty', $this->order_qty);
        $criteria->compare('name_of_unit', $this->name_of_unit);
        $criteria->compare('subj', $this->subj, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('is_verified', $this->is_verified);

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
        public function isOrdered($is_ordered){
        if($is_ordered==0)
            echo "<font color='red'>Order Not Completed!</font>";
        else
            echo "<font color='green'>Order Completed</font>";
    }
    
    public function searchForPORcv() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data = PurchaseProcurement::model()->findAll($criteria2);
        $req_id = array();
        if ($data) {
            foreach ($data as $d):
                $req_id[] = $d->id;
            endforeach;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('procurement_id', $req_id);
        $criteria->addColumnCondition(array('is_verified'=>self::VERIFIED), "AND", "AND");
        
        $criteria->compare('procurement_id', $this->procurement_id);
        $criteria->compare('procurement_no', $this->procurement_no);
        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('ref_no', $this->ref_no, true);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('order_qty', $this->order_qty);
        $criteria->compare('name_of_unit', $this->name_of_unit);
        $criteria->compare('subj', $this->subj, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('is_verified', $this->is_verified);
        

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