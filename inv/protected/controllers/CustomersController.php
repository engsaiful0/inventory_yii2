<?php

class CustomersController extends Controller {

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
    
    public function actionCustomerLedgerAll(){
        $model = new Customers;

        $this->render('customerLedgerAll', array(
            'model' => $model,
        ));
    }
    
    public function actionCustomerLedgerAllView(){
        $startDate = $_POST['Customers']['startDate'];
        $endDate = $_POST['Customers']['endDate'];
        
        if ($startDate != "" && $endDate != "") {
            $message = "All Customer Ledger From " . $startDate . " to " . $endDate;
            $criteria=new CDbCriteria();
            $criteria->order="company_name ASC";
            $data = Customers::model()->findAll($criteria);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
            $data = "";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('customerLedgerAllView', array(
                'data' => $data,
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                    ), true, true),
        ));
    }
    
    public function actionCustomerLedgerSpecific(){
        $model = new Customers;

        $this->render('customerLedgerSpecific', array(
            'model' => $model,
        ));
    }
    
    public function actionCustomerLedgerSpecificView(){
        $startDate = $_POST['Customers']['startDate'];
        $endDate = $_POST['Customers']['endDate'];
        $id = $_POST['Customers']['id'];
        
        if ($startDate != "" && $endDate != "" && $id!="") {
            $customerInfo = Customers::model()->customerNameAndAddress($id);
            $message = "Specific Customer Ledger From " . $startDate . " to " . $endDate."<br>".$customerInfo;
        } else {
            $message = "<div class='flash-error'>Please select date range & customer !</div>";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('customerLedgerSpecificView', array(
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'id'=>$id,
                    ), true, true),
        ));
    }

    public function actionAdminMoneyReceipt() {
        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

        $this->render('adminMoneyReceipt', array(
            'model' => $model,
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Customers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
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

    public function actionCreateCustomerFromOutSide() {
        $model = new Customers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Customers::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => "<div class='flash-notice'>New Customer successfully added</div>",
                        'value' => $data->id,
                        'label' => $data->company_name,
                    ));
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $resultDiv = '';
            echo CJSON::encode(array(
                'status' => 'failure',
                'resultDiv' => $resultDiv,
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
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

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
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
        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

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
        $model = Customers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
