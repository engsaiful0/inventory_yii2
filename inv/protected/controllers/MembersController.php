<?php

class MembersController extends Controller {

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

    public function actionAddPoints($id) {
        $model = new MemberPoints;
        $memberInfo = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MemberPoints'])) {
            $model->attributes = $_POST['MemberPoints'];
            $model->added_by = Yii::app()->user->getId();
            $model->setScenario('addPointsScenario');
            if ($model->save()) {

                $newlyAddedPoint = ($memberInfo->available_point + $model->added_point);
                Members::model()->updateByPk($memberInfo->id, array("available_point" => $newlyAddedPoint));

                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">successfully saved</div>',
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
                'content' => $this->renderPartial('_formAddPoints', array(
                    'model' => $model, 'memberInfo' => $memberInfo), true, true),
            ));
            exit;
        }
    }

    public function actionReducePoints($id) {
        $model = new MemberPoints;
        $memberInfo = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MemberPoints'])) {
            $model->attributes = $_POST['MemberPoints'];
            $model->reduced_by = Yii::app()->user->getId();
            $model->setScenario('reducePointsScenario');
            if ($model->save()) {

                $newlyAddedPoint = ($memberInfo->available_point - $model->used_point);
                Members::model()->updateByPk($memberInfo->id, array("available_point" => $newlyAddedPoint));

                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => $this->renderPartial('reducePointsVoucher', array('model' => $model), true, true),
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
                'content' => $this->renderPartial('_formReducePoints', array(
                    'model' => $model, 'memberInfo' => $memberInfo), true, true),
            ));
            exit;
        }
    }

    public function actionPointsHistory($id) {
        $model = $this->loadModel($id);
        $condition = "member_id=" . $id . " ORDER BY id ASC";
        $data = MemberPoints::model()->findAll(array('condition' => $condition,), 'id');

        $this->renderPartial('pointsHistory', array('data' => $data, 'model' => $model));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionMembersAVpoint() {
        $model = new Members;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form3', array(
                    'model' => $model), true, true),
            ));
            exit;
        }
    }

    public function actionAvailablePointsOfThis() {
        $cardNo = $_POST['cardNo'];
        $contactNo = $_POST['contactNo'];
        
        if ($cardNo != "") {
            $data = Members::model()->findByAttributes(array("card_no" => $cardNo));
        } else if ($contactNo != "") {
            $data = Members::model()->findByAttributes(array("contact_no" => $contactNo));
        } else {
            $data = "";
        }
        $availablePoints = 0;
        $usablePoints=0;
        $usableAmounts=0;
        
        if ($data){
            $availablePoints = $data->available_point;

            $pointAdd = 0;
            $overAmount = 0;
            $eachPointAmount = 0;
            $usableAfterPoint=0;
            $activePointConf = MemberPointsConf::model()->findByAttributes(array('is_active' => MemberPointsConf::ACTIVE));
            if ($activePointConf) {
                $pointAdd = $activePointConf->point_add;
                $overAmount = $activePointConf->over_amount;
                $eachPointAmount = $activePointConf->each_point_amount;
                $usableAfterPoint=$activePointConf->usable_after_point;
            }
            
            if($availablePoints>=$usableAfterPoint){
                $usablePoints=(intval(($availablePoints/$usableAfterPoint))*$usableAfterPoint);
                $usableAmounts=($usablePoints*$eachPointAmount);
            }
        }
        echo CJSON::encode(array(
            'availablePoints' => $availablePoints,
            'usablePoints'=>$usablePoints,
            'usableAmounts'=>$usableAmounts,
        ));
    }

    public function actionCreateMembersFromOutSide() {
        $model = new Members;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if (isset($_POST['Members'])) {
            $model->attributes = $_POST['Members'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Members::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => "<div class='flash-notice'>New member successfully added</div>",
                        'value' => $data->id,
                        'label' => $data->card_no,
                    ));
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form2', array('model' => $model), true, true)));
            exit;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Members;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Members'])) {
            $model->attributes = $_POST['Members'];
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

        if (isset($_POST['Members'])) {
            $model->attributes = $_POST['Members'];
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

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Members('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Members']))
            $model->attributes = $_GET['Members'];

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
        $model = Members::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'members-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
