<?php

class CustomerBillController extends Controller {

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
    
    public function actionBillPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = CustomerBill::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('mainData' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set bill no!</div>';
        }
    }
    
    public function actionBillCreate() {
        $model = new CustomerBill;

        $this->render('billCreate', array(
            'model' => $model,
        ));
    }

    public function actionBillCreateView() {
        $customer_id = $_POST['CustomerBill']['customer_id'];

        if ($customer_id != "") {
            $criteria = new CDbCriteria();
            $criteria->select="sl_no, d_date";
            $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
            $criteria->addColumnCondition(array("bill" => 0), "AND", "AND");
            $criteria->order = "d_date ASC";
            $criteria->group = "sl_no";
            $data = SellDelvRtn::model()->findAll($criteria);
            
            echo CJSON::encode(array(
                'content' => $this->renderPartial('billCreateView', array(
                    'data' => $data,
                    'customer_id'=>$customer_id,
                        ), true, true),
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CustomerBill;
        $customerIds = "no_customer";
        $challanNumbers = "no_challan_no";
        
        if (isset($_POST['attrChallanNoArr']) && isset($_POST['attrCustomerIdArr'])) {
            $customerIds = $_POST['attrCustomerIdArr'];
            $challanNumbers = $_POST['attrChallanNoArr'];
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerBill'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                
                if ($model->validate()) {
                    if (isset($_POST['CustomerBill']['challan_no'])) {
                        date_default_timezone_set("Asia/Dhaka");
                        $todayDate = $_POST['CustomerBill']['bill_date'];
                        $dateForInvNo = str_replace("-", "", $todayDate);
                        $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("CustomerBill", 'max_sl_no', 'maxSINo', 'bill_date', $todayDate);
                        $slInvNo = $dateForInvNo . $thisInvMaxNo;
                        $i = 0;
                        $jsPart="<script>";
                        foreach ($_POST['CustomerBill']['challan_no'] as $tempChallanNo):
                            
                            $jsPart.='$(".challanInfoRow_'.$tempChallanNo.'").remove();';
                            
                            $model = new CustomerBill;
                            $model->challan_no = $tempChallanNo;
                            $model->customer_id = $_POST['CustomerBill']['customer_id'];
                            $model->bill_date = $_POST['CustomerBill']['bill_date'];
                            $model->due_date = $_POST['CustomerBill']['due_date'];
                            $model->sl_no = $slInvNo;
                            $model->max_sl_no = $thisInvMaxNo;
                            $model->save();
                            SellDelvRtn::model()->updateAll(array("bill"=>1), "sl_no=:sl_no", array(":sl_no"=>$tempChallanNo));
                            $i++;
                        endforeach;
                        $condition = "sl_no='" . $model->sl_no . "'";
                        $data = CustomerBill::model()->findAll(array("condition" => $condition));
                        $jsPart.="</script>";
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => $this->renderPartial('voucherPreview', array('mainData' => $data), true, true),
                            'jsPart'=>$jsPart,
                        ));
                        exit;
                    }else {
                        exit;
                    }
                } else {
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_form', array(
                    'model' => $model,
                    'customerIds' => $customerIds,
                    'challanNumbers' => $challanNumbers,
                        ), true, true),
            ));
            exit;
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model_item = new CustomerBill;
            $thisInfo = CustomerBill::model()->findByPk($id);
            SellDelvRtn::model()->updateAll(array("bill"=>0), "sl_no=:sl_no", array(":sl_no"=>$thisInfo->challan_no));
            $model_item->deleteByPk($id);
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDeleteAll() {
        if (isset($_POST['customer-bill-grid_c0'])) {
            $del_item = $_POST['customer-bill-grid_c0'];
            $model_item = new CustomerBill;
            foreach ($del_item as $_id) {
                $thisInfo = CustomerBill::model()->findByPk($_id);
                SellDelvRtn::model()->updateAll(array("bill"=>0), "sl_no=:sl_no", array(":sl_no"=>$thisInfo->challan_no));
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
        $model = new CustomerBill('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerBill']))
            $model->attributes = $_GET['CustomerBill'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminCreditMemo() {
        $model = new CustomerBill('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerBill']))
            $model->attributes = $_GET['CustomerBill'];

        $this->render('adminCreditMemo', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CustomerBill::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-bill-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
