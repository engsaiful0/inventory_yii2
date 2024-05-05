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
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/stockReportExcel',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'category' => $category,
    'item' => $item,
    'supplier_id' => $supplier_id,), array('title' => 'Export as xls'));
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/stockReportPdf',
    'startDate' => $startDate,
    'endDate' => $endDate,
    'store' => $store,
    'category' => $category,
    'item' => $item,
    'supplier_id' => $supplier_id,), array('title' => 'Save as PDF'));
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
                    <th>Opening Stock</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Closing Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data) { ?>
                    <?php
                    $itemArr = array();
                    $ostArr = array();
                    $sstiArr = array();
                    $sstoArr = array();
                    $cstArr = array();

                    $arrPos = 0;

                    $openingStockTotal = 0;
                    $sumStockInTotal = 0;
                    $sumStockOutTotal = 0;
                    $closingStockTotal = 0;

                    $sl = 1;

                    foreach ($data as $d):

                        $sumStockIn = $d->sumStockIn;
                        $sumStockOut = $d->sumStockOut;
                        $itemId = $d->item;

                        $cirteriaOpeningStock = new CDbCriteria();
                        $cirteriaOpeningStock->select = 'sum(stock_in) as sumStockIn, sum(stock_out) as sumStockOut';
                        $cirteriaOpeningStock->condition = "date < '" . $startDate . "' AND item=" . $itemId;
                        if ($store != "")
                            $cirteriaOpeningStock->condition.=" AND store=" . $store;
                        $dataOpeningStock = Inventory::model()->findAll($cirteriaOpeningStock);

                        $closingStock = 0;
                        $sumStockInOpening = 0;
                        $sumStockOutOpening = 0;
                        if ($dataOpeningStock) {
                            foreach ($dataOpeningStock as $dos):
                                $sumStockInOpening = $dos->sumStockIn;
                                $sumStockOutOpening = $dos->sumStockOut;
                            endforeach;
                        }
                        $openingStock = ($sumStockInOpening - $sumStockOutOpening);
                        $closingStock = ($openingStock + $sumStockIn - $sumStockOut);

                        $openingStockTotal = $openingStock + $openingStockTotal;
                        $sumStockInTotal = $sumStockIn + $sumStockInTotal;
                        $sumStockOutTotal = $sumStockOut + $sumStockOutTotal;
                        $closingStockTotal = $closingStock + $closingStockTotal;

                        $itemArr[$arrPos] = $itemId;
                        $ostArr[$arrPos] = $openingStock;
                        $sstiArr[$arrPos] = $sumStockIn;
                        $sstoArr[$arrPos] = $sumStockOut;
                        $cstArr[$arrPos] = $closingStock;
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
                                $openingStockSubTotal = 0;
                                $sumStockInSubTotal = 0;
                                $sumStockOutSubTotal = 0;
                                $closingStockSubTotal = 0;

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
                                            <td style="text-align: left;"><?php echo $itemCat; ?></td>
                                            <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                                            <td style="text-align: left;"><?php echo $itemName; ?></td>
                                            <td style="text-align: left;"><?php echo $itemCode; ?></td>
                                            <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                                            <td><?php echo $itemUnit; ?></td>
                                            <td><?php echo number_format(floatval($ostArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #8db4e2;"><?php echo number_format(floatval($sstiArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($sstoArr[$indexOfArr]), 2); ?></td>
                                            <td style="background-color: #ffff00;"><?php echo number_format(floatval($cstArr[$indexOfArr]), 2); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    $openingStockSubTotal = $openingStockSubTotal + $ostArr[$indexOfArr];
                                    $sumStockInSubTotal = $sumStockInSubTotal + $sstiArr[$indexOfArr];
                                    $sumStockOutSubTotal = $sumStockOutSubTotal + $sstoArr[$indexOfArr];
                                    $closingStockSubTotal = $closingStockSubTotal + $cstArr[$indexOfArr];
                                }
                                ?>
                                <tr>
                                    <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Sub Total</td>
                                    <td style="background-color: #f7f7f7; font-weight: bold;"><?php echo number_format(floatval($openingStockSubTotal), 2); ?></td>
                                    <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumStockInSubTotal), 2); ?></td>
                                    <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumStockOutSubTotal), 2); ?></td>
                                    <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($closingStockSubTotal), 2); ?></td>
                                </tr>

                                <?php
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                        <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($openingStockTotal), 2); ?></td>
                        <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumStockInTotal), 2); ?></td>
                        <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumStockOutTotal), 2); ?></td>
                        <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($closingStockTotal), 2); ?></td>
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
