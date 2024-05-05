<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'purchase-order-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Doubli Machin Productin Input (From Basick Sheet Production Output)</legend>
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
                <td><?php echo $form->labelEx($model, 'input_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'input_date',
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
                    <td><?php echo $form->labelEx($model, 'store'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%; padding: 10px 0px;',
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
                <td><?php echo $form->labelEx($model, 'doubli_producton_input_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'doubli_producton_input_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
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
         echo "<th>Production Input No</th>";

        echo "<th>Item</th>";
        echo "<th>Length</th>";
        echo "<th>Width</th>";
        echo "<th>Thickness</th>";
        echo "<th>Unit Of Distance</th>";
        echo "<th>Qty</th>";
        echo "<th>Kg/Qty</th>";

        echo "</tr>";
        $totalCount = count($procurementArray);
        $cashTotal2 = 0;
        $cashTotal = 0;
        $trClass='row';
        for ($i = 0; $i < $totalCount; $i++) {
            $procurementInfo = ProductionOutput::model()->findByPk($procurementArray[$i]);

                echo "<input type='hidden' name='DoubliMachinProductionInput[production_output_id][]' value='" . $procurementArray[$i] . "'>";
                echo "<input type='hidden' name='DoubliMachinProductionInput[production_output_no][]' value='" . $procurementInfo->sl_no . "'>";

                echo "<tr class='" . $trClass.$i . "'>";
                echo "<td>" . $sl++ . "</td>";
                echo "<td>" . $procurementInfo->sl_no . "</td>";
              

       
            echo "<input style='text-align: center;' type='hidden' id='length_" . $i . "' class='length' name='DoubliMachinProductionInput[item][]' type='text' value='" . $procurementInfo->item . "'>";
                 echo "<td><input style='text-align: center;' type='text' id='item_" . $i . "' class='item' name='' type='text' value='" . Items::model()->nameOfThis($procurementInfo->item) . "'></td>";
                 echo "<td><input style='text-align: center;' id='length_" . $i . "' class='length' name='DoubliMachinProductionInput[length][]' type='text' value='" . $procurementInfo->length . "'></td>";
                echo "<td><input style='text-align: center;' class='width' id='width_" . $i . "' type='text' name='DoubliMachinProductionInput[width][]' value='" . $procurementInfo->width  . "'></td>";
                echo "<td><input style='text-align: center;' class='thickness' id='thickness_" . $i . "' class='thickness' name='DoubliMachinProductionInput[thickness][]' type='text' value='" . $procurementInfo->thickness  . "'></td>";
                echo "<td><input style='text-align: center;' class='unit_of_distance' id='unit_of_distance_" . $i . "' class='unit_of_distance' name='DoubliMachinProductionInput[unit_of_distance][]' type='text' value='" . $procurementInfo->unit_of_distance  . "'></td>";
                echo "<td><input style='text-align: center;' class='qty' id='qty_" . $i . "' type='text' name='DoubliMachinProductionInput[qty][]' value='" . $procurementInfo->qty . "'></td>";
                echo "<td><input style='text-align: center;' class='qty_kg' id='qty_kg_" . $i . "' type='text' name='DoubliMachinProductionInput[qty_kg][]' value='" . $procurementInfo->qty_kg . "'></td>";
             
                echo "</tr>";

                ?>
                <script type="text/javascript">
                    $('#qtyInpt_<?php echo $i; ?>').bind('keyup', function () {
                        var costing = $('#costing_<?php echo $i; ?>').val();
                        var remainingQnty = parseFloat(('0' + $('#remainingqtyInpt_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                        var orderQnty = parseFloat(('0' + $('#qtyInpt_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                        if (orderQnty > remainingQnty) {
                            alertify.alert("Warning: Remaining Qty Exceeds !");
                            $('#qtyInpt_<?php echo $i; ?>').val(<?php //echo $remainingQty; ?>);
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
    
      $("input.item").css("background-color", "#D7D7D7");
    $("input.item").focus(function () {
        $(this).blur();
    });
        $("input.length").css("background-color", "#D7D7D7");
    $("input.length").focus(function () {
        $(this).blur();
    });
    
        $("input.width").css("background-color", "#D7D7D7");
    $("input.width").focus(function () {
        $(this).blur();
    });
    
       $("input.thickness").css("background-color", "#D7D7D7");
    $("input.thickness").focus(function () {
        $(this).blur();
    });
    
       $("input.unit_of_distance").css("background-color", "#D7D7D7");
    $("input.unit_of_distance").focus(function () {
        $(this).blur();
    });
    
       $("input.qty").css("background-color", "#D7D7D7");
    $("input.qty").focus(function () {
        $(this).blur();
    });
    
       $("input.qty_kg").css("background-color", "#D7D7D7");
    $("input.qty_kg").focus(function () {
        $(this).blur();
    });
    
    
    $(".tanim").click(function () {
    

        $("#ajaxLoaderMR").show();
    });
</script>
<?php $this->endWidget(); ?>

