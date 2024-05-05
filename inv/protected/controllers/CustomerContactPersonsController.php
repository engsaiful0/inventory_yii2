<?php

class CustomerContactPersonsController extends Controller {

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
    
    public function actionContactPersonsOfThis() {
        $customer_id = $_POST['customer_id'];
        $personList = '';
        
        if ($customer_id != '') {
            $condition = 'company_id = ' . $customer_id . ' ORDER BY contact_person_name ASC';
            $data = CustomerContactPersons::model()->findAll(array("condition" => $condition,), "id");
            
            if ($data) {
                $personList = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $personList .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->contact_person_name), true);
                }
            } else {
                $personList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
           $personList = CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        }
        echo CJSON::encode(array(
            'personList' => $personList,
        ));
    }
   

    public function actionContacts($company_id){
        $condition = "company_id=" . $company_id . " ORDER BY id DESC";
        $data = CustomerContactPersons::model()->findAll(array('condition' => $condition,), 'id');

        $this->renderPartial('contacts', array('data' => $data, 'company_id' => $company_id));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    
    public function actionAddContactPerson($company_id) {
        $company_id = $_GET['company_id'];

        $model = new CustomerContactPersons();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerContactPersons'])) {
            $model->attributes = $_POST['CustomerContactPersons'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">Contact Person Added</div>',
                    ));
                    exit;
                }
                else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_addContactPersonForm', array(
                    'model' => $model,
                    'company_id' => $company_id,
                        ), true, true),
            ));
            exit;
        }
        else
            $this->redirect('admin');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
     public function actionCreate() {
        $model = new CustomerContactPersons;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerContactPersons'])) {
            $model->attributes = $_POST['CustomerContactPersons'];
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

        if (isset($_POST['CustomerContactPersons'])) {
            $model->attributes = $_POST['CustomerContactPersons'];
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
        $model = new CustomerContactPersons('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerContactPersons']))
            $model->attributes = $_GET['CustomerContactPersons'];

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
        $model = CustomerContactPersons::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-contact-persons-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
