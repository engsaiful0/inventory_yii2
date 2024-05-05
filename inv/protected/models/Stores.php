<?php

class Stores extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Stores the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'stores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_name', 'required'),
            array('store_name, location', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, store_name, safe', 'safe', 'on' => 'search'),
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
            'store_name' => 'Store Name',
            'location'=>'Location',
        );
    }
    
    public function storeName($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->store_name;
    }
    
    public function storeNameAndAddr($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->store_name.", ".$data->location;
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
        $criteria->compare('store_name', $this->store_name, true);
        $criteria->compare('location', $this->location, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'store_name ASC',
            ),
        ));
    }

}