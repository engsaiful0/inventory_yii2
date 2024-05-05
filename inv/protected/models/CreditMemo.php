<?php

class CreditMemo extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CreditMemo the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'credit_memo';
    }

    public $maxSINo;
    public $startDate;
    public $endDate;
    
    public $sumAmount;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, discount', 'required'),
            array('max_sl_no, customer_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('discount', 'numerical'),
            array('sl_no, bill_no', 'length', 'max' => 255),
            array('date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('startDate, endDate, id, max_sl_no, sl_no, date, customer_id, bill_no, discount, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'max_sl_no' => 'Max Sl No',
            'sl_no' => 'Voucher No',
            'customer_id' => 'Customer',
            'bill_no' => 'Bill No',
            'date'=>'Date',
            'discount' => 'Promotional Discount',
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
    
    public function totalCreditMemoThisRangeThisCustomer($id, $startDate, $endDate){
        $criteria=new CDbCriteria();
        $criteria->select="sum(discount) as sumAmount";
        $criteria->addBetweenCondition("date", $startDate, $endDate);
        $criteria->addColumnCondition(array("customer_id"=>$id), "AND", "AND");
        $data=self::model()->findAll($criteria);
        $totalAmount=0;
        if($data){
            $totalAmount=end($data)->sumAmount;
        }
        
        return $totalAmount;
    }
    
    public function totalCreditMemoThisDateThisCustomer($id, $date){
        $criteria=new CDbCriteria();
        $criteria->select="sum(discount) as sumAmount";
        $criteria->addColumnCondition(array("customer_id"=>$id, "date"=>$date), "AND", "AND");
        $data=self::model()->findAll($criteria);
        $totalAmount=0;
        if($data){
            $totalAmount=end($data)->sumAmount;
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('bill_no', $this->bill_no, true);
        $criteria->compare('discount', $this->discount);
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
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}