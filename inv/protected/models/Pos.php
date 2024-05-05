<?php

class Pos extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Pos the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pos';
    }

    public $temp_item_id;
    public $temp_price;
    public $temp_qty;
    public $maxInvNo;
    public $cashTotal;

    const YES=1;

    public $supplier_id;
    public $category;
    public $startDate;
    public $endDate;
    public $timeFrom;
    public $timeTo;
    public $pin_code;
    public $cash_card;

    const CASH=81;
    const MASTER_CARD=82;
    const VISA_CARD=83;
    const AMEX_CARD=84;
    const GIFT_CARD=85;

    public $sumOfQty;
    public $sumOfSaleAmount;
    public $sumOfSaleAmountVatable;
    
    public $member_card_no;
    public $member_point_add;
    
    public $member_card_no_for_reduce;
    public $member_point_reduce;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('qty, cash_payment, visa_payment, master_payment, amex_payment, gift_card_payment, overall_discount, cash_return', 'required', 'on' => 'update'),
            array('max_inv_no, store_id, item_id, initiated_by, authorized_by, machine_id, is_void, update_by, update_auth_by, month, year, void_auth_by, is_recycled, discount_type', 'numerical', 'integerOnly' => true),
            array('price, vatable_price, qty, overall_discount, cashTotal, cash_payment, visa_payment, master_payment, amex_payment, gift_card_payment, cash_return', 'numerical'),
            array('date, time, update_time, void_time', 'safe'),
            array('pin_code', 'length', 'max' => 6, 'min' => 4),
            array('inv_no', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, inv_no, date, store_id, item_id, price, vatable_price, qty, overall_discount, initiated_by, time, authorized_by, machine_id, is_void, update_by, update_time, update_auth_by, month, year, void_auth_by, void_time, is_recycled, discount_type', 'safe', 'on' => 'search'),
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
            'inv_no' => 'Invoice No',
            'date' => 'Date',
            'time' => 'Time',
            'store_id' => 'Store',
            'item_id' => 'Item',
            'price' => 'Price',
            'vatable_price'=>'Vatable Price',
            'qty' => 'Qty',
            'overall_discount' => 'Overall Discount',
            'discount_type'=>'Discount Type',
            'cash_payment' => 'CASH',
            'visa_payment' => 'VISA',
            'master_payment' => 'MASTER',
            'amex_payment' => 'AMEX',
            'gift_card_payment' => 'GIFT CARD',
            'cash_return' => 'Cash Return',
            'initiated_by' => 'Cashier',
            'authorized_by' => 'Authorized By',
            'startDate' => 'From',
            'endDate' => 'To',
            'pin_code' => 'PIN',
            'update_by' => 'Updated By',
            'update_time' => 'Updated Time',
            'update_auth_by' => 'Update Auth By',
            'month' => 'Month',
            'year' => 'Year',
            'timeFrom' => 'From',
            'timeTo' => 'To',
            'machine_id' => 'Counter',
            'is_void' => 'isVoid',
            'cash_card' => 'Cash/Card',
            'sumOfSaleAmount' => 'Total Sales Amount',
            'void_auth_by'=>'VOID Auth By',
            'void_time'=>'VOID Time',
        );
    }
    
    public function discountType($discountType){
        if($discountType==0)
            echo "Amount";
        else
            echo "%";
    }
    
    public function overallDiscount($discount, $discountType){
        if($discountType==0)
            echo $discount;
        else
            echo $discount."%";
    }

    public function paymentDetails($inv_no) {
        $condition = "inv_no='" . $inv_no . "'";
        $data = self::model()->findAll(array('condition' => $condition));
        if ($data) {
            if (end($data)->cash_payment != 0)
                echo "<b>CASH:</b> " . number_format(floatval(end($data)->cash_payment), 2) . "<br>";
            if (end($data)->visa_payment != 0)
                echo "<b>VISA:</b> " . number_format(floatval(end($data)->visa_payment), 2) . "<br>";
            if (end($data)->master_payment != 0)
                echo "<b>MASTER:</b> " . number_format(floatval(end($data)->master_payment), 2) . "<br>";
            if (end($data)->amex_payment != 0)
                echo "<b>AMEX:</b> " . number_format(floatval(end($data)->amex_payment), 2) . "<br>";
            if (end($data)->gift_card_payment != 0)
                echo "<b>GIFT-CARD:</b> " . number_format(floatval(end($data)->gift_card_payment), 2) . "<br>";
            $cashPaid = end($data)->cash_payment + end($data)->visa_payment + end($data)->master_payment + end($data)->amex_payment + end($data)->gift_card_payment;
            echo "<b>NET:</b> " . number_format(floatval($cashPaid), 2);
            echo "<br><b>CHANGE:</b> " . number_format(floatval(end($data)->cash_return), 2) . "<br>";
            $gross=$cashPaid-end($data)->cash_return;
            echo "<b>GROSS:</b> " . number_format(floatval($gross), 2);
        }
    }
    
    public function updatePos($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/editBtnPos.png'), array('/pos/updateFromPos', 'inv_no' => $inv_no), array('target'=>'_blank'));
    }

    public function voidPos($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/deleteBtnPos.png'), array('/pos/voidPos', 'inv_no' => $inv_no), array('onclick'=>'$("#ajaxLoader").show();'));
    }

    public function voidPosUndo($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/undoBtnPos.png'), array('/pos/voidPosUndo', 'inv_no' => $inv_no), array('onclick'=>'$("#ajaxLoader").show();'));
    }
    
    public function tempDelete($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/deleteBtnPos.png'), array('/pos/tempDelete', 'inv_no' => $inv_no));
    }
    
    public function tempDeleteUndo($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/undoBtnPos.png'), array('/pos/tempDeleteUndo', 'inv_no' => $inv_no));
    }
    
    public function deletePermanently($inv_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/pos/images/deleteBtnPos.png'), array('/pos/deletePermanently', 'inv_no' => $inv_no));
    }

    public function isVoid($is_void) {
        if ($is_void == self::YES)
            echo "<font style='color: red; font-wieight: bold;'>VOID</font>";
        else
            echo "<font style='color: green; font-wieight: bold;'>ESTABLISHED</font>";
    }

    public function isVoidOnlyValue($is_void) {
        if ($is_void == self::YES)
            return "VOID";
        else
            return "ESTABLISHED";
    }

    public function isVoidInVoid($inv_no) {
        $data = self::model()->findByAttributes(array('inv_no' => $inv_no));

        if ($data->is_void == self::YES)
            return "VOID";
        else
            return "ESTABLISHED";
    }
    
    public function beforeSave() {
        if ($this->isNewRecord) {
            $modelInventory = new Inventory;
            $modelInventory->store = $this->store_id;
            $modelInventory->item = $this->item_id;
            $modelInventory->stock_out = $this->qty;
            $modelInventory->sell_price = $this->price;
            $modelInventory->date = $this->date;
            $modelInventory->save();
            
        } else {
            $previousData = self::model()->findByPk($this->id);

            if ($previousData->qty > $this->qty) {
                $actualQty = ($previousData->qty - $this->qty);
                
                $modelInventory = new Inventory;
                $modelInventory->store = $this->store_id;
                $modelInventory->item = $this->item_id;
                $modelInventory->stock_in = $actualQty;
                $modelInventory->purchase_price = 0;
                $modelInventory->date = $this->date;
                $modelInventory->save();
            }
            else if ($previousData->qty < $this->qty) {
                $actualQty = ($this->qty - $previousData->qty);
                $modelInventory = new Inventory;
                $modelInventory->store = $this->store_id;
                $modelInventory->item = $this->item_id;
                $modelInventory->stock_out = $actualQty;
                $modelInventory->sell_price = $this->price;
                $modelInventory->date = $this->date;
                $modelInventory->save();
            }else {
                
            }
        }
        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchVoid() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "is_void=0 AND is_recycled=0";

        $criteria->compare('id', $this->id);
        $criteria->compare('inv_no', $this->inv_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('price', $this->price);
        $criteria->compare('vatable_price', $this->vatable_price);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('overall_discount', $this->overall_discount);
        $criteria->compare('discount_type', $this->discount_type);
        $criteria->compare('initiated_by', $this->initiated_by);
        $criteria->compare('authorized_by', $this->authorized_by);
        $criteria->compare('machine_id', $this->machine_id);
        $criteria->compare('is_void', $this->is_void);
        $criteria->compare('update_by', $this->update_by);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_auth_by', $this->update_auth_by);
        $criteria->compare('month', $this->month);
        $criteria->compare('year', $this->year);
        $criteria->compare('void_auth_by', $this->void_auth_by);
        $criteria->compare('void_time', $this->void_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'inv_no DESC',
            ),
        ));
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "is_recycled=0";

        $criteria->compare('id', $this->id);
        $criteria->compare('inv_no', $this->inv_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('price', $this->price);
        $criteria->compare('vatable_price', $this->vatable_price);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('overall_discount', $this->overall_discount);
        $criteria->compare('discount_type', $this->discount_type);
        $criteria->compare('initiated_by', $this->initiated_by);
        $criteria->compare('authorized_by', $this->authorized_by);
        $criteria->compare('machine_id', $this->machine_id);
        $criteria->compare('is_void', $this->is_void);
        $criteria->compare('update_by', $this->update_by);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_auth_by', $this->update_auth_by);
        $criteria->compare('month', $this->month);
        $criteria->compare('year', $this->year);
        $criteria->compare('void_auth_by', $this->void_auth_by);
        $criteria->compare('void_time', $this->void_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'inv_no DESC',
            ),
        ));
    }
    
    public function searchRecycled(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "is_recycled=1";

        $criteria->compare('id', $this->id);
        $criteria->compare('inv_no', $this->inv_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('price', $this->price);
        $criteria->compare('vatable_price', $this->vatable_price);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('overall_discount', $this->overall_discount);
        $criteria->compare('initiated_by', $this->initiated_by);
        $criteria->compare('authorized_by', $this->authorized_by);
        $criteria->compare('machine_id', $this->machine_id);
        $criteria->compare('is_void', $this->is_void);
        $criteria->compare('update_by', $this->update_by);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_auth_by', $this->update_auth_by);
        $criteria->compare('month', $this->month);
        $criteria->compare('year', $this->year);
        $criteria->compare('void_auth_by', $this->void_auth_by);
        $criteria->compare('void_time', $this->void_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'inv_no DESC',
            ),
        ));
    }

}