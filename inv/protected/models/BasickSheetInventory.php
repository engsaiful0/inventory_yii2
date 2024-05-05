<?php

class BasickSheetInventory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ProductionOutput the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'basick_sheet_inventory';
    }
    
    public $maxSINo;
    public $sumOfQty;
    public $sumOfQtyKg;
    public $category;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('', 'required'),
            array('max_sl_no, item, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty, qty_kg,length,width,thickness,stock_in_qty,stock_out_qty', 'numerical'),
            array('production_input_no, sl_no', 'length', 'max' => 255),
            array('date, time, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, production_input_no, max_sl_no, sl_no, date, time, item, qty, qty_kg, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'length'=>'Length',
            'width'=>'Width',
            'thickness'=>'Thickness',
            'unit_of_distance'=>'Unit Of Distance',
            'production_input_no' => 'Production Input No',
            'max_sl_no' => 'Max Sl No',
            'sl_no' => 'Output/Batch No',
            'date' => 'Date',
            'time' => 'Time',
            'item' => 'Item',
            'qty' => 'Output Qty',
            'qty_kg'=>'Output Qty(Kg)',
            'stock_in_qty'=>'Stock In Qty',
            'stock_out_qty'=>'Stock Out Qty',
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
        public function presentStockOfThisItem($item, $store){
         $condition = "item='" . $item . "' AND store='".$store."'";
        $data=self::model()->findAll($condition);
        $sumStockIn=0;$sumStockOut=0;
        foreach ($data as $value) {
            $sumStockIn+=$value->stock_in_qty;
            $sumStockOut+=$value->stock_out_qty;
        }
        $stockQty=0;
            $stockQty=($sumStockIn-$sumStockOut);
        return $stockQty;
    }

        public function presentStockOfThisItemAllStore($item){
        $condition = "item='" . $item . "'";
        $data=self::model()->findAll($condition);
        $sumStockIn=0;$sumStockOut=0;
        foreach ($data as $value) {
            $sumStockIn+=$value->stock_in_qty;
            $sumStockOut+=$value->stock_out_qty;
        }
        $stockQty=0;
            $stockQty=($sumStockIn-$sumStockOut);
        return $stockQty;
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
        $criteria2 = new CDbCriteria;
        $criteria2->select="sl_no";
        $criteria2->addInCondition('store', $assignedStores);
        $criteria2->group="sl_no";
        $data = ProductionInput::model()->findAll($criteria2);
        $req_id = array();
        if ($data) {
            foreach ($data as $d):
                $req_id[] = $d->sl_no;
            endforeach;
        }
        $criteria->addInCondition('production_input_no', $req_id);
        $criteria->compare('id', $this->id);
        $criteria->compare('production_input_no', $this->production_input_no);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('qty_kg', $this->qty_kg);
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
                'defaultOrder' => 'sl_no DESC',
            ),
        ));
    }

}