<?php

class StorckTranferHistoryFromTempToMain extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StorckTranferHistoryFromTempToMain the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'storck_tranfer_history_from_temp_to_main';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_temp_store, to_main_store, item, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            array('created_time, updated_time, date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, from_temp_store, to_main_store, item, qty, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'from_temp_store' => 'From Temp Store (Inventory)',
            'to_main_store' => 'To Main Store (Inventory)',
            'item' => 'Item',
            'qty' => 'Qty',
            'date'=>'Transfered Date',
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $assignedStores=  UserStore::model()->forSearchCondition();
        $criteria->addInCondition('from_temp_store', $assignedStores);
        $criteria->addInCondition('to_main_store', $assignedStores);
        $criteria->addCondition(array('created_by'=>Yii::app()->user->getId()));
        $criteria->compare('id', $this->id);
        $criteria->compare('from_temp_store', $this->from_temp_store);
        $criteria->compare('to_main_store', $this->to_main_store);
        $criteria->compare('item', $this->item);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}