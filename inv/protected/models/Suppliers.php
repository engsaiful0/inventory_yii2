<?php

class Suppliers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Suppliers the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'suppliers';
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
            array('id, company_name, company_address, company_contact_no, company_fax, company_email, company_web, id_no', 'safe', 'on' => 'search'),
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

    public function supplierName($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name;
    }

    public function supplierNameAddr($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            echo $data->company_name . "<br><pre>" . $data->company_address . "</pre>";
    }
    
    public function supplierNameAndAddress($id){
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name."<br><pre>".$data->company_address."</pre>";
    }

    public function supplierAllInfo($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Supplier',
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

    protected function beforeValidate() {
        if ($this->id_no) {
            
        } else {
            $this->id_no = date('Ymdhms');
        }
        return parent::beforeValidate();
    }
    
    public function transactionInfo($poid){
        $totalReceived=  PurchaseRcvRtn::model()->totalRcvAmount($po_id=$poid, $date=null, $startDate=null, $endDate=null);
        $totalPaid = 0;
        $totalDiscount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        $criteria->addColumnCondition(array("po_id" => $poid), "AND", "AND");
        $data = SupplierMr::model()->findAll($criteria);
        if ($data) {
            $totalPaid=end($data)->sumOfPaidAmount;
            $totalDiscount = end($data)->sumOfDiscount;
        }
        $totalMr=($totalPaid+$totalDiscount);
        $totalDue=($totalReceived-$totalMr);
        
        echo "<font style='color: blue;'>Received: ".number_format(floatval($totalReceived),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: purple;'>Paid: ".number_format(floatval($totalPaid),2)."</font><br>";
        echo "<font style='color: brown;'>Discount: ".number_format(floatval($totalDiscount),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: black;'>Total: ".number_format(floatval($totalMr),2)."</font><br>";
        echo "<hr>";
        echo "<font style='color: red;'>Due: ".number_format(floatval($totalDue),2)."</font>";
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
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'company_name ASC',
            ),
        ));
    }

}