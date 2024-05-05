<?php
//$data = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
if ($data) {
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'production-wastage-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    ));
    ?>
    <div class="formDiv">
        <fieldset>
            <legend>Production Wastage Form</legend>
            <div class="scrollable">
                <table class="checkoutTab">
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 6px 0px; font-weight: bold;">
                            Production Input No: <i><?php echo end($data)->sl_no; ?></i>
                            <br/>Date: <i><?php echo end($data)->date; ?></i>
                            <br/>Time: <i><?php echo end($data)->time; ?></i>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 32px;">Sl</th>
                        <th>Label/Track No</th>
                        <th>Item</th>
                        <th>Length</th>
                        <th>Width</th>
                        <th>Thickness</th>
                        <th>Unit Of Distance</th>
                        <th>Input Qty</th>
                        <th>Input Qty(Kg)</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $totalQtyKg = 0;
                    ?>
                    <?php foreach ($data as $d) { ?>
                        <tr class='cartList'>
                            <td class='sno' style='text-align: center;'>
                                <?php echo $sl; ?> 
                            </td>
                            <td style='padding-left:2px; text-align: left;'>
                                <?php echo $d->track_no; ?> 
                            </td>
                            <td style='text-align: left; padding-left:2px;'>
                                <?php echo Items::model()->item($d->item); ?> 
                            </td>
                            <td>
                                <?php echo $d->length; ?>
                            </td>
                            <td>
                                <?php echo $d->width; ?>
                            </td>
                            <td>
                                <?php echo $d->thickness; ?>
                            </td>
                             <td>
                                <?php echo UnitDistance::model()->unit_of_distanceOfThis($d->unit_of_distance); ?>
                            </td>
                            <td>
                                <?php echo $d->qty; ?>
                            </td>
                            <td>
                                <?php
                                echo number_format(floatval($d->qty_kg), 2);
                                $totalQtyKg = $d->qty_kg + $totalQtyKg;
                                ?> 
                                
                            </td>
                        </tr>
                        <?php $sl++; ?>
                    <?php } ?>
                    <tr>
                        <td colspan="7"></td>
                        <td style="font-weight: bold; color: teal;">Total Input</td>
                        <input id="input_qty" type="hidden" value="<?php echo $totalQtyKg ?>">
                        <td style="font-weight: bold; color: teal;"><span id="totalQtyKg"><?php echo number_format(floatval($totalQtyKg), 2); ?></span></td>
                    </tr>
                </table>
            </div>
            <div class="touchWrapper" style="height: 485px;">
                <div style="float: left; width: 100%; padding: 6px 0px; text-align: center; color: #ffffff; font-weight: bold;">Output History</div>
                <?php
                $data2 = DoubliMachinProductionOuput::model()->findAll(array("condition" => "production_input_no='" . $sl_no . "'"));
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
                            <th>Width</th>
                            <th>Thickness</th>
                            <th>Unit Of Distance</th>
                            <th>Output Qty</th>
                            <th>Output Qty(Kg)</th>
                        </tr>
                        <?php
                        $sl = 1;
                        $totalQty2 = 0;
                        $totalQtyKg2 = 0;
                        ?>
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
                                    <?php echo Items::model()->item($d2->item); ?> 
                                </td>
                                         <td>
                                <?php echo $d2->length; ?>
                            </td>
                            <td>
                                <?php echo $d2->width; ?>
                            </td>
                            <td>
                                <?php echo $d2->thickness; ?>
                            </td>
                             <td>
                                <?php echo UnitDistance::model()->unit_of_distanceOfThis($d2->unit_of_distance); ?>
                            </td>
                                <td>
                                    <?php
                                    echo $d2->qty;
                                    $totalQty2 = $d2->qty + $totalQty2;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format(floatval($d2->qty_kg), 2);
                                    $totalQtyKg2 = $d2->qty_kg + $totalQtyKg2;
                                    ?> 
                                </td>
                            </tr>
                            <?php $sl++; ?>
                        <?php } ?>
                        <tr>
                            <td colspan="3"></td>
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
            <div class="rightDiv" style="height: 485px;">
                <table>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;">
                            <label>Prev.Wast.Qty (Kg)</label>
                        </td>
                        <td style="font-weight: bold; color: yellow; font-style: italic; padding: 8px 0px;">
                            <?php
                            $totalWastageQtyPrev = DoubliMachinProductionWastage::model()->totalWastageQtyOfThisProductionInputNo($sl_no);
                            echo number_format(floatval($totalWastageQtyPrev), 2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'wastage_qty'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'wastage_qty', array('id' => 'wastage_qty', 'class' => 'coloredInput')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php //echo $form->error($model, 'wastage_qty');   ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'date'); ?></td>
                        <td>
                            <?php
                            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                            $dateTimePickerConfig1 = array(
                                'model' => $model,
                                'attribute' => 'date',
                                'mode' => 'date',
                                'language' => 'en-AU',
                                'options' => array(
                                    'changeMonth' => 'true',
                                    'changeYear' => 'true',
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array("class" => "coloredInput"),
                            );
                            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'date'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Store</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Stores::model()->storeName(end($data)->store); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Input Machine</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Machines::model()->nameOfThis(end($data)->machine); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                            <?php
                            echo CHtml::submitButton('Save', array('onclick' => 'loadingDivDisplay();'));
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
    <style>
        div.errorMessage {
            color: springgreen;
        }
    </style>
    <script>
        $('#wastage_qty').bind('keyup', function () {
            var wastage_qty = parseFloat(('0' + $('#wastage_qty').val()).replace(/[^0-9-\.]/g, ''), 10);
            var input_qty = parseFloat(('0' + $('#input_qty').val()).replace(/[^0-9-\.]/g, ''), 10);
            if (input_qty < wastage_qty) {
                alertify.alert("Warning! Wastage quantity exceeds");
                $('#wastage_qty').val(input_qty);
            }
        });
        function loadingDivDisplay(e) {
            $("#ajaxLoaderMR").show();
        }
        function closeMe() {
            window.opener = self;
            window.close();
        }

        $(document).ready(function () {
            ion.sound({
                sounds: [
                    {name: "beep"}
                ],
                path: "<?php echo Yii::app()->theme->baseUrl; ?>/sounds/",
                preload: true,
                volume: 1.0
            });

            $(".soundBtn").click(function () {
                ion.sound.play("beep");
            });
        })
    </script>
    <?php
} else {
    $this->redirect(array('/doubliMachinProductionWastage/adminWastage'));
}
?>
