<?php

class BasickSheetRequisitionController extends Controller {

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

    public function actionStoreReqReport() {
        $model = new BasickSheetRequisition;

        $this->render('storeReqReport', array(
            'model' => $model,
        ));
    }

    public function actionStoreReqReportView() {
        $startDate = $_POST['BasickSheetRequisition']['startDate'];
        $endDate = $_POST['BasickSheetRequisition']['endDate'];
        $store = $_POST['BasickSheetRequisition']['store'];
        $department = $_POST['BasickSheetRequisition']['department'];
        $category = $_POST['BasickSheetRequisition']['category'];
        $item = $_POST['BasickSheetRequisition']['item'];
        $reqBy = $_POST['BasickSheetRequisition']['req_by'];

        if ($startDate != "" && $endDate != "") {
            $message = "Store Requisition From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('req_date', $startDate, $endDate, 'AND');

            if ($reqBy != "") {
                $message.=", Requisition By: " . Employees::model()->fullName($reqBy);
                $criteria->addColumnCondition(array("req_by" => $reqBy), "AND", "AND");
            }
            if ($department != "") {
                $message.=", Department: " . Departments::model()->nameOfThis($department);
                $criteria->addColumnCondition(array("department" => $department), "AND", "AND");
            }
            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store" => $store), "AND", "AND");
            }
            if ($category != "") {
                $itemsData = Items::model()->findAll(array("condition" => "cat=" . $category));
                $itemsArray = array();
                if ($itemsData) {
                    foreach ($itemsData as $itmsd) {
                        $itemsArray[] = $itmsd->id;
                    }
                }
                $message.=", Category: " . Cats::model()->nameOfThis($category);
                $criteria->addInCondition("item", $itemsArray, "AND");
            }
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
            }

            $data = BasickSheetRequisition::model()->findAll($criteria);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
            $data = "";
        }

        echo CJSON::encode(array(
            'content' => $this->renderPartial('storeReqReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'store' => $store,
                'department' => $department,
                'category' => $category,
                'item' => $item,
                'reqBy' => $reqBy,
                    ), true, true),
        ));
    }

    public function actionRequisitionPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = BasickSheetRequisition::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set requisition no!</div>';
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new BasickSheetRequisition;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['BasickSheetRequisition'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['BasickSheetRequisition']['req_date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("BasickSheetRequisition", 'max_sl_no', 'maxSINo', 'req_date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                foreach ($_POST['BasickSheetRequisition']['item'] as $tempItems):
                    $model = new BasickSheetRequisition;
                    $model->item = $tempItems;
                    $model->qty = $_POST['BasickSheetRequisition']['qty'][$i];
                    $model->width = $_POST['BasickSheetRequisition']['width'][$i];
                    $model->height = $_POST['BasickSheetRequisition']['height'][$i];

                    $model->unit_of_distance = $_POST['BasickSheetRequisition']['unit_of_distance'][$i];
                    $model->unit_of_weight = $_POST['BasickSheetRequisition']['unit_of_weight'][$i];

                    $model->thickness = $_POST['BasickSheetRequisition']['thickness'][$i];
                    $model->department = $_POST['BasickSheetRequisition']['department'];
                    $model->req_by = $_POST['BasickSheetRequisition']['req_by'];
                    $model->approve_by = $_POST['BasickSheetRequisition']['approve_by'];

                    $model->remarks = $_POST['BasickSheetRequisition']['remarks'];
                    $model->req_date = $_POST['BasickSheetRequisition']['req_date'];
                    $model->from_store = $_POST['BasickSheetRequisition']['from_store'];
                    $model->store = $_POST['BasickSheetRequisition']['store'];
                    $model->sl_no = $slInvNo;
                    $model->max_sl_no = $thisInvMaxNo;
                    $model->save();
                    $i++;
                endforeach;
                $condition = "sl_no='" . $model->sl_no . "'";
                $data = BasickSheetRequisition::model()->findAll(array("condition" => $condition));
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
            $this->render('_form', array(
                'model' => $model,
                'itemsModel' => new Items,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($sl_no) {
        $model = new BasickSheetRequisition;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['BasickSheetRequisition'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['BasickSheetRequisition']['item'] as $tempItems):
                    $isExist = BasickSheetRequisition::model()->findByPk($_POST['BasickSheetRequisition']['id'][$i]);
                    if ($isExist) {
                        BasickSheetRequisition::model()->updateByPk($_POST['BasickSheetRequisition']['id'][$i], array(
                            'sl_no' => $_POST['BasickSheetRequisition']['sl_no'],
                            'max_sl_no' => $_POST['BasickSheetRequisition']['max_sl_no'],
                            'item' => $tempItems,
                            'width' => $_POST['BasickSheetRequisition']['width'][$i],
                            'height' => $_POST['BasickSheetRequisition']['height'][$i],
                            'thickness' => $_POST['BasickSheetRequisition']['thickness'][$i],
                            'unit_of_distance' => $_POST['BasickSheetRequisition']['unit_of_distance'][$i],
                            'unit_of_weight' => $_POST['BasickSheetRequisition']['unit_of_weight'][$i],
                            'qty' => $_POST['BasickSheetRequisition']['qty'][$i],
                            'req_by' => $_POST['BasickSheetRequisition']['req_by'],
                            'from_store' => $_POST['BasickSheetRequisition']['from_store'],
                            'remarks' => $_POST['BasickSheetRequisition']['remarks'],
                            'store' => $_POST['BasickSheetRequisition']['store'],
                            'department' => $_POST['BasickSheetRequisition']['department'],
                            'req_date' => $_POST['BasickSheetRequisition']['req_date'],
                            'created_by' => $_POST['BasickSheetRequisition']['created_by'],
                            'created_time' => $_POST['BasickSheetRequisition']['created_time'],
                            'updated_by' => Yii::app()->user->getId(),
                            'updated_time' => new CDbExpression('NOW()'),
                        ));
                    } else {
                        $model = new BasickSheetRequisition;
                        $model->item = $tempItems;
                        $model->width = $_POST['BasickSheetRequisition']['width'][$i];
                        $model->height = $_POST['BasickSheetRequisition']['height'][$i];
                        $model->thickness = $_POST['BasickSheetRequisition']['thickness'][$i];
                        $model->unit_of_distance = $_POST['BasickSheetRequisition']['unit_of_distance'][$i];
                        $model->unit_of_weight = $_POST['BasickSheetRequisition']['unit_of_weight'][$i];
                        $model->qty = $_POST['BasickSheetRequisition']['qty'][$i];
                        $model->department = $_POST['BasickSheetRequisition']['department'];
                        $model->req_by = $_POST['BasickSheetRequisition']['req_by'];
                        $model->remarks = $_POST['BasickSheetRequisition']['remarks'];
                        $model->req_date = $_POST['BasickSheetRequisition']['req_date'];
                        $model->from_store = $_POST['BasickSheetRequisition']['from_store'];
                        $model->store = $_POST['BasickSheetRequisition']['store'];
                        $model->created_by = Yii::app()->user->getId();
                        $model->created_time = new CDbExpression('NOW()');
                        $model->sl_no = $_POST['BasickSheetRequisition']['sl_no'];
                        $model->max_sl_no = $_POST['BasickSheetRequisition']['max_sl_no'];
                        $model->save();
                    }
                    $i++;
                endforeach;
                $condition = "sl_no='" . $sl_no . "'";
                $data = BasickSheetRequisition::model()->findAll(array("condition" => $condition));
                echo CJSON::encode(array(
                    'status' => 'success',
                    'voucherPreview' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                ));
                //echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('_form2', array(
                'model' => $model,
                'itemsModel' => new Items,
                'sl_no' => $sl_no,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($sl_no) {
        BasickSheetRequisition::model()->deleteAll(array("condition" => "sl_no='" . $sl_no . "'"));
        $this->redirect(array('admin'));
    }

    public function actionDeleteFromUpdate() {
        if (isset($_POST["id"])) {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                BasickSheetRequisition::model()->deleteByPk($_POST["id"]);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteAll() {
        if (isset($_POST['store-requisition-grid_c0'])) {
            $del_item = $_POST['store-requisition-grid_c0'];
            $model_item = new BasickSheetRequisition;
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
        $model = new BasickSheetRequisition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BasickSheetRequisition']))
            $model->attributes = $_GET['BasickSheetRequisition'];

        $this->render('admin', array(
            'model' => $model,
            'itemsModel' => new Items,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = BasickSheetRequisition::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'basick-sheet-requisition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
