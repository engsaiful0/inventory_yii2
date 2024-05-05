<?php

class SaleOrderController extends Controller {

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
    
    public function actionStop($id) {
        if (Yii::app()->request->isAjaxRequest) {
            SaleOrder::model()->updateByPk($id, array('is_stopped'=>'1'));
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            exit;
        }
    }
    
    public function actionStart($id) {
        if (Yii::app()->request->isAjaxRequest) {
            SaleOrder::model()->updateByPk($id, array('is_stopped'=>'0'));
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            exit;
        }
    }
    
    public function actionSalesReport(){
        $model = new SaleOrder;

        $this->render('salesReport', array(
            'model' => $model,
        ));
    }
    
    public function actionSalesReportView(){
        $startDate = $_POST['SaleOrder']['startDate'];
        $endDate = $_POST['SaleOrder']['endDate'];
        $store = $_POST['SaleOrder']['store'];
        $category = $_POST['SaleOrder']['category'];
        $item = $_POST['SaleOrder']['item'];
        $customer_id = $_POST['SaleOrder']['customer_id'];
        $sales_by = $_POST['SaleOrder']['sales_by'];
        $order_type2 = $_POST['SaleOrder']['order_type2'];
        $supplier_id = $_POST['SaleOrder']['supplier_id'];
        
        if ($startDate != "" && $endDate != "") {
            $message = "Sales Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select="sl_no, issue_date, expected_d_date, order_type2, pi_no, pi_date, store, customer_id, contact_person, sales_by";
            $criteria->addBetweenCondition('issue_date', $startDate, $endDate, 'AND');
            if ($order_type2 != "") {
                $message.=", " . Lookup::item("order_type2", $order_type2);
                $criteria->addColumnCondition(array("order_type2" => $order_type2), "AND", "AND");
            }
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
            
            if ($customer_id != "") {
                $message.=", Customer: " . Customers::model()->customerName($customer_id);
                $criteria->addColumnCondition(array("customer_id" => $customer_id), "AND", "AND");
            }
            
            if ($sales_by != "") {
                $message.=", Sales By: " . Employees::model()->fullName($sales_by);
                $criteria->addColumnCondition(array("sales_by" => $sales_by), "AND", "AND");
            }
            $criteria->group="sl_no";
            $data = SaleOrder::model()->findAll($criteria);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
            $data = "";
        }
        
        echo CJSON::encode(array(
            'content' => $this->renderPartial('salesReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'store' => $store,
                'category' => $category,
                'item' => $item,
                'customer_id' => $customer_id,
                'sales_by' => $sales_by,
                'order_type2'=>$order_type2,
                'supplier_id'=>$supplier_id,
                    ), true, true),
        ));
    }

    public function actionSoPreview() {
        $sl_no = $_POST['sl_no'];
        if ($sl_no) {
            $condition = 'sl_no="' . $sl_no . '"';
            $data = SaleOrder::model()->findAll(array('condition' => $condition,));
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('voucherPreview', array('data' => $data), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please set so no!</div>';
        }
    }

    public function actionCreate() {
        $model = new SaleOrder;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SaleOrder'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                date_default_timezone_set("Asia/Dhaka");
                $todayDate = $_POST['SaleOrder']['issue_date'];
                $dateForInvNo = str_replace("-", "", $todayDate);
                $thisInvMaxNo = Items::model()->maxValOfThisWithDateCondition("SaleOrder", 'max_sl_no', 'maxSINo', 'issue_date', $todayDate);
                $slInvNo = $dateForInvNo . $thisInvMaxNo;
                $i = 0;

                foreach ($_POST['SaleOrder']['item'] as $tempItems):
                    $model = new SaleOrder;
                    $model->item = $tempItems;
                    $model->qty = $_POST['SaleOrder']['qty'][$i];
                    $model->price = $_POST['SaleOrder']['price'][$i];
                    $model->conv_unit = $_POST['SaleOrder']['conv_unit'][$i];
                    $model->order_type2 = $_POST['SaleOrder']['order_type2'];
                    $model->customer_id = $_POST['SaleOrder']['customer_id'];
                    $model->contact_person = $_POST['SaleOrder']['contact_person'];
                    $model->pi_no = $_POST['SaleOrder']['pi_no'];
                    $model->pi_date = $_POST['SaleOrder']['pi_date'];
                    $model->subj = $_POST['SaleOrder']['subj'];
                    $model->issue_date = $_POST['SaleOrder']['issue_date'];
                    $model->expected_d_date = $_POST['SaleOrder']['expected_d_date'];
                    $model->store = $_POST['SaleOrder']['store'];
                    $model->created_time = new CDbExpression('NOW()');
                    $model->created_by = Yii::app()->user->getId();
                    $model->sales_by = $_POST['SaleOrder']['sales_by'];
                    $model->sl_no = $slInvNo;
                    $model->max_sl_no = $thisInvMaxNo;
                    $model->save();
                    $i++;
                endforeach;
                $condition = "sl_no='" . $model->sl_no . "'";
                $data = SaleOrder::model()->findAll(array("condition" => $condition));
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
        $model = new SaleOrder;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SaleOrder'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['SaleOrder']['item'] as $tempItems):
                    $isExist = SaleOrder::model()->findByPk($_POST['SaleOrder']['id'][$i]);
                    if ($isExist) {
                        SaleOrder::model()->updateByPk($_POST['SaleOrder']['id'][$i], array(
                            'sl_no'=>$_POST['SaleOrder']['sl_no'],
                            'max_sl_no'=>$_POST['SaleOrder']['max_sl_no'],
                            'item'=>$tempItems,
                            'qty'=>$_POST['SaleOrder']['qty'][$i],
                            'price'=>$_POST['SaleOrder']['price'][$i],
                            'conv_unit' => $_POST['SaleOrder']['conv_unit'][$i],
                            'order_type2'=>$_POST['SaleOrder']['order_type2'],
                            'customer_id'=>$_POST['SaleOrder']['customer_id'],
                            'contact_person'=>$_POST['SaleOrder']['contact_person'],
                            'store'=>$_POST['SaleOrder']['store'],
                            'sales_by'=>$_POST['SaleOrder']['sales_by'],
                            'issue_date'=>$_POST['SaleOrder']['issue_date'],
                            'expected_d_date'=>$_POST['SaleOrder']['expected_d_date'],
                            'pi_no'=>$_POST['SaleOrder']['pi_no'],
                            'pi_date'=>$_POST['SaleOrder']['pi_date'],
                            'subj'=>$_POST['SaleOrder']['subj'],
                            'created_by'=>$_POST['SaleOrder']['created_by'],
                            'created_time'=>$_POST['SaleOrder']['created_time'],
                            'updated_by'=>Yii::app()->user->getId(),
                            'updated_time'=>new CDbExpression('NOW()'),
                        ));
                    } else {
                        $model = new SaleOrder;
                        $model->item = $tempItems;
                        $model->qty = $_POST['SaleOrder']['qty'][$i];
                        $model->price = $_POST['SaleOrder']['price'][$i];
                        $model->conv_unit = $_POST['SaleOrder']['conv_unit'][$i];
                        $model->order_type2 = $_POST['SaleOrder']['order_type2'];
                        $model->customer_id = $_POST['SaleOrder']['customer_id'];
                        $model->contact_person = $_POST['SaleOrder']['contact_person'];
                        $model->pi_no = $_POST['SaleOrder']['pi_no'];
                        $model->pi_date = $_POST['SaleOrder']['pi_date'];
                        $model->subj = $_POST['SaleOrder']['subj'];
                        $model->issue_date = $_POST['SaleOrder']['issue_date'];
                        $model->expected_d_date = $_POST['SaleOrder']['expected_d_date'];
                        $model->store = $_POST['SaleOrder']['store'];
                        $model->created_by = Yii::app()->user->getId();
                        $model->created_time = new CDbExpression('NOW()');
                        $model->sales_by = $_POST['SaleOrder']['sales_by'];
                        $model->sl_no = $_POST['SaleOrder']['sl_no'];
                        $model->max_sl_no = $_POST['SaleOrder']['max_sl_no'];
                        $model->save();
                    }
                    $i++;
                endforeach;
                $condition = "sl_no='" . $sl_no . "'";
                $data = SaleOrder::model()->findAll(array("condition" => $condition));
                echo CJSON::encode(array(
                    'status' => 'success',
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($sl_no) {
        SaleOrder::model()->deleteAll(array("condition"=>"sl_no='".$sl_no."'"));
        $this->redirect(array('admin'));
    }

    public function actionDeleteAll() {
        if (isset($_POST['sale-order-grid_c0'])) {
            $del_item = $_POST['sale-order-grid_c0'];
            $model_item = new SaleOrder;
            foreach ($del_item as $_id) {
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
                SaleOrder::model()->deleteByPk($_POST["id"]);

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
        $model = new SaleOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleOrder']))
            $model->attributes = $_GET['SaleOrder'];

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
        $model = SaleOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
