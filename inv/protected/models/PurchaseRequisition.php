<?php

class PurchaseRequisition extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return PurchaseRequisition the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'purchase_requisition';
    }
    
    public $maxSINo;
    public $sumQty;
    public $startDate;
    public $endDate;
    public $category;
    public $supplier_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, store, item, created_by,superadmin_approved_by, updated_by,is_superadmin_approved, is_pp_created, department, store_req_id', 'numerical', 'integerOnly' => true),
            array('qty, cost', 'numerical'),
            array('sl_no, remarks', 'length', 'max' => 255),
            array('date,superadmin_approved_time, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sl_no, max_sl_no, date, store, item, department, qty, cost, remarks, created_by, created_time, updated_by, updated_time, is_pp_created,superadmin_approved_by,superadmin_approved_time,is_superadmin_approved', 'safe', 'on' => 'search'),
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
            'sl_no' => 'PR No',
            'max_sl_no' => 'Max Sl No',
            'date' => 'Date',
            'store'=>'Store',
            'store'=>'Store',
            'approve_to'=>'Approved By',
            'req_by'=>'Requisition By',
            'item' => 'Item',
            'department' => 'Department',
            'qty' => 'Requisition Qty',
            'cost' => 'Cost',
            'remarks' => 'Remarks',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'is_pp_created'=>'isPPcreated',
            'store_req_id'=>'Store Req ID',
            'superadmin_approved_by'=>'Superadmin Approved By',
            'superadmin_approved_time'=>'Superadmin Approved Time',
            'is_superadmin_approved'=>'isSuperAdminApproved',
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
    
    public function isPPcreated($is_pp_created){
        if($is_pp_created==0)
            echo "<font color='red'>Not Created !</font>";
        else
            echo "<font color='green'>Created</font>";
    }
    public function isSuperadminApproved($is_superadmin_approved){
        if(is_superadmin_approved==1){
            echo CHtml::image(Yii::app()->theme->baseUrl . "/images/approved.ico");
        }else{
            echo CHtml::image(Yii::app()->theme->baseUrl . "/images/pending.ico");
        }
    }
    public function approveAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Approve" value="Approve" onclick="allApprove'.$sl_no.'();$(\'#approveAll-dialog\').dialog(\'open\');" />';
    }
    
    public function prNoOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->sl_no;
    }
    
    public function totalPPqty($store_req_id){
        $criteria=new CDbCriteria();
        $criteria->select="sum(qty) as sumQty";
        $criteria->addColumnCondition(array("store_req_id"=>$store_req_id));
        $data=self::model()->findAll($criteria);
        $totalPRqty=0;
        if($data)
            $totalPRqty=end($data)->sumQty;
        return $totalPRqty;
    }
    
    public function procurement($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/purchaseProc.png'), array('/purchaseProcurement/create', 'sl_no' => $sl_no));
    }
    
    public function update($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/editBtnBg.png'), array('/purchaseRequisition/update', 'sl_no' => $sl_no));
    }
    
    public function delete($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/deleteBtnBg.png'), array('/purchaseRequisition/delete', 'sl_no' => $sl_no));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
     public function searchApprove() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched        
        $criteria = new CDbCriteria;
        $assignedStores=  UserStore::model()->forSearchCondition();
        $criteria->addColumnCondition(array('is_superadmin_approved'=>0));
        $criteria->addInCondition('store', $assignedStores);
        $criteria->compare('id', $this->id);
        $criteria->compare('store', $this->store);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('item', $this->item);
        $criteria->compare('department', $this->department);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('is_superadmin_approved', $this->is_superadmin_approved);
        $criteria->compare('superadmin_approved_by', $this->superadmin_approved_by);
        $criteria->compare('superadmin_approved_time', $this->superadmin_approved_time);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('is_pp_created', $this->is_pp_created);

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
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $assignedStores=  UserStore::model()->forSearchCondition();
        $criteria->addInCondition('store', $assignedStores);
        $criteria->compare('id', $this->id);
        $criteria->compare('store', $this->store);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('item', $this->item);
        $criteria->compare('department', $this->department);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('is_superadmin_approved', $this->is_superadmin_approved);
        $criteria->compare('superadmin_approved_by', $this->superadmin_approved_by);
        $criteria->compare('superadmin_approved_time', $this->superadmin_approved_time);
        $criteria->compare('is_pp_created', $this->is_pp_created);

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