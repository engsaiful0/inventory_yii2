<?php

class MasterLc extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return MasterLc the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'master_lc';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplier_id, lc_no, shipment_date, expire_date, lc_date, lc_tenor_id, bank_id, po_no', 'required'),
            array('supplier_id, lc_tenor_id, bank_id', 'numerical', 'integerOnly' => true),
            array('lc_amount', 'numerical'),
            array('lc_no, export_lc_no, remarks, po_no, shipment_from, shipment_to, hs_code, insurance_company, agent, c_f_agent, transport_agency, lc_amended', 'length', 'max' => 255),
            array('shipment_date, expire_date, lc_date, last_date_of_shipmentt', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, supplier_id, lc_no, lc_amount, shipment_date, expire_date, lc_date, lc_tenor_id, export_lc_no, bank_id, remarks, po_no, shipment_from, shipment_to, hs_code, insurance_company, agent, c_f_agent, transport_agency, lc_amended, last_date_of_shipment', 'safe', 'on' => 'search'),
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
            'supplier_id' => 'Supplier',
            'lc_no' => 'LC No',
            'lc_amount' => 'LC Amount',
            'shipment_date' => 'Shipment Date',
            'expire_date' => 'Expire Date',
            'lc_date' => 'LC Date',
            'lc_tenor_id' => 'LC Tenor',
            'export_lc_no' => 'Export LC No',
            'bank_id' => 'Bank',
            'remarks' => 'Remarks',
            'po_no' => 'PO No(s)',
            'shipment_from'=>'Shipment From',
            'shipment_to'=>'Shipment To',
            'hs_code'=>'HS Code',
            'insurance_company'=>'Insurance Company',
            'agent'=>'Agent',
            'c_f_agent'=>'C & F Agent',
            'transport_agency'=>'Transport Agency',
            'lc_amended'=>'LC Amended',
            'last_date_of_shipment'=>'Last Date of Shipment',
            
        );
    }
    
    public function findAllWithoutCreated(){
        $criteriaImportDoc=new CDbCriteria();
        $criteriaImportDoc->select="lc_id";
        $importDocData=  ImportDocument::model()->findAll($criteriaImportDoc);
        $createdLcIds=array();
        if($importDocData){
            foreach($importDocData as $impdd):
                $createdLcIds[]=$impdd->lc_id;
            endforeach;
        }
        $criteria=new CDbCriteria();
        $criteria->addNotInCondition("id", $createdLcIds);
        $data=self::model()->findAll($criteria);
        return $data;
    }
    
    public function nameOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->lc_no;
    }
    
    public function lcDetails($lcId){
        $lcDetails = "";
        
        if ($lcId != '') {
            $data = self::model()->findByPk($lcId);
            
            if ($data) {
                $ponos=explode(",", $data->po_no);
                $lcDetails .= "<table class='checkoutTab'>";
                $lcDetails .= "<tr><th style='text-align: left;'>Supplier</th><td>".Suppliers::model()->supplierName($data->supplier_id)."</td><th style='text-align: left;'>LC No</th><td>".$data->lc_no."</td><th style='text-align: left;'>LC Amount</th><td>".$data->lc_amount."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Shipment Date</th><td>".$data->shipment_date."</td><th style='text-align: left;'>Expire Date</th><td>".$data->expire_date."</td><th style='text-align: left;'>LC Date</th><td>".$data->lc_date."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Shipment From</th><td>".$data->shipment_from."</td><th style='text-align: left;'>Shipment To</th><td>".$data->shipment_to."</td><th style='text-align: left;'>HS Code</th><td>".$data->hs_code."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Insurance Company</th><td>".$data->insurance_company."</td><th style='text-align: left;'>Expire Agent</th><td>".$data->agent."</td><th style='text-align: left;'>C & F Agent</th><td>".$data->c_f_agent."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Transport Agency</th><td>".$data->transport_agency."</td><th style='text-align: left;'>LC Amended</th><td>".$data->lc_amended."</td><th style='text-align: left;'>Last Date of Shipment</th><td>".$data->last_date_of_shipment."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Export Tenor</th><td>".Tenors::model()->nameOfThis($data->lc_tenor_id)."</td><th style='text-align: left;'>Export LC No</th><td>".$data->export_lc_no."</td><th style='text-align: left;'>Bank</th><td>".Banks::model()->nameOfThis($data->bank_id)."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>Remarks</th><td colspan='5'>".$data->remarks."</td></tr>";
                $lcDetails .= "<tr><th style='text-align: left;'>PO Details</th><td colspan='5'>";
                $lcDetails .= "<table class='checkoutTab'>";
                $lcDetails .="<tr><th>PO No</th><th>Issue Date</th><th>Item Details</th></tr>";
                for($i=0; $i<count($ponos); $i++):
                    $condition="sl_no='".$ponos[$i]."'";
                    $poData=  PurchaseOrder::model()->findAll(array('condition'=>$condition),'id');
                    if($poData){
                        $itemDetails="";
                        $countpoData=count($poData);
                        $cnt=0;
                        foreach ($poData as $pod):
                            $cnt++;
                            if($cnt==$countpoData)
                                $hrbrk="";
                            else
                                $hrbrk="<hr>";
                            $issuedDate=$pod->issue_date;
                            $purchaseProcData=  PurchaseProcurement::model()->findByPk($pod->procurement_id);
                            $itemDetails .=Items::model()->nameOfThis($purchaseProcData->item).$hrbrk;
                        endforeach;
                        $lcDetails .="<tr><td>".$ponos[$i]."</td><td>".$issuedDate."</td><td style='text-align: left;'>".$itemDetails."</td></tr>";
                    }else{
                        $lcDetails .="<tr><td colspan='3'><div class='flash-error'>Notice! PO info. not found!</div></td></tr>";
                    }
                endfor;
                $lcDetails .= "</table>";
                $lcDetails .="</td></tr>";
                $lcDetails .= "</table>";
            } else {
                $lcDetails = "<div class='flash-error'>Notice! No result found!</div>";
            }
        } else {
                $lcDetails = "<div class='flash-error'>Notice! Please select LC No!</div>";
        }
        
        echo $lcDetails;
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
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('lc_no', $this->lc_no, true);
        $criteria->compare('lc_amount', $this->lc_amount);
        $criteria->compare('shipment_date', $this->shipment_date, true);
        $criteria->compare('expire_date', $this->expire_date, true);
        $criteria->compare('lc_date', $this->lc_date, true);
        $criteria->compare('lc_tenor_id', $this->lc_tenor_id);
        $criteria->compare('export_lc_no', $this->export_lc_no, true);
        $criteria->compare('bank_id', $this->bank_id);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('po_no', $this->po_no, true);
        $criteria->compare('shipment_from', $this->shipment_from, true);
        $criteria->compare('shipment_to', $this->shipment_to, true);
        $criteria->compare('hs_code', $this->hs_code, true);
        $criteria->compare('insurance_company', $this->insurance_company, true);
        $criteria->compare('agent', $this->agent, true);
        $criteria->compare('c_f_agent', $this->c_f_agent, true);
        $criteria->compare('transport_agency', $this->transport_agency, true);
        $criteria->compare('lc_amended', $this->lc_amended, true);
        $criteria->compare('last_date_of_shipment', $this->last_date_of_shipment, true);

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