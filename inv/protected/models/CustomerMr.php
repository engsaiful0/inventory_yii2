<?php

class CustomerMr extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CustomerMr the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customer_mr';
    }

    public $sumOfPaidAmount;
    public $sumOfDiscount;
    public $maxSINo;
    public $startDate;
    public $endDate;
    
    const CASH=20;
    const CHEQUE=21;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bank_name, cheque_date, cheque_no', 'checkIfPaymentTypeIsCheque', 'on' => 'isChequePaymentScenario'),
            array('max_sl_no, customer_id, received_type, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('paid_amount, discount', 'numerical'),
            array('sl_no, bill_no, bank_name, cheque_no', 'length', 'max' => 255),
            array('date, cheque_date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('startDate, endDate, id, max_sl_no, sl_no, bill_no, customer_id, date, received_type, bank_name, cheque_no, cheque_date, paid_amount, discount, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkIfPaymentTypeIsCheque() {
        if ($this->received_type == "")
                $this->addError('received_type', 'Receive Type can not be blank');
        if ($this->received_type == self::CHEQUE) {
            if ($this->bank_name == "")
                $this->addError('bank_name', 'Bank Name can be empty for Receive Type: Cheque');
            if ($this->cheque_no == "")
                $this->addError('cheque_no', 'Cheque No can be empty for Receive Type: Cheque');
            if ($this->cheque_date == "")
                $this->addError('cheque_date', 'Cheque Date can be empty for Receive Type: Cheque');
        }
        if ($this->paid_amount == "")
            $this->addError('paid_amount', 'Receive Amount can not be blank');
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
            'max_sl_no' => 'Max Sl No',
            'sl_no' => 'MR No',
            'bill_no' => 'Bill No',
            'customer_id' => 'Customer',
            'date' => 'MR Date',
            'received_type' => 'Receive Type',
            'bank_name' => 'Bank Name',
            'cheque_no' => 'Cheque No',
            'cheque_date' => 'Cheque Date',
            'paid_amount' => 'Current Receive Amount',
            'discount' => 'Discount',
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

    public function totalMrAmountOfThisBill($bill_no) {
        $totalAmount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        $criteria->addColumnCondition(array("bill_no" => $bill_no), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $totalAmount = end($data)->sumOfPaidAmount + end($data)->sumOfDiscount;
        }

        return $totalAmount;
    }
    
    public function totalPaidAmountOfThisCustomer($customer_id) {
        $totalAmount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $totalAmount = end($data)->sumOfPaidAmount + end($data)->sumOfDiscount;
        }

        return $totalAmount;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        if($this->startDate!="" && $this->endDate!=""){
            $criteria->addBetweenCondition('date', $this->startDate, $this->endDate);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('bill_no', $this->bill_no, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('received_type', $this->received_type);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('cheque_no', $this->cheque_no, true);
        $criteria->compare('cheque_date', $this->cheque_date, true);
        $criteria->compare('paid_amount', $this->paid_amount);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);

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