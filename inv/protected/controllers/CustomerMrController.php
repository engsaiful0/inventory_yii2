<?php

class CustomerMrController extends Controller {

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

    public function actionMoneyReceiptHistory($customer_id) {
        $criteria = new CDbCriteria();
        $criteria->select = "sl_no, date";
        $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
        $criteria->order = "id ASC";
        $criteria->group = "sl_no";
        $data = CustomerMr::model()->findAll($criteria);

        $this->renderPartial('moneyReceiptHistory', array('groupData' => $data, 'customer_id' => $customer_id));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionMrPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = CustomerMr::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('mainData' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set MR no!</div>';
        }
    }

    public function actionAddMoneyReceipt($customer_id) {

        $model = new CustomerMr;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerMr'])) {
            if (isset($_POST['CustomerMr']['bill_no'])) {
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['CustomerMr']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("CustomerMr", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                foreach ($_POST['CustomerMr']['bill_no'] as $tempBillNo) {
                    if($_POST['CustomerMr']['paid_amount'][$i]>0){
                        $model = new CustomerMr;
                        $model->bill_no = $tempBillNo;
                        $model->date = $_POST['CustomerMr']['date'];
                        $model->customer_id = $_POST['CustomerMr']['customer_id'];
                        $model->received_type = $_POST['CustomerMr']['received_type'][$i];
                        $model->bank_name = $_POST['CustomerMr']['bank_name'][$i];
                        $model->cheque_no = $_POST['CustomerMr']['cheque_no'][$i];
                        $model->cheque_date = $_POST['CustomerMr']['cheque_date'][$i];
                        $model->paid_amount = $_POST['CustomerMr']['paid_amount'][$i];
                        if ($_POST['CustomerMr']['discount'][$i] != "")
                            $model->discount = $_POST['CustomerMr']['discount'][$i];
                        else
                            $model->discount = 0;
                        $model->sl_no = $slInvNo;
                        $model->max_sl_no = $thisInvMaxNo;
                        $model->save();
                    }
                    $i++;
                }
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    $condition = "sl_no='" . $model->sl_no . "'";
                    $data = CustomerMr::model()->findAll(array("condition" => $condition));
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => $this->renderPartial('voucherPreview', array('mainData' => $data), true, true),
                    ));
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_addMoneyReceiptForm', array(
                    'model' => $model,
                    'customerId' => $customer_id,
                        ), true, true),
            ));
            exit;
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

        if (isset($_POST['CustomerMr'])) {
            $model->attributes = $_POST['CustomerMr'];
            $model->setScenario('isChequePaymentScenario');
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

    public function actionDeleteAll() {
        if (isset($_POST['customer-mr-grid_c0'])) {
            $del_item = $_POST['customer-mr-grid_c0'];
            $model_item = new CustomerMr;
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
        $model = new CustomerMr('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerMr']))
            $model->attributes = $_GET['CustomerMr'];

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
        $model = CustomerMr::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-mr-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
