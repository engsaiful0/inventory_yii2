<?php

/**
 * This is the model class for table "authassignment".
 *
 * The followings are the available columns in table 'authassignment':
 * @property string $itemname
 * @property integer $userid
 * @property string $bizrule
 */
class Authassignment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Authassignment the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'authassignment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('itemname', 'required'),
            array('userid', 'numerical', 'integerOnly' => true),
            array('itemname', 'length', 'max' => 64),
            array('bizrule', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('itemname, userid, bizrule', 'safe', 'on' => 'search'),
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
            'itemname' => 'Permission',
            'userid' => 'EIIN',
            'bizrule' => 'Bizrule',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        // $criteria = new CDbCriteria;

        $criteria = new CDbCriteria(array('condition' => 'itemname!="Admin"'));

        if (strlen($this->userid)) {
            $uid = Users::model()->findByAttributes(array('id' => $this->userid));
            if ($uid)
                $userid = $uid->id;
            else
                $userid="";
            $criteria->compare('userid', $userid);
        }

        $criteria->compare('itemname', $this->itemname);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000,
            ),
//            'sort' => array(
//                'defaultOrder' => 'esif ASC',
//            ),
        ));
    }

}