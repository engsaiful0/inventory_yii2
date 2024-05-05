<?php

class CreditMemoController extends Controller {

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
    
    public function actionVoucherPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = CreditMemo::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set voucher no!</div>';
        }
    }
    
    public function actionCreate($sl_no) {
        $model = new CreditMemo;
        $condition = "sl_no='" . $sl_no . "'";
        $billInfo = CustomerBill::model()->findAll(array('condition' => $condition,));

        if (isset($_POST['CreditMemo'])) {
            $model->attributes = $_POST['CreditMemo'];
            date_default_timezone_set("Asia/Dhaka");
            $todayDate = $_POST['CreditMemo']['date'];
            $dateForInvNo = str_replace("-", "", $todayDate);
            $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("CreditMemo", 'max_sl_no', 'maxSINo', 'date', $todayDate);
            $slInvNo = $dateForInvNo . $thisInvMaxNo;
            $model->sl_no=$slInvNo;
            $model->max_sl_no=$thisInvMaxNo;
            if ($model->save()){
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    $condition = "sl_no='" . $model->sl_no . "'";
                    $data = CreditMemo::model()->findAll(array("condition" => $condition));
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                    ));
                    Yii::app()->end();
                }
            } 
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_form', array(
                    'model' => $model,
                    'billInfo' => $billInfo,
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

        if (isset($_POST['CreditMemo'])) {
            $model->attributes = $_POST['CreditMemo'];
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
        if (isset($_POST['credit-memo-grid_c0'])) {
            $del_item = $_POST['credit-memo-grid_c0'];
            $model_item = new CreditMemo;
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
        $model = new CreditMemo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CreditMemo']))
            $model->attributes = $_GET['CreditMemo'];

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
        $model = CreditMemo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'credit-memo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
