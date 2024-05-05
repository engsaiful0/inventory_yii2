<?php

class PurchaseRequisitionController extends Controller {

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
    
    public function actionAdminPRFromSR() {
        $model = new StoreRequisition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreRequisition']))
            $model->attributes = $_GET['StoreRequisition'];

        $this->render('adminPRFromSR', array(
            'model' => $model,
        ));
    }
    public function actionAdminApprove() {
        $model = new PurchaseRequisition('searchApprove');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseRequisition']))
            $model->attributes = $_GET['PurchaseRequisition'];

        $this->render('adminApprove', array(
            'model' => $model,
        ));
    }
    public function actionAllApprove($sl_no) {
        $model = new PurchaseRequisition;
        $condition = "sl_no='" . $sl_no . "' AND is_approved!=1";
        $reqInfo = PurchaseRequisition::model()->findAll(array('condition' => $condition,));
        $reqInfoMain=  PurchaseRequisition::model()->findAll(array('condition' => 'sl_no="'.$sl_no.'"',));
        if (isset($_POST['PurchaseRequisition'])) {
            $model->attributes = $_POST['PurchaseRequisition'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $i = 0;
                foreach ($_POST['PurchaseRequisition']['sl_no'] as $tempPOid):
                    
                    
                    
                        $model = $this->loadModel($_POST['PurchaseRequisition']['id'][$i]);
                        $model->is_superadmin_approved = 1;
                        $model->superadmin_approved_by = Yii::app()->user->getId();
                        $model->superadmin_approved_time = new CDbExpression('NOW()');
                        $model->save();

                        
                    
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
                    'reqInfoMain'=>'',
                    'reqInfo' => '',
                        ), true, true),
            ));
            exit;
        }
    }
    
    public function actionReqFromStoreReq($sl_no) {
        $model = new PurchaseRequisition;
        $condition = "sl_no='" . $sl_no . "'";
        $reqInfo = StoreRequisition::model()->findAll(array('condition' => $condition,));
        
        if (isset($_POST['PurchaseRequisition'])) {
            $model->attributes = $_POST['PurchaseRequisition'];
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['PurchaseRequisition']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseRequisition", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;
                foreach ($_POST['PurchaseRequisition']['item'] as $tempItems):
                    if($_POST['PurchaseRequisition']['qty'][$i]>0){
                        $model = new PurchaseRequisition;
                        $model->item = $tempItems;
                        $model->qty = $_POST['PurchaseRequisition']['qty'][$i];
                        $model->cost = $_POST['PurchaseRequisition']['cost'][$i];
                        $model->remarks = $_POST['PurchaseRequisition']['remarks'][$i];
                        $model->department = $_POST['PurchaseRequisition']['department'];
                        $model->date = $_POST['PurchaseRequisition']['date'];
                        $model->store = $_POST['PurchaseRequisition']['store'];
                        $model->sl_no = $slInvNo;
                        $model->max_sl_no = $thisInvMaxNo;
                        $model->store_req_id=$_POST['PurchaseRequisition']['store_req_id'][$i];
                        $model->save();
                    }
                    $i++;
                endforeach;
                $condition = "sl_no='" . $model->sl_no . "'";
                $data = PurchaseRequisition::model()->findAll(array("condition" => $condition));
                echo CJSON::encode(array(
                    'status' => 'success',
                    'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                ));
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_formReqStoreReq', array(
                    'model' => $model,
                    'reqInfo' => $reqInfo,
                        ), true, true),
            ));
            exit;
        }
    }
    
    public function actionReqFromSO() {
        $model = new PurchaseRequisition;

        $this->render('reqFromSO', array(
            'model' => $model,
            'itemsModel' => new Items,
        ));
    }

    public function actionReqFromSOView() {
        $store = $_POST['PurchaseRequisition']['store'];
        $category = $_POST['Items']['cat'];
        $pbrand = $_POST['Items']['pbrand'];
        $pmodel = $_POST['Items']['pmodel'];
        $country = $_POST['Items']['country'];
        $product_type = $_POST['Items']['product_type'];
        $grade = $_POST['Items']['grade'];
        $mfi = $_POST['Items']['mfi'];
        
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
           
            $criteria->order = "name ASC";
            $data = Items::model()->findAll($criteria);
            
            echo CJSON::encode(array(
                'content' => $this->renderPartial('reqFromSOView', array(
                    'data' => $data,
                    'store'=>$store,
                        ), true, true),
            ));
        }
    }
    
    public function actionReqFromSoCreate() {
        $model = new PurchaseRequisition;
        $storeIds = "no_store";
        $prodIds = "no_prod";
        $prodReqQtys = "no_prod";
        if (isset($_POST['attrStoreArr']) && isset($_POST['attrProdArr']) && isset($_POST['attrProdReqQtyArr'])) {
            $storeIds = $_POST['attrStoreArr'];
            $prodIds = $_POST['attrProdArr'];
            $prodReqQtys = $_POST['attrProdReqQtyArr'];
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRequisition'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['PurchaseRequisition'];
                if ($model->validate()) {
                    if (isset($_POST['PurchaseRequisition']['item'])) {
                        date_default_timezone_set("Asia/Dhaka");
                        $todayDate = $_POST['PurchaseRequisition']['date'];
                        $dateForInvNo = str_replace("-", "", $todayDate);
                        $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseRequisition", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                        $slInvNo = $dateForInvNo . $thisInvMaxNo;
                        $i = 0;
                        foreach ($_POST['PurchaseRequisition']['item'] as $tempItems):
                            if($_POST['PurchaseRequisition']['qty'][$i]>0){
                                $model = new PurchaseRequisition;
                                $model->item = $tempItems;
                                $model->qty = $_POST['PurchaseRequisition']['qty'][$i];
                                $model->cost = $_POST['PurchaseRequisition']['cost'][$i];
                                $model->remarks = $_POST['PurchaseRequisition']['remarks'][$i];
                                $model->department = $_POST['PurchaseRequisition']['department'];
                                $model->date = $_POST['PurchaseRequisition']['date'];
                                $model->store = $_POST['PurchaseRequisition']['store'];
                                $model->sl_no = $slInvNo;
                                $model->max_sl_no = $thisInvMaxNo;
                                $model->save();
                            }
                            $i++;
                        endforeach;
                        $condition = "sl_no='" . $model->sl_no . "'";
                        $data = PurchaseRequisition::model()->findAll(array("condition" => $condition));
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
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
                'content' => $this->renderPartial('_formReqFromSo', array(
                    'model' => $model,
                    'storeIds' => $storeIds,
                    'prodIds' => $prodIds,
                    'prodReqQtys'=>$prodReqQtys,
                        ), true, true),
            ));
            exit;
        }
    }

    public function actionReqFromItemsWarningQty() {
        $model = new PurchaseRequisition;

        $this->render('reqFromItemsWarningQty', array(
            'model' => $model,
            'itemsModel' => new Items,
        ));
    }

    public function actionReqFromItemsWarningQtyView() {
        $store = $_POST['PurchaseRequisition']['store'];
        $category = $_POST['Items']['cat'];
        $pbrand = $_POST['Items']['pbrand'];
        $pmodel = $_POST['Items']['pmodel'];
        $country = $_POST['Items']['country'];
        $product_type = $_POST['Items']['product_type'];
        $grade = $_POST['Items']['grade'];
        $mfi = $_POST['Items']['mfi'];

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

            $criteria->order = "name ASC";
            $data = Items::model()->findAll($criteria);
            
            echo CJSON::encode(array(
                'content' => $this->renderPartial('reqFromItemsWarningQtyView', array(
                    'data' => $data,
                    'store'=>$store,
                        ), true, true),
            ));
        }
    }
    
    public function actionReqFromItemsWarnQtyCreate() {
        $model = new PurchaseRequisition;
        $storeIds = "no_store";
        $prodIds = "no_prod";
        if (isset($_POST['attrStoreArr']) && isset($_POST['attrProdArr'])) {
            $storeIds = $_POST['attrStoreArr'];
            $prodIds = $_POST['attrProdArr'];
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRequisition'])) {
            if (Yii::app()->request->isAjaxRequest) {
                // Stop jQuery from re-initialization
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                //$model->attributes = $_POST['PurchaseRequisition'];
                if ($model->validate()) {
                    if (isset($_POST['PurchaseRequisition']['item'])) {
                        date_default_timezone_set("Asia/Dhaka");
                        $todayDate = $_POST['PurchaseRequisition']['date'];
                        $dateForInvNo = str_replace("-", "", $todayDate);
                        $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseRequisition", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                        $slInvNo = $dateForInvNo . $thisInvMaxNo;
                        $i = 0;
                        foreach ($_POST['PurchaseRequisition']['item'] as $tempItems):
                            if($_POST['PurchaseRequisition']['qty'][$i]>0){
                                $model = new PurchaseRequisition;
                                $model->item = $tempItems;
                                $model->qty = $_POST['PurchaseRequisition']['qty'][$i];
                                $model->cost = $_POST['PurchaseRequisition']['cost'][$i];
                                $model->remarks = $_POST['PurchaseRequisition']['remarks'][$i];
                                $model->department = $_POST['PurchaseRequisition']['department'];
                                $model->date = $_POST['PurchaseRequisition']['date'];
                                $model->store = $_POST['PurchaseRequisition']['store'];
                                $model->sl_no = $slInvNo;
                                $model->max_sl_no = $thisInvMaxNo;
                            }
                            $model->save();
                            $i++;
                        endforeach;
                        $condition = "sl_no='" . $model->sl_no . "'";
                        $data = PurchaseRequisition::model()->findAll(array("condition" => $condition));
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
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
                'content' => $this->renderPartial('_formReqFromItemsWarningQty', array(
                    'model' => $model,
                    'storeIds' => $storeIds,
                    'prodIds' => $prodIds,
                        ), true, true),
            ));
            exit;
        }
    }

    public function actionPurchaseReport() {
        $model = new PurchaseRequisition;

        $this->render('purchaseReport', array(
            'model' => $model,
        ));
    }

    public function actionPurchaseReportView() {
        $startDate = $_POST['PurchaseRequisition']['startDate'];
        $endDate = $_POST['PurchaseRequisition']['endDate'];
        $store = $_POST['PurchaseRequisition']['store'];
        $category = $_POST['PurchaseRequisition']['category'];
        $item = $_POST['PurchaseRequisition']['item'];
        $supplier_id = $_POST['PurchaseRequisition']['supplier_id'];

        if ($startDate != "" && $endDate != "") {
            $message = "Purchase Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(qty) as sumQty, item';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');

            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store" => $store), "AND", "AND");
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
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
            }

            $criteria->group = "item";
            $data = PurchaseRequisition::model()->findAll($criteria);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
            $data = "";
        }

        echo CJSON::encode(array(
            'content' => $this->renderPartial('purchaseReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'store' => $store,
                'category' => $category,
                'item' => $item,
                'supplier_id'=>$supplier_id,
                    ), true, true),
        ));
    }

    public function actionRequisitionPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = PurchaseRequisition::model()->findAll(array('condition' => $condition,));
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
        $model = new PurchaseRequisition;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRequisition'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['PurchaseRequisition']['date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("PurchaseRequisition", 'max_sl_no', 'maxSINo', 'date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;

                $i = 0;
                foreach ($_POST['PurchaseRequisition']['item'] as $tempItems):
                    if($_POST['PurchaseRequisition']['qty'][$i]>0){
                        $model = new PurchaseRequisition;
                        $model->item = $tempItems;
                        $model->qty = $_POST['PurchaseRequisition']['qty'][$i];
                        $model->cost = $_POST['PurchaseRequisition']['cost'][$i];
                        $model->name_of_unit = $_POST['PurchaseRequisition']['name_of_unit'][$i];
                        $model->req_by = $_POST['PurchaseRequisition']['req_by'];
                        $model->approve_to = $_POST['PurchaseRequisition']['approve_to'];
                        $model->remarks = $_POST['PurchaseRequisition']['remarks'][$i];
                        $model->department = $_POST['PurchaseRequisition']['department'];
                        $model->date = $_POST['PurchaseRequisition']['date'];
                        $model->store = $_POST['PurchaseRequisition']['store'];
                        $model->sl_no = $slInvNo;
                        $model->max_sl_no = $thisInvMaxNo;
                        $model->save();
                    }
                    $i++;
                endforeach;
                $condition = "sl_no='" . $model->sl_no . "'";
                $data = PurchaseRequisition::model()->findAll(array("condition" => $condition));
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
        $model = new PurchaseRequisition;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PurchaseRequisition'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['PurchaseRequisition']['item'] as $tempItems):
                    $isExist = PurchaseRequisition::model()->findByPk($_POST['PurchaseRequisition']['id'][$i]);
                    if ($isExist) {
                        PurchaseRequisition::model()->updateByPk($_POST['PurchaseRequisition']['id'][$i], array(
                            'sl_no'=>$_POST['PurchaseRequisition']['sl_no'],
                            'max_sl_no'=>$_POST['PurchaseRequisition']['max_sl_no'],
                            'item'=>$tempItems,
                            'qty'=>$_POST['PurchaseRequisition']['qty'][$i],
                            'name_of_unit'=>$_POST['PurchaseRequisition']['name_of_unit'][$i],
                            
                            'cost'=>$_POST['PurchaseRequisition']['cost'][$i],
                            'remarks'=>$_POST['PurchaseRequisition']['remarks'][$i],
                            'store'=>$_POST['PurchaseRequisition']['store'],
                            'department'=>$_POST['PurchaseRequisition']['department'],
                            'req_by' => $_POST['PurchaseRequisition']['req_by'],
                        'approve_to' => $_POST['PurchaseRequisition']['approve_to'],
                            'date'=>$_POST['PurchaseRequisition']['date'],
                            'created_by'=>$_POST['PurchaseRequisition']['created_by'],
                            'created_time'=>$_POST['PurchaseRequisition']['created_time'],
                            'updated_by'=>Yii::app()->user->getId(),
                            'updated_time'=>new CDbExpression('NOW()'),
                        ));
                    } else {
                        $model = new PurchaseRequisition;
                        $model->item = $tempItems;
                        $model->qty = $_POST['PurchaseRequisition']['qty'][$i];
                        $model->cost = $_POST['PurchaseRequisition']['cost'][$i];
                        
                        
                        $model->remarks = $_POST['PurchaseRequisition']['remarks'][$i];
                        $model->department = $_POST['PurchaseRequisition']['department'];
                        $model->name_of_unit = $_POST['PurchaseRequisition']['name_of_unit'][$i];
                        $model->req_by = $_POST['PurchaseRequisition']['req_by'];
                        $model->approve_to = $_POST['PurchaseRequisition']['approve_to'];
                        $model->date = $_POST['PurchaseRequisition']['date'];
                        $model->store = $_POST['PurchaseRequisition']['store'];
                        $model->sl_no = $_POST['PurchaseRequisition']['sl_no'];
                        $model->max_sl_no = $_POST['PurchaseRequisition']['max_sl_no'];
                        $model->created_by = Yii::app()->user->getId();
                        $model->created_time = new CDbExpression('NOW()');
                        $model->save();
                    }
                    $i++;
                endforeach;
                
                $condition = "sl_no='" . $sl_no . "'";
                $data = PurchaseRequisition::model()->findAll(array("condition" => $condition));
                
                echo CJSON::encode(array(
                    'voucherPreview' => $this->renderPartial('voucherPreview', array('data' => $data), true, true),
                ));
                //echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
                Yii::app()->end();
            }else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('_form2', array(
                'model' => $model,
                'itemsModel' => new Items,
                'sl_no'=>$sl_no,
            ));
        }
    }

    public function actionDeleteAll() {
        if (isset($_POST['purchase-requisition-grid_c0'])) {
            $del_item = $_POST['purchase-requisition-grid_c0'];
            $model_item = new PurchaseRequisition;
            foreach ($del_item as $_id) {
                $model_item->deleteByPk($_id);
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to delete.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionDelete($sl_no) {
        PurchaseRequisition::model()->deleteAll(array("condition"=>"sl_no='".$sl_no."'"));
        $this->redirect(array('admin'));
    }
    
    public function actionDeleteFromUpdate() {
        if(isset($_POST["id"])){
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                PurchaseRequisition::model()->deleteByPk($_POST["id"]);

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
        $model = new PurchaseRequisition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseRequisition']))
            $model->attributes = $_GET['PurchaseRequisition'];

        $this->render('admin', array(
            'model' => $model,
            'itemsModel' => new Items,
        ));
    }
    
    public function actionAdminPP() {
        $model = new PurchaseRequisition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseRequisition']))
            $model->attributes = $_GET['PurchaseRequisition'];

        $this->render('adminPP', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PurchaseRequisition::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-requisition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
