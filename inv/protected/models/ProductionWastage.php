<?php

class ProductionWastage extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ProductionWastage the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'production_wastage';
    }
    
    public $sumOfWastageQty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('wastage_qty, date', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('wastage_qty', 'numerical'),
            array('production_input_no', 'length', 'max' => 255),
            array('date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, production_input_no, wastage_qty, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'production_input_no' => 'Production Input No',
            'wastage_qty' => 'Wastage Qty (Kg)',
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
    
    public function totalWastageQtyOfThisProductionInputNo($sl_no){
        $criteria=new CDbCriteria();
        $criteria->select="sum(wastage_qty) as sumOfWastageQty";
        $criteria->addColumnCondition(array("production_input_no"=>$sl_no));
        $data = self::model()->findAll($criteria);
        $totalWastageQty=0;
        if($data){
            $totalWastageQty=end($data)->sumOfWastageQty;
        }
        return $totalWastageQty;
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('production_input_no', $this->production_input_no, true);
        $criteria->compare('wastage_qty', $this->wastage_qty);
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