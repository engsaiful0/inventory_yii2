<?php

class ImportDocument extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ImportDocument the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'import_document';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lc_id, pi_no, pi_date', 'required'),
            array('lc_id', 'numerical', 'integerOnly' => true),
            array('pi_no', 'length', 'max' => 255),
            array('pi_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, lc_id, pi_no, pi_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lc' => array(self::BELONGS_TO, 'MasterLc', 'lc_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'lc_id' => 'LC No',
            'pi_no' => 'PI No',
            'pi_date' => 'PI Date',
        );
    }
    
    public function beforeSave() {
       
        $data = MasterLc::model()->findByPk($this->lc_id);
        if($data){
            $ponos=explode(",", $data->po_no);
            for($i=0; $i<count($ponos); $i++):
                PurchaseOrder::model()->updateAll(array('is_verified'=>PurchaseOrder::VERIFIED), 'sl_no=:sl_no', array(':sl_no' => $ponos[$i]));
            endfor;
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

        $criteria->compare('id', $this->id);
        $criteria->compare('lc_id', $this->lc_id);
        $criteria->compare('pi_no', $this->pi_no, true);
        $criteria->compare('pi_date', $this->pi_date, true);

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