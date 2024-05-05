<ul id="nav" class="dropdown dropdown-linear dropdown-columnar">
    <li><?php echo CHtml::link('Dashboard', array('/site/dashboard')); ?></li>
    <li class="dir">Configure
        <ul>
            <li class="dir"><span class="titleM">Item Related</span>
                <ul>
                    <li><span id="departments"></span><?php echo CHtml::link('Grades', array('/grades/admin')); ?></li>
                    <li><span id="departments"></span><?php echo CHtml::link('Units(Weight)', array('/units/admin')); ?></li>
                    <li><span id="departments"></span><?php echo CHtml::link('Units(Distance)', array('/unitDistance/admin')); ?></li>
                    <li><span id="brand"></span><?php echo CHtml::link('Brands', array('/pBrand/admin')); ?></li>
                    <li><span id="model"></span><?php echo CHtml::link('Models', array('/pModel/admin')); ?></li>
                    <li><span id="country"></span><?php echo CHtml::link('Countries', array('/countries/admin')); ?></li>
                    <li><span id="cats"></span><?php echo CHtml::link('Categories', array('/cats/admin')); ?></li>
                    <li><span id="cats"></span><?php echo CHtml::link('Sub-Categories', array('/catsSub/admin')); ?></li>
                    <li><span id="items"></span><?php echo CHtml::link('Items', array('/items/admin')); ?></li>
                    <li><span id="barcode"></span><?php echo CHtml::link('Items Barcode', array('/items/barCodeGen')); ?></li>
                    <li><span id="price"></span><?php echo CHtml::link('Add Costing Price', array('/items/adminAddCostingPrice')); ?></li>
                    <li><span id="price"></span><?php echo CHtml::link('Add Selling Price', array('/items/adminAddSellingPrice')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Company Related</span>
                <ul>
                    <li><span id="yourCompany"></span><?php echo CHtml::link('Your Company', array('/yourCompany/admin')); ?></li>
                    <li><span id="designations"></span><?php echo CHtml::link('Designations', array('/designations/admin')); ?></li>
                    <li><span id="departments"></span><?php echo CHtml::link('Departments', array('/departments/admin')); ?></li>
                    <li><span id="employee"></span><?php echo CHtml::link('Employees', array('/employees/admin')); ?></li>
                    <li><span id="contacts"></span><?php echo CHtml::link('Manufacturers [MFI]', array('/mfis/admin')); ?></li>
                    <li><span id="supplier"></span><?php echo CHtml::link('Suppliers', array('/suppliers/admin')); ?></li>
                    <li><span id="contacts"></span><?php echo CHtml::link('Customers', array('/customers/admin')); ?></li>
                    <li><span id="users"></span><?php echo CHtml::link('Members', array('/members/admin')); ?></li>
                    <li><span id="users"></span><?php echo CHtml::link('Points Conf.', array('/memberPointsConf/admin')); ?></li>
                    <li><span id="banks"></span><?php echo CHtml::link('Banks', array('/banks/admin')); ?></li>
                    <li><span id="stores"></span><?php echo CHtml::link('Stores', array('/stores/admin')); ?></li>
                    <li><span id="machines"></span><?php echo CHtml::link('Counters [POS]', array('/machineNames/admin')); ?></li>
                    <li><span id="departments"></span><?php echo CHtml::link('Machines [Production]', array('/machines/admin')); ?></li>
                </ul>
            </li> 
            <li class="dir"><span class="titleM">User Related</span>
                <ul>
                    <li><span id="users"></span><?php echo CHtml::link('Assign Stores', array('/users/adminAssignStore')); ?></li>
                    <li><span id="users"></span><?php echo CHtml::link('Manage Users', array('/users/admin')); ?></li>
                    <li><span id="permission_mngmnt"></span><?php echo CHtml::link('Manage Permissions', array('/rights')); ?></li>
                </ul>
            </li> 
        </ul>
    </li>
    <li class="dir">Purchase
        <ul>
            <li class="dir"><span class="titleM">Requisition</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/purchaseRequisition/create')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create  <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 15px;">[Based On Items Warning Qty]</font>', array('/purchaseRequisition/reqFromItemsWarningQty')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create  <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 15px;">[Based On Store Req]</font>', array('/purchaseRequisition/adminPRFromSR')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create  <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 15px;">[Based On Sale Order]</font>', array('/purchaseRequisition/reqFromSO')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/purchaseRequisition/admin')); ?></li>
                    <?php 
                     if(Yii::app()->session['role']=='superadmin')
                     {
                         ?>
                    <li><span id="order_form"></span><?php echo CHtml::link('Approve', array('/purchaseRequisition/adminApprove')); ?></li>
                    <?php
                     }
                    
                    ?>
                    
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Procurement</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/purchaseRequisition/adminPP')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/purchaseProcurement/admin')); ?></li>
                </ul>
            </li> 
            <li class="dir"><span class="titleM">PO</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create (From Procurement)', array('/purchaseOrder/adminPO')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/purchaseOrder/admin')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Master LC', array('/masterLc/admin')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Import Document', array('/importDocument/admin')); ?></li> 
                    <?php 
                     if(Yii::app()->session['role']=='superadmin')
                     {
                         ?>;;;;;;;
                    <li><span id="order_form"></span><?php echo CHtml::link('Approve', array('/purchaseOrder/adminApprove')); ?></li>
                    <?php
                     }
                    
                    ?>
                </ul>
            </li> 
            <li class="dir"><span class="titleM">Receive, Return</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Receive', array('/purchaseRcvRtn/adminReceive')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Return / Manage', array('/purchaseRcvRtn/admin')); ?></li>
                </ul>
            </li> 
            <li class="dir"><span class="titleM">Payment Receipt</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/suppliers/adminMoneyReceipt')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/supplierMr/admin')); ?></li>
                </ul>
            </li>
        </ul>
    </li>
     <li class="dir">Store Requisition
        <ul>
            <li class="dir"><span class="titleM">Requisition</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/storeRequisition/create')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/storeRequisition/admin')); ?></li>
                     <li><span id="order_form"></span><?php echo CHtml::link('Basick Sheet Requisition Create', array('/basickSheetRequisition/create')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Basick Sheet Requisition Manage', array('/basickSheetRequisition/admin')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Deliver, Approve, Return</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Send Stock', array('/storeReqDR/adminDelivery')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Approve', array('/storeReqDR/adminApprove')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Return Stock', array('/storeReqDR/adminReturn')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/storeReqDR/admin')); ?></li>
                    
                    <li><span id="order_form"></span><?php echo CHtml::link('Basic Sheet Send Stock', array('/basickSheetReqDR/adminDelivery')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Basic Sheet Approve', array('/basickSheetReqDR/adminApprove')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Basic Sheet Return Stock', array('/basickSheetReqDR/adminReturn')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Basic Sheet Manage', array('/basickSheetReqDR/admin')); ?></li>
                </ul>
            </li>  
        </ul>
    </li>
    <li class="dir">Production
        <ul>
            <li class="dir"><span class="titleM">Input</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Input', array('/productionInput/create')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Return', array('/productionInput/adminReturn')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/productionInput/admin')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Input', array('/doubliMachinProductionInput/adminPO')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Return', array('/doubliMachinProductionInput/adminReturn')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Manage', array('/doubliMachinProductionInput/admin')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Output</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Wastage', array('/productionInput/adminWastage')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/productionWastage/admin')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Output', array('/productionInput/adminOutput')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/productionOutput/admin')); ?></li>
                    
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Wastage', array('/doubliMachinProductionInput/adminWastage')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Manage', array('/doubliMachinProductionWastage/admin')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Output', array('/doubliMachinProductionInput/adminOutput')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Doubli Machin Production Manage', array('/doubliMachinProductionOutput/admin')); ?></li>
                </ul>
            </li>  
        </ul>
    </li>
    <li class="dir">Sale
        <ul>
            <li class="dir"><span class="titleM">Order</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/saleOrder/create')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/saleOrder/admin')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Deliver, Return</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Delivery', array('/sellDelvRtn/adminDelivery')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Return / Manage', array('/sellDelvRtn/admin')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Bill</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/customerBill/billCreate')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/customerBill/admin')); ?></li>
                </ul>
            </li>
            <li class="dir"><span class="titleM">Money Receipt</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/customers/adminMoneyReceipt')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/customerMr/admin')); ?></li>
                </ul>
            </li>
            <li class="dir"><span class="titleM">Credit Memo</span>
                <ul>
                    <li><span id="order_form"></span><?php echo CHtml::link('Create', array('/customerBill/adminCreditMemo')); ?></li>
                    <li><span id="order_form"></span><?php echo CHtml::link('Manage', array('/creditMemo/admin')); ?></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="dir">POS
        <ul>
            <li class="dir"><span class="titleM">POS</span>
                <ul>
                    <li><span id="pos"></span><?php echo CHtml::link('Create', array('/pos/create')); ?></li>   
                    <li><span id="order_form"></span><?php echo CHtml::link('Transactions', array('/pos/admin')); ?></li>   
                    <li><span id="order_form"></span><?php echo CHtml::link('Recycle Bin', array('/pos/adminRecycled')); ?></li>
                </ul>
            </li> 
        </ul>
    </li>
    <li class="dir">Inventory
        <ul>
            <li class="dir"><span class="titleM">Manage</span>
              <ul>
                      <!--<li><span id="inventory"></span><?php // echo CHtml::link('Inventory <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 35px;">[and manual stock entry]</font>', array('/storeInventory/admin')); ?></li>-->
                    <!--<li><span id="inventory"></span><?php //echo CHtml::link('Temporary <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 35px;">[and manual stock entry]</font>', array('/storeInventory/admin')); ?></li>-->
                    <li><span id="inventory"></span><?php echo CHtml::link('Main Inventory <br><font style="color: red; font-size: 10px; font-weight: bold; margin-left: 35px;"></font>', array('/inventory/admin')); ?></li>
                </ul>
            </li>  
            <li class="dir"><span class="titleM">Stock Transfer</span>
                <ul>
                    <li><span id="inventory"></span><?php echo CHtml::link('From Temp To Main', array('/storeInventory/sendFromTempToMainInv')); ?></li>
                    <li><span id="inventory"></span><?php echo CHtml::link('History', array('/storckTranferHistoryFromTempToMain/admin')); ?></li>
                    <li><span id="inventory"></span><?php echo CHtml::link('Send Between Main', array('/inventory/transferStock')); ?></li>
                    <li><span id="inventory"></span><?php echo CHtml::link('Receive Between Main', array('/stockTransferHistory/adminForReceive')); ?></li>
                    <li><span id="inventory"></span><?php echo CHtml::link('History', array('/stockTransferHistory/admin')); ?></li>
                </ul>
            </li>  
        </ul>
    </li>
    <li class="dir">Reports
        <ul>
            <li class="dir"><span class="titleM">Purchase, Sales, Stock</span>
                <ul>
                    <li><span id="reports"></span><?php echo CHtml::link('Purchase', array('/purchaseRequisition/purchaseReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Sales', array('/saleOrder/salesReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Store Requisition', array('/storeRequisition/storeReqReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Stock [Temporary]', array('/storeInventory/stockReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Stock [Main]', array('/inventory/stockReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Consumption', array('/productionInput/consumptionReport')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Production & Wastage', array('/productionOutput/productionReport')); ?></li>
                </ul>
            </li> 
            <li class="dir"><span class="titleM">POS</span>
                <ul>
                    <li><span id="reports"></span><?php echo CHtml::link('POS', array('/pos/posReport')); ?></li>
                </ul>
            </li>
            <li class="dir"><span class="titleM">Party Ledger</span>
                <ul>
                    <li><span id="reports"></span><?php echo CHtml::link('All Supplier', array('/suppliers/supplierLedgerAll')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('All Customer', array('/customers/customerLedgerAll')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Specific Supplier', array('/suppliers/supplierLedgerSpecific')); ?></li>
                    <li><span id="reports"></span><?php echo CHtml::link('Specific Customer', array('/customers/customerLedgerSpecific')); ?></li>
                </ul>
            </li>  
        </ul>
    </li>
    <li><?php echo CHtml::link('Logout ( ' . Users::model()->fullNameOfThis(Yii::app()->user->id) . ' )', array('/site/logout')); ?></li>
</ul>