<?php

class PurchaseOrderController extends Controller {

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

    public function actionRequisitionPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = PurchaseOrder::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set purchase order no!</div>';
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
        $model = new PurchaseOrder;
        $selectedIds = "no_selected_ids";

        if (isset($_POST['selectedArr'])) {
            $selectedIds = $_POST['selectedArr'];
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseOrder'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['PurchaseRequisition'];
                if ($model->validate()) {
                    if (isset($_POST['PurchaseOrder']['procurement_id'])) {
                        date_default_timezone_set("Asia/Dhaka");
                        $todayDate = $_POST['PurchaseOrder']['issue_date'];
                        $dateForInvNo = str_replace("-", "", $todayDate);
                        $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseOrder", 'max_sl_no', 'maxSINo', 'issue_date', $todayDate);
                        $slInvNo = $dateForInvNo . $thisInvMaxNo;
                        $i = 0;
                        foreach ($_POST['PurchaseOrder']['procurement_id'] as $tempProcureId):
                            if ($_POST['PurchaseOrder']['order_qty'][$i] > 0) {
                                $model = new PurchaseOrder;
                                $model->procurement_id = $tempProcureId;
                                $model->procurement_no = $_POST['PurchaseOrder']['procurement_no'][$i];
                                $model->order_qty = $_POST['PurchaseOrder']['order_qty'][$i];
                                $model->cost = $_POST['PurchaseOrder']['costing'][$i];
                                $condition = "name_of_unit='" . $_POST['PurchaseOrder']['name_of_unit'][$i] . "'";
                                $unitQuery= Units::model()->findAll(array("condition" => $condition));
                                foreach($unitQuery as $value):
                                    $model->name_of_unit=$value->id;
                                endforeach;
                                                           
                                $model->issue_date = $_POST['PurchaseOrder']['issue_date'];
                                $model->ref_no = $_POST['PurchaseOrder']['ref_no'];
                                $model->issue_date = $_POST['PurchaseOrder']['issue_date'];
                                $model->purchase_order_by = $_POST['PurchaseOrder']['purchase_order_by'];
                                $model->approved_by = $_POST['PurchaseOrder']['approved_by'];
                                $model->sl_no = $slInvNo;
                                $model->max_sl_no = $thisInvMaxNo;
                                $procData = PurchaseProcurement::model()->findByPk($model->procurement_id);
                                if ($procData->order_type == PurchaseProcurement::LOCAL)
                                    $model->is_verified = PurchaseOrder::VERIFIED;
                                else
                                    $model->is_verified = PurchaseOrder::NON_VERIFIED;

                                $model->save();

                                //if Total PurchaseOrder Qty is equal to PurchaseProcurement qty then is_ordered=1 set
                                $condition = "procurement_id='" . $tempProcureId . "'";
                                $data = PurchaseOrder::model()->findAll(array("condition" => $condition));
                                $purchaseOrderQty = 0;
                                foreach ($data as $value) :
                                    $purchaseOrderQty+=$value->order_qty;

                                endforeach;
                                $purchaseProcurement = PurchaseProcurement::model()->findByPk($tempProcureId);

                                if ($purchaseProcurement->qty == $purchaseOrderQty) {
                                    PurchaseProcurement::model()->updateByPk($tempProcureId, array('is_ordered' => 1));
                                }
                                //if Total PurchaseOrder Qty is equal to PurchaseProcurement qty then is_ordered=1 set
                            }
                            $i++;
                        endforeach;
                        $condition = "sl_no='" . $model->sl_no . "'";
                        $data = PurchaseOrder::model()->findAll(array("condition" => $condition));
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

        if (isset($_POST['PurchaseOrder'])) {
            $model->attributes = $_POST['PurchaseOrder'];
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
            $model_item = new PurchaseOrder;
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
        $model = new PurchaseOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseOrder']))
            $model->attributes = $_GET['PurchaseOrder'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminPO() {
        $model = new PurchaseProcurement('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseProcurement']))
            $model->attributes = $_GET['PurchaseProcurement'];

        $this->render('adminPO', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PurchaseOrder::model()->findByPk($id);
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
