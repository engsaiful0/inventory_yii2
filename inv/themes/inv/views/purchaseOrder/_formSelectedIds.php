<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'purchase-order-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Purchase Order (From Procurement)</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'ref_no'); ?></td>
                <td><?php echo $form->textField($model, 'ref_no', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'subj'); ?></td>
                <td><?php echo $form->textField($model, 'subj', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'issue_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'issue_date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'showOn' => 'button',
                            'buttonText' => 'Date',
                            'buttonImageOnly' => true,
                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'float: left;
                                        margin-top: 6px;
                                        width: 61%;'
                        ),
                    ));
                    ?>
                </td>               
            </tr>
            <tr>
                <td ><?php echo $form->labelEx($model, 'approved_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'approved_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'purchase_order_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'purchase_order_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 20px 0px;"> </td>
            </tr>
        </table>
        <?php
        $procurementArray = explode(",", $selectedIds);

        $sl = 1;
        echo "<div class='grid-view'>";
        echo "<table class='items'>";
        echo "<tr>";
        echo "<th style='width: 20px;'>SL</th>";
        echo "<th>Procurement No</th>";
        echo "<th>Supplier</th>";
        echo "<th>Local/Import</th>";
        echo "<th>Item</th>";
        echo "<th>Present Stock</th>";
        echo "<th>Requisition Qty</th>";
        echo "<th>Unit</th>";
        echo "<th>Cost/Unit</th>";
        echo "<th>Approx. Amount</th>";
        echo "<th>Remarks</th>";
        echo "<th>Remaining Qty for PO</th>";
        echo "<th>Order Qty</th>";
        echo "<th>Unit</th>";
        echo "<th>Approx. Amount</th>";
        echo "</tr>";
        $totalCount = count($procurementArray);
        $cashTotal2 = 0;
        $cashTotal = 0;
        for ($i = 0; $i < $totalCount; $i++) {
            $procurementInfo = PurchaseProcurement::model()->findByPk($procurementArray[$i]);

            $presentStock = Inventory::model()->presentStockOfThisItem($procurementInfo->item, $procurementInfo->store);
            $approxAmount = ($procurementInfo->qty * $procurementInfo->cost);
            $remainingQty = ($procurementInfo->qty - PurchaseOrder::model()->totalPOQtyForThis($procurementArray[$i]));
            $approxAmount2 = ($remainingQty * $procurementInfo->cost);
            if ($remainingQty > 0) {
                if ($sl % 2 == 0)
                    $trClass = "even";
                else
                    $trClass = "odd";
                echo "<input type='hidden' name='PurchaseOrder[procurement_id][]' value='" . $procurementArray[$i] . "'>";
                echo "<input type='hidden' name='PurchaseOrder[procurement_no][]' value='" . $procurementInfo->sl_no . "'>";

                echo "<tr class='" . $trClass . "'>";
                echo "<td>" . $sl++ . "</td>";
                echo "<td>" . $procurementInfo->sl_no . "</td>";
                echo "<td style='text-align: left;'>" . Suppliers::model()->supplierName($procurementInfo->supplier_id) . "</td>";
                echo "<td style='text-align: left;'>" . Lookup::item('order_type', $procurementInfo->order_type) . " (" . Lookup::item('order_sub_type', $procurementInfo->order_sub_type) . ")" . "</td>";
                ?>
                <td style='text-align: left;'><?php Items::model()->item($procurementInfo->item); ?></td>
                <?php
                echo "<td>" . number_format(floatval($presentStock), 2) . "</td>";
                echo "<td>" . number_format(floatval($procurementInfo->qty), 2) . "</td>";
                echo "<td>" .Units::model()->name_of_unitOfThis($procurementInfo->name_of_unit). "</td>";
                echo "<td><input style='text-align: center;' id='costing_" . $i . "' name='PurchaseOrder[costing][]'  class='' type='text' value='" . number_format(floatval($procurementInfo->cost), 2) . "'></td>";
//            echo "<input id='costing_".$i."' type='hidden' value='".$procurementInfo->cost."'>";
                echo "<td>" . number_format(floatval($approxAmount), 2) . "</td>";
                echo "<td>" . $procurementInfo->remarks . "</td>";
                echo "<td><input style='text-align: center;' id='remainingqtyInpt_" . $i . "' class='remainingQtyInpt' type='text' value='" . $remainingQty . "'></td>";
                echo "<td><input style='text-align: center;' id='qtyInpt_" . $i . "' type='text' name='PurchaseOrder[order_qty][]' value='" . $remainingQty . "'></td>";
                echo "<td><input style='text-align: center;' id='name_of_unit_" . $i . "' class='nameOfUnit' type='text' name='PurchaseOrder[name_of_unit][]' value='" . Units::model()->name_of_unitOfThis($procurementInfo->name_of_unit) . "'></td>";
                echo "<td><input style='text-align: center;' id='lineTtlInpt_" . $i . "' class='lineTotalInpt' type='text' value='" . number_format(floatval($approxAmount2), 2) . "'></td>";
                echo "</tr>";
                $cashTotal2 = ($cashTotal2 + $approxAmount);
                $cashTotal = ($cashTotal + $approxAmount2);
                ?>
                <script type="text/javascript">
                    $('#qtyInpt_<?php echo $i; ?>').bind('keyup', function () {
                        var costing = $('#costing_<?php echo $i; ?>').val();
                        var remainingQnty = parseFloat(('0' + $('#remainingqtyInpt_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                        var orderQnty = parseFloat(('0' + $('#qtyInpt_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                        if (orderQnty > remainingQnty) {
                            alertify.alert("Warning: Remaining Qty Exceeds !");
                            $('#qtyInpt_<?php echo $i; ?>').val(<?php echo $remainingQty; ?>);
                            var total = (remainingQnty * costing);
                            $('#lineTtlInpt_<?php echo $i; ?>').val(total.toFixed(2));
                            $('#cashTotal').val($('input.lineTotalInpt').sumValues().toFixed(2));
                        } else {
                            var total = (orderQnty * costing);
                            $('#lineTtlInpt_<?php echo $i; ?>').val(total.toFixed(2));
                            $('#cashTotal').val($('input.lineTotalInpt').sumValues().toFixed(2));
                        }
                    });
                </script>
                <?php
            }
        }
        echo "<tr><td colspan='8' style='text-align: right;'>Total:</td><td><input style='text-align: center;' type='text' id='cashTotal2' value='" . number_format(floatval($cashTotal2), 2) . "'/></td><td colspan='3'></td><td><input style='text-align: center;' type='text' id='cashTotal' value='" . number_format(floatval($cashTotal), 2) . "'/></td></tr>";
        echo "</table>";
        echo "</div>";
        ?>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Save', array('class' => 'tanim')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $.fn.sumValues = function () {
        var sum = 0;
        this.each(function () {
            if ($(this).is(':input')) {
                var val = $(this).val();
            } else {
                var val = $(this).text();
            }
            sum += parseFloat(('0' + val).replace(/[^0-9-\.]/g, ''), 10);
        });
        return sum;
    };
    $("input#cashTotal2").css("background-color", "#D7D7D7");
    $("input#cashTotal2").focus(function () {
        $(this).blur();
    });
    
       $("input.nameOfUnit").css("background-color", "#D7D7D7");
    $("input.nameOfUnit").focus(function () {
        $(this).blur();
    });
    
    $("input#cashTotal").css("background-color", "#D7D7D7");
    $("input#cashTotal").focus(function () {
        $(this).blur();
    });
    $("input.lineTotalInpt").css("background-color", "#D7D7D7");
    $("input.lineTotalInpt").focus(function () {
        $(this).blur();
    });
    $("input.remainingQtyInpt").css("background-color", "#D7D7D7");
    $("input.remainingQtyInpt").focus(function () {
        $(this).blur();
    });
    $(".tanim").click(function (e) {
        if ($("#PurchaseOrder_issue_date").val() == "") {
            alertify.alert("Issue Date can not be empty.");
            $("#PurchaseOrder_issue_date").css("border-color", "#D50000");
            e.preventDefault();
        } else {
            $("#PurchaseOrder_issue_date").css("border-color", "#AAAAAA");
        }

        var errOQArr = new Array();
<?php for ($j = 0; $j < $totalCount; $j++): ?>
            if ($("#qtyInpt_<?php echo $j; ?>").val() == '' || $("#qtyInpt_<?php echo $j; ?>").val() == 0) {
                $("#qtyInpt_<?php echo $j; ?>").css("border-color", "#D50000");
                errOQArr[<?php echo $j; ?>] = "err_exist";
                e.preventDefault();
            } else {
                $("#qtyInpt_<?php echo $j; ?>").css("border-color", "#AAAAAA");
                errOQArr[<?php echo $j; ?>] = "";
            }
<?php endfor; ?>
        if ($.inArray("err_exist", errOQArr) > -1) {
            alertify.alert("There is an empty/zero field on items order quantity column !");
            return false;
        }
        $("#ajaxLoaderMR").show();
    });
</script>
<?php $this->endWidget(); ?>

