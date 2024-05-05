<?php

class MemberPointsConf extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return MemberPointsConf the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'member_points_conf';
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
            array('is_active, start_date, end_date, point_add_after_amount, point_add, over_amount, each_point_amount, usable_after_point', 'required'),
            array('is_active', 'numerical', 'integerOnly' => true),
            array('point_add_after_amount, point_add, over_amount, each_point_amount, usable_after_point', 'numerical'),
            array('start_date, end_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, is_active, start_date, end_date, point_add_after_amount, point_add, over_amount, each_point_amount, usable_after_point', 'safe', 'on' => 'search'),
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
            'is_active' => 'Is Active',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'point_add_after_amount'=>'Start Adding After (Amount)',
            'point_add' => 'Points (To Be Added)',
            'over_amount' => 'After Starting Amount, Start Adding After Each (Amount)',
            'each_point_amount' => 'Amount For Each Points',
            'usable_after_point'=>'Points Usable After (Points)',
        );
    }

    public function afterSave() {
        if ($this->is_active == self::ACTIVE) {
            self::model()->updateAll(array('is_active' => self::INACTIVE), 'id!=:id', array(':id' => $this->id));
        }
        return parent::afterSave();
    }
    
    public function statusColor($status) {
        if ($status == self::ACTIVE) {
            echo "<font color='green'>ACTIVE</font>";
        } else {
            echo "<font color='red'>INACTIVE</font>";
        }
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
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('point_add_after_amount', $this->point_add_after_amount);
        $criteria->compare('point_add', $this->point_add);
        $criteria->compare('over_amount', $this->over_amount);
        $criteria->compare('each_point_amount', $this->each_point_amount);
        $criteria->compare('usable_after_point', $this->usable_after_point);

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