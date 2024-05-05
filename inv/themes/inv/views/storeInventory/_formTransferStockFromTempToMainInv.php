<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'inventory-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
$storeIds=explode(",", $storeIds);
$model->from_store=$storeIds[0];
echo $form->hiddenField($model, 'from_store');
?>
<div class="formDiv">
    <fieldset>
        <legend>Sending Stock Form</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'date',
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
                <td><?php echo $form->labelEx($model, 'Transfered_from_Store'); ?></td>
                <td><?php echo Stores::model()->storeNameAndAddr($storeIds[0]) ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'Transfer_to_Store'); ?></td>
                <td>
                    <?php
                        echo $form->dropDownList(
                                $model, 'to_store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 20px 0px;"> </td>
            </tr>
        </table>
        <?php
        $itemsArray = explode(",", $prodIds);
        $itemsAvlStckArray = explode(",", $prodAS);
        $itemsCostArray = explode(",", $prodCosts);
        
        $sl = 1;
        echo "<div class='grid-view'>";
        echo "<table class='items'>";
        echo "<tr>";
        echo "<th style='width: 20px;'>SL</th>";
        echo "<th>Item</th>";
        echo "<th>Stock In Qty</th>";
        echo "<th>Costing Price</th>";
        echo "</tr>";
        $totalCount = count($itemsArray);
        for ($i = 0; $i < $totalCount; $i++) {
            if ($sl % 2 == 0)
                $trClass = "even";
            else
                $trClass="odd";
            echo "<input type='hidden' name='Inventory[item][]' value='" . $itemsArray[$i] . "'>";
            echo "<input type='hidden' name='Inventory[costing_price][]' value='" . $itemsCostArray[$i] . "'>";
            echo "<tr class='" . $trClass . "'>";
            echo "<td>" . $sl++ . "</td>";
            ?>
            <td style='text-align: left;'><?php Items::model()->item($itemsArray[$i]); ?></td>
            <?php
            echo "<td><input style='text-align: center;' id='qtyInpt_".$i."' type='text' name='Inventory[stock_in][]' value='".$itemsAvlStckArray[$i]."'></td>";
            echo "<td>".$itemsCostArray[$i]."</td></td>";
            echo "</tr>";
            ?>
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
    $(".tanim").click(function(e){
        if($("#Inventory_date").val()==""){
            alertify.alert("Date can not be empty.");
            $("#Inventory_date").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#Inventory_date").css("border-color", "#AAAAAA");
        }
        if($("#Inventory_to_store").val()==""){
            alertify.alert("Transfer to store can not be empty.");
            $("#Inventory_to_store").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#Inventory_to_store").css("border-color", "#AAAAAA");
        }
        if($("#Inventory_from_store").val()==$("#Inventory_to_store").val()){
            alertify.alert("Transfer from location and to location can not be same.");
            $("#Inventory_to_store").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#Inventory_to_store").css("border-color", "#AAAAAA");
        }
<?php for ($j = 0; $j < $totalCount; $j++): ?>
            if($("#qtyInpt_<?php echo $j; ?>").val()=='' || $("#qtyInpt_<?php echo $j; ?>").val()==0) {
                alertify.alert("Stock In Qty can not be empty / zero.");
                $("#qtyInpt_<?php echo $j; ?>").css("border-color", "#D50000");
                e.preventDefault();
            }else{
                $("#qtyInpt_<?php echo $j; ?>").css("border-color", "#AAAAAA");
            }   
<?php endfor; ?>
        $("#ajaxLoaderMR").show();
    });
</script>
<?php $this->endWidget(); ?>

