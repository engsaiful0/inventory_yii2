<?php

class ProductionOutputController extends Controller {

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
    
    public function actionProductionReport(){
        $model = new ProductionInput;

        $this->render('productionReport', array(
            'model' => $model,
        ));
    }
    
    public function actionProductionReportView(){
        $startDate = $_POST['ProductionInput']['startDate'];
        $endDate = $_POST['ProductionInput']['endDate'];
        $store = $_POST['ProductionInput']['store'];
        $machine = $_POST['ProductionInput']['machine'];
        $category = $_POST['ProductionInput']['category'];
        $item = $_POST['ProductionInput']['item'];

        if ($startDate != "" && $endDate != "") {
            $message = "Production Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'machine, date, time, sl_no, sum(qty_kg) as sumOfQtyKg, sum(return_qty_kg) as sumOfRtnQtyKg';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
            
            if($store!=""){
                $message.=", Store: ".Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store"=>$store), "AND", "AND");
            }
            if($machine!=""){
                $message.=", Machine: ".  Machines::model()->nameOfThis($machine);
                $criteria->addColumnCondition(array("machine"=>$machine), "AND", "AND");
            }
            if($category!=""){
                $message.=", Category: ".Cats::model()->nameOfThis($category);
            }
            if($item!=""){
                $message.=", Item: ".Items::model()->nameOfThisOnly($item);
            }
            
            $criteria->group = "sl_no";
            $data = ProductionInput::model()->findAll($criteria);
            
        } else {
            $message= "<div class='flash-error'>Please select date range!</div>";
            $data="";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('productionReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate'=>$startDate,
                'endDate'=>$endDate,
                'store'=>$store,
                'machine'=>$machine,
                'category'=>$category,
                'item'=>$item,
            ), true, true),
        ));
    }

    public function actionCreate($sl_no) {
        $data = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
        if ($data) {
            $model = new ProductionOutput;
            $this->performAjaxValidation($model);
            
            if (isset($_POST['ProductionOutput'])) {
                $model->attributes = $_POST['ProductionOutput'];
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['ProductionOutput']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("ProductionOutput", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $model->max_sl_no = $thisInvMaxNo;
                $model->production_input_no = $sl_no;
                if ($model->validate()){
                    $productionInputInfo=ProductionInput::model()->findByPk($_POST['ProductionInput']['id'][0]);
                    $machineCode=  Machines::model()->codeOfThis($productionInputInfo->machine);
                    $model->sl_no = $machineCode."-".$slInvNo;
                    $model->save();
                    $inventory = new BasickSheetInventory;
                    $inventory->store = $productionInputInfo->store;
                    $inventory->item = $model->item;
                    $inventory->qty = $model->qty;
                    $inventory->qty_kg = $model->qty_kg;
                    $inventory->stock_in_qty = $model->qty;
                    $inventory->length = $model->length;
                    $inventory->width = $model->width;
                    $inventory->thickness = $model->thickness;
                    $inventory->unit_of_distance = $model->unit_of_distance;
                    $inventory->date = $model->date;
                    $inventory->time = $model->time;
                    $inventory->save();
                    
                    $this->redirect(array('create', 'sl_no'=>$sl_no));
                }
            } else {
                $this->render('_form', array(
                    'model' => $model,
                    'itemsModel' => new Items,
                    'sl_no' => $sl_no,
                    'data'=>$data,
                ));
            }
        } else {
            $this->redirect(array('/productionInput/adminOutput'));
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

        if (isset($_POST['ProductionOutput'])) {
            $model->attributes = $_POST['ProductionOutput'];
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

    public function actionDeleteAll() {
        if (isset($_POST['production-output-grid_c0'])) {
            $del_item = $_POST['production-output-grid_c0'];
            $model_item = new ProductionOutput;
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
        $model = new ProductionOutput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionOutput']))
            $model->attributes = $_GET['ProductionOutput'];

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
        $model = ProductionOutput::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'production-output-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
