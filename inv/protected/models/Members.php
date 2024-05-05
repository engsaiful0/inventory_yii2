<?php

class Members extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Members the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'members';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, contact_no, card_no', 'required'),
            array('available_point', 'numerical'),
            array('card_no', 'unique', 'caseSensitive' => FALSE),
            array('name, contact_no, email, address, spouse, card_no', 'length', 'max' => 255),
            array('dob', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, contact_no, email, address, dob, spouse, card_no, available_point', 'safe', 'on' => 'search'),
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
            'name'=>'Name',
            'contact_no' => 'Contact Number',
            'email'=>'Email',
            'address'=>'Address',
            'dob'=>'DOB',
            'spouse'=>'Spouse Name',
            'card_no' => 'Card Number',
            'available_point'=>'Available Points',
        );
    }
    
    public function nameOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            echo "Name: ".$data->name.", Card Number: ".$data->card_no."<br> Contact Number: ".$data->contact_no;
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('dob', $this->dob, true);
        $criteria->compare('spouse', $this->spouse, true);
        $criteria->compare('card_no', $this->card_no, true);
        $criteria->compare('available_point', $this->available_point);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}