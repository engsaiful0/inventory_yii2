<?php

class CustomerBill extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CustomerBill the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customer_bill';
    }
    
    public $maxSINo;
    public $startDate;
    public $endDate;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, customer_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('sl_no, challan_no', 'length', 'max' => 255),
            array('bill_date, due_date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('startDate, endDate, id, max_sl_no, sl_no, customer_id, challan_no, bill_date, due_date, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'sl_no' => 'Bill No',
            'customer_id' => 'Customer',
            'challan_no' => 'Challan No',
            'bill_date' => 'Bill Date',
            'due_date' => 'Due Date',
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
    
    public function paymentInfo($sl_no){
        $totalBilled=0;
        $data=self::model()->findAll(array("condition"=>"sl_no='".$sl_no."'"));
        if($data){
            foreach($data as $d){
                $totalBilled=SellDelvRtn::model()->totalDelvAmount($bill=1, $sl_no=$d->challan_no, $customer_id=null, $date=null, $startDate=null, $endDate=null)+$totalBilled;
            }
        }
        $totalPaid = 0;
        $totalDiscount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        $criteria->addColumnCondition(array("bill_no" => $sl_no), "AND", "AND");
        $data = CustomerMr::model()->findAll($criteria);
        if ($data) {
            $totalPaid = end($data)->sumOfPaidAmount;
            $totalDiscount = end($data)->sumOfDiscount;
        }
        $totalMr=($totalPaid+$totalDiscount);
        $totalDue=($totalBilled-$totalMr);
        echo "<table>";
        echo "<tr>";
        echo "<td style='text-align: left;'>";
        echo "<font style='color: green;'>Billed: ".number_format(floatval($totalBilled),2)."</font><br>";
        echo "<font style='color: purple;'>Received: ".number_format(floatval($totalPaid),2)."</font><br>";
        echo "<font style='color: brown;'>Discount: ".number_format(floatval($totalDiscount),2)."</font><br>";
        echo "<font style='color: black;'>Total: ".number_format(floatval($totalMr),2)."</font><br>";
        echo "<font style='color: red;'>Due: ".number_format(floatval($totalDue),2)."</font>";
        echo "</td>";
        if($totalDue==0){
        echo "<td>";
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Create Credit Memo" value="Create" onclick="allDeliver' . $sl_no . '();$(\'#deliverAll-dialog\').dialog(\'open\');" />';
        echo "</td>";
        }
        echo "</tr>";
        echo "</table>";
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
            $criteria->addBetweenCondition('bill_date', $this->startDate, $this->endDate);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('challan_no', $this->challan_no, true);
        $criteria->compare('bill_date', $this->bill_date, true);
        $criteria->compare('due_date', $this->due_date, true);
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