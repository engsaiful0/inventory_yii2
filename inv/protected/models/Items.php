<?php

class Items extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Items the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'items';
    }
    
    public $barCodeGenerator;
    public $activeCostinglPrice;
    public $activeSellinglPrice;
    
    const VIRGIN=3;
    const RECYCLED=4;

    public $maxval;
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat, name, unit', 'required', 'on'=>'updateScenario'),
            array('cat, cat_sub, is_rawmat, pbrand, pmodel, country, grade, mfi, product_type, unit_convertable, supplier_id, vatable', 'numerical', 'integerOnly' => true),
            array('warn_qty', 'numerical'),
            array('code, name, desc, unit,store', 'length', 'max' => 255),
            //array('name, desc', 'match', 'pattern' => '/^[A-Za-z0-9-, ]+$/u', 'message' => 'Allowed characters- a-z, A-Z, 0-9, comma & dash'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cat, cat_sub, code, name, desc, unit, is_rawmat, pbrand, pmodel, country, grade, mfi, product_type, warn_qty, unit_convertable, supplier_id, vatable', 'safe', 'on' => 'search'),
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
    
    public function getNameWithDesc(){
        return $this->name." (".$this->code.")- ".$this->desc;
    }
    
    public function getNameWithUnit(){
        return $this->name." (".$this->code.")- ".$this->unit;
    }
    
    public function getSupplierName(){
        return Suppliers::model()->supplierName($this->supplier_id);
    }
    
     public function existingItemSupplier(){
        $criteria=new CDbCriteria();
        $criteria->select="supplier_id";
        $criteria->condition="supplier_id!=''";
        $criteria->group="supplier_id";
        $data=self::model()->findAll($criteria);
        $emptyarray=array();
        if($data)
            return $data;
        else
            return $emptyarray;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cat' => 'Category',
            'cat_sub'=>'Sub-Category',
            'code' => 'Code',
            'name' => 'Item Name',
            'desc' => 'Specification',
            'unit' => 'Unit',
            'store'=>'Store',
            'barCodeGenerator'=>'Generate Barcode (39)',
            'activeCostinglPrice'=>'Active Costing Price',
            'activeSellinglPrice'=>'Active Selling Price',
            'pbrand'=>'Brand',
            'pmodel'=>'Model',
            'country'=>'Country',
            'grade'=>'Grade',
            'mfi'=>'MFI',
            'product_type'=>'Product Type',
            'supplier_id'=>'Supplier',
            'warn_qty'=>'Warning Quantity',
            'is_rawmat' => 'isRawMat.',
            'vatable'=>'isVATable',
            'unit_convertable'=>'isUnitConv.',
        );
    }

    public function beforeSave() {
        $this->desc=strtoupper($this->desc);
        return parent::beforeSave();
    }


    public function maxValOfThis($whatModel, $whatField, $whatFieldsMaxVal) {
        $maxVal = 0;
        $maxValL = 0;
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(' . $whatField . ') as ' . $whatFieldsMaxVal . '';
        $maxValInfo = $whatModel::model()->findAll($criteria);
        foreach ($maxValInfo as $mvi):
            $maxVal = $mvi->$whatFieldsMaxVal;
        endforeach;
        $maxNumberVal = floatval($maxVal + 1);

        if ($whatModel == "ProdModels") {
            if ($maxNumberVal == 1) {
                $list = Yii::app()->db->createCommand("SELECT `AUTO_INCREMENT`
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '" . Yii::app()->params->dbName . "'
                AND   TABLE_NAME   = 'prod_models'")->queryAll();

                foreach ($list as $item) {
                    $rs = $item['AUTO_INCREMENT'];
                }
                $maxNumberVal = $rs;
            }
        }
        return $maxNumberVal;
    }
    
    protected function beforeValidate() {
        if ($this->code) {
            
        } else {
            $thisCodeNo = self::model()->maxValOfThis('Items', 'code', 'maxval');
            $thisCodeNo = str_pad($thisCodeNo, 5, "0", STR_PAD_LEFT);
            $this->code = $thisCodeNo;
        }
        return parent::beforeValidate();
    }
    
    public function barcodeGenerator($code) {
        $link = '<form target="_blank" action="' . Yii::app()->request->baseUrl . '/myBarCodeGen/html/BCGcode39.php" method="post">';
        $link.= '<input type="hidden" name="codeTobe" value="' . $code . '">';
        $link.= '<input class="barCodeBtn" type="submit" value="Generate">';
        $link.= '</form>';

        echo $link;
    }
    
    public function item($id){
        $item="";
        $data=self::model()->findByPk($id);
        if($data){
            $cat=Cats::model()->nameOfThis($data->cat);
            $catSub=CatsSub::model()->nameOfThis($data->cat_sub);
            $name=$data->name;
            $code=$data->code;
            $desc=$data->desc;
            $unit=$data->unit;
            
            $item=$name." (".$code.")";
            if($catSub!="")
                $item.="- ".$catSub;
            $item.="- ".$cat;
            if($desc!="")
                $item.="<br>".$desc;
            $item.="<br>".$unit;
        }
        echo $item;
    }


    public function nameOfThis($id){
        $item="";
        $data=self::model()->findByPk($id);
        if($data){
            $cat=Cats::model()->nameOfThis($data->cat);
            $catSub=CatsSub::model()->nameOfThis($data->cat_sub);
            $name=$data->name;
            $code=$data->code;
            $desc=$data->desc;
            $unit=$data->unit;
            
            $item=$name." (".$code.")";
            if($catSub!="")
                $item.="- ".$catSub;
            $item.="- ".$cat;
            if($desc!="")
                $item.="- ".$desc;
            $item.="- ".$unit;
        }
        return $item;
    }
    
    const SFT=1;
    const RFT=2;
    const CFT=3;
    const SQM=4;
    
    public function convertedUnitText($conv_unit, $item, $qty) {
        $convUnit="";
        $itemInfo=self::model()->findByPk($item);
        if($itemInfo){
            $desc=$itemInfo->desc;
            $unitConvertable=$itemInfo->unit_convertable;
            $convertedUnit=self::model()->convertedUnit($unitConvertable, $desc);
            
            if ($conv_unit == self::SFT) {
            $convUnit = $convertedUnit[0]." SFT";
            } else if ($conv_unit == self::RFT) {
                $convUnit = $convertedUnit[1]." RFT";
            } else if ($conv_unit == self::CFT) {
                $convUnit = $convertedUnit[2]." CFT";
            } else if ($conv_unit == self::SQM) {
                $convUnit = $convertedUnit[3]." SQM";
            } else {
                $convUnit = "";
            }
        }
        
        return $convUnit;
    }
    
    public function convertedUnit($unitConvertable, $desc){
        $convertedUnits=array();
        $convertedUnits[0]=0;
        $convertedUnits[1]=0;
        $convertedUnits[2]=0;
        $convertedUnits[3]=0;
        if($unitConvertable==1){
            $arr = explode("X", $desc);
            if (isset($arr[0]) && isset($arr[1]) && isset($arr[2])) {
                $t = preg_replace("/[^0-9\.]/", '', $arr[0]);
                $w = preg_replace("/[^0-9\.]/", '', $arr[1]);
                $l = preg_replace("/[^0-9\.]/", '', $arr[2]);
                
                $convertedUnits[0]=($l*10.76); // SFT
                $convertedUnits[1]=($l*3.28); // RFT
                $convertedUnits[2] = (($t* 0.03937 * $w* 39.37 * $l* 39.37) / 1728); // CFT
                $convertedUnits[3]=($w*$l); // SQM
            }
        }
        return $convertedUnits;
    }
//    
//    public function nameOfThisOnly($id){
//        $data=self::model()->findByPk($id);
//        if($data)
//            return $data->name."- ".$data->code." (".$data->unit.")- ".$data->desc;
//    }
//    
//    public function unitOfThis($id){
//        $data=self::model()->findByPk($id);
//        if($data)
//            return $data->unit;
//    }
//    
//    public function nameOfThisAndUnit($id){
//        $data=self::model()->findByPk($id);
//        if($data)
//            return $data->name." (".$data->unit.")- ".$data->code;
//    }

    public function isRawmat($isRawmat){
        if($isRawmat==1)
            echo "<font color='green'>YES</font>";
        else
            echo "<font color='red'>NO</font>";
    }
    
    public function isUnitConvertable($unit_convertable){
        if($unit_convertable==1)
            echo "<font color='green'>YES</font>";
        else
            echo "<font color='red'>NO</font>";
    }
    
    public function isVatable($vatable){
        if($vatable==1)
            echo "<font color='green'>YES</font>";
        else
            echo "<font color='red'>NO</font>";
    }


    public function maxValOfThisWithDateCondition($whatModel, $whatField, $whatFieldsMaxVal, $conditionalField, $conditionalFieldVal){
        $maxVal=0;
        $criteria=new CDbCriteria();
        $criteria->select='MAX('.$whatField.') as '.$whatFieldsMaxVal.'';
        $criteria->addColumnCondition(array($conditionalField=>$conditionalFieldVal));
        $maxValInfo = $whatModel::model()->findAll($criteria);
        foreach($maxValInfo as $mvi):
            $maxVal=$mvi->$whatFieldsMaxVal;
        endforeach;
        $maxNumberVal= floatval($maxVal+1);

        return $maxNumberVal;
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
        $criteria->compare('cat', $this->cat);
        $criteria->compare('cat_sub', $this->cat_sub);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('unit', $this->unit, true);
        $criteria->compare('is_rawmat', $this->is_rawmat);
        $criteria->compare('pbrand', $this->pbrand);
        $criteria->compare('pmodel', $this->pmodel);
        $criteria->compare('country', $this->country);
        $criteria->compare('grade', $this->grade);
        $criteria->compare('mfi', $this->mfi);
        $criteria->compare('product_type', $this->product_type);
        $criteria->compare('warn_qty', $this->warn_qty);
        $criteria->compare('unit_convertable', $this->unit_convertable);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('vatable', $this->vatable);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'cat, cat_sub, id DESC',
            ),
        ));
    }

}