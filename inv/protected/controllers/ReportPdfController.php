<?php

class ReportPdfController extends Controller {

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
    
    public function actionPosReportPdf($startDate, $endDate, $store, $category, $supplier_id, $item, $isVoid, $machineId, $initiatedBy) {
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
            
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('posReportPdf', array(
                        'message' => $message, 'data' => $data, 'data2' => $data2), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }
    
    public function actionSupplierLedgerSpecificPdf($startDate, $endDate, $id) {
        if ($startDate != "" && $endDate != "" && $id != "") {
            $supplierInfo = Suppliers::model()->supplierNameAndAddress($id);
            $message = "Specific Supplier Ledger From " . $startDate . " to " . $endDate . "<br>" . $supplierInfo;

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('supplierLedgerSpecificPdf', array(
                        'message' => $message, 'startDate' => $startDate, 'endDate' => $endDate, 'id' => $id), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range and supplier !</div>");
        }
    }

    public function actionSupplierLedgerAllPdf($startDate, $endDate) {
        if ($startDate != "" && $endDate != "") {
            $message = "All Supplier Ledger From " . $startDate . " to " . $endDate;
            $criteria = new CDbCriteria();
            $criteria->order = "company_name ASC";
            $data = Suppliers::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('supplierLedgerAllPdf', array(
                        'data' => $data,
                        'message' => $message, 'startDate' => $startDate, 'endDate' => $endDate), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionCustomerLedgerSpecificPdf($startDate, $endDate, $id) {
        if ($startDate != "" && $endDate != "" && $id != "") {
            $customerInfo = Customers::model()->customerNameAndAddress($id);
            $message = "Specific Customer Ledger From " . $startDate . " to " . $endDate . "<br>" . $customerInfo;

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('customerLedgerSpecificPdf', array(
                        'message' => $message, 'startDate' => $startDate, 'endDate' => $endDate, 'id' => $id), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range and customer !</div>");
        }
    }

    public function actionCustomerLedgerAllPdf($startDate, $endDate) {
        if ($startDate != "" && $endDate != "") {
            $message = "All Customer Ledger From " . $startDate . " to " . $endDate;
            $criteria = new CDbCriteria();
            $criteria->order = "company_name ASC";
            $data = Customers::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('customerLedgerAllPdf', array(
                        'data' => $data,
                        'message' => $message, 'startDate' => $startDate, 'endDate' => $endDate), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionSalesReportPdf($startDate, $endDate, $store, $category, $item, $customer_id, $sales_by, $order_type2, $supplier_id) {
        if ($startDate != "" && $endDate != "") {
            $message = "Sales Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = "sl_no, issue_date, expected_d_date, order_type2, pi_no, pi_date, store, customer_id, contact_person, sales_by";
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
            $criteria->group = "sl_no";
            $data = SaleOrder::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('salesReportPdf', array(
                        'data' => $data,
                        'message' => $message, 'category' => $category, 'item' => $item, 'supplier_id'=>$supplier_id,), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionProductionReportPdf($startDate, $endDate, $store, $machine, $category, $item) {
        if ($startDate != "" && $endDate != "") {
            $message = "Production Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'machine, date, time, sl_no, sum(qty_kg) as sumOfQtyKg, sum(return_qty_kg) as sumOfRtnQtyKg';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');

            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store" => $store), "AND", "AND");
            }
            if ($machine != "") {
                $message.=", Machine: " . Machines::model()->nameOfThis($machine);
                $criteria->addColumnCondition(array("machine" => $machine), "AND", "AND");
            }
            if ($category != "") {
                $message.=", Category: " . Cats::model()->nameOfThis($category);
            }
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
            }

            $criteria->group = "sl_no";
            $data = ProductionInput::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('productionReportPdf', array(
                        'data' => $data,
                        'message' => $message, 'category' => $category, 'item' => $item), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionConsumptionReportPdf($startDate, $endDate, $store, $machine, $category, $item) {
        if ($startDate != "" && $endDate != "") {
            $message = "Consumption Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(qty) as sumOfQty, sum(qty_kg) as sumOfQtyKg, sum(return_qty) as sumOfRtnQty, sum(return_qty_kg) as sumOfRtnQtyKg, item';
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');

            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store" => $store), "AND", "AND");
            }
            if ($machine != "") {
                $message.=", Machine: " . Machines::model()->nameOfThis($machine);
                $criteria->addColumnCondition(array("machine" => $machine), "AND", "AND");
            }
            if ($category != "") {
                $itemsData = Items::model()->findAll(array("condition" => "cat=" . $category));
                $itemsArray = array();
                if ($itemsData) {
                    foreach ($itemsData as $itmsd) {
                        $itemsArray[] = $itmsd->id;
                    }
                }
                $message.=", Category: " . Cats::model()->nameOfThis($category);
                $criteria->addInCondition("item", $itemsArray, "AND");
            }
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
            }

            $criteria->group = "item";
            $data = ProductionInput::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('consumptionReportPdf', array(
                        'data' => $data,
                        'message' => $message,), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionPurchaseReportPdf($startDate, $endDate, $store, $category, $item, $supplier_id) {
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

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('purchaseReportPdf', array(
                        'data' => $data,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'store' => $store,
                        'message' => $message,), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionStoreReqReportPdf($startDate, $endDate, $store, $department, $category, $item, $reqBy) {
        if ($startDate != "" && $endDate != "") {
            $message = "Store Requisition From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('req_date', $startDate, $endDate, 'AND');

            if ($reqBy != "") {
                $message.=", Requisition By: " . Employees::model()->fullName($reqBy);
                $criteria->addColumnCondition(array("req_by" => $reqBy), "AND", "AND");
            }
            if ($department != "") {
                $message.=", Department: " . Departments::model()->nameOfThis($department);
                $criteria->addColumnCondition(array("department" => $department), "AND", "AND");
            }
            if ($store != "") {
                $message.=", Store: " . Stores::model()->storeName($store);
                $criteria->addColumnCondition(array("store" => $store), "AND", "AND");
            }
            if ($category != "") {
                $itemsData = Items::model()->findAll(array("condition" => "cat=" . $category));
                $itemsArray = array();
                if ($itemsData) {
                    foreach ($itemsData as $itmsd) {
                        $itemsArray[] = $itmsd->id;
                    }
                }
                $message.=", Category: " . Cats::model()->nameOfThis($category);
                $criteria->addInCondition("item", $itemsArray, "AND");
            }
            if ($item != "") {
                $message.=", Item: " . Items::model()->nameOfThisOnly($item);
                $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
            }

            $data = StoreRequisition::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('storeReqReportPdf', array(
                        'data' => $data,
                        'message' => $message,), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionStockReportPdf($startDate, $endDate, $store, $category, $item, $supplier_id) {

        if ($startDate != "" && $endDate != "") {
            $message = "Stock (Main Inventory) Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut, item';
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
            $data = Inventory::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('stockReportPdf', array(
                        'data' => $data,
                        'message' => $message,
                        'startDate' => $startDate,
                        'store' => $store), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

    public function actionStockReportStorePdf($startDate, $endDate, $store, $category, $item, $supplier_id) {

        if ($startDate != "" && $endDate != "") {
            $message = "Stock (Temporary Inventory) Report From " . $startDate . " to " . $endDate;

            $criteria = new CDbCriteria();
            $criteria->select = 'sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut, item';
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
            $data = StoreInventory::model()->findAll($criteria);

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($this->renderPartial('stockReportStorePdf', array(
                        'data' => $data,
                        'message' => $message,
                        'startDate' => $startDate,
                        'store' => $store), true));
            $content_PDF = $html2pdf->Output($message . '.pdf', 'D');
        } else {
            die("<div class='flash-error'>Please select date range!</div>");
        }
    }

}