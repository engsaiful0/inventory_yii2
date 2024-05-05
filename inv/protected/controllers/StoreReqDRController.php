<?php

class StoreReqDRController extends Controller {

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
    
    public function actionAdminApprove() {
        $model = new StoreReqDR('searchApprove');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreReqDR']))
            $model->attributes = $_GET['StoreReqDR'];

        $this->render('adminApprove', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminReturn() {
        $model = new StoreReqDR('searchReturn');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreReqDR']))
            $model->attributes = $_GET['StoreReqDR'];

        $this->render('adminReturn', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminDelivery() {
        $model = new StoreRequisition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreRequisition']))
            $model->attributes = $_GET['StoreRequisition'];

        $this->render('adminDelivery', array(
            'model' => $model,
        ));
    }
    
    public function actionAllDelivery($sl_no) {
        $model = new StoreReqDR;
        $condition = "sl_no='" . $sl_no . "'";
        $reqInfo = StoreRequisition::model()->findAll(array('condition' => $condition,));
        
        if (isset($_POST['StoreReqDR'])) {
            $model->attributes = $_POST['StoreReqDR'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                foreach ($_POST['StoreReqDR']['req_id'] as $tempPOid):
                    if($_POST['StoreReqDR']['d_qty'][$i]!=0){
                        $rInfo = StoreRequisition::model()->findByPk($tempPOid);
                        $m = new StoreReqDR;
                        $m->req_id = $tempPOid;
                        $m->req_no = $rInfo->sl_no;
                        $m->d_qty = $_POST['StoreReqDR']['d_qty'][$i];
                        $m->d_date = $_POST['StoreReqDR']['d_date'];
                        $m->created_by = Yii::app()->user->getId();
                        $m->created_time = new CDbExpression('NOW()');
                        $m->save();
                    }
                    $i++;
                endforeach;
                echo CJSON::encode(array(
                    'status' => 'success',
                    'content' => '<div class="flash-notice">Successfully Delivered</div>',
                ));
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_allDelivery', array(
                    'model' => $model,
                    'reqInfo' => $reqInfo,
                        ), true, true),
            ));
            exit;
        }
    }
    
    public function actionAllApprove($sl_no) {
        $model = new StoreReqDR;
        $condition = "req_no='" . $sl_no . "' AND is_approved!=1";
        $reqInfo = StoreReqDR::model()->findAll(array('condition' => $condition,));
        $reqInfoMain=  StoreRequisition::model()->findAll(array('condition' => 'sl_no="'.$sl_no.'"',));
        if (isset($_POST['StoreReqDR'])) {
            $model->attributes = $_POST['StoreReqDR'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                foreach ($_POST['StoreReqDR']['req_id'] as $tempPOid):
                    $rInfo = StoreRequisition::model()->findByPk($tempPOid);
                    
                    $stockQtyMainInventory=Inventory::model()->presentStockOfThisItem($rInfo->item, $rInfo->store);
                    if($stockQtyMainInventory>0){
                        $model = $this->loadModel($_POST['StoreReqDR']['id'][$i]);
                        $model->is_approved = 1;
                        $model->approved_by = Yii::app()->user->getId();
                        $model->approved_time = new CDbExpression('NOW()');
                        $model->save();

                        $inventory = new Inventory;
                        $inventory->store = $rInfo->store;
                        $inventory->item = $rInfo->item;
                        $inventory->stock_out = $model->d_qty;
                        $inventory->date = date('Y-m-d');
                        $inventory->save();

                        $storeInventory = new StoreInventory;
                        $storeInventory->store = $rInfo->store;
                        $storeInventory->item = $rInfo->item;
                        $storeInventory->stock_in = $model->d_qty;
                        $storeInventory->date = date('Y-m-d');
                        $costingPrice = CostingPrice::model()->activeCostingPrice($rInfo->item);
                        $storeInventory->costing_price = $costingPrice;
                        $storeInventory->save();
                    }
                    $i++;
                endforeach;
                echo CJSON::encode(array(
                    'status' => 'success',
                    'content' => '<div class="flash-notice">Successfully Approved</div>',
                ));
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_allApprove', array(
                    'model' => $model,
                    'reqInfoMain'=>$reqInfoMain,
                    'reqInfo' => $reqInfo,
                        ), true, true),
            ));
            exit;
        }
    }
    
    public function actionReturn($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreReqDR'])) {
            $model->attributes = $_POST['StoreReqDR'];
            $model->setScenario('returnScenario');
            $model->return_time = new CDbExpression('NOW()');
            $model->return_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $reqInfo = StoreRequisition::model()->findByPk($model->req_id);
                $cost=CostingPrice::model()->activeCostingPrice($reqInfo->item);
                
                $storeInventory = new StoreInventory;
                $storeInventory->store = $reqInfo->store;
                $storeInventory->item = $reqInfo->item;
                $storeInventory->stock_out = $model->r_qty;
                $storeInventory->date = $model->r_date;
                $storeInventory->save();
                
                $inventory = new Inventory;
                $inventory->store = $reqInfo->store;
                $inventory->item = $reqInfo->item;
                $inventory->stock_in = $model->r_qty;
                $inventory->date = $model->r_date;
                $inventory->costing_price = $cost;
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
        $oldDelvQty=$model->d_qty;
        $oldRtnQty=$model->r_qty;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreReqDR'])) {
            $model->attributes = $_POST['StoreReqDR'];
            $model->updated_time = new CDbExpression('NOW()');
            $model->updated_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $reqInfo = StoreRequisition::model()->findByPk($model->req_id);
                $cost=CostingPrice::model()->activeCostingPrice($reqInfo->item);
                
                $storeInventory = new StoreInventory;
                $storeInventory->store = $reqInfo->store;
                $storeInventory->item = $reqInfo->item;
                $storeInventory->date = $model->d_date;
                
                $inventory = new Inventory;
                $inventory->store = $reqInfo->store;
                $inventory->item = $reqInfo->item;
                $inventory->date = $model->d_date;
                
                if($oldDelvQty > $model->d_qty){
                    $actualRcvQty=$oldDelvQty-$model->d_qty;
                    $inventory->stock_in = $actualRcvQty;
                    $inventory->costing_price = $cost;
                    $inventory->save();
                    
                    $storeInventory->stock_out = $actualRcvQty;
                    $storeInventory->save();
                }else if($oldDelvQty < $model->d_qty){
                    $actualRcvQty=$model->d_qty-$oldDelvQty;
                    $inventory->stock_out = $actualRcvQty;
                    $inventory->save();
                    
                    $storeInventory->stock_in = $actualRcvQty;
                    $storeInventory->costing_price = $cost;
                    $storeInventory->save();
                }else{
                    
                }
                
                if($model->r_qty!="" || $model->r_qty!=0){
                    $inventory = new Inventory;
                    $inventory->store = $reqInfo->store;
                    $inventory->item = $reqInfo->item;
                    $inventory->date = $model->rtn_date;
                    
                    $storeInventory = new StoreInventory;
                    $storeInventory->store = $reqInfo->store;
                    $storeInventory->item = $reqInfo->item;
                    $storeInventory->date = $model->rtn_date;
                    
                    if($oldRtnQty > $model->r_qty){
                        $actualRtnQty=$oldRtnQty-$model->r_qty;
                        $inventory->stock_out = $actualRtnQty;
                        $inventory->save();
                        
                        $storeInventory->stock_in = $actualRtnQty;
                        $storeInventory->costing_price = $cost;
                        $storeInventory->save();
                    }else if($oldRtnQty < $model->r_qty){
                        $actualRtnQty=$model->r_qty-$oldRtnQty;
                        $inventory->stock_in = $actualRtnQty;
                        $inventory->costing_price = $cost;
                        $inventory->save();
                        
                        $storeInventory->stock_out = $actualRtnQty;
                        $storeInventory->save();
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
        if (isset($_POST['store-req-dr-grid_c0'])) {
            $del_item = $_POST['store-req-dr-grid_c0'];
            $model_item = new StoreReqDR;
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
        $model = new StoreReqDR('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreReqDR']))
            $model->attributes = $_GET['StoreReqDR'];

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
        $model = StoreReqDR::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'store-req-dr-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
