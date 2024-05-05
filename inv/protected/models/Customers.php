<?php

class Customers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Customers the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customers';
    }
    public $startDate;
    public $endDate;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_name', 'required'),
            array('id_no', 'unique', 'caseSensitive' => FALSE),
            array('opening_amount', 'numerical'),
            array('company_name, id_no', 'length', 'max' => 255),
            array('company_contact_no, company_fax', 'length', 'max' => 20),
            array('company_email, company_web', 'length', 'max' => 50),
            array('company_address', 'safe'),
            array('company_email', 'email'),
            array('company_web', 'url', 'defaultScheme' => 'http'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, id_no, company_name, company_address, company_contact_no, company_fax, company_email, company_web', 'safe', 'on' => 'search'),
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
            'id' => 'Customer',
            'id_no' => 'ID No',
            'company_name' => 'Name',
            'company_address' => 'Address',
            'company_contact_no' => 'Contact No',
            'company_fax' => 'FAX',
            'company_email' => 'E-Mail',
            'company_web' => 'Web',
            'opening_amount' => 'Opening Amount',
            );
    }

    public function customerName($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name;
    }

    public function customerAddress($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_address;
    }

    public function customerAllInfo($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }
    
    public function customerNameAndAddress($id){
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name."<br><pre>".$data->company_address."</pre>";
    }

    protected function beforeValidate() {
        if ($this->id_no) {
            
        } else {
            $this->id_no = date('Ymdhms');
        }
        return parent::beforeValidate();
    }
    
    public function transactionInfo($id){
        
//        $totalSold=SellDelvRtn::model()->totalSoldAmountOfThisCustomer($id);
//        $totalBilled=SellDelvRtn::model()->totalBillAmountOfThisCustomer($id);
        $totalSold=SellDelvRtn::model()->totalDelvAmount($bill=null, $sl_no=null, $customer_id=$id, $date=null, $startDate=null, $endDate=null);
        $totalBilled=SellDelvRtn::model()->totalDelvAmount($bill=1, $sl_no=null, $customer_id=$id, $date=null, $startDate=null, $endDate=null);
        
        $totalNotBilled=($totalSold-$totalBilled);
        
        $totalPaid = 0;
        $totalDiscount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        $criteria->addColumnCondition(array("customer_id" => $id), "AND", "AND");
        $data = CustomerMr::model()->findAll($criteria);
        if ($data) {
            $totalPaid = end($data)->sumOfPaidAmount;
            $totalDiscount = end($data)->sumOfDiscount;
        }
        $totalMr=($totalPaid+$totalDiscount);
        $totalDue=($totalBilled-$totalMr);
        echo "<font style='color: blue;'>Sold: ".number_format(floatval($totalSold),2)."</font><br>";
        echo "<font style='color: darkgoldenrod;'>Not Billed: ".number_format(floatval($totalNotBilled),2)."</font><br>";
        echo "<font style='color: green;'>Billed: ".number_format(floatval($totalBilled),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: purple;'>Received: ".number_format(floatval($totalPaid),2)."</font><br>";
        echo "<font style='color: brown;'>Discount: ".number_format(floatval($totalDiscount),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: black;'>Total: ".number_format(floatval($totalMr),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: red;'>Due (Billed Amount): ".number_format(floatval($totalDue),2)."</font>";
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('company_contact_no', $this->company_contact_no, true);
        $criteria->compare('company_fax', $this->company_fax, true);
        $criteria->compare('company_email', $this->company_email, true);
        $criteria->compare('company_web', $this->company_web, true);
        $criteria->compare('id_no', $this->id_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'company_name ASC',
            ),
        ));
    }

}