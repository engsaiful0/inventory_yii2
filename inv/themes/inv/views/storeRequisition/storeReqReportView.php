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
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/storeReqReportExcel',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'department' => $department,
    'category' => $category,
    'item' => $item,
    'reqBy' => $reqBy,), array('title' => 'Export as xls'));
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/storeReqReportPdf',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'department' => $department,
    'category' => $category,
    'item' => $item,
    'reqBy' => $reqBy,), array('title' => 'Save as PDF'));
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
                    <th>Req No</th>
                    <th>Req Date</th>
                    <th>Department</th>
                    <th>Store</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Req. Qty</th>
                    <th>Req. By</th>
                    <th>Delv. Qty</th>
                    <th>Approved By</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data) { ?>
                    <?php
                    $totalQty = 0;
                    $totalDelvQty = 0;
                    $sl = 1;
                    ?>
                    <?php foreach ($data as $d) { ?>
                        <?php
                        $itemInfo = Items::model()->findByPk($d->item);
                        if ($itemInfo) {
                            $itemName = $itemInfo->name;
                            $itemUnit = $itemInfo->unit;
                            $itemDesc = $itemInfo->desc;
                            $itemCode = $itemInfo->code;
                            $itemCat = Cats::model()->nameOfThis($itemInfo->cat);
                            $itemCatSub = CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                        } else {
                            $itemName = "<font color='red'>Removed!</font>";
                            $itemUnit = "";
                            $itemDesc = "";
                            $itemCode = "";
                            $itemCat = "";
                            $itemCatSub = "";
                        }
                        ?>
                        <tr class="<?php if ($sl % 2 == 0)
                    echo 'even'; else
                    echo 'odd'; ?>">
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $d->sl_no; ?></td>
                            <td><?php echo $d->req_date; ?></td>
                            <td><?php echo Departments::model()->nameOfThis($d->department); ?></td>
                            <td><?php echo Stores::model()->storeName($d->store); ?></td>
                            <td style="text-align: left;"><?php echo $itemCat; ?></td>
                            <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                            <td style="text-align: left;"><?php echo $itemName; ?></td>
                            <td style="text-align: left;"><?php echo $itemCode; ?></td>
                            <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                            <td><?php echo $itemUnit; ?></td>
                            <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($d->qty), 2); ?></td>
                            <td style="text-align: left;"><?php echo Employees::model()->fullNameWithDesigDepart($d->req_by); ?></td>
                            <?php
                            $deliveryQty = StoreReqDR::model()->availableQtyOfThisReqId($d->id);
                            $approvedBy = StoreReqDR::model()->approvedByOfThisReqId($d->id);
                            ?>
                            <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($deliveryQty), 2); ?></td>
                            <td style="text-align: left;"><?php echo Users::model()->fullNameOfThis($approvedBy); ?></td>
                        </tr>
                        <?php
                        $totalQty = $d->qty + $totalQty;
                        $totalDelvQty = $deliveryQty + $totalDelvQty;
                        ?>
    <?php } ?>
                    <tr>
                        <td colspan="11" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                        <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalQty), 2); ?></td>
                        <td style="background-color: #d6963f; font-weight: bold;"></td>
                        <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalDelvQty), 2); ?></td>
                        <td style="background-color: #d6963f; font-weight: bold;"></td>
                    </tr>
<?php } else { ?>
                    <tr>
                        <td colspan="15"><div class="flash-error">No result found!</div></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>
