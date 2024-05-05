<?php

class StoreInventoryController extends Controller {

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
    
    public function actionSendFromTempToMainInv() {
        $model = new StoreInventory;

        $this->render('sendFromTempToMainInv', array(
            'model' => $model,
            'itemsModel' => new Items,
        ));
    }
    
    public function actionSendFromTempToMainInvView() {
        $store = $_POST['StoreInventory']['store'];
        $category = $_POST['Items']['cat'];
        $pbrand = $_POST['Items']['pbrand'];
        $pmodel = $_POST['Items']['pmodel'];
        $country = $_POST['Items']['country'];
        $product_type = $_POST['Items']['product_type'];
        $grade = $_POST['Items']['grade'];
        $mfi = $_POST['Items']['mfi'];
        $supplier_id = $_POST['Items']['supplier_id'];
        $id = $_POST['Items']['id'];

        if ($store != "") {
            $criteria = new CDbCriteria();
            if ($category != "") {
                $criteria->addColumnCondition(array("cat" => $category), "AND", "AND");
            }
            if ($pbrand != "") {
                $criteria->addColumnCondition(array("pbrand" => $pbrand), "AND", "AND");
            }
            if ($pmodel != "") {
                $criteria->addColumnCondition(array("pmodel" => $pmodel), "AND", "AND");
            }
            if ($country != "") {
                $criteria->addColumnCondition(array("country" => $country), "AND", "AND");
            }
            if ($product_type != "") {
                $criteria->addColumnCondition(array("product_type" => $product_type), "AND", "AND");
            }
            if ($grade != "") {
                $criteria->addColumnCondition(array("grade" => $grade), "AND", "AND");
            }
            if ($mfi != "") {
                $criteria->addColumnCondition(array("mfi" => $mfi), "AND", "AND");
            }
            if ($id != "") {
                $criteria->addColumnCondition(array("id" => $id), "AND", "AND");
            }
            if ($supplier_id != "") {
                $criteria->addColumnCondition(array("supplier_id" => $supplier_id), "AND", "AND");
            }

            $criteria->order = "name ASC";
            $data = Items::model()->findAll($criteria);
            
            $itemsArray=array();
            $criteria2 = new CDbCriteria();
            $criteria2->select="sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut, item, costing_price";
            $criteria2->addColumnCondition(array("store"=>$store), "AND", "AND");
            if($data){
                foreach($data as $d){
                    $itemsArray[]=$d->id;
                }
                $criteria2->addInCondition("item", $itemsArray, "AND");
            }
            $criteria2->group="item";
            $data2=StoreInventory::model()->findAll($criteria2);
            
            echo CJSON::encode(array(
                'content' => $this->renderPartial('sendFromTempToMainInvView', array(
                    'data' => $data2,
                    'store'=>$store,
                        ), true, true),
            ));
        }
    }
    
    public function actionTransferStockFromTempToMainInvCreate() {
        $model = new Inventory;
        $storeIds = "no_store";
        $prodIds = "no_prod";
        $prodAS = "no_av_stck";
        $prodCosts = "no_cost";
        
        if (isset($_POST['attrStoreArr']) && isset($_POST['attrProdArr']) && isset($_POST['attrProdAvStckArr']) && isset($_POST['attrProdCostArr'])) {
            $storeIds = $_POST['attrStoreArr'];
            $prodIds = $_POST['attrProdArr'];
            $prodAS = $_POST['attrProdAvStckArr'];
            $prodCosts = $_POST['attrProdCostArr'];
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Inventory'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['PurchaseRequisition'];
                if ($model->validate()) {
                    if (isset($_POST['Inventory']['item'])) {
                        $i = 0;
                        foreach ($_POST['Inventory']['item'] as $tempItems):
                            $model2 = new StoreInventory;
                            $model2->item = $tempItems;
                            $model2->stock_out = $_POST['Inventory']['stock_in'][$i];
                            $model2->date = $_POST['Inventory']['date'];
                            $model2->store = $_POST['Inventory']['from_store'];
                            $model2->save();
                            
                            $model = new Inventory;
                            $model->item = $tempItems;
                            $model->stock_in = $_POST['Inventory']['stock_in'][$i];
                            $model->costing_price = $_POST['Inventory']['costing_price'][$i];
                            $model->date = $_POST['Inventory']['date'];
                            $model->store = $_POST['Inventory']['to_store'];
                            $model->save();
                            
                            $model3 = new StorckTranferHistoryFromTempToMain;
                            $model3->item = $tempItems;
                            $model3->qty = $_POST['Inventory']['stock_in'][$i];
                            $model3->date = $_POST['Inventory']['date'];
                            $model3->from_temp_store = $_POST['Inventory']['from_store'];
                            $model3->to_main_store = $_POST['Inventory']['to_store'];
                            $model3->save();
                            
                            $i++;
                        endforeach;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => '<div class="flash-notice">successfully transfered</div>',
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
                'content' => $this->renderPartial('_formTransferStockFromTempToMainInv', array(
                    'model' => $model,
                    'storeIds' => $storeIds,
                    'prodIds' => $prodIds,
                    'prodAS' => $prodAS,
                    'prodCosts' => $prodCosts,
                        ), true, true),
            ));
            exit;
        }
    }
    
    public function actionStockReport(){
        $model = new StoreInventory;

        $this->render('stockReport', array(
            'model' => $model,
        ));
    }
    
    public function actionStockReportView(){
        $startDate = $_POST['StoreInventory']['startDate'];
        $endDate = $_POST['StoreInventory']['endDate'];
        $store = $_POST['StoreInventory']['store'];
        $category = $_POST['StoreInventory']['category'];
        $item = $_POST['StoreInventory']['item'];
        $supplier_id = $_POST['StoreInventory']['supplier_id'];

        if ($startDate != "" && $endDate != "") {
            $message = "Stock (Temporary Inventory) Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut, item';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
            
            if($store!=""){
                $message.=", Store: ".Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store"=>$store), "AND", "AND");
            }
            if ($category != "" || $supplier_id != "") {
                if($category != "" && $supplier_id == ""){
                    $condition="cat=".$category;
                    $message.=", Category: " . Cats::model()->nameOfThis($category);
                }else if($category == "" && $supplier_id != ""){
                    $condition="supplier_id=".$supplier_id;
                    $message.=", Supplier: " . Suppliers::model()->supplierName($supplier_id);
                }else if ($category != "" && $supplier_id != ""){
                    $condition="cat=".$category." AND supplier_id=".$supplier_id;
                    $message.=", Category: " . Cats::model()->nameOfThis($category);
                    $message.=", Supplier: " . Suppliers::model()->supplierName($supplier_id);
                }else{
                    $condition="";
                    $message.="";
                }
                $itemsData = Items::model()->findAll(array("condition" => $condition));
                $itemsArray = array();
                if ($itemsData) {
                    foreach ($itemsData as $itmsd) {
                        $itemsArray[] = $itmsd->id;
                    }
                }
                $criteria->addInCondition("item", $itemsArray, "AND");
            }
            if($item!=""){
                $message.=", Item: ".Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item"=>$item), "AND", "AND");
            }
            
            $criteria->group = "item";
            $data = StoreInventory::model()->findAll($criteria);
            
        } else {
            $message= "<div class='flash-error'>Please select date range!</div>";
            $data="";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('stockReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate'=>$startDate,
                'endDate'=>$endDate,
                'store'=>$store,
                'category'=>$category,
                'item'=>$item,
                'supplier_id'=>$supplier_id,
            ), true, true),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new StoreInventory;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreInventory'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['StoreInventory']['item'] as $tempItems):
                    $model = new StoreInventory;
                    $model->item = $tempItems;
                    $model->stock_in = $_POST['StoreInventory']['stock_in'][$i];
                    $costinPrice=  CostingPrice::model()->activeCostingPrice($tempItems);
                    $model->costing_price = $costinPrice;
                    $model->date = $_POST['StoreInventory']['date'];
                    $model->store = $_POST['StoreInventory']['store'];
                    $model->save();
                    $i++;
                endforeach;
                
                echo CJSON::encode(array(
                    'status' => 'success',
                ));
                Yii::app()->end();
            }else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('admin', array(
                'model' => $model,
                'itemsModel'=>new Items,
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

        if (isset($_POST['StoreInventory'])) {
            $model->attributes = $_POST['StoreInventory'];
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
        if (isset($_POST['store-inventory-grid_c0'])) {
            $del_item = $_POST['store-inventory-grid_c0'];
            $model_item = new StoreInventory;
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
        $model = new StoreInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreInventory']))
            $model->attributes = $_GET['StoreInventory'];

        $this->render('admin', array(
            'model' => $model,
            'itemsModel'=>new Items,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = StoreInventory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'store-inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
