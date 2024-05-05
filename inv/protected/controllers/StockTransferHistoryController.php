<?php

class StockTransferHistoryController extends Controller {

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
    
    public function actionAdminForReceive() {
        $model = new StockTransferHistory('searchForReceive');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockTransferHistory']))
            $model->attributes = $_GET['StockTransferHistory'];

        $this->render('adminForReceive', array(
            'model' => $model,
        ));
    }
    
    public function actionReceiveStock() {
        $model = new StockTransferHistory;
        $ids = "no_ids";
        if (isset($_POST['attrIds'])) {
            $ids = $_POST['attrIds'];
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StockTransferHistory'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['StockTransferHistory'];
                if ($model->validate()) {
                    if (isset($_POST['StockTransferHistory']['id'])) {
                        $i = 0;
                        foreach ($_POST['StockTransferHistory']['id'] as $ids):
                            $model = StockTransferHistory::model()->findByPk($ids);
                            $model->rcv_qty = $_POST['StockTransferHistory']['rcv_qty'][$i]+$model->rcv_qty;
                            $model->rcv_date = $_POST['StockTransferHistory']['rcv_date'];
                            $model->rcv_by = Yii::app()->user->getId();
                            $model->rcv_time = new CDbExpression('NOW()');
                            $model->save();
                            
                            $model2 = new Inventory;
                            $model2->item = $model->item;
                            $model2->stock_in = $_POST['StockTransferHistory']['rcv_qty'][$i];
                            $model2->date = $_POST['StockTransferHistory']['rcv_date'];
                            $model2->store = $model->to_store;
                            $model2->costing_price = CostingPrice::model()->activeCostingPrice($model->item);
                            $model2->save();
                            
                            $i++;
                        endforeach;
                        
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content'=>'<div class="flash-notice">Received successfully</div>',
                        ));
                        exit;
                    }else {
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
                'content' => $this->renderPartial('_formReceiveStock', array(
                    'model' => $model,
                    'ids' => $ids,
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
        // $this->performAjaxValidation($model);

        if (isset($_POST['StockTransferHistory'])) {
            $model->attributes = $_POST['StockTransferHistory'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $model = new StockTransferHistory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockTransferHistory']))
            $model->attributes = $_GET['StockTransferHistory'];

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
        $model = StockTransferHistory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'stock-transfer-history-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
