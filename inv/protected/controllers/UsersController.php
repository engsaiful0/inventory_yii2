<?php

class UsersController extends Controller {

    public $layout = '//layouts/column2';
    private $_model;

    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions() {
        return '';
    }


    public function actionCreate() {
        $model = new Users;
        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                //do anything here
                echo CJSON::encode(array(
                    'status' => 'success'
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
   
    public function actionUpdate() {
        $model = $this->loadModel();
        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
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

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            //Yii::app()->user->isSuperuser;  OR Rights::getAuthorizer()->isSuperuser(Yii::app()->user->getId());
            if(Rights::getAuthorizer()->isSuperuser($id)===true ){
                echo "<div class='flash-error'>Can not delete Super User! You can only change the info.</div>"; //for ajax
            }else{
                $this->loadModel()->delete();
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminAssignStore(){
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->render('adminAssignStore', array(
            'model' => $model,
        ));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Users::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
