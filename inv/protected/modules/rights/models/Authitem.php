<?php

/**
 * This is the model class for table "authitem".
 *
 * The followings are the available columns in table 'authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Authitemchild[] $authitemchildren
 * @property Authitemchild[] $authitemchildren1
 * @property Rights $rights
 */
class Authitem extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Authitem the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'authitem';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('description, bizrule, data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, type, description, bizrule, data', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'authitemchildren' => array(self::HAS_MANY, 'Authitemchild', 'parent'),
            'authitemchildren1' => array(self::HAS_MANY, 'Authitemchild', 'child'),
            'rights' => array(self::HAS_ONE, 'Rights', 'itemname'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
        );
    }

    public function allRoles() {

        $condition = 'type=2 AND name!="Admin"';

        $result = Authitem::model()->findAll(array("condition" => $condition,), "name");


        //$sql="SELECT name from authitem where type=2";
        //$result=  Authitem::model()->findBySql($sql);
        return $result;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}