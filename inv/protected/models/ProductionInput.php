<?php

class ProductionInput extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ProductionInput the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'production_input';
    }

    public $maxSINo;
    
    public $startDate;
    public $endDate;
    public $startTime;
    public $endTime;
    
    public $sumOfQty;
    public $sumOfQtyKg;
    public $sumOfRtnQty;
    public $sumOfRtnQtyKg;
    
    public $category;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, store, machine, item, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty, qty_kg, return_qty, return_qty_kg', 'numerical'),
            array('sl_no, track_no', 'length', 'max' => 255),
            array('date, time, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attribut,es that should not be searched.
            array('startDate, endDate, startTime, endTime, id, max_sl_no, sl_no, track_no, date, time, store, machine, item, qty, qty_kg, return_qty, return_qty_kg, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'sl_no' => 'Production Input No',
            'track_no'=>'Output/Batch No',
            'date' => 'Date',
            'time' => 'Time',
            'store' => 'Store',
            'machine' => 'Machine',
              'length'=>'Length',
            'width'=>'Width',
            'thickness'=>'Thickness',
            'unit_of_distance'=>'Unit Of Distance',
            'item' => 'Item',
            'qty' => 'Input Qty',
            'qty_kg'=>'Input Qty(Kg)',
            'return_qty'=>'Rtn Qty',
            'return_qty_kg'=>'Rtn Qty(Kg)',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        );
    }
    
    public function returnQty($sl_no){
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/returnBtnBg.png'), array('/productionInput/returnQty', 'sl_no' => $sl_no));
    }
    
    public function update($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/editBtnBg.png'), array('/productionInput/update', 'sl_no' => $sl_no));
    }
    
    public function delete($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/deleteBtnBg.png'), array('/productionInput/delete', 'sl_no' => $sl_no));
    }
    
    public function output($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/outputBtnBg.png'), array('/productionOutput/create', 'sl_no' => $sl_no), array('target'=>'_blank'));
    }
    
    public function wastage($sl_no) {
        echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . '/images/wastageBtnBg.png', '',array('width'=>64)), array('/productionWastage/create', 'sl_no' => $sl_no), array('target'=>'_blank'));
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
        if($this->startTime!="" && $this->endTime!=""){
            $criteria->addBetweenCondition('time', $this->startTime, $this->endTime);
        }
        
        $assignedStores = UserStore::model()->forSearchCondition();
        $criteria->addInCondition('store', $assignedStores);
        $criteria->compare('id', $this->id);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('sl_no', $this->sl_no, true);
        $criteria->compare('track_no', $this->track_no, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('store', $this->store);
        $criteria->compare('machine', $this->machine);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('qty_kg', $this->qty_kg);
        $criteria->compare('return_qty', $this->return_qty);
        $criteria->compare('return_qty_kg', $this->return_qty_kg);
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