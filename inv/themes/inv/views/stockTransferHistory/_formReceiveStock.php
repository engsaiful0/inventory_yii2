<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'stock-transfer-history-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Receive Stock Form</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'rcv_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'rcv_date',
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
                <td colspan="2" style="padding: 20px 0px;"> </td>
            </tr>
        </table>
        <?php
        $idsArray = explode(",", $ids);

        $sl = 1;
        echo "<div class='grid-view'>";
        echo "<table class='items'>";
        echo "<tr>";
        echo "<th style='width: 20px;'>SL</th>";
        echo "<th>Item</th>";
        echo "<th>Send Date</th>";
        echo "<th>Send From</th>";
        echo "<th>Send Qty</th>";
        echo "<th>Rcv To</th>";
        echo "<th>Remaining Receivable Qty</th>";
        echo "<th>Rcv Qty</th>";
        echo "</tr>";
        $totalCount = count($idsArray);
        for ($i = 0; $i < $totalCount; $i++) {
            $data=  StockTransferHistory::model()->findByPk($idsArray[$i]);
            $remainingQty=($data->send_qty-$data->rcv_qty);
            if ($remainingQty > 0) {
                $itemInfo = Items::model()->findByPk($data->item);
                if ($itemInfo) {
                    $itemName = $itemInfo->name;
                    $itemDesc = $itemInfo->desc;
                    $itemUnit = $itemInfo->unit;
                    $itemCat=  Cats::model()->nameOfThis($itemInfo->cat);
                    $itemSubCat=CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                } else {
                    $itemName = "";
                    $itemDesc = "";
                    $itemUnit = "";
                    $itemCat="";
                    $itemSubCat="";
                }
                
                if ($sl % 2 == 0)
                    $trClass = "even";
                else
                    $trClass="odd";
                echo "<input type='hidden' name='StockTransferHistory[id][]' value='" . $idsArray[$i] . "'>";
                echo "<tr class='" . $trClass . "'>";
                echo "<td>" . $sl++ . "</td>";
                echo "<td style='text-align: left;'>" . $itemName."<br>".$itemCat." - ".$itemSubCat . "</td>";
                echo "<td>".$data->send_date."</td>";
                echo "<td>".Stores::model()->storeName($data->from_store)."</td>";
                echo "<td>".$data->send_qty."</td>";
                echo "<td>".Stores::model()->storeName($data->to_store)."</td>";
                echo "<td><input style='text-align: center;' id='remainingQtyInpt_" . $i . "' type='hidden' value='" . $remainingQty . "'>".$remainingQty."</td>";
                echo "<td><input style='text-align: center;' id='rcvQtyInpt_" . $i . "'  name='StockTransferHistory[rcv_qty][]' type='text' value='" . $remainingQty . "'></td>";
                echo "</tr>";
                ?>
                <script type="text/javascript">
                    $('#rcvQtyInpt_<?php echo $i; ?>').bind('keyup', function() {
                        var rcvQty=parseFloat( ('0' + $("#rcvQtyInpt_<?php echo $i; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                        var remQty=parseFloat( ('0' + $("#remainingQtyInpt_<?php echo $i; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                            
                        if(rcvQty>remQty){
                            alertify.alert("Warning: remaining receivable qty exceeds !");
                            $('#rcvQtyInpt_<?php echo $i; ?>').val("<?php echo $remainingQty; ?>");
                        }
                    });
                </script>
                <?php
            }
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
        if($("#StockTransferHistory_rcv_date").val()==""){
            alertify.alert("Receive date can not be empty.");
            $("#StockTransferHistory_rcv_date").css("border-color", "#D50000");
            e.preventDefault();
        }else{
            $("#StockTransferHistory_rcv_date").css("border-color", "#AAAAAA");
        }
<?php for ($j = 0; $j < $totalCount; $j++): ?>
            if($("#rcvQtyInpt_<?php echo $j; ?>").val()=='' || $("#rcvQtyInpt_<?php echo $j; ?>").val()==0) {
                alertify.alert("Sending Qty can not be empty / zero.");
                $("#rcvQtyInpt_<?php echo $j; ?>").css("border-color", "#D50000");
                e.preventDefault();
            }else{
                $("#rcvQtyInpt_<?php echo $j; ?>").css("border-color", "#AAAAAA");
            }   
<?php endfor; ?>
        $("#ajaxLoaderMR").show();
    });
</script>
<?php $this->endWidget(); ?>
