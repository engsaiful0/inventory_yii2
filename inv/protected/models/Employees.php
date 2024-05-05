<?php

class Employees extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Employees the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'employees';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_no, full_name, designation_id, department_id, contact_no', 'required'),
            array('id_no', 'unique', 'caseSensitive' => FALSE),
            array('designation_id, department_id', 'numerical', 'integerOnly' => true),
            array('full_name, id_no', 'length', 'max' => 255),
            array('contact_no', 'length', 'max' => 20),
            array('email', 'email'),
            array('email', 'length', 'max' => 50),
            array('address', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, full_name, designation_id, department_id, contact_no, email, address, id_no', 'safe', 'on' => 'search'),
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
    
    public function getNameWithDesignation(){
        return $this->full_name." (".Designations::model()->infoOfThis($this->designation_id).")";
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'full_name' => 'Full Name',
            'designation_id' => 'Designation',
            'department_id' => 'Department',
            'id_no'=>'ID No',
            'contact_no' => 'Contact No',
            'email' => 'Email',
            'address' => 'Address',
        );
    }
    
    public function fullName($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->full_name;
    }
    
    public function fullNameWithDesigDepart($id){
        $data=self::model()->findByPk($id);
        if($data)
            echo $data->full_name."<br>".Designations::model()->infoOfThis($data->designation_id)."<br>Dept.: ".Departments::model()->nameOfThis($data->department_id);
    }
    
    public function infoOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data;
    }
    
    protected function beforeValidate() {
        if ($this->id_no) {
            
        } else {
            $this->id_no = date('Ymdhms');
        }
        return parent::beforeValidate();
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
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('designation_id', $this->designation_id);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('id_no', $this->id_no);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'department_id, full_name ASC',
            ),
        ));
    }

}