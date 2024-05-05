<?php

class SaleOrder extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return SaleOrder the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sale_order';
    }

    public $maxSINo;
    public $sumOfSoQty;
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
            array('max_sl_no, order_type2, store, customer_id, contact_person, item, created_by, updated_by, sales_by, conv_unit, is_stopped', 'numerical', 'integerOnly' => true),
            array('qty, price', 'numerical'),
            array('sl_no, subj, pi_no', 'length', 'max' => 255),
            array('issue_date, expected_d_date, pi_date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sl_no, max_sl_no, issue_date, expected_d_date, subj, order_type2, pi_no, pi_date, store, customer_id, contact_person, item, qty, price, conv_unit, sales_by, created_by, created_time, updated_by, updated_time, is_stopped', 'safe', 'on' => 'search'),
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
            'sl_no' => 'SO No',
            'max_sl_no' => 'Max Sl No',
            'issue_date' => 'Issue Date',
            'expected_d_date' => 'Expected D.Date',
            'subj' => 'Subj/Remarks',
            'order_type2' => 'Local/Export',
            'pi_no' => 'PI/PO No',
            'pi_date' => 'PI/PO Date',
            'store' => 'Store',
            'customer_id' => 'Customer',
            'contact_person' => 'Contact Person',
            'item' => 'Item',
            'qty' => 'Qty',
            'price' => 'Rate',
            'conv_unit' => 'Convertable Unit',
            'sales_by' => 'Sales Person',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'is_stopped'=>'is Delivery Stopped',
        );
    }

    public function totalSoQtyOfThisItem($item, $store) {
        $criteria = new CDbCriteria();
        $criteria->select = "sum(qty) as sumOfSoQty";
        $criteria->addColumnCondition(array("item" => $item, "store" => $store), "AND", "AND");
        $data = self::model()->findAll($criteria);
        $totalSoQty = 0;
        if ($data)
            $totalSoQty = end($data)->sumOfSoQty;
        return $totalSoQty;
    }

    public function update($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/editBtnBg.png'), array('/saleOrder/update', 'sl_no' => $sl_no));
    }

    public function delete($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/deleteBtnBg.png'), array('/saleOrder/delete', 'sl_no' => $sl_no));
    }
    
    public function isStopped($is_stopped, $id){
        if($is_stopped==1){
            echo '<input class="undoBtn" type="button" title="Undo" value="Undo" onclick="start'.$id.'();" />';
        }else{
            echo '<input class="completeBtn" type="button" title="Stop" value="Stop" onclick="stop'.$id.'();" />';
        }
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
        $criteria->addInCondition('store', $assignedStores);
        $criteria->compare('is_stopped', $this->is_stopped);
        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('expected_d_date', $this->expected_d_date, true);
        $criteria->compare('subj', $this->subj, true);
        $criteria->compare('order_type2', $this->order_type2);
        $criteria->compare('pi_no', $this->pi_no, true);
        $criteria->compare('pi_date', $this->pi_date, true);
        $criteria->compare('store', $this->store);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('contact_person', $this->contact_person);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('price', $this->price);
        $criteria->compare('conv_unit', $this->conv_unit);
        $criteria->compare('sales_by', $this->sales_by);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'sl_no DESC',
            ),
        ));
    }
    
    public function searchForDelivery() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria->addInCondition('store', $assignedStores);
        $criteria->condition="is_stopped=0";
        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('expected_d_date', $this->expected_d_date, true);
        $criteria->compare('subj', $this->subj, true);
        $criteria->compare('order_type2', $this->order_type2);
        $criteria->compare('pi_no', $this->pi_no, true);
        $criteria->compare('pi_date', $this->pi_date, true);
        $criteria->compare('store', $this->store);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('contact_person', $this->contact_person);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('price', $this->price);
        $criteria->compare('conv_unit', $this->conv_unit);
        $criteria->compare('sales_by', $this->sales_by);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'sl_no DESC',
            ),
        ));
    }

}