<?php

class MasterLcController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions() {
        return '';
    }
    
    public function actionVerifiedImportPurchaseOrder() {
        $supplierId = $_POST['supplierId'];
        $verifiedImportPurchaseOrder = "";
        
        if ($supplierId != '') {
            $conditionPP="supplier_id=".$supplierId." AND order_type=".PurchaseProcurement::IMPORT;
            $dataPP=  PurchaseProcurement::model()->findAll(array('condition'=>$conditionPP));
            if($dataPP){
                $ppIds=array();
                foreach($dataPP as $dpp){
                    $ppIds[]=$dpp->id;
                }
                
                $criteria=new CDbCriteria();
                $criteria->select="sl_no";
                $criteria->addInCondition('procurement_id', $ppIds);
                $criteria->addColumnCondition(array(
                    "is_verified"=>PurchaseOrder::NON_VERIFIED,
                ), "AND", "AND");
                $criteria->group="sl_no";
                $data = PurchaseOrder::model()->findAll($criteria);
                if ($data) {
                    $count=0;
                    foreach ($data as $d) {
                        $count++;
                        if($count>1)
                            $commaSeparator=",";
                        else
                            $commaSeparator="";
                        $verifiedImportPurchaseOrder .= $commaSeparator.$d->sl_no;

                    }
                } else {
                    $verifiedImportPurchaseOrder = "";
                }
            }else {
                $verifiedImportPurchaseOrder = "";
            }
        } else {
                $verifiedImportPurchaseOrder = "";
        }
        echo CJSON::encode(array(
            'verifiedImportPurchaseOrder' => $verifiedImportPurchaseOrder,
        ));
    }
    
    public function actionDetailsOfThisLc(){
        $lcId = $_POST['lcId'];
        $lcDetails = "";
        
        if ($lcId != '') {
            $data = MasterLc::model()->findByPk($lcId);
            
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
                            $itemDetails .=Items::model()->nameOfThisOnly($purchaseProcData->item).$hrbrk;
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
                $lcDetails = "<div class='flash-error'>No result found!</div>";
            }
        } else {
                $lcDetails = "<div class='flash-error'>Please select LC No!</div>";
        }
        echo CJSON::encode(array(
            'lcDetails' => $lcDetails,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->renderPartial('view', array('model' => $model,));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    
    public function actionCreate() {
        $model = new MasterLc;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MasterLc'])) {
            $model->attributes = $_POST['MasterLc'];
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                //do anything here
                
                echo CJSON::encode(array(
                    'status' => 'success',
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        }else {
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MasterLc'])) {
            $model->attributes = $_POST['MasterLc'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">successfully updated</div>',
                    ));
                    exit;
                }
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_form2', array(
                    'model' => $model), true, true),
            ));
            exit;
        }
        else
            $this->render('update', array('model' => $model));
    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MasterLc('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MasterLc']))
            $model->attributes = $_GET['MasterLc'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = MasterLc::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-lc-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
