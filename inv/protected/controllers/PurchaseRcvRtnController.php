<?php

class PurchaseRcvRtnController extends Controller {

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

    public function actionReceiveHistory($id) {
        $model = PurchaseOrder::model()->findByPk($id);
        $condition = "po_id=" . $model->id;
        $data = PurchaseRcvRtn::model()->findAll(array('condition' => $condition,), 'id');

        $this->renderPartial('receiveHistory', array('data' => $data, 'model' => $model,));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionAllReceive($sl_no) {
        $model = new PurchaseRcvRtn;
        $condition = "sl_no='" . $sl_no . "'";
        $purchaseOrderInfo = PurchaseOrder::model()->findAll(array('condition' => $condition,));

        if (isset($_POST['PurchaseRcvRtn'])) {
            $model->attributes = $_POST['PurchaseRcvRtn'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                foreach ($_POST['PurchaseRcvRtn']['po_id'] as $tempPOid):
                    if($_POST['PurchaseRcvRtn']['rcv_qty'][$i]!=0){
                        $poInfo = PurchaseOrder::model()->findByPk($tempPOid);
                        $reqInfo = PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
                        
                        $m = new PurchaseRcvRtn;
                        $m->po_id = $tempPOid;
                        $po_id=$tempPOid;
                        $m->supplier_id = $reqInfo->supplier_id;
                        $m->challan_no = $_POST['PurchaseRcvRtn']['challan_no'];
                        $m->rcv_date = $_POST['PurchaseRcvRtn']['rcv_date'];
                        $m->received_by = $_POST['PurchaseRcvRtn']['received_by'];
                        $m->approved_by = $_POST['PurchaseRcvRtn']['approved_by'];
                        $m->store = $_POST['PurchaseRcvRtn']['store'];
                        $m->rcv_qty = $_POST['PurchaseRcvRtn']['rcv_qty'][$i];
                        $m->noOfReceivedSack = $_POST['PurchaseRcvRtn']['noOfReceivedSack'][$i];
                        $m->name_of_unit = $_POST['PurchaseRcvRtn']['name_of_unit'][$i];
                        $m->weightPerSack = $_POST['PurchaseRcvRtn']['weightPerSack'][$i];
                        $m->remarks_for_rcv = $_POST['PurchaseRcvRtn']['remarks_for_rcv'][$i];
                        $m->cost = $_POST['PurchaseRcvRtn']['cost'][$i];
                        $m->save();


                        $inventory = new Inventory;
                        $inventory->store = $_POST['PurchaseRcvRtn']['store'];
                        $inventory->name_of_unit = $_POST['PurchaseRcvRtn']['name_of_unit'][$i];
                        
                        $inventory->item = $reqInfo->item;
                        $inventory->stock_in = $m->rcv_qty;
                        $inventory->costing_price = $m->cost;
                        $inventory->date = $m->rcv_date;
                        $inventory->save();
                    }
                    $i++;
                endforeach;
            
                echo CJSON::encode(array(
                    'status' => 'success',
                    'content' => $this->renderPartial('voucherPreview', array('dataPurchaseOrderInfo' => $purchaseOrderInfo), true, true),
                ));
                Yii::app()->end();
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_allReceive', array(
                    'model' => $model,
                    'purchaseOrderInfo' => $purchaseOrderInfo,
                        ), true, true),
            ));
            exit;
        }
    }

    public function actionReturn($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRcvRtn'])) {
            $model->attributes = $_POST['PurchaseRcvRtn'];
            $model->setScenario('returnScenario');
            $model->return_time = new CDbExpression('NOW()');
            $model->return_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                $poInfo = PurchaseOrder::model()->findByPk($model->po_id);
                $reqInfo = PurchaseProcurement::model()->findByPk($poInfo->procurement_id);

                $inventory = new Inventory;
                $inventory->store = $reqInfo->store;
                $inventory->item = $reqInfo->item;
                $inventory->stock_out = $model->rtn_qty;
                $inventory->date = $model->rtn_date;
                $inventory->save();
                
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">successfully returned</div>',
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
                'content' => $this->renderPartial('_returnForm', array(
                    'model' => $model), true, true),
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
        
        $oldRcvQty=$model->rcv_qty;
        $oldRtnQty=$model->rtn_qty;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRcvRtn'])) {
            $model->attributes = $_POST['PurchaseRcvRtn'];
            $model->updated_time = new CDbExpression('NOW()');
            $model->updated_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $poInfo = PurchaseOrder::model()->findByPk($model->po_id);
                $reqInfo = PurchaseProcurement::model()->findByPk($poInfo->procurement_id);

                $inventory = new Inventory;
                $inventory->store = $model->store;
                $inventory->item = $reqInfo->item;
                $inventory->date = $model->rcv_date;
                if($oldRcvQty > $model->rcv_qty){
                    $actualRcvQty=$oldRcvQty-$model->rcv_qty;
                    $inventory->stock_out = $actualRcvQty;
                    $inventory->save();
                }else if($oldRcvQty < $model->rcv_qty){
                    $actualRcvQty=$model->rcv_qty-$oldRcvQty;
                    $inventory->stock_in = $actualRcvQty;
                    $inventory->costing_price = $model->cost;
                    $inventory->save();
                }else{
                    
                }
                
                if($model->rtn_qty!="" || $model->rtn_qty!=0){
                    $inventory = new Inventory;
                    $inventory->store = $model->store;
                    $inventory->item = $reqInfo->item;
                    $inventory->date = $model->rtn_date;
                    if($oldRtnQty>$model->rtn_qty){
                        $actualRtnQty=$oldRtnQty-$model->rtn_qty;
                        $inventory->stock_in = $actualRtnQty;
                        $inventory->costing_price = $model->cost;
                        $inventory->save();
                    }else if($oldRtnQty < $model->rtn_qty){
                        $actualRtnQty=$model->rtn_qty-$oldRtnQty;
                        $inventory->stock_out = $actualRtnQty;
                        $inventory->save();
                    }else{
                        
                    }
                }
                
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
                'content' => $this->renderPartial('_form', array(
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

    public function actionDeleteAll() {
        if (isset($_POST['purchase-rcv-rtn-grid_c0'])) {
            $del_item = $_POST['purchase-rcv-rtn-grid_c0'];
            $model_item = new PurchaseRcvRtn;
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
        $model = new PurchaseRcvRtn('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseRcvRtn']))
            $model->attributes = $_GET['PurchaseRcvRtn'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminReceive() {
        $model = new PurchaseOrder('searchForPORcv');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseOrder']))
            $model->attributes = $_GET['PurchaseOrder'];

        $this->render('adminReceive', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PurchaseRcvRtn::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-rcv-rtn-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
