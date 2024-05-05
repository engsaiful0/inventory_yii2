<?php

class StoreInventory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StoreInventory the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'store_inventory';
    }
    
    public $startDate;
    public $endDate;
    public $category;
    public $sumStockIn;
    public $sumStockOut;
    public $supplier_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, store, item, stock_in', 'required', 'on'=>'update'),
            array('store, item', 'numerical', 'integerOnly' => true),
            array('stock_in, stock_out, costing_price', 'numerical'),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, store, item, stock_in, stock_out, costing_price', 'safe', 'on' => 'search'),
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
            'date' => 'Date',
            'store' => 'Store',
            'item' => 'Item',
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'costing_price' => 'Costing Price',
        );
    }
    
    public function presentStockOfThisItem($item, $store){
        $criteria=new CDbCriteria();
        $criteria->select="sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut";
        $criteria->addColumnCondition(array("item"=>$item, "store"=>$store), "AND");
        $data=self::model()->findAll($criteria);
        $stockQty=0;
        if($data){
            $stockQty=(end($data)->sumStockIn-end($data)->sumStockOut);
        }
        return $stockQty;
    }
    
    public function presentStockOfThisItemAllStore($item){
        $criteria=new CDbCriteria();
        $criteria->select="sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut";
        $criteria->addColumnCondition(array("item"=>$item), "AND");
        $data=self::model()->findAll($criteria);
        $stockQty=0;
        if($data){
            $stockQty=(end($data)->sumStockIn-end($data)->sumStockOut);
        }
        return $stockQty;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $assignedStores=  UserStore::model()->forSearchCondition();
        
        $criteria = new CDbCriteria;
        $criteria->addInCondition('store', $assignedStores);

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('store', $this->store);
        $criteria->compare('item', $this->item);
        $criteria->compare('stock_in', $this->stock_in);
        $criteria->compare('stock_out', $this->stock_out);
        $criteria->compare('costing_price', $this->costing_price);

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