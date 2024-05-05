<?php

class DoubliMachinProductionInputController extends Controller {

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

    public function actionDoubliMachinProductionInputPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = DoubliMachinProductionInput::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set Doubli Machin Production Input  no!</div>';
        }
    }

    public function actionCreateAll() {
        if (isset($_POST['purchase-procurement-grid_c0'])) {
            $selectedItems = $_POST['purchase-procurement-grid_c0'];
            $this->actionCreate($selectedItems);
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one item to create PO');
            $this->actionAdminPO();
        }
    }

    public function actionCreateFromSelected() {
        $model = new DoubliMachinProductionInput;
        $selectedIds = "no_selected_ids";

        if (isset($_POST['selectedArr'])) {
            $selectedIds = $_POST['selectedArr'];
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DoubliMachinProductionInput'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['PurchaseRequisition'];
                if ($model->validate()) {
                    if (isset($_POST['DoubliMachinProductionInput']['production_output_id'])) {
                        date_default_timezone_set("Asia/Dhaka");
                        $todayDate = $_POST['DoubliMachinProductionInput']['input_date'];
                        $dateForInvNo = str_replace("-", "", $todayDate);
                        $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("DoubliMachinProductionInput", 'max_sl_no', 'maxSINo', 'input_date', $todayDate);
                        $slInvNo = $dateForInvNo . $thisInvMaxNo;
                        $i = 0;
                        foreach ($_POST['DoubliMachinProductionInput']['production_output_id'] as $tempProcureId):
                            if ($_POST['DoubliMachinProductionInput']['qty'][$i] > 0) {
                                $model = new DoubliMachinProductionInput;
                                $model->production_output_id = $tempProcureId;
                                $model->production_output_no = $_POST['DoubliMachinProductionInput']['production_output_no'][$i];

                                 $model->item = $_POST['DoubliMachinProductionInput']['item'][$i];
                                
                                $model->length = $_POST['DoubliMachinProductionInput']['length'][$i];
                                $model->width = $_POST['DoubliMachinProductionInput']['width'][$i];
                                $model->thickness = $_POST['DoubliMachinProductionInput']['thickness'][$i];
                                $model->unit_of_distance = $_POST['DoubliMachinProductionInput']['unit_of_distance'][$i];
                                
                                $model->qty = $_POST['DoubliMachinProductionInput']['qty'][$i];
                                $model->qty_kg = $_POST['DoubliMachinProductionInput']['qty_kg'][$i];

                                $model->input_date = $_POST['DoubliMachinProductionInput']['input_date'];
                                $model->store = $_POST['DoubliMachinProductionInput']['store'];
                                
                                
                                $model->ref_no = $_POST['DoubliMachinProductionInput']['ref_no'];
                                $model->doubli_producton_input_by = $_POST['DoubliMachinProductionInput']['doubli_producton_input_by'];
                                $model->approved_by = $_POST['DoubliMachinProductionInput']['approved_by'];
                                $model->sl_no = $slInvNo;
                                $model->max_sl_no = $thisInvMaxNo;
                                $model->save();
                            }
                            $i++;
                        endforeach;
                        $condition = "sl_no='" . $model->sl_no . "'";
                        $data = DoubliMachinProductionInput::model()->findAll(array("condition" => $condition));
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                        ));
                        exit;
                    } else {
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
                'content' => $this->renderPartial('_formSelectedIds', array(
                    'model' => $model,
                    'selectedIds' => $selectedIds,
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

        if (isset($_POST['DoubliMachinProductionInput'])) {
            $model->attributes = $_POST['DoubliMachinProductionInput'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">successfully updated</div>',
                    ));
                    exit;
                } else
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
        } else
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
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteAll() {
        if (isset($_POST['purchase-order-grid_c0'])) {
            $del_item = $_POST['purchase-order-grid_c0'];
            $model_item = new DoubliMachinProductionInput;
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
        $model = new DoubliMachinProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoubliMachinProductionInput']))
            $model->attributes = $_GET['DoubliMachinProductionInput'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function actionAdminOutput() {
        $model = new DoubliMachinProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoubliMachinProductionInput']))
            $model->attributes = $_GET['DoubliMachinProductionInput'];

        $this->render('adminOutput', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminWastage() {
        $model = new DoubliMachinProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoubliMachinProductionInput']))
            $model->attributes = $_GET['DoubliMachinProductionInput'];

        $this->render('adminWastage', array(
            'model' => $model,
        ));
    }

    public function actionAdminPO() {
        $model = new ProductionOutput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionOutput']))
            $model->attributes = $_GET['ProductionOutput'];

        $this->render('adminPO', array(
            'model' => $model,
        ));
    }
    public function actionReturnQty($sl_no) {
        $model = new DoubliMachinProductionInput;
        $this->performAjaxValidation($model);

        if (isset($_POST['DoubliMachinProductionInput'])) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                
                $updated_by = Yii::app()->user->getId();
                foreach ($_POST['DoubliMachinProductionInput']['id'] as $tempId):
                    $modelOld = $this->loadModel($tempId);
                    $oldReturnQty=$modelOld->return_qty;
                    DoubliMachinProductionInput::model()->updateByPk($tempId, array(
                        'return_qty' => $_POST['DoubliMachinProductionInput']['return_qty'][$i],
                        'return_qty_kg' => $_POST['DoubliMachinProductionInput']['return_qty_kg'][$i],
                        'updated_by' => $updated_by,
                        'updated_time' => new CDbExpression('NOW()'),
                    ));
                    $model = $this->loadModel($tempId);
                    $basickSheetInventory = new BasickSheetInventory;
                   
                    if($oldReturnQty>$model->return_qty){
                        $actualQty=$oldReturnQty-$model->return_qty;
                        $basickSheetInventory->stock_out_qty = $actualQty;
                        $basickSheetInventory->save();
                    }else if($oldReturnQty < $model->return_qty){
                        $actualQty=$model->return_qty-$oldReturnQty;
                        $basickSheetInventory->stock_in_qty = $actualQty;
                     
                        $storeInventory->save();
                    }else{
                        
                    }
                    $i++;
                endforeach;
                
                echo CJSON::encode(array(
                    'status' => 'Data Saved Successfully',
                ));
                Yii::app()->end();
        } 
        $this->render('_form3', array(
            'model' => $model,
            'itemsModel' => new Items,
            'sl_no' => $sl_no,
        ));
    }
      public function actionAdminReturn(){
        $model = new DoubliMachinProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoubliMachinProductionInput']))
            $model->attributes = $_GET['DoubliMachinProductionInput'];

        $this->render('adminReturn', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = DoubliMachinProductionInput::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
