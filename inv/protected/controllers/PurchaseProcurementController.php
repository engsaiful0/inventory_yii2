<?php

class PurchaseProcurementController extends Controller {

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
    
    public function actionProcurementPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = PurchaseProcurement::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set procurement no!</div>';
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    
    public function actionCreate($sl_no) {
        $data = PurchaseRequisition::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
        if ($data) {
            $model = new PurchaseProcurement;
            $this->performAjaxValidation($model);
            
            if (isset($_POST['PurchaseProcurement'])) {
                $model->attributes = $_POST['PurchaseProcurement'];
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['PurchaseProcurement']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseProcurement", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                $prNo=$_POST['PurchaseProcurement']['req_no'];
                foreach ($_POST['PurchaseProcurement']['item'] as $tempItem):
                    $model = new PurchaseProcurement;
                    $model->item = $tempItem;
                    $model->req_id = $_POST['PurchaseProcurement']['req_id'][$i];
                    $model->qty = $_POST['PurchaseProcurement']['qty'][$i];
                    $model->name_of_unit = $_POST['PurchaseProcurement']['name_of_unit'][$i];
                    $model->cost = $_POST['PurchaseProcurement']['cost'][$i];
                    $model->remarks = $_POST['PurchaseProcurement']['remarks'][$i];
                    $model->date = $_POST['PurchaseProcurement']['date'];
                    $model->store = $_POST['PurchaseProcurement']['store'];
                    $model->procurement_by=$_POST['PurchaseProcurement']['procurement_by'];
                            $model->approve_to=$_POST['PurchaseProcurement']['approve_to'];
                    $model->department = $_POST['PurchaseProcurement']['department'];
                    $model->supplier_id = $_POST['PurchaseProcurement']['supplier_id'];
                    $model->order_type = $_POST['PurchaseProcurement']['order_type'];
                    $model->order_sub_type = $_POST['PurchaseProcurement']['order_sub_type'];
                    $model->req_no = $prNo;
                    $model->sl_no = $slInvNo;
                    $model->max_sl_no = $thisInvMaxNo;
                    $model->save();
                    if($model->req_id!="")
                        PurchaseRequisition::model()->updateByPk($model->req_id, array('is_pp_created' => 1));
                    $i++;
                endforeach;
                $this->redirect(array('/purchaseRequisition/adminPP'));
            } else {
                $this->render('_form', array(
                    'model' => $model,
                    'itemsModel' => new Items,
                    'sl_no' => $sl_no,
                ));
            }
        } else {
            $this->redirect(array('/purchaseRequisition/adminPP'));
        }
    }
    

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
     public function actionUpdate($sl_no) {
        $model = new PurchaseProcurement;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseProcurement'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['PurchaseProcurement']['item'] as $tempItems):
                    $isExist = PurchaseProcurement::model()->findByPk($_POST['PurchaseProcurement']['id'][$i]);
                    if ($isExist) {
                        PurchaseProcurement::model()->updateByPk($_POST['PurchaseProcurement']['id'][$i], array(
                            'sl_no'=>$_POST['PurchaseProcurement']['sl_no'],
                            'max_sl_no'=>$_POST['PurchaseProcurement']['max_sl_no'],
                            'req_id'=>$_POST['PurchaseProcurement']['req_id'][$i],
                            'req_no'=>$_POST['PurchaseProcurement']['req_no'],
                            'item'=>$tempItems,
                            'qty'=>$_POST['PurchaseProcurement']['qty'][$i],
                            'name_of_unit'=>$_POST['PurchaseProcurement']['name_of_unit'][$i],
                            
                            'cost'=>$_POST['PurchaseProcurement']['cost'][$i],
                            'remarks'=>$_POST['PurchaseProcurement']['remarks'][$i],
                            'store'=>$_POST['PurchaseProcurement']['store'],
                            'department'=>$_POST['PurchaseProcurement']['department'],
                            'procurement_by'=>$_POST['PurchaseProcurement']['procurement_by'],
                            'approve_to'=>$_POST['PurchaseProcurement']['approve_to'],
                            'date'=>$_POST['PurchaseProcurement']['date'],
                            'supplier_id'=>$_POST['PurchaseProcurement']['supplier_id'],
                            'order_type'=>$_POST['PurchaseProcurement']['order_type'],
                            'order_sub_type'=>$_POST['PurchaseProcurement']['order_sub_type'],
                            'created_by'=>$_POST['PurchaseProcurement']['created_by'],
                            'created_time'=>$_POST['PurchaseProcurement']['created_time'],
                            'updated_by'=>Yii::app()->user->getId(),
                            'updated_time'=>new CDbExpression('NOW()'),
                        ));
                        if($_POST['PurchaseProcurement']['req_id'][$i]!="")
                            PurchaseRequisition::model()->updateByPk($_POST['PurchaseProcurement']['req_id'][$i], array('is_pp_created' => 1));
                    } else {
                        $model = new PurchaseProcurement;
                        $model->item = $tempItems;
                        $model->req_id = $_POST['PurchaseProcurement']['req_id'][$i];
                        $model->qty = $_POST['PurchaseProcurement']['qty'][$i];
                        $model->cost = $_POST['PurchaseProcurement']['cost'][$i];
                        $model->name_of_unit = $_POST['PurchaseProcurement']['name_of_unit'][$i];
                        
                        $model->remarks = $_POST['PurchaseProcurement']['remarks'][$i];
                        $model->date = $_POST['PurchaseProcurement']['date'];
                        $model->store = $_POST['PurchaseProcurement']['store'];
                        $model->procurement_by=$_POST['PurchaseProcurement']['procurement_by'];
                            $model->approve_to=$_POST['PurchaseProcurement']['approve_to'];
                        $model->department = $_POST['PurchaseProcurement']['department'];
                        $model->supplier_id = $_POST['PurchaseProcurement']['supplier_id'];
                        $model->order_type = $_POST['PurchaseProcurement']['order_type'];
                        $model->order_sub_type = $_POST['PurchaseProcurement']['order_sub_type'];
                        $model->req_no = $_POST['PurchaseProcurement']['req_no'];
                        $model->created_by = Yii::app()->user->getId();
                        $model->created_time = new CDbExpression('NOW()');
                        $model->sl_no = $_POST['PurchaseProcurement']['sl_no'];
                        $model->max_sl_no = $_POST['PurchaseProcurement']['max_sl_no'];
                        $model->save();
                        if($_POST['PurchaseProcurement']['req_id'][$i]!="")
                                PurchaseRequisition::model()->updateByPk($_POST['PurchaseProcurement']['req_id'][$i], array('is_pp_created' => 1));
                    }
                    $i++;
                endforeach;
                $condition = "sl_no='" . $sl_no . "'";
                $data = PurchaseProcurement::model()->findAll(array("condition" => $condition));
                echo CJSON::encode(array(
                    'status' => 'success',
                    'voucherPreview' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                ));
                Yii::app()->end();
            }else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('_form2', array(
                'model' => $model,
                'itemsModel' => new Items,
                'sl_no'=>$sl_no,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($sl_no) {
        PurchaseProcurement::model()->deleteAll(array("condition"=>"sl_no='".$sl_no."'"));
        $this->redirect(array('admin'));
    }
    
    public function actionDeleteFromUpdate() {
        if(isset($_POST["id"])){
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                PurchaseProcurement::model()->deleteByPk($_POST["id"]);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDeleteAll() {
        if (isset($_POST['purchase-procurement-grid_c0'])) {
            $del_item = $_POST['purchase-procurement-grid_c0'];
            $model_item = new PurchaseProcurement;
            foreach ($del_item as $_id) {
                $model_item->deleteByPk($_id);
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to delete.');
            $this->redirect(array('admin'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PurchaseProcurement('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseProcurement']))
            $model->attributes = $_GET['PurchaseProcurement'];

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
        $model = PurchaseProcurement::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-procurement-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
