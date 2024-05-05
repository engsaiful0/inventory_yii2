<?php

class SellingPrice extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return SellingPrice the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'selling_price';
    }
    const ACTIVE=1;
    const INACTIVE=2;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item, price, date, is_active', 'required'),
            array('item, is_active, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('date, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, item, price, date, is_active, created_by, created_time, updated_by, updated_time', 'safe', 'on' => 'search'),
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
            'item' => 'Item',
            'price' => 'Price',
            'date' => 'Date',
            'is_active' => 'isActive',
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

    public function afterSave() {
        if ($this->is_active == self::ACTIVE) {
            self::model()->updateAll(array('is_active' => self::INACTIVE), 'id!=:id AND item=:item', array(':id' => $this->id, ':item' => $this->item));
        }
        return parent::afterSave();
    }

    public function activeSellingPrice($item_id) {
        $price = 0;
        $data = self::model()->findByAttributes(array("item" => $item_id, "is_active" => self::ACTIVE));
        if ($data) {
            $price = $data->price;
        }
        return $price;
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
        $criteria->compare('item', $this->item);
        $criteria->compare('price', $this->price);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('is_active', $this->is_active);
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