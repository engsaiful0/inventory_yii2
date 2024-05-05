<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'production-input-form',
            'action' => $this->createUrl('productionInput/returnQty'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<?php $data = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'")); ?>
<div class="formDiv">
    <fieldset>
        <legend>Production Input Return Qty Form</legend>
        <div class="scrollable">
            <table class="checkoutTab" id="tbl">
                <tr>
                    <td colspan="10" style="padding: 6px 0px; font-weight: bold; text-align: left;">
                        Production Input No: <i><?php echo end($data)->sl_no; ?></i><br/>
                        Input Date/Time: <i><?php echo end($data)->date . "/" . end($data)->time; ?></i><br/>
                        Store: <i><?php echo Stores::model()->storeName(end($data)->store); ?></i><br/>
                        Machine: <i><?php echo Machines::model()->nameOfThis(end($data)->machine); ?></i>
                    </td>
                </tr>
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Label/Track No</th>
                    <th>Item</th>
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Input Qty</th>
                    <th>Input Qty(Kg)</th>
                    <th>Return Qty</th>
                    <th>Return Qty(Kg)</th>
                </tr>
                <script>
                    var errQtyArr=new Array();
                    var sl=0;
                    var newArr=new Array();
                </script>
                <tr></tr>
                <?php $sl = 1; ?>

                <?php foreach ($data as $d) { ?>
                    <?php
                    $itemInfo = Items::model()->findByPk($d->item);
                    if ($itemInfo) {
                        $itemName = $itemInfo->name;
                        $itemDesc = $itemInfo->desc;
                        $itemUnit = $itemInfo->unit;
                    } else {
                        $itemName = "";
                        $itemDesc = "";
                        $itemUnit = "";
                    }
                    ?>
                    <tr class='cartList'>
                        <input type='hidden' name='ProductionInput[id][]' value='<?php echo $d->id; ?>'/>
                        <td class='sno' style='text-align: center;'>
                            <?php echo $sl; ?> 
                        </td>
                        <td>
                            <?php echo $d->track_no; ?>
                        </td>
                        <td style='text-align: left; padding-left:2px;'>
                            <?php echo $itemName; ?> 
                        </td>
                        <td style='text-align: left; padding-left:2px;'>
                            <?php echo $itemDesc; ?> 
                        </td>
                        <td style='text-align: center;'>
                            <?php echo $itemUnit; ?> 
                        </td>
                        <td>
                            <?php echo $d->qty; ?>
                        </td>
                        <td>
                            <?php echo $d->qty_kg; ?>
                        </td>
                        <td>
                            <input style='text-align: center;' id='qtyInpt_<?php echo $sl; ?>' type='hidden' value="<?php echo $d->qty; ?>"/>
                            <input style='text-align: center;' id='rtnqtyInpt_<?php echo $sl; ?>' type='text' name='ProductionInput[return_qty][]' value="<?php echo $d->return_qty; ?>"/>
                        </td>
                        <td>
                            <input style='text-align: center;' id='qtyInptKg_<?php echo $sl; ?>' type='hidden' value="<?php echo $d->qty_kg; ?>"/>
                            <input style='text-align: center;' id='rtnqtyInptKg_<?php echo $sl; ?>' type='text' name='ProductionInput[return_qty_kg][]' value="<?php echo $d->return_qty_kg; ?>"/>
                        </td>
                        <script>
                            $('#rtnqtyInpt_<?php echo $sl; ?>').bind('keyup', function() {
                                var returnQty=parseFloat( ('0' + $("#rtnqtyInpt_<?php echo $sl; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var qty=parseFloat( ('0' + $("#qtyInpt_<?php echo $sl; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                                if(returnQty>qty){
                                    alertify.alert("Warning: Return qty exceeds !");
                                    $("#rtnqtyInpt_<?php echo $sl; ?>").val("0");
                                }
                            });
                            $('#rtnqtyInptKg_<?php echo $sl; ?>').bind('keyup', function() {
                                var returnQtyKg=parseFloat( ('0' + $("#rtnqtyInptKg_<?php echo $sl; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var qtyKg=parseFloat( ('0' + $("#qtyInptKg_<?php echo $sl; ?>").val()).replace(/[^0-9-\.]/g, ''), 10 );
                                if(returnQtyKg>qtyKg){
                                    alertify.alert("Warning: Return qty (Kg) exceeds !");
                                    $("#rtnqtyInptKg_<?php echo $sl; ?>").val("0");
                                }
                            });
                        </script>
                    </tr>
                    <?php $sl++; ?>
                <?php } ?>
            </table>
        </div>
        <div class="touchWrapper">
            <div style="float: left; width: 100%; padding: 6px 0px; text-align: center; color: #ffffff; font-weight: bold;">Output History</div>
            <?php
            $data2 = ProductionOutput::model()->findAll(array("condition" => "production_input_no='" . $sl_no . "'"));
            if ($data2) {
                ?>
                <style>
                    table.colorWhite tr td{
                        color: #FFFFFF;
                    }
                </style>
                <table class="checkoutTab colorWhite">
                    <tr>
                        <th style="width: 32px;">Sl</th>
                        <th>Label/Track No</th>
                        <th>Date/Time</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Output Qty</th>
                        <th>Output Qty(Kg)</th>
                    </tr>
                    <?php $sl = 1;
                    $totalQty2 = 0;
                    $totalQtyKg2 = 0; ?>
                    <?php foreach ($data2 as $d2) { ?>
                        <?php
                        $itemInfo2 = Items::model()->findByPk($d2->item);
                        if ($itemInfo2) {
                            $itemName2 = $itemInfo2->name;
                            $itemDesc2 = $itemInfo2->desc;
                            $itemUnit2 = $itemInfo2->unit;
                        } else {
                            $itemName2 = "";
                            $itemDesc2 = "";
                            $itemUnit2 = "";
                        }
                        ?>
                        <tr class='cartList'>
                            <td class='sno' style='text-align: center;'>
                                <?php echo $sl; ?> 
                            </td>
                            <td style='padding-left:2px; text-align: left;'>
                                <?php echo $d2->sl_no; ?> 
                            </td>
                            <td>
                                <?php echo $d2->date . " / " . $d2->time; ?> 
                            </td>
                            <td style='text-align: left; padding-left:2px;'>
                                <?php echo $itemName2; ?> 
                            </td>
                            <td style='text-align: left; padding-left:2px;'>
                                <?php echo $itemDesc2; ?> 
                            </td>
                            <td style='text-align: center;'>
                                <?php echo $itemUnit2; ?> 
                            </td>
                            <td>
                                <?php echo $d2->qty;
                                $totalQty2 = $d2->qty + $totalQty2; ?>
                            </td>
                            <td>
                        <?php echo number_format(floatval($d2->qty_kg), 2);
                        $totalQtyKg2 = $d2->qty_kg + $totalQtyKg2; ?> 
                            </td>
                        </tr>
        <?php $sl++; ?>
    <?php } ?>
                    <tr>
                        <td colspan="5"></td>
                        <td style="font-weight: bold; color: #ffffff;">Total Output</td>
                        <td style="font-weight: bold; color: #ffffff;"><?php echo $totalQty2; ?></td>
                        <td style="font-weight: bold; color: #ffffff;"><?php echo number_format(floatval($totalQtyKg2), 2); ?></td>
                    </tr>
                </table>
                <?php
            } else {
                ?>
                <div style="float: left; width: 100%; padding: 6px 0px; text-align: center; color: red; font-style: italic; border: 1px solid #ffffff;">No production output yet !</div>
    <?php
}
?>
        </div>
        <div class="rightDiv">
            <table>
                <tr>
                    <td></td>
                    <td>
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('productionInput/returnQty', 'sl_no' => end($data)->sl_no)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                        $("#ajaxLoader").hide();
                                        $("#formResult").fadeIn();
                                        $("#formResult").html(data.status);
                                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");     
                            }',
                            'beforeSend' => 'function(){  
                                    $("#ajaxLoader").show();
                             }'
                        ));
                        echo CHtml::link('Close', array('#'), array('class' => 'closeBtn additionalBtn', 'onclick' => 'closeMe();'));
                        ?>  
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
                        <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
<script>
    function closeMe(){
        window.opener = self;
        window.close();
    }
</script>

