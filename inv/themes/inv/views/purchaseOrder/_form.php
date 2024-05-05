<?php echo CHtml::link('Back', array('/purchaseOrder/adminPO'), array('class' => 'additionalBtn')); ?>
<?php echo CHtml::link('Manage PO', array('/purchaseOrder/admin'), array('class' => 'additionalBtn', 'style' => 'margin-left: 10px;')); ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'purchase-order-form',
            'action' => $this->createUrl('purchaseOrder/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Purchase Order Form</legend>
        <div class="scrollable" style="height: 350px;">
            <table class="headerTab">
                <?php
                $endDataPR = PurchaseRequisition::model()->findByPk(end($selectedItems));
                ?>
                <tr>
                    <td style="text-align: left; padding-bottom: 10px;"><b>Requisition No: </b><?php echo $endDataPR->sl_no; ?></td>
                    <td style="text-align: right; padding-bottom: 10px;"><b>Requisition Date: </b><?php echo $endDataPR->date; ?></td>
                </tr>
                <tr>
                    <td style="text-align: left; padding-bottom: 10px;"><b>Supplier: </b><?php echo Suppliers::model()->supplierName($endDataPR->supplier_id); ?></td>
                    <td style="text-align: right; padding-bottom: 10px;"><b>Local/Import: </b><?php echo Lookup::item('order_type', $endDataPR->order_type)." (".Lookup::item('order_sub_type', $endDataPR->order_sub_type).")"; ?></td>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: left; padding-bottom: 10px;">Following items are required as shown against each for department: <i><?php echo Departments::model()->nameOfThis($endDataPR->department); ?></i>, to store: <i><?php echo Stores::model()->storeName($endDataPR->store); ?></i></th>
                </tr>
            </table>
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">SL</th>
                    <th>Item</th>
                    <th>Specification</th>
                    <th>Present Stock</th>
                    <th>Requisition Qty</th>
                    <th>Unit</th>
                    <th>Cost/Unit</th>
                    <th>Approx Amount</th>
                    <th>Remarks</th>
                    <th>Order Qty</th>
                </tr>
                <?php
                $i = 1;
                $total = 0;
                ?>
                <?php foreach ($selectedItems as $selectedItem) { ?>
                    <?php $d = PurchaseRequisition::model()->findByPk($selectedItem); ?>
                    <?php
                    echo $form->hiddenField($model, 'requisition_id[]', array('value' => $selectedItem));
                    ?>
                    <tr class="<?php
                if ($i % 2 == 0)
                    echo 'odd'; else
                    echo 'even';
                    ?>">
                        <td><?php echo $i; ?></td>
                        <?php
                        $itemInfo = Items::model()->findByPk($d->item);
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
                        ?>
                        <td style="text-align: left;"><?php echo $itemName."<br>".$itemCat." - ".$itemSubCat; ?></td>
                        <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                        <td><?php echo number_format(floatval(Inventory::model()->presentStockOfThisItem($d->item, $d->store)), 2); ?></td>
                        <td><?php echo $d->qty; ?></td>
                        <td><?php echo $itemUnit; ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($d->cost), 2); ?></td>
                        <?php
                        $lineTotal = $d->cost * $d->qty;
                        $total = $total + $lineTotal;
                        ?>
                        <td style="text-align: right;"><?php echo number_format(floatval($lineTotal), 2); ?></td>
                        <td style="text-align: right;"><?php echo $d->remarks; ?></td>
                        <td><?php echo $form->textField($model, 'order_qty[]', array('id' => 'PurchaseOrder_order_qty_' . $i, 'value' => $d->qty)); ?></td>
                        <?php $i++; ?>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="7" style="text-align: right; padding-right: 6px;">Total</th>
                    <th style="text-align: right;"><?php echo number_format(floatval($total), 2); ?></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $amountInWord = new AmountInWord();
                ?>
                <tr>
                    <th colspan="8" style="text-align: right;">In Word: BDT <?php echo $amountInWord->convert(intval($total)); ?> Only</th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
        <div class="rightDiv" style="width: 100%;">
            <table>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'ref_no'); ?></td>
                    <td><?php echo $form->textField($model, 'ref_no', array('maxlength' => 255, 'class' => 'coloredInput')); ?></td>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'issue_date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'issue_date',
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
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%; padding: 10px 0px;',
                        ));
                        ?>
                    </td>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'subj'); ?></td>
                    <td><?php echo $form->textField($model, 'subj', array('maxlength' => 255, 'class' => 'coloredInput')); ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
                        <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
                    </td>
                    <td colspan="2">
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('purchaseOrder/create', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                    $("#ajaxLoader").hide();  
                                    if(data.status=="success"){
                                        $(".localOrderSubType").hide();
                                        $(".importOrderSubType").hide();
                                        errOQArr.length=0;
                                        $("#purchase-order-form")[0].reset();
                                        $("#formResultError").hide();
                                        $("#formResult").fadeIn();
                                        $("#formResult").html("Data saved successfully.");
                                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                                        $("#ajaxLoaderReport").show(); 
                                        $("#soReportDialogBox").dialog("open");
                                        $("#AjFlashReportSo").html(data.voucherPreview).show();
                                        $("#ajaxLoaderReport").hide();
                                        $.fn.yiiGridView.update("purchase-order-grid", {
                                                data: $(this).serialize()
                                        });
                                    }else{
                                        $("#formResult").hide();
                                        $("#formResultError").show();
                                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                                        $.each(data, function(key, val) {
                                            $("#purchase-order-form #"+key+"_em_").html(""+val+"");                                                    
                                            $("#purchase-order-form #"+key+"_em_").show();
                                        });
                                    }       
                }',
                            'beforeSend' => 'function(){  
                        if($("#PurchaseOrder_issue_date").val()==""){
                            alertify.alert("Please set issue date !");
                            return false;
                        }else{
                            for(var i=1; i<($("#tbl tr").length); i++){
                                if($("#PurchaseOrder_order_qty_"+i).val()==""){
                                    $("#PurchaseOrder_order_qty_"+i).css("border-color","red");
                                    errOQArr[i]="err_exist";
                                }else{
                                    $("#PurchaseOrder_order_qty_"+i).css("border-color","#aaa");
                                    errOQArr[i]="";
                                }
                            }
                            if($.inArray("err_exist", errOQArr)>-1){
                                alertify.alert("There is an empty field on items order quantity column !");
                                return false;
                            }else{
                                $("#ajaxLoader").show();
                            }
                        }
                }'
                        ));
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var errOQArr=new Array();
</script>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gridview/styles.css" type="text/css" media="screen" />
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Purchase Order Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

