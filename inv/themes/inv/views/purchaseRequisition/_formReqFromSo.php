<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'purchase-requisition-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
$storeIds=explode(",", $storeIds);
$model->store=$storeIds[0];
echo $form->hiddenField($model, 'store');
?>
<div class="formDiv">
    <fieldset>
        <legend>Purchase Requisition Form</legend>
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
                <td><?php echo $form->labelEx($model, 'store'); ?></td>
                <td><?php echo Stores::model()->storeNameAndAddr($storeIds[0]) ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'department'); ?></td>
                <td>
                    <?php
                        echo $form->dropDownList(
                                $model, 'department', CHtml::listData(Departments::model()->findAll(array('order'=>'department_name ASC')), 'id', 'department_name'), array(
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
        $itemsReqQtyArray=explode(",", $prodReqQtys);
        $sl = 1;
        echo "<div class='grid-view'>";
        echo "<table class='items'>";
        echo "<tr>";
        echo "<th style='width: 20px;'>SL</th>";
        echo "<th>Item</th>";
        echo "<th>Req Qty</th>";
        echo "<th>Cost/Unit</th>";
        echo "<th>Approx. Amount</th>";
        echo "<th>Remarks</th>";
        echo "</tr>";
        $totalCount = count($itemsArray);
        $cashTotal=0;
        for ($i = 0; $i < $totalCount; $i++) {
            $costingPrice = CostingPrice::model()->activeCostingPrice($itemsArray[$i]);
            if ($sl % 2 == 0)
                $trClass = "even";
            else
                $trClass="odd";
            echo "<input type='hidden' name='PurchaseRequisition[item][]' value='" . $itemsArray[$i] . "'>";
            echo "<tr class='" . $trClass . "'>";
            echo "<td>" . $sl++ . "</td>";
            ?>
            <td style='text-align: left;'><?php Items::model()->item($itemsArray[$i]); ?></td>
            <?php
            echo "<td><input style='text-align: center;' id='qtyInpt_".$i."' type='text' name='PurchaseRequisition[qty][]' value='".$itemsReqQtyArray[$i]."'></td>";
            echo "<td><input style='text-align: center;' id='priceInpt_".$i."' type='text' name='PurchaseRequisition[cost][]' value='".$costingPrice."'></td></td>";
            echo "<td><input style='text-align: center;' id='lineTtlInpt_".$i."' class='lineTotalInpt' type='text' value='0'></td>";
            echo "<td><input type='text' name='PurchaseRequisition[remarks][]'></td>";
            echo "</tr>";
            
            $cashTotal=($costingPrice*1)+$cashTotal;
            ?>
            <script type="text/javascript">
                var sellPrc=$('#priceInpt_<?php echo $i; ?>').val();
                var sellQnty=$('#qtyInpt_<?php echo $i; ?>').val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_<?php echo $i; ?>').val(total);
                //$('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                $('#priceInpt_<?php echo $i; ?>').bind('keyup', function() {
                    var sellPrc=$('#priceInpt_<?php echo $i; ?>').val();
                    var sellQnty=$('#qtyInpt_<?php echo $i; ?>').val();
                    var total=(sellQnty*sellPrc);
                    $('#lineTtlInpt_<?php echo $i; ?>').val(total);
                    $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                });
                $('#qtyInpt_<?php echo $i; ?>').bind('keyup', function() {
                    var sellPrc=$('#priceInpt_<?php echo $i; ?>').val();
                    var sellQnty=$('#qtyInpt_<?php echo $i; ?>').val();
                    var total=(sellQnty*sellPrc);
                    $('#lineTtlInpt_<?php echo $i; ?>').val(total);
                    $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                });
            </script>
            <?php
        }
        echo "<tr><td colspan='4' style='text-align: right;'>Total:</td><td><input style='text-align: center;' type='text' id='cashTotal' value='".$cashTotal."'/></td><td></td></tr>";
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
    $.fn.sumValues = function() {
        var sum = 0; 
        this.each(function() {
            if ( $(this).is(':input') ) {
                var val = $(this).val();
            } else {
                var val = $(this).text();
            }
            sum += parseFloat( ('0' + val).replace(/[^0-9-\.]/g, ''), 10 );
        });
        return sum;
    };
    $("input#cashTotal").css("background-color", "#D7D7D7");
    $("input#cashTotal").focus(function(){
            $(this).blur();           
        }); 
    $("input.lineTotalInpt").css("background-color", "#D7D7D7");
    $("input.lineTotalInpt").focus(function(){
        $(this).blur();         
    }); 
    
    $(".tanim").click(function(e){
        if($("#PurchaseRequisition_date").val()==""){
            alertify.alert("Date can not be empty.");
            $("#PurchaseRequisition_date").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#PurchaseRequisition_date").css("border-color", "#AAAAAA");
        }
        if($("#PurchaseRequisition_department").val()==""){
            alertify.alert("Department can not be empty.");
            $("#PurchaseRequisition_department").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#PurchaseRequisition_department").css("border-color", "#AAAAAA");
        }
<?php for ($j = 0; $j < $totalCount; $j++): ?>
            if($("#qtyInpt_<?php echo $j; ?>").val()=='' || $("#qtyInpt_<?php echo $j; ?>").val()==0) {
                alertify.alert("Qty can not be empty / zero.");
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Purchase Requisition Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
