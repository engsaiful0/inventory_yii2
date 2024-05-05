<?php

class BasickSheetReqDR extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StoreReqDR the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'basick_sheet_req_d_r';
    }
    
    public $remainingDeliverableQty;
    public $stockQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('d_date, d_qty', 'required', 'on'=>'update'),
            array('req_id, created_by, updated_by, return_by, is_approved, approved_by', 'numerical', 'integerOnly' => true),
            array('d_qty, r_qty', 'numerical'),
            array('req_no, remarks', 'length', 'max' => 255),
            array('d_date, r_date, created_time, updated_time, return_time, approved_time', 'safe'),
            array('d_qty, r_date', 'isExceedReturn', 'on'=>'returnScenario'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, req_no, req_id, d_qty, d_date, r_qty, r_date, remarks, created_by, created_time, updated_by, updated_time, return_by, return_time, is_approved, approved_by, approved_time', 'safe', 'on' => 'search'),
        );
    }
    
    public function isExceedReturn() {

        if ($this->r_qty=="") {
            $this->addError('r_qty', 'Return qty can not be blank');
        }
        if ($this->r_qty > $this->d_qty) {
            $this->addError('r_qty', 'Return qty exceeds delivered qty!');
        }
        if ($this->r_date=="") {
            $this->addError('r_date', 'Return date can not be blank');
        }
        $currentDate=date('Y-m-d');
        if($this->d_date > $currentDate){
            $this->addError('r_qty', 'Can not return. Delivered date is a future date!');
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
            'req_no' => 'Requisition No',
            'req_id' => 'Item',
            'd_qty' => 'Sending Qty',
            'd_date' => 'Sending Date',
            'r_qty' => 'Return Qty',
            'r_date' => 'Return Date',
            'remarks' => 'Remarks',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Update By',
            'updated_time' => 'Update Time',
            'return_by'=>'Returned By',
            'return_time'=>'Returned Time',
            'is_approved'=>'isApproved',
            'approved_by'=>'Approved By',
            'approved_time'=>'Approved Time',
        );
    }
    
    public function isApproved($is_approved){
        if($is_approved==1){
            echo CHtml::image(Yii::app()->theme->baseUrl . "/images/approved.ico");
        }else{
            echo CHtml::image(Yii::app()->theme->baseUrl . "/images/pending.ico");
        }
    }
    
    public function isApprovedOnlyText($is_approved){
        if($is_approved==1){
            echo "<font color='green'>APPROVED</font>";
        }else{
            echo "<font color='red'>PENDING</font>";
        }
    }
    
    public function createPRAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Create" value="Create" onclick="allDelivery'.$sl_no.'();$(\'#deliveryAll-dialog\').dialog(\'open\');" />';
    }
    
    public function deliveryAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Send" value="Send" onclick="allDelivery'.$sl_no.'();$(\'#deliveryAll-dialog\').dialog(\'open\');" />';
    }
    
    public function approveAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Approve" value="Approve" onclick="allApprove'.$sl_no.'();$(\'#approveAll-dialog\').dialog(\'open\');" />';
    }
    
   public function availableQtyOfThisReqId($id) {
        $availableQty = 0;
        $condition = "req_id=" . $id;
        $data = self::model()->findAll(array('condition' => $condition,), 'id');
        if ($data) {
            $totalDelivered = 0;
            $totalReturned = 0;
            foreach ($data as $d):
                $totalDelivered = $d->d_qty + $totalDelivered;
                $totalReturned = $d->r_qty + $totalReturned;
            endforeach;

            $availableQty = $totalDelivered - $totalReturned;
        }

        return $availableQty;
    }
    
    public function approvedByOfThisReqId($id){
        $data=self::model()->findByAttributes(array("req_id"=>$id));
        $approvedBy="";
        if($data){
            $approvedBy=$data->approved_by;
        }
        return $approvedBy;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    
    public function searchApprove() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data2 = BasickSheetRequisition::model()->findAll($criteria2);
        $req_id = array();
        if ($data2) {
            foreach ($data2 as $d2):
                $req_id[] = $d2->id;
            endforeach;
        }
        $criteria->addInCondition('req_id', $req_id);
        $criteria->addColumnCondition(array('is_approved'=>0));
        $criteria->compare('id', $this->id);
        $criteria->compare('req_no', $this->req_no, true);
        $criteria->compare('req_id', $this->req_id);
        $criteria->compare('d_qty', $this->d_qty);
        $criteria->compare('d_date', $this->d_date, true);
        $criteria->compare('r_qty', $this->r_qty);
        $criteria->compare('r_date', $this->r_date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('return_by', $this->return_by);
        $criteria->compare('return_time', $this->return_time, true);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('approved_time', $this->approved_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'req_no, req_id DESC',
            ),
        ));
    }
    
    
    public function searchReturn() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data2 = BasickSheetRequisition::model()->findAll($criteria2);
        $req_id = array();
        if ($data2) {
            foreach ($data2 as $d2):
                $req_id[] = $d2->id;
            endforeach;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('req_id', $req_id);
        $criteria->addColumnCondition(array('is_approved'=>1));
        $criteria->compare('id', $this->id);
        $criteria->compare('req_no', $this->req_no, true);
        $criteria->compare('req_id', $this->req_id);
        $criteria->compare('d_qty', $this->d_qty);
        $criteria->compare('d_date', $this->d_date, true);
        $criteria->compare('r_qty', $this->r_qty);
        $criteria->compare('r_date', $this->r_date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('return_by', $this->return_by);
        $criteria->compare('return_time', $this->return_time, true);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('approved_time', $this->approved_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'req_no, req_id DESC',
            ),
        ));
    }
    
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data2 = BasickSheetRequisition::model()->findAll($criteria2);
        $req_id = array();
        if ($data2) {
            foreach ($data2 as $d2):
                $req_id[] = $d2->id;
            endforeach;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('req_id', $req_id);

        $criteria->compare('id', $this->id);
        $criteria->compare('req_no', $this->req_no, true);
        $criteria->compare('req_id', $this->req_id);
        $criteria->compare('d_qty', $this->d_qty);
        $criteria->compare('d_date', $this->d_date, true);
        $criteria->compare('r_qty', $this->r_qty);
        $criteria->compare('r_date', $this->r_date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('return_by', $this->return_by);
        $criteria->compare('return_time', $this->return_time, true);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('approved_time', $this->approved_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'req_no, req_id DESC',
            ),
        ));
    }

}