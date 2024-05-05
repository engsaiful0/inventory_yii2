<?php

class PosController extends Controller {

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

    public function actionPosReport() {
        $model = new Pos;

        $this->render('posReport', array(
            'model' => $model,
        ));
    }

    public function actionPosReportView() {
        $startDate = $_POST['Pos']['startDate'];
        $endDate = $_POST['Pos']['endDate'];
        $store = $_POST['Pos']['store_id'];
        $category = $_POST['Pos']['category'];
        $item = $_POST['Pos']['item_id'];
        $isVoid = $_POST['Pos']['is_void'];
        $machineId = $_POST['Pos']['machine_id'];
        $initiatedBy = $_POST['Pos']['initiated_by'];
        $supplier_id = $_POST['Pos']['supplier_id'];

        if ($startDate != "" && $endDate != "") {
            $message = "POS Summery From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(qty) as sumOfQty, price, vatable_price, sum(price*qty) as sumOfSaleAmount, sum(vatable_price*qty) as sumOfSaleAmountVatable, item_id';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');

            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store_id" => $store), "AND", "AND");
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
                $criteria->addInCondition("item_id", $itemsArray, "AND");
            }
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item_id" => $item), "AND", "AND");
            }
            if ($isVoid != '') {
                $criteria->addColumnCondition(array('is_void' => $isVoid), 'AND', 'AND');
            }
            if ($machineId != "") {
                $message.=", Counter: " . MachineNames::model()->nameOfThis($machineId);
                $criteria->addColumnCondition(array("machine_id" => $machineId), "AND", "AND");
            }
            if ($initiatedBy != "") {
                $message.=", Cashier: " . Users::model()->fullNameOfThisOnlyName($initiatedBy);
                $criteria->addColumnCondition(array("initiated_by" => $initiatedBy), "AND", "AND");
            }
            $criteria->addColumnCondition(array("is_recycled"=>"0"), "AND", "AND");
            $criteria->group = "item_id";
            $data = Pos::model()->findAll($criteria);

            $criteria2 = new CDbCriteria();
            //$criteria2->select = "sum((price-discount)*qty) as cashTotal, sum(qty*vatable_price) as sumOfSaleAmount, overall_discount, cash_payment, visa_payment, master_payment, amex_payment, gift_card_payment, cash_return";
            $criteria2->select = "sum(vatable_price*qty) as sumOfSaleAmountVatable, overall_discount, discount_type, cash_payment, visa_payment, master_payment, amex_payment, gift_card_payment, cash_return";
            $criteria2->addBetweenCondition("date", $startDate, $endDate);

            if ($isVoid != '') {
                $criteria2->addColumnCondition(array('is_void' => $isVoid), 'AND', 'AND');
            }
            if ($machineId != "") {
                $criteria2->addColumnCondition(array("machine_id" => $machineId), "AND", "AND");
            }
            if ($initiatedBy != "") {
                $criteria2->addColumnCondition(array("initiated_by" => $initiatedBy), "AND", "AND");
            }
            $criteria->addColumnCondition(array("is_recycled"=>"0"), "AND", "AND");
            $criteria2->group = "inv_no";
            $data2 = Pos::model()->findAll($criteria2);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
            $data = "";
        }

        echo CJSON::encode(array(
            'content' => $this->renderPartial('posReportView', array(
                'data' => $data,
                'message' => $message,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'store' => $store,
                'category' => $category,
                'supplier_id'=>$supplier_id,
                'item' => $item,
                'isVoid' => $isVoid,
                'machineId' => $machineId,
                'initiatedBy' => $initiatedBy,
                'data2' => $data2,
                    ), true, true),
        ));
    }

    public function actionCreate() {
        $this->layout = "column1";
        $model = new Pos;
        $modelMembers = new Members;
//        if (empty(Yii::app()->session['authorized_by'])) {
//            $this->redirect(array('authorizationCheck'));
//        } else {
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if (isset($_POST['Pos'])) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $model->attributes = $_POST['Pos'];
                $grandTotal = $_POST['Pos']['cashTotal'];
                if ($grandTotal > 0) {
                    $valid = $model->validate();
                    if ($valid) {

                        $machineInfo = MachineNames::model()->findByAttributes(array('ip_address' => Yii::app()->request->getUserHostAddress()));
                        if ($machineInfo) {
                            $machineId = $machineInfo->id;
                        } else {
                            $machineId = "";
                        }
                        $initiatedBy = Yii::app()->user->getId();

                        date_default_timezone_set("Asia/Dhaka");
                        $todaySaleDate = date("Y-m-d");
                        $saleDateForInvNo = str_replace("-", "", $todaySaleDate);

                        $thisPosMaxNo = Items::model()->maxValOfThisWithDateCondition('Pos', 'max_inv_no', 'maxInvNo', 'date', $todaySaleDate);
                        $thisPosNo = $saleDateForInvNo . $thisPosMaxNo;
                        $i = 0;
                        foreach ($_POST['Pos']['temp_item_id'] as $tempItemId):
                            $model = new Pos;
                            $model->initiated_by = $initiatedBy;
                            $model->machine_id = $machineId;
                            $model->authorized_by = Yii::app()->session['authorized_by'];
                            $model->max_inv_no = $thisPosMaxNo;
                            $model->inv_no = $thisPosNo;
                            $model->item_id = $tempItemId;
                            $itemInfo = Items::model()->findByPk($model->item_id);
                            $model->price = $_POST['Pos']['temp_price'][$i];
                            $model->qty = $_POST['Pos']['temp_qty'][$i];

                            if ($itemInfo->vatable == 1) {
                                $vatablePrice = $model->price + ($model->price * 0.04);
                            } else {
                                $vatablePrice = $model->price;
                            }

                            $model->vatable_price = $vatablePrice;
                            $model->store_id = $_POST['Pos']['store_id'];
                            $model->overall_discount = $_POST['Pos']['overall_discount'];
                            $model->discount_type = $_POST['Pos']['discount_type'];
                            $model->cash_payment = $_POST['Pos']['cash_payment'];
                            $model->visa_payment = $_POST['Pos']['visa_payment'];
                            $model->master_payment = $_POST['Pos']['master_payment'];
                            $model->amex_payment = $_POST['Pos']['amex_payment'];
                            $model->gift_card_payment = $_POST['Pos']['gift_card_payment'];
                            $model->cash_return = $_POST['Pos']['cash_return'];
                            $model->date = $todaySaleDate;
                            $model->time = new CDbExpression('NOW()');
                            $model->month = substr($model->date, 5, 2);
                            $model->year = substr($model->date, 0, 4);
                            $model->save();
                            $i++;
                        endforeach;
                        
                        $memberName="";
                        $memberAVPoint="";
                        $pointOfThisSale=$_POST['Pos']['member_point_add'];
                        
                        if(isset($_POST['Pos']['member_card_no']) && $_POST['Pos']['member_card_no']!=""){
                            $memberInfo=  Members::model()->findByAttributes(array("card_no"=>$_POST['Pos']['member_card_no']));
                            if($memberInfo){
                                $modelMemberPointAdd=new MemberPoints;
                                $modelMemberPointAdd->member_id=$memberInfo->id;
                                $modelMemberPointAdd->inv_no=$thisPosNo;
                                $modelMemberPointAdd->date=$todaySaleDate;
                                $modelMemberPointAdd->added_point=$_POST['Pos']['member_point_add'];
                                $modelMemberPointAdd->save();

                                $newlyAddedPoint=($memberInfo->available_point+$_POST['Pos']['member_point_add']);
                                Members::model()->updateByPk($memberInfo->id, array("available_point"=>$newlyAddedPoint));
                                
                                $memberName=$memberInfo->name;
                                $memberAVPoint=$newlyAddedPoint;
                            }
                        }
                        
                        if(isset($_POST['Pos']['member_card_no_for_reduce']) && $_POST['Pos']['member_card_no_for_reduce']!=""){
                            $memberInfo=  Members::model()->findByAttributes(array("card_no"=>$_POST['Pos']['member_card_no_for_reduce']));
                            if($memberInfo){
                                $modelMemberPointAdd=new MemberPoints;
                                $modelMemberPointAdd->member_id=$memberInfo->id;
                                $modelMemberPointAdd->inv_no=$thisPosNo;
                                $modelMemberPointAdd->date=$todaySaleDate;
                                $modelMemberPointAdd->used_point=$_POST['Pos']['member_point_reduce'];
                                $modelMemberPointAdd->save();

                                $newlyAddedPoint=($memberInfo->available_point-$_POST['Pos']['member_point_reduce']);
                                Members::model()->updateByPk($memberInfo->id, array("available_point"=>$newlyAddedPoint));
                                
                                $memberName=$memberInfo->name;
                                $memberAVPoint=$newlyAddedPoint;
                            }
                        }
                        
                        $changeDue = $_POST['Pos']['cash_return'];
                        $so = $thisPosNo;
                        $condition = 'inv_no="' . $so . '"';
                        $data = Pos::model()->findAll(array('condition' => $condition,), 'id');

                        echo CJSON::encode(array(
                            'status' => 'success',
                            'changeDue' => $changeDue,
                            'discountType'=>$model->discount_type,
                            //'newOrderNo' => $thisPosNoFormat . $thisNewPosNo,
                            'soReportInfo' => $this->renderPartial('soReport', array('data' => $data, 'memberName'=>$memberName, 'memberAVPoint'=>$memberAVPoint, 'pointOfThisSale'=>$pointOfThisSale), true, true),
                        ));
                        Yii::app()->end();
                    } else {
                        $error = CActiveForm::validate($model);
                        if ($error != '[]')
                            echo $error;
                        Yii::app()->end();
                    }
                }else {
                    echo CJSON::encode(array(
                        'status' => 'errorBalance',
                    ));
                    Yii::app()->end();
                }
            } else {
                $this->render('_form', array(
                    'model' => $model,
                    'modelMembers'=>$modelMembers,
                ));
            }
        //}
    }

    public function actionUpdateFromPos($inv_no) {
        $this->layout = "column1";
        $model = new Pos;
        $modelMembers = new Members;
        $this->performAjaxValidation($model);

        if (isset($_POST['Pos'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $model->attributes = $_POST['Pos'];
            $grandTotal = $_POST['Pos']['cashTotal'];
            if ($grandTotal > 0) {
                $valid = $model->validate();
                if ($valid) {
                    //Pos::model()->deleteAll(array("condition" => "inv_no='" . $inv_no . "'"));
                    
                    $data=Pos::model()->findAll(array("condition"=>"inv_no='".$inv_no."'"));
                    foreach($data as $d){
                        $modelInventory = new Inventory;
                        $modelInventory->store = $d->store_id;
                        $modelInventory->item = $d->item_id;
                        $modelInventory->stock_in = $d->qty;
                        $modelInventory->costing_price = 0;
                        $modelInventory->date = $d->date;
                        $modelInventory->save();

                        Pos::model()->deleteByPk($d->id);
                    }
                    
                    $i = 0;
                    $machineInfo = MachineNames::model()->findByAttributes(array('ip_address' => Yii::app()->request->getUserHostAddress()));
                    if ($machineInfo) {
                        $machineId = $machineInfo->id;
                    } else {
                        $machineId = "";
                    }
                    foreach ($_POST['Pos']['temp_item_id'] as $tempItemId):
                        $model = new Pos;
                        $model->item_id = $tempItemId;
                        $model->price = $_POST['Pos']['temp_price'][$i];
                        $model->qty = $_POST['Pos']['temp_qty'][$i];
                        $itemInfo = Items::model()->findByPk($model->item_id);
                        if ($itemInfo->vatable == 1) {
                            $vatablePrice = $model->price + ($model->price * 0.04);
                        } else {
                            $vatablePrice = $model->price;
                        }
                        $model->vatable_price = $vatablePrice;
                        $model->machine_id = $machineId;
                        $model->date = $_POST['Pos']['date'];
                        $model->time = $_POST['Pos']['time'];
                        $model->month = $_POST['Pos']['month'];
                        $model->year = $_POST['Pos']['year'];
                        $model->initiated_by = $_POST['Pos']['initiated_by'];
                        $model->authorized_by = $_POST['Pos']['authorized_by'];
                        $model->update_auth_by = $_POST['Pos']['update_auth_by'];
                        $model->update_by = Yii::app()->user->getId();
                        $model->update_time = new CDbExpression('NOW()');
                        $model->max_inv_no = $_POST['Pos']['max_inv_no'];
                        $model->inv_no = $_POST['Pos']['inv_no'];
                        $model->store_id = $_POST['Pos']['store_id'];
                        $model->overall_discount = $_POST['Pos']['overall_discount'];
                        $model->discount_type = $_POST['Pos']['discount_type'];
                        $model->cash_payment = $_POST['Pos']['cash_payment'];
                        $model->visa_payment = $_POST['Pos']['visa_payment'];
                        $model->master_payment = $_POST['Pos']['master_payment'];
                        $model->amex_payment = $_POST['Pos']['amex_payment'];
                        $model->gift_card_payment = $_POST['Pos']['gift_card_payment'];
                        $model->cash_return = $_POST['Pos']['cash_return'];
                        $model->save();
                        $i++;
                    endforeach;
                    
                    $memberName="";
                    $memberAVPoint="";
                    $pointOfThisSale=$_POST['Pos']['member_point_add'];

                    if(isset($_POST['Pos']['member_card_no']) && $_POST['Pos']['member_card_no']!=""){
                        $memberInfo=  Members::model()->findByAttributes(array("card_no"=>$_POST['Pos']['member_card_no']));
                        if($memberInfo){
                            
                            $isPreviousDataExist=MemberPoints::model()->findByAttributes(array('inv_no'=>$_POST['Pos']['inv_no'], 'member_id'=>$memberInfo->id));
                            if($isPreviousDataExist){
                                MemberPoints::model()->updateByPk($isPreviousDataExist->id, array('added_point'=>$_POST['Pos']['member_point_add']));
                                
                                $newlyAddedPoint=(($memberInfo->available_point-$isPreviousDataExist->added_point)+$_POST['Pos']['member_point_add']);
                                Members::model()->updateByPk($memberInfo->id, array("available_point"=>$newlyAddedPoint));
                            }else{
                                $modelMemberPointAdd=new MemberPoints;
                                $modelMemberPointAdd->member_id=$memberInfo->id;
                                $modelMemberPointAdd->inv_no=$_POST['Pos']['inv_no'];
                                $modelMemberPointAdd->date=$_POST['Pos']['date'];
                                $modelMemberPointAdd->added_point=$_POST['Pos']['member_point_add'];
                                $modelMemberPointAdd->save();
                                $newlyAddedPoint=($memberInfo->available_point+$_POST['Pos']['member_point_add']);
                                Members::model()->updateByPk($memberInfo->id, array("available_point"=>$newlyAddedPoint));
                            }

                            $memberName=$memberInfo->name;
                            $memberAVPoint=$newlyAddedPoint;
                        }
                    }

                    if(isset($_POST['Pos']['member_card_no_for_reduce']) && $_POST['Pos']['member_card_no_for_reduce']!=""){
                        $memberInfo=  Members::model()->findByAttributes(array("card_no"=>$_POST['Pos']['member_card_no_for_reduce']));
                        if($memberInfo){
                            $modelMemberPointAdd=new MemberPoints;
                            $modelMemberPointAdd->member_id=$memberInfo->id;
                            $modelMemberPointAdd->inv_no=$_POST['Pos']['inv_no'];
                            $modelMemberPointAdd->date=$_POST['Pos']['date'];
                            $modelMemberPointAdd->used_point=$_POST['Pos']['member_point_reduce'];
                            $modelMemberPointAdd->save();

                            $newlyAddedPoint=($memberInfo->available_point-$_POST['Pos']['member_point_reduce']);
                            Members::model()->updateByPk($memberInfo->id, array("available_point"=>$newlyAddedPoint));

                            $memberName=$memberInfo->name;
                            $memberAVPoint=$newlyAddedPoint;
                        }
                    }
                    
                    $changeDue = $_POST['Pos']['cash_return'];
                    $so = $_POST['Pos']['inv_no'];
                    $condition = 'inv_no="' . $so . '"';
                    $data = Pos::model()->findAll(array('condition' => $condition,), 'id');

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'changeDue' => $changeDue,
                        'discountType'=>$model->discount_type,
                        'soReportInfo' => $this->renderPartial('soReport', array('data' => $data, 'memberName'=>$memberName, 'memberAVPoint'=>$memberAVPoint, 'pointOfThisSale'=>$pointOfThisSale), true, true),
                    ));
                    Yii::app()->end();
                } else {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]')
                        echo $error;
                    Yii::app()->end();
                }
            }else {
                echo CJSON::encode(array(
                    'status' => 'errorBalance',
                ));
                Yii::app()->end();
            }
        } else {
            $this->render('_formUpdateFromPos', array(
                'model' => $model,
                'inv_no' => $inv_no,
                'modelMembers'=>$modelMembers,
            ));
        }
    }

    public function actionSoReportOfThis() {
        $so = $_POST['so'];
        if ($so) {
            $condition = 'inv_no="' . $so . '"';
            $data = Pos::model()->findAll(array('condition' => $condition,), 'id');
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('soReport', array('data' => $data, 'memberName'=>"", 'memberAVPoint'=>"", 'pointOfThisSale'=>""), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please select an invoice no!</div>';
        }
    }

    public function actionSoReportOfThisNonPosUser() {
        $so = $_POST['so'];
        if ($so) {
            $condition = 'inv_no="' . $so . '"';
            $data = Pos::model()->findAll(array('condition' => $condition,), 'id');
            //Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            echo $this->renderPartial('soReportNonPosUser', array('data' => $data, 'memberName'=>"", 'memberAVPoint'=>"", 'pointOfThisSale'=>""), true, true);
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please select an invoice no!</div>';
        }
    }

    public function actionAuthorizationCheckUpdate() {
        unset(Yii::app()->session['update_authorized_by']);
        $this->layout = "column1";
        $model = new Pos;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Pos'])) {
            $model->attributes = $_POST['Pos'];
            if ($model->pin_code) {
                $authorizationInfo = Users::model()->findByAttributes(array('pin_code' => md5($model->pin_code)));
                if ($authorizationInfo) {
                    Yii::app()->session['update_authorized_by'] = $authorizationInfo->id;
                    $this->redirect(array('voidUpdate'));
                } else {
                    Yii::app()->user->setFlash('error', "Authorization failed !");
                    $this->redirect(array('authorizationCheckUpdate'));
                }
            } else {
                Yii::app()->user->setFlash('error', "Authorization failed !");
                $this->redirect(array('authorizationCheckUpdate'));
            }
        }
        $this->render('authorizationCheck', array('model' => $model));
    }

    public function actionVoidUpdate() {
        $this->layout = "column1";
        $model = new Pos('searchVoid');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pos']))
            $model->attributes = $_GET['Pos'];

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionAuthorizationCheckVoid() {
        unset(Yii::app()->session['void_authorized_by']);
        $this->layout = "column1";
        $model = new Pos;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Pos'])) {
            $model->attributes = $_POST['Pos'];
            if ($model->pin_code) {
                $authorizationInfo = Users::model()->findByAttributes(array('pin_code' => md5($model->pin_code)));
                if ($authorizationInfo) {
                    Yii::app()->session['void_authorized_by'] = $authorizationInfo->id;
                    $this->redirect(array('void'));
                } else {
                    Yii::app()->user->setFlash('error', "Authorization failed !");
                    $this->redirect(array('authorizationCheckVoid'));
                }
            } else {
                Yii::app()->user->setFlash('error', "Authorization failed !");
                $this->redirect(array('authorizationCheckVoid'));
            }
        }
        $this->render('authorizationCheck', array('model' => $model));
    }

    public function actionVoid() {
        $this->layout = "column1";
        $model = new Pos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pos']))
            $model->attributes = $_GET['Pos'];

        $this->render('void', array(
            'model' => $model,
        ));
    }

    public function actionVoidPos($inv_no) {
        $voidAuthBy = Yii::app()->session['void_authorized_by'];
        $voidTime = new CDbExpression('NOW()');
        
        $data=Pos::model()->findAll(array("condition"=>"inv_no='".$inv_no."'"));
        foreach($data as $d){
            $modelInventory = new Inventory;
            $modelInventory->store = $d->store_id;
            $modelInventory->item = $d->item_id;
            $modelInventory->stock_in = $d->qty;
            $modelInventory->costing_price = 0;
            $modelInventory->date = $d->date;
            $modelInventory->save();
            
            Pos::model()->updateByPk($d->id, array('is_void' => Pos::YES, 'void_auth_by' => $voidAuthBy, 'void_time' => $voidTime));
        }
        $this->redirect(array('void'));
    }

    public function actionVoidPosUndo($inv_no) {
        //Pos::model()->updateAll(array('is_void' => '0'), "inv_no=:inv_no", array(":inv_no" => $inv_no));
        
        $data=Pos::model()->findAll(array("condition"=>"inv_no='".$inv_no."'"));
        foreach($data as $d){
            $modelInventory = new Inventory;
            $modelInventory->store = $d->store_id;
            $modelInventory->item = $d->item_id;
            $modelInventory->stock_out = $d->qty;
            $modelInventory->sell_price = $d->price;
            $modelInventory->date = $d->date;
            $modelInventory->save();
            
            Pos::model()->updateByPk($d->id, array('is_void' => 0));
        }
        
        $this->redirect(array('void'));
    }

    public function actionAuthorizationCheckReprint() {
        unset(Yii::app()->session['reprint_authorized_by']);
        $this->layout = "column1";
        $model = new Pos;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Pos'])) {
            $model->attributes = $_POST['Pos'];
            if ($model->pin_code) {
                $authorizationInfo = Users::model()->findByAttributes(array('pin_code' => md5($model->pin_code)));
                if ($authorizationInfo) {
                    Yii::app()->session['reprint_authorized_by'] = $authorizationInfo->id;
                    $this->redirect(array('reprint'));
                } else {
                    Yii::app()->user->setFlash('error', "Authorization failed !");
                    $this->redirect(array('authorizationCheckReprint'));
                }
            } else {
                Yii::app()->user->setFlash('error', "Authorization failed !");
                $this->redirect(array('authorizationCheckReprint'));
            }
        }
        $this->render('authorizationCheck', array('model' => $model));
    }

    public function actionReprint() {
        $this->layout = "column1";
        $this->render('reprint');
    }

    public function actionAuthorizationCheck() {
        unset(Yii::app()->session['authorized_by']);
        $this->layout = "column1";
        $model = new Pos;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Pos'])) {
            $model->attributes = $_POST['Pos'];
            if ($model->pin_code) {
                $authorizationInfo = Users::model()->findByAttributes(array('pin_code' => md5($model->pin_code)));
                if ($authorizationInfo) {
                    Yii::app()->session['authorized_by'] = $authorizationInfo->id;
                    $this->redirect(array('create'));
                } else {
                    Yii::app()->user->setFlash('error', "Authorization failed !");
                    $this->redirect(array('authorizationCheck'));
                }
            } else {
                Yii::app()->user->setFlash('error', "Authorization failed !");
                $this->redirect(array('authorizationCheck'));
            }
        }
        $this->render('authorizationCheck', array('model' => $model));
    }
    
    public function actionTempDelete($inv_no) {
        Pos::model()->updateAll(array("is_recycled"=>1), array("condition"=>"inv_no='".$inv_no."'"));
        $this->redirect(array('admin'));
    }
    
    public function actionTempDeleteUndo($inv_no) {
        Pos::model()->updateAll(array("is_recycled"=>0), array("condition"=>"inv_no='".$inv_no."'"));
        $this->redirect(array('adminRecycled'));
    }
    
    public function actionDeletePermanently($inv_no) {
        $data=Pos::model()->findAll(array("condition"=>"inv_no='".$inv_no."'"));
        if($data){
            foreach($data as $d){
                $modelInventory = new Inventory;
                $modelInventory->store = $d->store_id;
                $modelInventory->item = $d->item_id;
                $modelInventory->stock_in = $d->qty;
                $modelInventory->costing_price = 0;
                $modelInventory->date = $d->date;
                $modelInventory->save();
            }
            Pos::model()->deleteAll(array("condition"=>"inv_no='".$inv_no."'"));
        }
        $this->redirect(array('adminRecycled'));
    }

    public function actionAdminRecycled() {
        $model = new Pos('searchRecycled');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pos']))
            $model->attributes = $_GET['Pos'];

        $this->render('adminRecycled', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Pos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pos']))
            $model->attributes = $_GET['Pos'];

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
        $model = Pos::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
