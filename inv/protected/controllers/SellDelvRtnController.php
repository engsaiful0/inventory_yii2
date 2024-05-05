<?php

class SellDelvRtnController extends Controller {

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
    
    public function actionChallanNoPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = SellDelvRtn::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set challan no!</div>';
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $oldDelivQty=$model->d_qty;
        $oldRtnQty=$model->r_qty;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SellDelvRtn'])) {
            $model->attributes = $_POST['SellDelvRtn'];
            $model->updated_time = new CDbExpression('NOW()');
            $model->updated_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $soInfo = SaleOrder::model()->findByPk($model->so_id);

                $inventory = new Inventory;
                $inventory->store = $soInfo->store;
                $inventory->item = $soInfo->item;
                $inventory->date = $model->d_date;
                if($oldDelivQty > $model->d_qty){
                    $cost=CostingPrice::model()->activeCostingPrice($soInfo->item);
                    $actualDelivQty=$oldDelivQty-$model->d_qty;
                    $inventory->stock_in = $actualDelivQty;
                    $inventory->costing_price = $cost;
                    $inventory->save();
                }else if($oldDelivQty < $model->d_qty){
                    $actualDelivQty=$model->d_qty-$oldDelivQty;
                    $inventory->stock_out = $actualDelivQty;
                    $inventory->save();
                }else{
                    
                }
                
                if($model->r_qty!="" || $model->r_qty!=0){
                    $inventory = new Inventory;
                    $inventory->store = $soInfo->store;
                    $inventory->item = $soInfo->item;
                    $inventory->date = $model->r_date;
                    if($oldRtnQty > $model->r_qty){
                        $actualRtnQty=$oldRtnQty-$model->r_qty;
                        $inventory->stock_out = $actualRtnQty;
                        $inventory->save();
                    }else if($oldRtnQty < $model->r_qty){
                        $actualRtnQty=$model->r_qty-$oldRtnQty;
                        $inventory->stock_in = $actualRtnQty;
                        $inventory->costing_price = $model->cost;
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
    }

    public function actionDeliveryHistory($id) {
        $model = SaleOrder::model()->findByPk($id);
        $condition = "so_id=" . $model->id;
        $data = SellDelvRtn::model()->findAll(array('condition' => $condition,), 'id');

        $this->renderPartial('deliveryHistory', array('data' => $data, 'model' => $model,));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionAllDeliver($sl_no) {
        $model = new SellDelvRtn;
        $condition = "sl_no='" . $sl_no . "'";
        $sellOrderInfo = SaleOrder::model()->findAll(array('condition' => $condition,));

        if (isset($_POST['SellDelvRtn'])) {
            $model->attributes = $_POST['SellDelvRtn'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['SellDelvRtn']['d_date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("SellDelvRtn", 'max_sl_no', 'maxSINo', 'd_date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                
                foreach ($_POST['SellDelvRtn']['so_id'] as $tempPOid):
                    if($_POST['SellDelvRtn']['d_qty'][$i]!=0){
                        $soInfo = SaleOrder::model()->findByPk($tempPOid);
                        $model = new SellDelvRtn;
                        $model->so_id = $tempPOid;
                        $model->item = $soInfo->item;
                        $model->store = $soInfo->store;
                        $model->so_no = $sl_no;
                        $model->customer_id = $_POST['SellDelvRtn']['customer_id'];
                        $model->vehicle_type = $_POST['SellDelvRtn']['vehicle_type'];
                        $model->vehicle_no = $_POST['SellDelvRtn']['vehicle_no'];
                        $model->remarks1 = $_POST['SellDelvRtn']['remarks1'];
                        $model->d_date = $_POST['SellDelvRtn']['d_date'];
                        $model->d_qty = $_POST['SellDelvRtn']['d_qty'][$i];
                        $model->d_qty_kg = $_POST['SellDelvRtn']['d_qty_kg'][$i];
                        $model->created_time = new CDbExpression('NOW()');
                        $model->created_by = Yii::app()->user->getId();
                        $model->sl_no = $slInvNo;
                        $model->max_sl_no = $thisInvMaxNo;
                        $model->save();

                        $inventory = new Inventory;
                        $inventory->store = $soInfo->store;
                        $inventory->item = $soInfo->item;
                        $inventory->stock_out = $model->d_qty;
                        $inventory->date = $model->d_date;
                        $inventory->save();
                    }
                    $i++;
                endforeach;
                
                $condition = "sl_no='" . $model->sl_no . "'";
                $data = SellDelvRtn::model()->findAll(array("condition" => $condition));
                echo CJSON::encode(array(
                    'status' => 'success',
                    'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                ));
                Yii::app()->end();
                
//                echo CJSON::encode(array(
//                    'status' => 'success',
//                    'content' => '<div class="flash-notice">Successfully Delivered</div>',
//                ));
//                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_allDeliver', array(
                    'model' => $model,
                    'sellOrderInfo' => $sellOrderInfo,
                        ), true, true),
            ));
            exit;
        }
    }

    public function actionReturn($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SellDelvRtn'])) {
            $model->attributes = $_POST['SellDelvRtn'];
            $model->setScenario('returnScenario');
            $model->return_time = new CDbExpression('NOW()');
            $model->return_by = Yii::app()->user->getId();
            
            if ($model->save()) {
                
                $soInfo = SaleOrder::model()->findByPk($model->so_id);

                $inventory = new Inventory;
                $inventory->store = $soInfo->store;
                $inventory->item = $soInfo->item;
                $inventory->stock_in = $model->r_qty;
                $inventory->date = $model->r_date;
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model=$this->loadModel($id);
            $inventory = new Inventory;
            $inventory->store = $model->store;
            $inventory->item = $model->item;
            $inventory->stock_in = $model->d_qty-$model->r_qty;
            $inventory->date = $model->d_date;
            $inventory->save();
            
            SellDelvRtn::model()->deleteByPk($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDeleteAll() {
        if (isset($_POST['sell-delv-rtn-grid_c0'])) {
            $del_item = $_POST['sell-delv-rtn-grid_c0'];
            foreach ($del_item as $_id) {
                
                $model=$this->loadModel($_id);
                $inventory = new Inventory;
                $inventory->store = $model->store;
                $inventory->item = $model->item;
                $inventory->stock_in = $model->d_qty-$model->r_qty;
                $inventory->date = $model->d_date;
                $inventory->save();

                SellDelvRtn::model()->deleteByPk($_id);
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
        $model = new SellDelvRtn('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellDelvRtn']))
            $model->attributes = $_GET['SellDelvRtn'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminDelivery() {
        $model = new SaleOrder('searchForDelivery');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleOrder']))
            $model->attributes = $_GET['SaleOrder'];

        $this->render('adminDelivery', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SellDelvRtn::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-delv-rtn-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
