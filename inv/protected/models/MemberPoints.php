<?php

class MemberPoints extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return MemberPoints the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'member_points';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_id, date, inv_no', 'required'),
            array('added_point', 'required', 'on'=>'addPointsScenario'),
            array('used_point', 'required', 'on'=>'reducePointsScenario'),
            array('member_id, added_by, reduced_by', 'numerical', 'integerOnly' => true),
            array('added_point, used_point', 'numerical'),
            array('remarks, inv_no', 'length', 'max' => 255),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, member_id, added_point, used_point, date, remarks, inv_no, added_by, reduced_by', 'safe', 'on' => 'search'),
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
            'member_id' => 'Member',
            'inv_no'=>'Invoice No',
            'added_point' => 'Added Point',
            'used_point' => 'Used Point',
            'date' => 'Date',
            'remarks' => 'Remarks',
            'added_by'=>'Added By',
            'reduced_by'=>'Reduced By',
        );
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
        $criteria->compare('member_id', $this->member_id);
        $criteria->compare('inv_no', $this->inv_no);
        $criteria->compare('added_point', $this->added_point);
        $criteria->compare('used_point', $this->used_point);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('added_by', $this->added_by);
        $criteria->compare('reduced_by', $this->reduced_by);

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