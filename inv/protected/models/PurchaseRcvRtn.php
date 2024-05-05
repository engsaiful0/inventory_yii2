<?php

class PurchaseRcvRtn extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return PurchaseRcvRtn the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'purchase_rcv_rtn';
    }
    
    public $remainingReceivableQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('challan_no,rtn_qty,rtn_date, rcv_date,store, rcv_qty,name_of_unit,return_unit,weightPerSack,noOfReceivedSack, cost', 'required', 'on'=>'update'),
            array('po_id, created_by, updated_by, return_by,store, supplier_id', 'numerical', 'integerOnly' => true),
            array('rcv_qty, rtn_qty, cost,noOfReceivedSack,weightPerSack', 'numerical'),
            array('challan_no, remarks,name_of_unit,return_unit, remarks_for_rcv', 'length', 'max' => 255),
            array('rcv_date, rtn_date, created_time, updated_time, return_time', 'safe'),
            array('rtn_qty, rtn_date', 'isExceedReturn', 'on'=>'returnScenario'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, challan_no, po_id,noOfReceivedSack,weightPerSack,store,name_of_unit,return_unit, supplier_id, rcv_date,name_of_unit, rcv_qty, rtn_date, rtn_qty, cost, remarks, remarks_for_rcv, created_by, created_time, updated_by, updated_time, return_by, return_time', 'safe', 'on' => 'search'),
        );
    }
    
    public function isExceedReturn() {

        if ($this->rtn_qty=="") {
            $this->addError('rtn_qty', 'Return qty can not be blank');
        }
        if ($this->rtn_qty > $this->rcv_qty) {
            $this->addError('rtn_qty', 'Return qty exceeds received qty!');
        }
        if ($this->rtn_date=="") {
            $this->addError('rtn_date', 'Return date can not be blank');
        }
        if($this->rtn_date < $this->rcv_date){
            $this->addError('rtn_qty', 'Can not return from the previous date of received date!');
        }
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
            'challan_no' => 'Challan No',
            'po_id' => 'PO No',
            'supplier_id'=>'Supplier',
            'rcv_date' => 'Receive Date',
            'rcv_qty' => 'Receive Qty',
            'name_of_unit'=>'Unit',
            'return_unit'=>'Unit of Weight',
            'noOfReceivedSack'=>'No of RCV Sack',
            'weightPerSack'=>'Weight/Sack',
            'rtn_date' => 'Return Date',
            'rtn_qty' => 'Return Qty',
            'cost'=>'Cost',
            'store'=>'Store',
            'remarks_for_rcv'=>'Remarks (Receive)',
            'remarks' => 'Remarks (Return)',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'return_by' => 'Returned By',
            'return_time' => 'Returned Time',
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
    
    public function receiveAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Receive" value="Receive" onclick="allReceive'.$sl_no.'();$(\'#receiveAll-dialog\').dialog(\'open\');" />';
    }
    
//    public function totalReceivedAmountOfThisSupplier($supplier_id) {
//        $totalAmount = 0;
//        $condition = "supplier_id=" . $supplier_id;
//        $data = self::model()->findAll(array('condition' => $condition,), 'id');
//        if ($data) {
//            foreach ($data as $d):
//                $poInfo= PurchaseOrder::model()->findByPk($d->po_id);
//                if($poInfo){
//                    $ppInfo=  PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
//                    if($ppInfo){
//                        $price=$ppInfo->cost;
//                        $actualReceivedQty=($d->rcv_qty-$d->rtn_qty);
//                        $amount=$actualReceivedQty*$price;
//                        $totalAmount=$amount+$totalAmount;
//                    }
//                }
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalReceivedAmountOfThisSupplierThisRange($supplier_id, $startDate, $endDate) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addBetweenCondition("rcv_date", $startDate, $endDate);
//        $criteria->addColumnCondition(array("supplier_id" => $supplier_id), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        if ($data) {
//            foreach ($data as $d):
//                $poInfo= PurchaseOrder::model()->findByPk($d->po_id);
//                if($poInfo){
//                    $ppInfo=  PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
//                    if($ppInfo){
//                        $price=$ppInfo->cost;
//                        $actualReceivedQty=($d->rcv_qty-$d->rtn_qty);
//                        $amount=$actualReceivedQty*$price;
//                        $totalAmount=$amount+$totalAmount;
//                    }
//                }
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalReceivedAmountOfThisSupplierThisDate($supplier_id, $date) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addColumnCondition(array("supplier_id" => $supplier_id, "rcv_date"=>$date), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        if ($data) {
//            foreach ($data as $d):
//                $poInfo= PurchaseOrder::model()->findByPk($d->po_id);
//                if($poInfo){
//                    $ppInfo=  PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
//                    if($ppInfo){
//                        $price=$ppInfo->cost;
//                        $actualReceivedQty=($d->rcv_qty-$d->rtn_qty);
//                        $amount=$actualReceivedQty*$price;
//                        $totalAmount=$amount+$totalAmount;
//                    }
//                }
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
    
    public function totalRcvAmount($po_id, $date, $startDate, $endDate){
        $totalAmount = 0;
        $criteria=new CDbCriteria();
        if($po_id!=null){
            $criteria->addColumnCondition(array("po_id" => $po_id), "AND", "AND");
        }
        if($date!=null){
            $criteria->addColumnCondition(array("rcv_date"=>$date), "AND", "AND");
        }
        if($startDate!=null && $endDate!=null){
            $criteria->addBetweenCondition("rcv_date", $startDate, $endDate, "AND");
        }
        
        $data = self::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $poInfo= PurchaseOrder::model()->findByPk($d->po_id);
                if($poInfo){
                    $ppInfo=  PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
                    if($ppInfo){
                        $price=$ppInfo->cost;
                        $actualReceivedQty=($d->rcv_qty-$d->rtn_qty);
                        $amount=$actualReceivedQty*$price;
                        $totalAmount=$amount+$totalAmount;
                    }
                }
            endforeach;
        }

        return $totalAmount;
    }
        public function supplierOfThisPoId($po_id) {
        $supplier_id = 0;
        $condition = "po_id=" . $po_id;
        $data = self::model()->findAll(array('condition' => $condition,), 'id');
       if ($data) {
            foreach ($data as $d):
                $supplier_id = $d->supplier_id;
            endforeach;
        }
        return $supplier_id;
    }
    
    public function availableQtyOfThisPurchaseId($id) {
        $availableQty = 0;
        $condition = "po_id=" . $id;
        $data = self::model()->findAll(array('condition' => $condition,), 'id');
        if ($data) {
            $totalReceived = 0;
            $totalReturned = 0;
            foreach ($data as $d):
                $totalReceived = $d->rcv_qty + $totalReceived;
                $totalReturned = $d->rtn_qty + $totalReturned;
            endforeach;

            $availableQty = $totalReceived - $totalReturned;
        }

        return $availableQty;
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
        $data2 = PurchaseProcurement::model()->findAll($criteria2);
        $req_id = array();
        if ($data2) {
            foreach ($data2 as $d2):
                $req_id[] = $d2->id;
            endforeach;
        }
        
        $criteria3 = new CDbCriteria;
        $criteria3->addInCondition('procurement_id', $req_id);
        $data3 = PurchaseOrder::model()->findAll($criteria3);
        $po_id = array();
        if ($data3) {
            foreach ($data3 as $d3):
                $po_id[] = $d3->id;
            endforeach;
        }
        $criteria->addInCondition('po_id', $po_id);

        if ($this->po_id != "") {
            $data4 = PurchaseOrder::model()->findAll(array("condition"=>"sl_no=".$this->po_id));
            $po_ids = array();
            if ($data4) {
                foreach ($data4 as $d4):
                    $po_ids[] = $d4->id;
                endforeach;
                $criteria->addInCondition('po_id', $po_ids);
            }else
                $criteria->compare('po_id', "0");
        }else
            $criteria->compare('po_id', $this->po_id);

        $criteria->compare('id', $this->id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('challan_no', $this->challan_no, true);
        $criteria->compare('rcv_date', $this->rcv_date, true);
        $criteria->compare('rcv_qty', $this->rcv_qty);
        $criteria->compare('name_of_unit', $this->name_of_unit);
        $criteria->compare('weightPerSack', $this->weightPerSack);
        $criteria->compare('noOfReceivedSack', $this->noOfReceivedSack);
        $criteria->compare('return_unit', $this->return_unit);
        $criteria->compare('store', $this->store);
        
        
        $criteria->compare('cost', $this->cost);
        $criteria->compare('rtn_date', $this->rtn_date, true);
        $criteria->compare('rtn_qty', $this->rtn_qty);
        $criteria->compare('remarks_for_rcv', $this->remarks_for_rcv, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('return_by', $this->return_by);
        $criteria->compare('return_time', $this->return_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}