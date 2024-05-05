<?php
echo "<div class='printBtn' style='width: unset;'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
        '.summary',
        '.search-form',
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div'         //id of the print link
));
echo "</div>";
?>
<?php
    echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/purchaseReportExcel',
        'startDate'=>$startDate,
        'endDate'=>$endDate,
        'store'=>$store,
        'category'=>$category,
        'item'=>$item,), array('title' => 'Export as xls'));
    ?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/purchaseReportPdf',
    'startDate'=>$startDate,
    'endDate'=>$endDate,
    'store'=>$store,
    'category'=>$category,
    'item'=>$item,
    'supplier_id'=>$supplier_id,), array('title' => 'Save as PDF'));
?>
<div class='printAllTableForThisReport'>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" type="text/css" />
    <div class="grid-view">
        <table class="headerTab">
            <tr>
                <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px;"><?php echo $message; ?></th>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Req. Qty</th>
                    <th>Proc. Qty</th>
                    <th>Order Qty</th>
                    <th>Rcv. Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data) { ?>
                    <?php
                    $itemArr = array();
                    $sumQtyArr= array();
                    $sumProcQtyArr= array();
                    $sumOrderQtyArr= array();
                    $sumRcvQtyArr= array();
                    
                    $arrPos = 0;

                    $sumQtyTotal = 0;
                    $procQtyTotal = 0;
                    $orderQtyTotal = 0;
                    $rcvQtyTotal = 0;

                    foreach ($data as $d):

                        $sumQty = $d->sumQty;
                        $itemId = $d->item;
                    
                        $sumQtyTotal = $sumQty + $sumQtyTotal;
                        
                        $criteria=new CDbCriteria();
                        $criteria->addBetweenCondition("date", $startDate, $endDate);
                        if($store!="")
                            $criteria->addColumnCondition(array("store"=>$store, "item"=>$itemId), "AND", "AND");
                        else
                            $criteria->addColumnCondition(array("item"=>$itemId), "AND", "AND");
                        $procdata=  PurchaseProcurement::model()->findAll($criteria);
                        
                        $procQty=0;
                        $orderQty=0;
                        $rcvQty=0;
                        
                        if($procdata){
                            foreach($procdata as $prcd){
                                $procQty=$prcd->qty+$procQty;
                                $poData=PurchaseOrder::model()->findAll(array("condition"=>"procurement_id=".$prcd->id));
                                if($poData){
                                    foreach($poData as $pod){
                                        $orderQty=$pod->order_qty+$orderQty;
                                        $rcvQty=PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($pod->id)+$rcvQty;
                                    }
                                }
                            }
                        }
                        
                        $procQtyTotal = $procQty + $procQtyTotal;
                        $orderQtyTotal = $orderQty + $orderQtyTotal;
                        $rcvQtyTotal = $rcvQty + $rcvQtyTotal;
                        
                        $itemArr[$arrPos] = $itemId;
                        $sumQtyArr[$arrPos] = $sumQty;
                        $sumProcQtyArr[$arrPos] = $procQty;
                        $sumOrderQtyArr[$arrPos] = $orderQty;
                        $sumRcvQtyArr[$arrPos] = $rcvQty;
                        $arrPos++;
                    endforeach;
                    ?>
                    <?php
                    $categories = Cats::model()->findAll();
                    if ($categories) {
                        foreach ($categories as $category) {
                            $criteriaItms = new CDbCriteria();
                            $criteriaItms->addColumnCondition(array("cat" => $category->id), "AND", "AND");
                            $criteriaItms->addInCondition("id", $itemArr);
                            $items = Items::model()->findAll($criteriaItms);
                            if ($items) {
                                ?>
                                <tr>
                                    <td colspan="11" style="color: blue; font-weight: bold; text-align: center;">
                                        <?php echo $category->name; ?>
                                    </td>
                                </tr>
                                <?php
                                $sumQtySubTotal = 0;
                                $sumProcQtySubTotal=0;
                                $sumOrderQtySubTotal=0;
                                $sumRcvQtySubTotal=0;
                                $sl = 1;
                                foreach ($items as $item) {
                                    if (in_array($item->id, $itemArr)) {
                                        $indexOfArr = array_search($item->id, $itemArr);
                                        ?>
                                 <?php
                                $itemInfo = Items::model()->findByPk($itemArr[$indexOfArr]);
                                if ($itemInfo) {
                                    $itemName = $itemInfo->name;
                                    $itemUnit = $itemInfo->unit;
                                    $itemDesc = $itemInfo->desc;
                                    $itemCode=$itemInfo->code;
                                    $itemCat = Cats::model()->nameOfThis($itemInfo->cat);
                                    $itemCatSub = CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                                } else {
                                    $itemName = "<font color='red'>Removed!</font>";
                                    $itemUnit = "";
                                    $itemDesc = "";
                                    $itemCode="";
                                    $itemCat = "";
                                    $itemCatSub="";
                                }
                                ?>
                                        <tr class="<?php
                        if ($sl % 2 == 0)
                            echo 'even'; else
                            'odd';
                                        ?>">
                                            <td><?php echo $sl++; ?></td>
                                            <td style="text-align: left;"><?php echo $itemCat; ?></td>
                                            <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                                            <td style="text-align: left;"><?php echo $itemName; ?></td>
                                            <td style="text-align: left;"><?php echo $itemCode; ?></td>
                                            <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                                            <td><?php echo $itemUnit; ?></td>
                                            <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($sumQtyArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #8db4e2;"><?php echo number_format(floatval($sumProcQtyArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($sumOrderQtyArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #ffff00;"><?php echo number_format(floatval($sumRcvQtyArr[$indexOfArr]), 2); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    $sumQtySubTotal = $sumQtySubTotal + $sumQtyArr[$indexOfArr];
                                    $sumProcQtySubTotal = $sumProcQtySubTotal + $sumProcQtyArr[$indexOfArr];
                                    $sumOrderQtySubTotal = $sumOrderQtySubTotal + $sumOrderQtyArr[$indexOfArr];
                                    $sumRcvQtySubTotal = $sumRcvQtySubTotal + $sumRcvQtyArr[$indexOfArr];
                                }
                                ?>
                                <tr>
                                    <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Sub Total</td>
                                    <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumQtySubTotal), 2); ?></td>
                                    <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumProcQtySubTotal), 2); ?></td>
                                    <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumOrderQtySubTotal), 2); ?></td>
                                    <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($sumRcvQtySubTotal), 2); ?></td>
                                </tr>

                                <?php
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="12" style="padding: 10px 0px;"></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                        <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($sumQtyTotal), 2); ?></td>
                        <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($procQtyTotal), 2); ?></td>
                        <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotal), 2); ?></td>
                        <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($rcvQtyTotal), 2); ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="11"><div class="flash-error">No result found!</div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
