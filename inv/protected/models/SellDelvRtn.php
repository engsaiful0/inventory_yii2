<?php

class SellDelvRtn extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return SellDelvRtn the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sell_delv_rtn';
    }

    public $maxSINo;
    public $remainingDeliverableQty;
    public $stockQty;
    public $sumOfDeliveryQty;
    public $sumOfReturnQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('d_date, d_qty, vehicle_type, vehicle_no', 'required', 'on' => 'update'),
            array('max_sl_no, so_id, created_by, updated_by, return_by, item, store, bill', 'numerical', 'integerOnly' => true),
            array('d_qty, r_qty, d_qty_kg, r_qty_kg', 'numerical'),
            array('sl_no, so_no, remarks, vehicle_type, vehicle_no, remarks1', 'length', 'max' => 255),
            array('d_date, r_date, created_time, updated_time, return_time', 'safe'),
            array('r_qty, r_date', 'isExceedReturn', 'on' => 'returnScenario'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sl_no, max_sl_no, so_id, vehicle_type, vehicle_no, so_no, remarks1, remarks, bill, d_date, d_qty, r_date, r_qty, d_qty_kg, r_qty_kg, created_by, created_time, updated_by, updated_time, return_time, return_by, item, store', 'safe', 'on' => 'search'),
        );
    }

    public function isExceedReturn() {

        if ($this->r_qty == "") {
            $this->addError('r_qty', 'Return qty can not be blank');
        }
        if ($this->r_qty > $this->d_qty) {
            $this->addError('r_qty', 'Return qty exceeds delivered qty!');
        }
        if ($this->r_date == "") {
            $this->addError('r_date', 'Return date can not be blank');
        }
        if ($this->r_date < $this->d_date) {
            $this->addError('r_qty', 'Can not return from the previous date of delivered date!');
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
            'bill' => 'Bill',
            'sl_no' => 'Challan No',
            'max_sl_no' => 'Max Sl No',
            'so_id' => 'SO Id',
            'customer_id' => 'Customer',
            'item' => 'Item',
            'store' => 'Store',
            'so_no' => 'So No',
            'd_date' => 'Delivery Date',
            'd_qty' => 'Delivery Qty',
            'r_date' => 'Return Date',
            'r_qty' => 'Return Qty',
            'remarks1' => 'Remarks',
            'remarks' => 'Remarks',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'return_by' => 'Returned By',
            'return_time' => 'Returned Time',
            'vehicle_type' => 'Vehicle Type',
            'vehicle_no' => 'Vehicle No',
            'd_qty_kg' => 'Delivery Qty(KG)',
            'r_qty_kg' => 'Return Qty(KG)',
        );
    }

    public function deliverAll($sl_no) {
        echo '<input style="background-color: #FFA500;" class="add-more-btn" type="button" title="Deliver" value="Deliver" onclick="allDeliver' . $sl_no . '();$(\'#deliverAll-dialog\').dialog(\'open\');" />';
    }

//    public function totalSoldAmountOfThisChallan($sl_no) {
//        $totalAmount = 0;
//        $condition = "sl_no='" . $sl_no."'";
//        $data = self::model()->findAll(array('condition' => $condition,), 'id');
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalSoldAmountOfThisCustomer($customer_id) {
//        $totalAmount = 0;
//        $condition = "customer_id=" . $customer_id;
//        $data = self::model()->findAll(array('condition' => $condition,), 'id');
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalSoldAmountOfThisCustomerThisRange($customer_id, $startDate, $endDate) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addBetweenCondition("d_date", $startDate, $endDate);
//        $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalSoldAmountOfThisCustomerThisDate($customer_id, $date) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addColumnCondition(array("customer_id" => $customer_id, "d_date"=>$date), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalBillAmountOfThisCustomer($customer_id) {
//        $totalAmount = 0;
//        $condition = "customer_id=" . $customer_id." AND bill=1";
//        $data = self::model()->findAll(array('condition' => $condition,), 'id');
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalBillAmountOfThisCustomerThisRange($customer_id, $startDate, $endDate) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addBetweenCondition("d_date", $startDate, $endDate);
//        $criteria->addColumnCondition(array("customer_id" => $customer_id, "bill"=>"1"), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }
//    
//    public function totalBillAmountOfThisCustomerThisDate($customer_id, $date) {
//        $totalAmount = 0;
//        $criteria=new CDbCriteria();
//        $criteria->addColumnCondition(array("customer_id" => $customer_id, "d_date"=>$date, "bill"=>"1"), "AND", "AND");
//        $data = self::model()->findAll($criteria);
//        
//        if ($data) {
//            foreach ($data as $d):
//                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
//                $price=$soInfo->price;
//                $actualDeliveryQty=($d->d_qty-$d->r_qty);
//                $amount=$actualDeliveryQty*$price;
//                $totalAmount=$amount+$totalAmount;
//            endforeach;
//        }
//
//        return $totalAmount;
//    }

    public function totalDelvAmount($bill, $sl_no, $customer_id, $date, $startDate, $endDate) {
        $totalAmount = 0;
        $criteria = new CDbCriteria();
        if ($bill != null) {
            $criteria->addColumnCondition(array("bill" => $bill), "AND", "AND");
        }
        if ($sl_no != null) {
            $criteria->addColumnCondition(array("sl_no" => $sl_no), "AND", "AND");
        }
        if ($customer_id != null) {
            $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
        }
        if ($date != null) {
            $criteria->addColumnCondition(array("d_date" => $date), "AND", "AND");
        }
        if ($startDate != null && $endDate != null) {
            $criteria->addBetweenCondition("d_date", $startDate, $endDate, "AND");
        }

        $data = self::model()->findAll($criteria);

        if ($data) {
            foreach ($data as $d):
                $actualDeliveryQty = ($d->d_qty - $d->r_qty);
                $soInfo = SaleOrder::model()->findByPk($d->so_id);
                $qty = $soInfo->qty;
                $price = $soInfo->price;
                $conv_unit = $soInfo->conv_unit;
                
                if ($conv_unit != "") {
                    $itemInfo = Items::model()->findByPk($soInfo->item);
                    if ($itemInfo) {
                        $desc = $itemInfo->desc;
                        $unitConvertable = $itemInfo->unit_convertable;

                        $convertedUnit = Items::model()->convertedUnit($unitConvertable, $desc);
                        $sft = $convertedUnit[0];
                        $rft = $convertedUnit[1];
                        $cft = $convertedUnit[2];
                        $sqm = $convertedUnit[3];

                        if ($conv_unit == Items::SFT) {
                            $qty = $sft;
                        } else if ($conv_unit == Items::RFT) {
                            $qty = $rft;
                        } else if ($conv_unit == Items::CFT) {
                            $qty = $cft * $actualDeliveryQty;
                        } else if ($conv_unit == Items::SQM) {
                            $qty = $sqm;
                        } else {
                            $qty = $qty;
                        }
                    }
                    $amount = $qty * $price;
                    $totalAmount = $amount + $totalAmount;
                } else {
                    $amount = $actualDeliveryQty * $price;
                    $totalAmount = $amount + $totalAmount;
                }
            endforeach;
        }

        return $totalAmount;
    }

    public function availableQtyOfThisSellOrderId($id) {
        $availableQty = 0;
        $condition = "so_id=" . $id;
        $data = self::model()->findAll(array('condition' => $condition,), 'id');
        if ($data) {
            $totalReceived = 0;
            $totalReturned = 0;
            foreach ($data as $d):
                $totalReceived = $d->d_qty + $totalReceived;
                $totalReturned = $d->r_qty + $totalReturned;
            endforeach;

            $availableQty = $totalReceived - $totalReturned;
        }

        return $availableQty;
    }

    public function totalDelivQtyOfThisItem($item, $store) {
        $criteria = new CDbCriteria();
        $criteria->select = "sum(d_qty) as sumOfDeliveryQty, sum(r_qty) as sumOfReturnQty";
        $criteria->addColumnCondition(array("item" => $item, "store" => $store), "AND", "AND");
        $data = self::model()->findAll($criteria);
        $totalDeliveryQty = 0;
        if ($data)
            $totalDeliveryQty = (end($data)->sumOfDeliveryQty - end($data)->sumOfReturnQty);
        return $totalDeliveryQty;
    }

    public function isBillCreated($bill) {
        if ($bill == 1)
            echo "<font style='font-weight: bold; color: green;'>Created</>";
        else
            echo "<font style='color: red;'>Not Created</>";
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('store', $assignedStores);
        $data2 = SaleOrder::model()->findAll($criteria2);
        $so_id = array();
        if ($data2) {
            foreach ($data2 as $d2):
                $so_id[] = $d2->id;
            endforeach;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('bill', $this->bill);
        $criteria->addInCondition('so_id', $so_id);
        $criteria->compare('item', $this->item);
        $criteria->compare('store', $this->store);
        $criteria->compare('id', $this->id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('so_no', $this->so_no, true);
        $criteria->compare('d_date', $this->d_date, true);
        $criteria->compare('d_qty', $this->d_qty);
        $criteria->compare('r_date', $this->r_date, true);
        $criteria->compare('r_qty', $this->r_qty);
        $criteria->compare('remarks1', $this->remarks1, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('return_by', $this->return_by);
        $criteria->compare('return_time', $this->return_time, true);
        $criteria->compare('vehicle_type', $this->vehicle_type);
        $criteria->compare('vehicle_no', $this->vehicle_no);
        $criteria->compare('d_qty_kg', $this->d_qty_kg);
        $criteria->compare('r_qty_kg', $this->r_qty_kg);

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