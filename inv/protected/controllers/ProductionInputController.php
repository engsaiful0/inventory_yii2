<?php

class ProductionInputController extends Controller {

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
    
    public function actionConsumptionReport(){
        $model = new ProductionInput;

        $this->render('consumptionReport', array(
            'model' => $model,
        ));
    }
    
    public function actionConsumptionReportView(){
        $startDate = $_POST['ProductionInput']['startDate'];
        $endDate = $_POST['ProductionInput']['endDate'];
        $store = $_POST['ProductionInput']['store'];
        $machine = $_POST['ProductionInput']['machine'];
        $category = $_POST['ProductionInput']['category'];
        $item = $_POST['ProductionInput']['item'];

        if ($startDate != "" && $endDate != "") {
            $message = "Consumption Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(qty) as sumOfQty, sum(qty_kg) as sumOfQtyKg, sum(return_qty) as sumOfRtnQty, sum(return_qty_kg) as sumOfRtnQtyKg, item';
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
                $itemsData=Items::model()->findAll(array("condition"=>"cat=".$category));
                $itemsArray=array();
                if($itemsData){
                    foreach($itemsData as $itmsd){
                        $itemsArray[]=$itmsd->id;
                    }
                }
                $message.=", Category: ".Cats::model()->nameOfThis($category);
                $criteria->addInCondition("item", $itemsArray, "AND");
            }
            if($item!=""){
                $message.=", Item: ".Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item"=>$item), "AND", "AND");
            }
            
            $criteria->group = "item";
            $data = ProductionInput::model()->findAll($criteria);
            
        } else {
            $message= "<div class='flash-error'>Please select date range!</div>";
            $data="";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('consumptionReportView', array(
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

    public function actionCreate() {
        $model = new ProductionInput;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductionInput'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['ProductionInput']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("ProductionInput", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                $created_by = Yii::app()->user->getId();
                $itemsArr = array();
                $itemsStockQtyArr = array();
                $machineCode=  Machines::model()->codeOfThis($_POST['ProductionInput']['machine']);
                foreach ($_POST['ProductionInput']['item'] as $tempItems):
                    $model = new ProductionInput;
                    $model->sl_no = $machineCode."-".$slInvNo;
                    $model->max_sl_no = $thisInvMaxNo;
                    $model->item = $tempItems;
                    $model->track_no = $_POST['ProductionInput']['track_no'][$i];
                    $model->qty = $_POST['ProductionInput']['qty'][$i];
                    $model->qty_kg = $_POST['ProductionInput']['qty_kg'][$i];
                    $model->store = $_POST['ProductionInput']['store'];
                    $model->machine = $_POST['ProductionInput']['machine'];
                    $model->date = $_POST['ProductionInput']['date'];
                    $model->time = $_POST['ProductionInput']['time'];
                    $model->created_by = $created_by;
                    $model->created_time = new CDbExpression('NOW()');
                    $model->save();

                    $storeInventory = new StoreInventory;
                    $storeInventory->store = $model->store;
                    $storeInventory->item = $model->item;
                    $storeInventory->stock_out = $model->qty;
                    $storeInventory->date = $model->date;
                    $storeInventory->save();

                    $itemsArr[] = $tempItems;
                    $itemsStockQtyArr[] = StoreInventory::model()->presentStockOfThisItemAllStore($tempItems);

                    $i++;
                endforeach;

                echo CJSON::encode(array(
                    'status' => 'success',
                    'itemsArrCount' => count($itemsArr),
                    'itemsArr' => $itemsArr,
                    'itemsStockQtyArr' => $itemsStockQtyArr,
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

    public function actionUpdate($sl_no) {
        $model = new ProductionInput;
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductionInput'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                //ProductionInput::model()->deleteAll(array("condition" => "sl_no='" . $sl_no . "'"));
                $thisInfo = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
                foreach ($thisInfo as $d) {
                    $storeInventory = new StoreInventory;
                    $storeInventory->store = $d->store;
                    $storeInventory->item = $d->item;
                    $storeInventory->stock_in = $d->qty;
                    $storeInventory->date = $d->date;
                    $costingPrice = CostingPrice::model()->activeCostingPrice($d->item);
                    $storeInventory->costing_price = $costingPrice;
                    $storeInventory->save();

                    //ProductionInput::model()->deleteByPk($d->id);
                }
                $i = 0;
                foreach ($_POST['ProductionInput']['item'] as $tempItems):
                    $isExist = ProductionInput::model()->findByPk($_POST['ProductionInput']['id'][$i]);
                    if ($isExist) {
                        ProductionInput::model()->updateByPk($_POST['ProductionInput']['id'][$i], array(
                            'sl_no'=>$_POST['ProductionInput']['sl_no'],
                            'max_sl_no'=>$_POST['ProductionInput']['max_sl_no'],
                            'item'=>$tempItems,
                            'track_no'=>$_POST['ProductionInput']['track_no'][$i],
                            'qty'=>$_POST['ProductionInput']['qty'][$i],
                            'qty_kg'=>$_POST['ProductionInput']['qty_kg'][$i],
                            'store'=>$_POST['ProductionInput']['store'],
                            'machine'=>$_POST['ProductionInput']['machine'],
                            'date'=>$_POST['ProductionInput']['date'],
                            'time'=>$_POST['ProductionInput']['time'],
                            'created_by'=>$_POST['ProductionInput']['created_by'],
                            'created_time'=>$_POST['ProductionInput']['created_time'],
                            'updated_by'=>Yii::app()->user->getId(),
                            'updated_time'=>new CDbExpression('NOW()'),
                        ));
                        
                        $storeInventory = new StoreInventory;
                        $storeInventory->store = $_POST['ProductionInput']['store'];
                        $storeInventory->item = $tempItems;
                        $storeInventory->stock_out = $_POST['ProductionInput']['qty'][$i];
                        $storeInventory->date = $_POST['ProductionInput']['date'];
                        $storeInventory->save();
                    } else {
                        $model = new ProductionInput;
                        $model->sl_no = $_POST['ProductionInput']['sl_no'];
                        $model->max_sl_no = $_POST['ProductionInput']['max_sl_no'];
                        $model->item = $tempItems;
                        $model->track_no = $_POST['ProductionInput']['track_no'][$i];
                        $model->qty = $_POST['ProductionInput']['qty'][$i];
                        $model->qty_kg = $_POST['ProductionInput']['qty_kg'][$i];
                        $model->store = $_POST['ProductionInput']['store'];
                        $model->machine = $_POST['ProductionInput']['machine'];
                        $model->date = $_POST['ProductionInput']['date'];
                        $model->time = $_POST['ProductionInput']['time'];
                        $model->created_by = Yii::app()->user->getId();
                        $model->created_time = new CDbExpression('NOW()');
                        $model->save();
                        
                        $storeInventory = new StoreInventory;
                        $storeInventory->store = $model->store;
                        $storeInventory->item = $model->item;
                        $storeInventory->stock_out = $model->qty;
                        $storeInventory->date = $model->date;
                        $storeInventory->save();
                    }
                    
                    $i++;
                endforeach;

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
        } else {
            $this->render('_form2', array(
                'model' => $model,
                'itemsModel' => new Items,
                'sl_no' => $sl_no,
            ));
        }
    }
    
    public function actionReturnQty($sl_no) {
        $model = new ProductionInput;
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductionInput'])) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                
                $updated_by = Yii::app()->user->getId();
                foreach ($_POST['ProductionInput']['id'] as $tempId):
                    $modelOld = $this->loadModel($tempId);
                    $oldReturnQty=$modelOld->return_qty;
                    ProductionInput::model()->updateByPk($tempId, array(
                        'return_qty' => $_POST['ProductionInput']['return_qty'][$i],
                        'return_qty_kg' => $_POST['ProductionInput']['return_qty_kg'][$i],
                        'updated_by' => $updated_by,
                        'updated_time' => new CDbExpression('NOW()'),
                    ));
                    $model = $this->loadModel($tempId);
                    $storeInventory = new StoreInventory;
                    $storeInventory->store = $model->store;
                    $storeInventory->item = $model->item;
                    $storeInventory->date = $model->date;
                    if($oldReturnQty>$model->return_qty){
                        $actualQty=$oldReturnQty-$model->return_qty;
                        $storeInventory->stock_out = $actualQty;
                        $storeInventory->save();
                    }else if($oldReturnQty < $model->return_qty){
                        $actualQty=$model->return_qty-$oldReturnQty;
                        $storeInventory->stock_in = $actualQty;
                        $costingPrice = CostingPrice::model()->activeCostingPrice($model->item);
                        $storeInventory->costing_price = $costingPrice;
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($sl_no) {
        //ProductionInput::model()->deleteAll(array("condition" => "sl_no='" . $sl_no . "'"));
        $thisInfo = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
        foreach ($thisInfo as $d) {
            $storeInventory = new StoreInventory;
            $storeInventory->store = $d->store;
            $storeInventory->item = $d->item;
            $storeInventory->stock_in = $d->qty;
            $storeInventory->date = $d->date;
            $costingPrice = CostingPrice::model()->activeCostingPrice($d->item);
            $storeInventory->costing_price = $costingPrice;
            $storeInventory->save();

            ProductionInput::model()->deleteByPk($d->id);
        }
        $this->redirect(array('admin'));
    }

    public function actionDeleteAll() {
        if (isset($_POST['production-input-grid_c0'])) {
            $del_item = $_POST['production-input-grid_c0'];
            $model_item = new ProductionInput;
            foreach ($del_item as $_id) {
                $thisInfo = ProductionInput::model()->findByPk($_id);
                $storeInventory = new StoreInventory;
                $storeInventory->store = $thisInfo->store;
                $storeInventory->item = $thisInfo->item;
                $storeInventory->stock_in = $thisInfo->qty;
                $storeInventory->date = $thisInfo->date;
                $costingPrice = CostingPrice::model()->activeCostingPrice($thisInfo->item);
                $storeInventory->costing_price = $costingPrice;
                $storeInventory->save();

                $model_item->deleteByPk($_id);
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to delete.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionDeleteFromUpdate() {
        if(isset($_POST["id"])){
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                ProductionInput::model()->deleteByPk($_POST["id"]);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionInput']))
            $model->attributes = $_GET['ProductionInput'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminOutput() {
        $model = new ProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionInput']))
            $model->attributes = $_GET['ProductionInput'];

        $this->render('adminOutput', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminWastage() {
        $model = new ProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionInput']))
            $model->attributes = $_GET['ProductionInput'];

        $this->render('adminWastage', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminReturn(){
        $model = new ProductionInput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductionInput']))
            $model->attributes = $_GET['ProductionInput'];

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
        $model = ProductionInput::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'production-input-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
