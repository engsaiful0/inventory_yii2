<?php

class ItemsController extends Controller {

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
    
    public function actionBarCodeGen(){
        $this->render('_barCodeGen', array(
            'itemsModel' => new Items,
        ));
    }

    public function actionItemsOfThis() {
        $supplier_id = $_POST['supplier_id'];
        $pbrand = $_POST['pbrand'];
        $pmodel = $_POST['pmodel'];
        $country = $_POST['country'];
        $grade = $_POST['grade'];
        $mfi = $_POST['mfi'];
        $product_type = $_POST['product_type'];
        $formName = $_POST['formName'];
        
        if ($supplier_id == "" && $pbrand == "" && $pmodel == "" && $country == "" && $grade == "" && $mfi == "" && $product_type == "") {
            $cats = Cats::model()->findAll(array('order' => 'name ASC'));
        } else {
            $condition = "id!=0";
            if ($supplier_id != "")
                $condition.=" AND supplier_id=" . $supplier_id;
            if ($pbrand != "")
                $condition.=" AND pbrand=" . $pbrand;
            if ($pmodel != "")
                $condition.=" AND pmodel=" . $pmodel;
            if ($country != "")
                $condition.=" AND country=" . $country;
            if ($grade != "")
                $condition.=" AND grade=" . $grade;
            if ($mfi != "")
                $condition.=" AND mfi=" . $mfi;
            if ($product_type != "")
                $condition.=" AND product_type=" . $product_type;
            $condition.=" GROUP BY cat";
            $items = Items::model()->findAll(array("condition" => $condition));
            $catIds = array();
            if ($items) {
                foreach ($items as $item):
                    $catIds[] = $item->cat;
                endforeach;
                $criteria = new CDbCriteria();
                $criteria->addInCondition("id", $catIds);
                $criteria->order = "name ASC";
                $cats = Cats::model()->findAll($criteria);
            }else {
                $cats = "";
                echo CJSON::encode(array(
                'content' => "<div class='flash-error'>No items found for these searching criteria !</div>",
                )); 
                exit;
            }
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        if($formName=="PurchaseRequisition"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisPurchaseReq', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="PurchaseProcurement"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisPurchaseProcurement', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="Inventory"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisInventory', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="StoreInventory"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisStoreInventory', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="StoreRequisition"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisStoreReq', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="QuatationAnalysis"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisQuatationAnalysis', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="ProductionInput"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisProductionInput', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="ProductionOutput"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisProductionOutput', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="SaleOrder"){
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisSaleOrder', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    ), true, true),
            ));
        }else if($formName=="UnitConvert"){
            $unitConvertFrom = $_POST['unitConvertFrom'];
            echo CJSON::encode(array(
                'content' => $this->renderPartial('_itemsOfThisUnitConvert', array(
                    'cats' => $cats,
                    'supplier_id' => $supplier_id,
                    'pbrand'=>$pbrand,
                    'pmodel'=>$pmodel,
                    'country'=>$country,
                    'grade'=>$grade,
                    'mfi'=>$mfi,
                    'product_type'=>$product_type,
                    'unitConvertFrom'=>$unitConvertFrom,
                    ), true, true),
            ));
        }else{
           echo CJSON::encode(array(
                'content' => "<div class='flash-error'>Error on line:81</div>",
            )); 
        }
        
        exit;
    }

    public function actionItemsOfThisCat() {
        $catId = $_POST['catId'];
        $list = '';

        if ($catId != '') {
            $condition = 'cat = ' . $catId . ' ORDER BY name ASC';
            $data = Items::model()->findAll(array("condition" => $condition,), "id");

            if ($data) {
                $list = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $list .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->nameWithDesc), true);
                }
            } else {
                $list = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
            $data = Items::model()->findAll();
            if ($data) {
                $list = CHtml::tag('option', array('value' => ""), "Select", true);
                foreach ($data as $d) {
                    $list .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->nameWithDesc), true);
                }
            } else {
                $list = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        }
        echo CJSON::encode(array(
            'items' => $list,
        ));
    }
    
    public function actionItemsOfThisSupplier(){
        $catId = $_POST['catId'];
        $supplierId = $_POST['supplierId'];
        $list = '';

        if ($supplierId != '') {
            $condition = 'supplier_id = ' . $supplierId;
            if($catId!="")
                $condition.= ' AND cat = ' . $catId;
            $condition.= ' ORDER BY name ASC';
            $data = Items::model()->findAll(array("condition" => $condition,), "id");

            if ($data) {
                $list = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $list .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->nameWithDesc), true);
                }
            } else {
                $list = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
            $data = Items::model()->findAll();
            if ($data) {
                $list = CHtml::tag('option', array('value' => ""), "Select", true);
                foreach ($data as $d) {
                    $list .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->nameWithDesc), true);
                }
            } else {
                $list = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        }
        echo CJSON::encode(array(
            'items' => $list,
        ));
    }
    
    public function actionCreateItemFromOutSide() {
        $model = new Items;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Items'])) {
            $model->attributes = $_POST['Items'];
            $model->setScenario('updateScenario');
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $cats = Cats::model()->findAll(array('order' => 'name ASC'));
                    $supplier_id="";
                    $pbrand = "";
                    $pmodel = "";
                    $country = "";
                    $grade = "";
                    $mfi = "";
                    $product_type = "";
                    $reqFrom="";
                    if(isset($_POST['reqFrom'])){
                        $reqFrom=$_POST['reqFrom'];
                    }
                    if($reqFrom=="saleOrder"){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisSaleOrder', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                                ), true, true),
                        ));
                    }else if($reqFrom=="productionOutput"){
                        $data = Items::model()->findByPk($model->id);
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisProductionOutput', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                            ), true, true),
                            'value' => $data->id,
                            'label' => $data->name." (".$data->unit.")",
                        ));
                    }else if($reqFrom=="purchaseReq"){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisPurchaseReq', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                            ), true, true),
                        ));
                    }else if($reqFrom=="inventory"){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisInventory', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                            ), true, true),
                        ));
                    }else if($reqFrom=="storeInventory"){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisStoreInventory', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                            ), true, true),
                        ));
                    }else if($reqFrom=="purchaseProcurement"){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => $this->renderPartial('_itemsOfThisPurchaseProcurement', array(
                                'cats' => $cats,
                                'supplier_id' => $supplier_id,
                                'pbrand'=>$pbrand,
                                'pmodel'=>$pmodel,
                                'country'=>$country,
                                'grade'=>$grade,
                                'mfi'=>$mfi,
                                'product_type'=>$product_type,
                            ), true, true),
                        ));
                    }else{
                        
                    }
                    
                    exit;
                }
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        }
    }

    public function actionCreate() {
        $model = new Items;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Items'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $valid = $model->validate();
            if ($valid) {
                $i = 0;
                foreach ($_POST['Items']['cat'] as $tempCat):
                    $model = new Items;
                    $model->cat = $tempCat;
                    $model->store = $_POST['Items']['store'][$i];
                    $model->cat_sub = $_POST['Items']['cat_sub'][$i];
                    $model->code = $_POST['Items']['code'][$i];
                    $model->name = $_POST['Items']['name'][$i];
                    $model->desc = $_POST['Items']['desc'][$i];
                    $model->unit = $_POST['Items']['unit'][$i];
                    $model->pbrand = $_POST['Items']['pbrand'][$i];
                    $model->pmodel = $_POST['Items']['pmodel'][$i];
                    $model->country = $_POST['Items']['country'][$i];
                    $model->grade = $_POST['Items']['grade'][$i];
                    $model->mfi = $_POST['Items']['mfi'][$i];
                    $model->product_type = $_POST['Items']['product_type'][$i];
                    $model->supplier_id = $_POST['Items']['supplier_id'][$i];
                    $model->warn_qty = $_POST['Items']['warn_qty'][$i];
                    if (isset($_POST['Items']['is_rawmat'][$i]))
                        $model->is_rawmat = 1;
                    if (isset($_POST['Items']['unit_convertable'][$i]))
                        $model->unit_convertable = 1;
                    if (isset($_POST['Items']['vatable'][$i]))
                        $model->vatable = 1;
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

        if (isset($_POST['Items'])) {
            $model->attributes = $_POST['Items'];
            $model->setScenario('updateScenario');
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
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->deleteByPk($_id);
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to delete.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionSetUnitConvertable() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('unit_convertable'=>1));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to set unit convertable.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionUndoUnitConvertable() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('unit_convertable'=>0));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to undo.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionSetVatable() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('vatable'=>1));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to set VATable.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionUndoVatable() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('vatable'=>0));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to undo.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionSetAsRawMat() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('is_rawmat'=>1));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to set as Raw Material.');
            $this->redirect(array('admin'));
        }
    }
    
    public function actionUndoAsRawMat() {
        if (isset($_POST['items-grid_c0'])) {
            $del_item = $_POST['items-grid_c0'];
            $model_item = new Items;
            foreach ($del_item as $_id) {
                $model_item->updateByPk($_id, array('is_rawmat'=>0));
            }
            $this->redirect(array('admin'));
        } else {
            Yii::app()->user->setFlash('error', 'Please select at least one record to undo.');
            $this->redirect(array('admin'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Items('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Items']))
            $model->attributes = $_GET['Items'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminAddCostingPrice() {
        $model = new Items('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Items']))
            $model->attributes = $_GET['Items'];

        $this->render('adminAddCostingPrice', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminAddSellingPrice() {
        $model = new Items('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Items']))
            $model->attributes = $_GET['Items'];

        $this->render('adminAddSellingPrice', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Items::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'items-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
