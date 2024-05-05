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
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/productionReportExcel',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'category' => $category,
    'item' => $item,), array('title' => 'Export as xls'));
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/productionReportPdf',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'machine' => $machine,
    'category' => $category,
    'item' => $item,), array('title' => 'Save as PDF'));
?>
<div class='printAllTableForThisReport'>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" type="text/css" />
    <div class="grid-view">
        <table class="headerTab">
            <tr>
                <th colspan="11" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
            </tr>
            <tr>
                <th colspan="11" style="text-align: center; text-decoration: underline; padding-bottom: 30px;"><?php echo $message; ?></th>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Production Input Date / Time</th>
                    <th>Production Input No</th>
                    <th>Machine</th>
                    <th>Input Qty- Used (Kg)</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Output Qty</th>
                    <th>Output Qty (Kg)</th>
                    <th>Wastage Qty (Kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data) {
                    $sl = 1;
                    $totalInputQty = 0;
                    $totalOutputQty = 0;
                    $totalOutputQtyKg = 0;
                    $totalWastageQty = 0;

                    foreach ($data as $d) {
                        $subTotalOutputQty = 0;
                        $subTotalOutputQtyKg = 0;
                        $subTotalWastageQty = 0;

                        $productionInputDateTime = $d->date . " / " . $d->time;
                        $productionInputNo = $d->sl_no;
                        $productionMachine = Machines::model()->nameOfThis($d->machine);
                        $productionInputQtyKg = ($d->sumOfQtyKg - $d->sumOfRtnQtyKg);

                        $wastageQty = ProductionWastage::model()->totalWastageQtyOfThisProductionInputNo($productionInputNo);

                        $criteria = new CDbCriteria();
                        $criteria->select = "sum(qty) as sumOfQty, sum(qty_kg) as sumOfQtyKg, item";
                        $criteria->addColumnCondition(array("production_input_no" => $productionInputNo));
                        if ($category != "") {
                            $itemsData = Items::model()->findAll(array("condition" => "cat=" . $category));
                            if ($itemsData) {
                                $itemsArray = array();
                                foreach ($itemsData as $itmsd) {
                                    $itemsArray[] = $itmsd->id;
                                }
                                $criteria->addInCondition("item", $itemsArray, "AND");
                            }
                        }
                        if ($item != "") {
                            $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
                        }
                        $criteria->group = "item";
                        $outputData = ProductionOutput::model()->findAll($criteria);

                        if ($outputData) {
                            $rowspan = count($outputData);
                            $countRowspan = 1;
                            foreach ($outputData as $od) {
                                $itemInfo = Items::model()->findByPk($od->item);
                                ?>
                                <?php
                                $itemInfo = Items::model()->findByPk($od->item);
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
                                <tr class="<?php
                if ($sl % 2 == 0)
                    echo 'even'; else
                    'odd';
                                ?>">
                                    <td><?php echo $sl++; ?></td>
                                    <?php if ($countRowspan == 1) { ?>
                                        <td rowspan="<?php echo $rowspan; ?>"><?php echo $productionInputDateTime; ?></td>
                                        <td rowspan="<?php echo $rowspan; ?>"><?php echo $productionInputNo; ?></td>
                                        <td style="text-align: left;" rowspan="<?php echo $rowspan; ?>"><?php echo $productionMachine; ?></td>
                                        <td style="background-color: #fee35c;" rowspan="<?php echo $rowspan; ?>"><?php echo $productionInputQtyKg; ?></td>
                                    <?php } ?>
                                    <td style="text-align: left;"><?php echo $itemCat; ?></td>
                                    <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                                    <td style="text-align: left;"><?php echo $itemName; ?></td>
                                    <td style="text-align: left;"><?php echo $itemCode; ?></td>
                                    <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                                    <td><?php echo $itemUnit; ?></td>
                                    <td style="background-color: #8db4e2;"><?php echo $od->sumOfQty; ?></td>
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($od->sumOfQtyKg), 2); ?></td>
                                    <?php if ($countRowspan == 1) { ?>
                                        <td style="background-color: #ffff00;" rowspan="<?php echo $rowspan; ?>"><?php echo number_format(floatval($wastageQty), 2); ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $subTotalOutputQty = $od->sumOfQty + $subTotalOutputQty;
                                $subTotalOutputQtyKg = $od->sumOfQtyKg + $subTotalOutputQtyKg;
                                $subTotalWastageQty = $wastageQty + $subTotalWastageQty;
                                $countRowspan++;
                            }
                            ?>
                            <tr>
                                <td colspan="11" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Sub Total</td>
                                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo $subTotalOutputQty; ?></td>
                                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($subTotalOutputQtyKg), 2); ?></td>
                                <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($subTotalWastageQty), 2); ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr class="<?php
                if ($sl % 2 == 0)
                    echo 'even'; else
                    'odd';
                            ?>">
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $productionInputDateTime; ?></td>
                                <td><?php echo $productionInputNo; ?></td>
                                <td style="text-align: left;"><?php echo $productionMachine; ?></td>
                                <td style="background-color: #fee35c;"><?php echo $productionInputQtyKg; ?></td>
                                <td style="text-align: center; color: red;" colspan="8">No output yet !</td>
                                <td style="background-color: #ffff00;"><?php echo number_format(floatval($wastageQty), 2); ?></td>
                            </tr>
                            <?php
                            $subTotalWastageQty = $subTotalWastageQty + $wastageQty;
                        }
                        $totalInputQty = $totalInputQty + $productionInputQtyKg;
                        $totalOutputQty = $totalOutputQty + $subTotalOutputQty;
                        $totalOutputQtyKg = $totalOutputQtyKg + $subTotalOutputQtyKg;
                        $totalWastageQty = $totalWastageQty + $subTotalWastageQty;
                    }
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                        <td style="background-color: #fee35c; font-weight: bold;"><?php echo number_format(floatval($totalInputQty), 2); ?></td>
                        <td colspan="6" style="background-color: #d6963f;"></td>
                        <td style="background-color: #8db4e2; font-weight: bold;"><?php echo $totalOutputQty; ?></td>
                        <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalOutputQtyKg), 2); ?></td>
                        <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($totalWastageQty), 2); ?></td>
                    </tr>
                    <?php
                }else {
                    ?>
                    <tr>
                        <td colspan="14"><div class="flash-error">No result found !</div></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>