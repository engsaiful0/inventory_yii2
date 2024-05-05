<?php
$data = Pos::model()->findAll(array("condition" => "inv_no='" . $inv_no . "'"));
if ($data) {
    ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/pos/css/pos.css" type="text/css" media="screen" />
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.manual-button').click(function(){
            $('.manual-page').toggle();
            $('#item_code').focus();
            return false;
    });
    $('#option-button').click(function(){
            $('#option-page').toggle();
            $('#item_code').focus();
            return false;
    });
");
    ?>
    <div class="manual-page" style="display:none">
        <?php $this->renderPartial('_manual'); ?>
    </div>
    <div class="manual-page" id="option-page" style="display:none">
        <?php $this->renderPartial('_option', array('model' => $modelMembers)); ?>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'pos-form',
                'action' => $this->createUrl('pos/updateFromPos'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true),
            ));

    $pointAddAfterAmount = 0;
    $pointAdd = 0;
    $overAmount = 0;
    $eachPointAmount = 0;
    $usableAfterPoint = 0;
    $activePointConf = MemberPointsConf::model()->findByAttributes(array('is_active' => MemberPointsConf::ACTIVE));
    if ($activePointConf) {
        $pointAddAfterAmount = $activePointConf->point_add_after_amount;
        $pointAdd = $activePointConf->point_add;
        $overAmount = $activePointConf->over_amount;
        $eachPointAmount = $activePointConf->each_point_amount;
        $usableAfterPoint = $activePointConf->usable_after_point;
    }

    $yourCompanyInfo = YourCompany::model()->findByAttributes(array('is_active' => YourCompany::ACTIVE,));
    if ($yourCompanyInfo) {
        $yourCompanyName = $yourCompanyInfo->company_name;
        $yourCompanyVatRegNo = $yourCompanyInfo->vat_regi_no;
        $yourCompanyLocation = $yourCompanyInfo->location;
        $yourCompanyContact = $yourCompanyInfo->contact;
        $yourCompanyEmail = $yourCompanyInfo->email;
        $yourCompanyWeb = $yourCompanyInfo->web;
        $yourCompanyVat = $yourCompanyInfo->vat_amount;
    } else {
        $yourCompanyName = '';
        $yourCompanyVatRegNo = '';
        $yourCompanyLocation = '';
        $yourCompanyContact = '';
        $yourCompanyEmail = '';
        $yourCompanyWeb = '';
        $yourCompanyVat = '';
    }
    ?>
    <script>
        var pointAddAfterAmount=<?php echo $pointAddAfterAmount; ?>;
        var pointAdd=<?php echo $pointAdd; ?>;
        var overAmount=<?php echo $overAmount; ?>;
        var eachPointAmount=<?php echo $eachPointAmount; ?>;
    </script>
    <input type="hidden" name="Pos[date]" value="<?php echo end($data)->date; ?>"/>
    <input type="hidden" name="Pos[time]" value="<?php echo end($data)->time; ?>"/>
    <input type="hidden" name="Pos[month]" value="<?php echo end($data)->month; ?>"/>
    <input type="hidden" name="Pos[year]" value="<?php echo end($data)->year; ?>"/>
    <input type="hidden" name="Pos[initiated_by]" value="<?php echo end($data)->initiated_by; ?>"/>
    <input type="hidden" name="Pos[authorized_by]" value="<?php echo end($data)->authorized_by; ?>"/>
    <input type="hidden" name="Pos[max_inv_no]" value="<?php echo end($data)->max_inv_no; ?>"/>
    <input type="hidden" name="Pos[inv_no]" value="<?php echo end($data)->inv_no; ?>"/>
    <input type="hidden" name="Pos[update_auth_by]" value="<?php echo Yii::app()->session['update_authorized_by']; ?>"/>
    <input type="hidden" name="Pos[store_id]" value="<?php echo end($data)->store_id; ?>"/>
    <div class="posWrapper" id="secondDisplay">
        <div class="divSec">
            <div class="leftDiv">
                <table class="posCheckoutTab">
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <th style="width: 10%;"></th>
                        <th style="text-align: left; padding-left: 2px; width: 50%;">Item</th>
                        <th>MRP</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>
                </table>
                <script>
                    var sl=0;
                    var newArr=new Array();
                </script>
                <div class="scrollableDiv" id="scrollableDivLeft">
                    <table class="posCheckoutTab" id="tbl">
                        <tr></tr>
                        <?php $sl = 1; ?>
                        <?php foreach ($data as $d) { ?>
                            <?php
                            $readyProducts = Items::model()->findByPk($d->item_id);
                            if ($readyProducts) {
                                $id = $readyProducts->id;
                                $cat = Cats::model()->nameOfThis($readyProducts->cat);
                                $catSub = CatsSub::model()->nameOfThis($readyProducts->cat_sub);
                                $name = $readyProducts->name;
                                $code = $readyProducts->code;
                                $desc = $readyProducts->desc;
                                $unit = $readyProducts->unit;
                                $isVatable = $readyProducts->vatable;

                                $item = $name . " (" . $code . ")";
                                if ($catSub != "")
                                    $item.="- " . $catSub;
                                $item.="- " . $cat;
                                if ($desc != "")
                                    $item.="- " . $desc;
                                if ($unit != "")
                                    $item.="- " . $unit;
                            } else {
                                $item = "";
                                $isVatable = "";
                            }
                            ?>
                            <tr class='cartList'>
                            <script>
                                sl='<?php echo $sl; ?>';
                                newArr[sl]='<?php echo $d->item_id; ?>';
                            </script>
                            <input type='hidden' name='Pos[temp_item_id][]' value='<?php echo $d->item_id; ?>'/>
                            <td style='width: 10%;'>
                                <input title="remove" id='<?php echo $sl; ?>' type="button" class="rdelete dltBtn"/>
                            </td>
                            <td style='text-align: left; padding-left:2px; width: 50%;'> 
                                <?php echo $item; ?>
                            </td>
                            <td>
                                <input id='priceInpt_<?php echo $sl; ?>' myAttr1='priceInpt_' myAttr2='<?php echo $sl; ?>' class='noWidthInput notEditable' type='text' name='Pos[temp_price][]' value='<?php echo $d->price; ?>'/>
                            </td>
                            <td>
                                <input id='qtyInpt_<?php echo $sl; ?>' onClick='me(<?php echo $sl; ?>); calFnc(<?php echo $sl; ?>);' myAttr1='qtyInpt_' myAttr2='<?php echo $sl; ?>' class='noWidthInput' type='text' name='Pos[temp_qty][]' value='<?php echo number_format($d->qty, 3); ?>'>
                            </td>
                            <td>
                                <?php
                                $lineTotal = $d->qty * $d->price;
                                if ($isVatable == 1) {
                                    $vat = ($yourCompanyVat/100);
                                } else {
                                    $vat = 0;
                                }
                                $lineTotalVA = $lineTotal + ($lineTotal * $vat);
                                ?>
                                <input id='lineTtlInpt_<?php echo $sl; ?>' class='noWidthInput lineTotalInpt notEditable' type='text' value='<?php echo number_format($lineTotal, 2); ?>'/>
                                <input id='lineTtlInptVA_<?php echo $sl; ?>' class='noWidthInput lineTotalInptVA notEditable' type='hidden' value='<?php echo $lineTotalVA; ?>'/>
                                <input id='isVatable_<?php echo $sl; ?>' type='hidden' value='<?php echo $isVatable; ?>'/>
                            </td>
                            </tr>
                            <script>
                                $(document).ready(function(){
                                    $('#cashTotal').val( $('input.lineTotalInptVA').sumValues().toFixed(2) );
                                    calFnc(<?php echo $sl; ?>);
                                    $("input.lineTotalInpt").css("background-color", "#D7D7D7");
                                    $("input.lineTotalInpt").focus(function(){
                                        $(this).blur();         
                                    }); 
                                });
                            </script>
                            <?php $sl++; ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="rightDiv">
                <table class="posCheckoutTab">
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <th style="color: LightGreen;">
                            <span id="orderNo">
                                <?php
                                echo "Invoice No:" . end($data)->inv_no;
                                ?>
                            </span>
                        </th>
                        <th style="color: LightGreen;">
                            <?php echo CHtml::link('', '#', array('class' => 'manual-button', 'id' => 'manual-button', 'title' => 'HELP')); ?>
                            <?php echo CHtml::link('Members', '#', array('class' => 'member-button', 'id' => 'option-button', 'title' => 'MEMBER OPTIONS')); ?>
                        </th>
                        <th style="color: LightGreen;">
                            Date: 
                            <?php
                            echo end($data)->date;
                            ?>
                        </th>
                        <th style="color: LightGreen;">
                            <?php
                            echo end($data)->time;
                            ?>
                        </th>
                        <th style="text-align: right; color: LightGreen;">
                            <?php echo MachineNames::model()->onlyNameOfThis(end($data)->machine_id); ?>
                        </th>
                        <th style="text-align: right; color: LightGreen;">
                            <?php echo Users::model()->fullNameOfThisOnlyName(end($data)->initiated_by); ?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div class="scrollableDiv" id="scrollableDivRight">
                                <?php
                                $cats = Cats::model()->findAll(array('order' => 'name ASC'));
                                if ($cats) {
                                    foreach ($cats as $cts) {
                                        ?>
                                        <div class="posItemCats categories soundBtn" id="cat_<?php echo $cts->id; ?>">
                                            <span class="prodTitle">
                                                <?php
                                                $catName = $cts->name;
                                                echo $catName;
                                                ?>
                                            </span>
                                        </div>
                                        <?php
                                        $subCats = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' GROUP BY cat_sub ORDER BY cat_sub ASC'));
                                        if ($subCats) {
                                            ?>
                                            <div class="subCatsOfThisCat" id="subCat_cat_<?php echo $cts->id; ?>" style="display: none;">
                                                <?php
                                                foreach ($subCats as $subCat) {
                                                    if ($subCat->cat_sub != "") {
                                                        ?>
                                                        <div class="posItemCats subCategories soundBtn" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>">
                                                            <span class="prodTitle">
                                                                <?php
                                                                $subCatName = CatsSub::model()->nameOfThis($subCat->cat_sub);
                                                                echo $subCatName;
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                        $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' AND cat_sub=' . $subCat->cat_sub . ' ORDER BY name ASC'));
                                                        if ($items) {
                                                            ?>
                                                            <div class="items" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>_item" style="display: none;">
                                                                <?php
                                                                foreach ($items as $itms) {
                                                                    $costingPrice = SellingPrice::model()->activeSellingPrice($itms->id);

                                                                    $id = $itms->id;
                                                                    $cat = $catName;
                                                                    $catSub = $subCatName;
                                                                    $name = $itms->name;
                                                                    $code = $itms->code;
                                                                    $desc = $itms->desc;
                                                                    $unit = $itms->unit;
                                                                    $isVatable = $itms->vatable;

                                                                    $item = $name . " (" . $code . ")";
                                                                    if ($catSub != "")
                                                                        $item.="- " . $catSub;
                                                                    $item.="- " . $cat;
                                                                    if ($desc != "")
                                                                        $item.="- " . $desc;
                                                                    if ($unit != "")
                                                                        $item.="- " . $unit;
                                                                    ?>
                                                                    <?php if ($costingPrice != 0) { ?>
                                                                        <div class="posItemCats itms soundBtn" id="itemCode_<?php echo $code; ?>" itemId="<?php echo $id; ?>" name="<?php echo $item; ?>" qtyUnit="<?php echo $unit; ?>" price="<?php echo $costingPrice; ?>" isVatableItem="<?php echo $isVatable; ?>">
                                                                            <span class="prodTitle">
                                                                                <?php echo $item; ?>
                                                                            </span>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div class="posItemCats itms soundBtn" id="" itemId="" name="" qtyUnit="" price="" isVatableItem="">
                                                                            <span class="prodTitle">
                                                                                <?php echo $item; ?>
                                                                                <span class="colorSpan">
                                                                                    No sell price !
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' AND cat_sub is NULL ORDER BY name ASC'));
                                                        if ($items) {
                                                            ?>
                                                            <div class="items itemsWithNoSubCat" id="cat_<?php echo $cts->id; ?>_subCat_no_item" style="display: none;">
                                                                <?php
                                                                foreach ($items as $itms) {
                                                                    $costingPrice = SellingPrice::model()->activeSellingPrice($itms->id);

                                                                    $id = $itms->id;
                                                                    $cat = $catName;
                                                                    $catSub = "";
                                                                    $name = $itms->name;
                                                                    $code = $itms->code;
                                                                    $desc = $itms->desc;
                                                                    $unit = $itms->unit;
                                                                    $isVatable = $itms->vatable;

                                                                    $item = $name . " (" . $code . ")";
                                                                    if ($catSub != "")
                                                                        $item.="- " . $catSub;
                                                                    $item.="- " . $cat;
                                                                    if ($desc != "")
                                                                        $item.="- " . $desc;
                                                                    if ($unit != "")
                                                                        $item.="- " . $unit;
                                                                    ?>
                                                                    <?php if ($costingPrice != 0) { ?>
                                                                        <div class="posItemCats itms soundBtn" id="itemCode_<?php echo $code; ?>" itemId="<?php echo $id; ?>" name="<?php echo $item; ?>" qtyUnit="<?php echo $unit; ?>" price="<?php echo $costingPrice; ?>" isVatableItem="<?php echo $isVatable; ?>">
                                                                            <span class="prodTitle">
                                                                                <?php echo $item; ?>
                                                                            </span>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div class="posItemCats itms soundBtn" id="" itemId="" name="" qtyUnit="" price="" isVatableItem="">
                                                                            <span class="prodTitle">
                                                                                <?php echo $item; ?>
                                                                                <span class="colorSpan">
                                                                                    (No sell price !)
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        //$grandTotal = ((end($data)->cash_payment - end($data)->cash_return) + end($data)->visa_payment + end($data)->master_payment + end($data)->amex_payment + end($data)->gift_card_payment);
        ?>
        <div class="divSec">
            <table class="numPadTab">
                <tr>
                    <td><span id="addedProdUp" class="navBtn scrlUp soundBtn"/></span></td>
                    <th><span id="changeDiscountType">
                            DISCOUNT (<?php
    if (end($data)->discount_type == 0)
        echo "Amount"; else
        echo "%";
        ?>)
                        </span></th>
                    <td>
                        <input type="text" id="cashOverallDisc" name="Pos[overall_discount]" value="<?php echo end($data)->overall_discount; ?>" class="posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <th>TOTAL</th>
                    <td>
                        <input type="text" id="cashTotal" name="Pos[cashTotal]" value="" class="coloredInpt posCashPaidReturn notEditable"/>
                        <input type="hidden" id="cashOverallDiscType" name="Pos[discount_type]" value="<?php echo end($data)->discount_type; ?>"/>
                    </td>
                    <th>RETURN AMOUNT</th>
                    <td>
                        <input type="text" id="cashReturn" name="Pos[cash_return]" value="<?php echo end($data)->cash_return; ?>" class="coloredInpt posCashPaidReturn notEditable"/>
                    </td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn7" attrVl="7" value="7"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn8" attrVl="8" value="8"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn9" attrVl="9" value="9"/></td>
                    <td rowspan="2"><input type="button" class="main_menuBtn soundBtn" value="Main Menu"/></td>
                    <td><span style="float: right;" id="prodUp" class="navBtn scrlUp soundBtn"/></span></td>
                </tr>
                <tr>
                    <td><span id="addedProdDn" class="navBtn scrlDn soundBtn"/></span></td>
                    <th>CASH</th>
                    <td>
                        <input type="text" id="cashPayment" name="Pos[cash_payment]" value="<?php echo end($data)->cash_payment; ?>" class="paymentCat posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <th>VISA</th>
                    <td>
                        <input type="text" id="visaPayment" name="Pos[visa_payment]" value="<?php echo end($data)->visa_payment; ?>" class="paymentCat posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <th>MASTER</th>
                    <td>
                        <input type="text" id="masterPayment" name="Pos[master_payment]" value="<?php echo end($data)->master_payment; ?>" class="paymentCat posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn4" attrVl="4" value="4"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn5" attrVl="5" value="5"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn6" attrVl="6" value="6"/></td>
                    <td><span style="float: right;" id="prodDn" class="navBtn scrlDn soundBtn"/></span></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::image(Yii::app()->theme->baseUrl . "/css/pos/images/reload.png", '', array('title' => 'Re-Initialize', 'class' => 'resetBtn soundBtn')); ?></td>
                    <th>AMEX</th>
                    <td>
                        <input type="text" id="amexPayment" name="Pos[amex_payment]" value="<?php echo end($data)->amex_payment; ?>" class="paymentCat posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <th>GIFT CARD</th>
                    <td>
                        <input type="text" id="giftCardPayment" name="Pos[gift_card_payment]" value="<?php echo end($data)->gift_card_payment; ?>" class="paymentCat posCashPaidReturn numPadBtnInput"/>
                    </td>
                    <th>CODE</th>
                    <td>
                        <input type="text" id="item_code" class="itemCode numPadBtnInput"/>
                    </td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn1" attrVl="1" value="1"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn2" attrVl="2" value="2"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn3" attrVl="3" value="3"/></td>
                    <td><input type="button" class="closeBtn soundBtn" value="CLOSE" onclick="closeMe();"/></td>
                    <td rowspan="2">
                        <?php
                        echo CHtml::ajaxSubmitButton('Update', CHtml::normalizeUrl(array('pos/updateFromPos', 'inv_no' => end($data)->inv_no)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                        $("#option-page").hide();
                                        $("#manual-page").hide();
                                        $("#ajaxLoader").hide();
                                        if(data.status=="success"){
                                        lastCheckout="no";
                                        clickCount=0;
                                        scrollTop=0;
                                        alertify.alert("Return Amount: MRP "+data.changeDue);
                                        $("#cashOverallDiscType").val(data.discountType);
                                        $("#ajaxLoaderReport").show(); 
                                        $("#soReportDialogBox").dialog("open");
                                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                                        $("a#print-div").focus().click();
                                        $("#ajaxLoaderReport").hide();
                                        $(".categories").show();
                                        $(".subCatsOfThisCat").hide();
                                        $(".items").hide();
                                        
                                        $("#memberCardNoInput").val("");
                                        $("#memberPointAddInput").val("");
                                        $("#memberCardNo").val("");
                                        $("#memberPointAddHtml").html("");
                                        
                                        $("#memberCardNoInputForReduce").val("");
                                        $("#memberPointAddInputForReduce").val("");

                                        $("#formResultError").hide();
                                    }else if(data.status=="errorBalance"){
                                        $("#formResultError").html("Please check Grand Total !");
                                    }else{
                                        $("#formResultError").html("Data not saved. Pleae solve the above errors !");
                                        $.each(data, function(key, val) {
                                            $("#pos-form #"+key+"_em_").html(""+val+"");                                                    
                                            $("#pos-form #"+key+"_em_").show();
                                        });
                                    } 
                                }',
                            'beforeSend' => 'function(){
                                       var paidTotal=$("input.paymentCat").sumValues();
                                       var cashReturn =parseFloat( ("0" + $("#cashReturn").val()).replace(/[^0-9-\.]/g, ""), 10 );
                                       var total=parseFloat( ("0" + $("#cashTotal").val()).replace(/[^0-9-\.]/g, ""), 10 );
                                       var actualPayable=(paidTotal-cashReturn).toFixed(2);

                                       if($("#Pos_store_id").val()==""){
                                            alertify.alert("Warning: No store is assigned to this user !");
                                            return false;
                                       }else if($("#pos_type").val()==""){
                                            alertify.alert("Warning: Please select a POS Type !");
                                            return false;
                                       }else if(total=="" || total<=0){
                                            alertify.alert("Warning: Please check total amount !");
                                            return false;
                                       }else if(paidTotal=="" || paidTotal<=0 || actualPayable!=total){
                                            alertify.alert("Warning: Please check payment amount !");
                                            return false;
                                       }else{
                                            clickCount++;
                                            if(clickCount==1){
                                                    if(total > pointAddAfterAmount){
                                                        if(lastCheckout=="yes"){
                                                            
                                                        }else{
                                                            $("#addPointDialogBox").dialog("open");
                                                            $("#pointAddPage").show();
                                                            $("#memberCardNo").focus();
                                                            
                                                            var totalAddablePoint=((total/overAmount)*pointAdd).toFixed();
                                                            
                                                            $("#memberPointAddInput").val(parseInt(totalAddablePoint));
                                                            $("#memberPointAddHtml").html(parseInt(totalAddablePoint));
                                                            clickCount=0;
                                                            return false;
                                                        }
                                                    }
                                            }else{
                                                alertify.alert("Processing please wait !");
                                                return false;
                                            }
                                        }
                                        $("#ajaxLoader").show();
                                 }'
                                ), array(
                            'class' => 'checkoutBtn soundBtn',
                            'id' => 'submitBtn',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
                        <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
                        <div id="ajaxLoader" style="display: none;"><img width="100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-bar.gif" /></div>
                    </td>
                    <td><input type="button" class="voidBtn soundBtn voidBtn" value="VOID"/></td>
                    <td></td>
                    <td><input type="button" class="updateBtn soundBtn updateBtn" value="UPDATE"/></td>
                    <td></td>
                    <td><input type="button" class="reprintBtn soundBtn reprintBtn" value="Re-Print"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn0" attrVl="0" value="0"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn00" attrVl="00" value="00"/></td>
                    <td><input type="button" class="numPadBtn soundBtn" id="numPadBtnDot" attrVl="." value="."/></td>
                    <td><input type="button" class="ersButton soundBtn" id="numPadBtnClr" attrVl="c" value="X"/></td>
                </tr>
            </table>
        </div>
    </div>

    <input type="hidden" id="memberCardNoInput" name="Pos[member_card_no]"/>
    <input type="hidden" id="memberPointAddInput" name="Pos[member_point_add]"/>

    <input type="hidden" id="memberCardNoInputForReduce" name="Pos[member_card_no_for_reduce]"/>
    <input type="hidden" id="memberPointAddInputForReduce" name="Pos[member_point_reduce]"/>

    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'addPointDialogBox',
        'options' => array(
            'title' => 'Enter member card number (if any)',
            'autoOpen' => false,
            'modal' => true,
            'resizable' => false,
            'position' => 'top',
            'width' => '306px',
        ),
    ));
    ?>              
    <div id='pointAddPage' class="" style="display:none;">
    <?php if ($activePointConf) { ?>
            <input type="text" id="memberCardNo" class="optionalInputsForPos"/>
            <font style="color: rebeccapurple; font-weight: bold; float: left; width: 100%; margin: 10px 0px;">Point Acquired: <span id="memberPointAddHtml"></span></font>
        <?php } else { ?>
            <div class="flash-error">No active point configuration found. Can not add point.</div>
    <?php } ?>
        <span id="lastCheckoutBtn">Checkout</span>
    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <script>
        $('#memberCardNo').bind('click keyup', function() {
            $('#memberCardNoInput').val($(this).val());
        });
        var lastCheckout="no";
        $("#lastCheckoutBtn").click(function(){
            lastCheckout="yes";
            $("#addPointDialogBox").dialog("close");
            $("#submitBtn").focus().click();
        });
    </script>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'soReportDialogBox',
        'options' => array(
            'title' => 'POS Invoice Preview',
            'autoOpen' => false,
            'modal' => true,
            'resizable' => false,
            'position' => 'top',
        ),
    ));
    ?>
    <div id="ajaxLoaderReport" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>                
    <div id='AjFlashReportSo' class="" style="display:none;">

    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <style>
        /*        .ui-widget-header .ui-icon {
                    float: right;
                    background: url("<?php echo Yii::app()->theme->baseUrl; ?>/css/pos/images/close.png") center transparent no-repeat;
                    width: 32px;
                    height: 32px;
                }
                .ui-dialog .ui-dialog-titlebar-close{
                    margin: -18px -5px 0px;
                }*/
    </style>
    <style>
        input[type="button"].closeBtn{
            box-shadow: unset;
            padding: 20px 0px;
            background:green;
            border:1px solid #000000;
            border-radius:35px;
            display:inline-block;
            color:yellow;
            font-size:16px;
            font-weight: bold;
            text-decoration:none;
            text-shadow:1px 1px 1px #000000;
            width: 100%;
        }
    </style>
    <script>
        var clickCount=0;
                                
        $(document).ready(function(){
            $("#changeDiscountType").click(function(){
                if($("#cashOverallDiscType").val()=='0'){
                    $("#cashOverallDiscType").val('1');
                    $("#changeDiscountType").html("Discount (%)");
                   
                    var netTotal=$('input.lineTotalInptVA').sumValues();
                    var overallDiscount=$('#cashOverallDisc').val();
                    overallDiscount=overallDiscount/100;
                    var grossTotal=(netTotal-(netTotal*overallDiscount));
                    $('#cashTotal').val(grossTotal.toFixed(2));
                    var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                    $('#cashReturn').val(changeDue.toFixed(2));
                }else{
                    $("#cashOverallDiscType").val('0');
                    $("#changeDiscountType").html("Discount (Amount)");
                    
                    var netTotal=$('input.lineTotalInptVA').sumValues();
                    var overallDiscount=$('#cashOverallDisc').val();
                    var grossTotal=(netTotal-overallDiscount);
                    $('#cashTotal').val(grossTotal.toFixed(2));
                    var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                    $('#cashReturn').val(changeDue.toFixed(2));
                }
            });
           
            $(".voidBtn").click(function(){
                window.open('<?php echo Yii::app()->baseUrl; ?>/pos/authorizationCheckVoid','_blank');
            });
            
            $(".updateBtn").click(function(){
                window.open('<?php echo Yii::app()->baseUrl; ?>/pos/authorizationCheckUpdate','_blank');
            });
            
            $(".reprintBtn").click(function(){
                window.open('<?php echo Yii::app()->baseUrl; ?>/pos/authorizationCheckReprint','_blank');
            });
            
            $("#homeBtn").click(function(e){
                e.preventDefault();
                $("#secondDisplay").hide();
                $("#firstDisplay").show();
            });
            
            $("#pos_in").click(function(e){
                e.preventDefault();
                $("#firstDisplay").hide();
                $("#secondDisplay").show();
                $("#item_code").focus();
            });
                    
            ion.sound({
                sounds: [
                    {name: "beep"}
                ],
                path: "<?php echo Yii::app()->theme->baseUrl; ?>/sounds/",
                preload: true,
                volume: 1.0
            });

            $(".soundBtn").click(function(){
                ion.sound.play("beep");
            });
            
            var scrollTopLeft=0;
            $('#addedProdDn').click(function() {
                scrollTopLeft=scrollTopLeft+118;
                $('#scrollableDivLeft').animate({
                    scrollTop: scrollTopLeft
                }, 200); 
            });
            $('#addedProdUp').click(function() {
                if(scrollTopLeft==0){
                      
                }else{
                    scrollTopLeft=scrollTopLeft-118;
                    $('#scrollableDivLeft').animate({
                        scrollTop: scrollTopLeft
                    }, 200);
                }
            });
            
            var scrollTopRight=0;
            $('#prodDn').click(function() {
                scrollTopRight=scrollTopRight+118;
                $('#scrollableDivRight').animate({
                    scrollTop: scrollTopRight
                }, 200);
            });
            $('#prodUp').click(function() {
                if(scrollTopRight==0){
                      
                }else{
                    scrollTopRight=scrollTopRight-118;
                    $('#scrollableDivRight').animate({
                        scrollTop: scrollTopRight
                    }, 200);
                }
            });
            
            $(".categories").click(function(){
                var thisCatId=$(this).attr("id");
                $(".categories").hide();
                $(".subCategories").show();
                $("#subCat_"+thisCatId).show();
                $("#"+thisCatId+"_subCat_no_item").show();
            });
            $(".subCategories").click(function(){
                var thisSubCatId=$(this).attr("id");
                $(".subCategories").hide();
                $(".itemsWithNoSubCat").hide();
                $("#"+thisSubCatId+"_item").show();
            });
            $(".main_menuBtn").click(function(){
                $(".categories").show();
                $(".subCatsOfThisCat").hide();
                $(".items").hide();
            });
            
            $(".resetBtn").click(function(){
                scrollTopLeft=0;
                scrollTopRight=0;
                $(".categories").show();
                $(".subCatsOfThisCat").hide();
                $(".items").hide();
                newArr.length=0;
                $("#tbl tr.cartList").remove();
                sl=0;
                $(".paymentCat").val("0");
                $("#cashReturn").val("0");
                $("#cashOverallDisc").val("0");
                $("#cashTotal").val("0");
                $("#item_code").val("");
                $("#item_code").focus();
            });
            
            $('#cashOverallDisc').bind('click keyup', function() {
                //var grossTotal=$('input.lineTotalInpt').sumValues();
                var grossTotal=$('input.lineTotalInptVA').sumValues();
                
                var overallDiscount=$(this).val();
                if($("#cashOverallDiscType").val()=='0'){
                    var netTotal=(grossTotal-overallDiscount);
                }else{
                    overallDiscount=overallDiscount/100;
                    var netTotal=(grossTotal-(grossTotal*overallDiscount));
                }
                
                $('#cashTotal').val(netTotal.toFixed(2));
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            });
            
            $('.paymentCat').bind('click keyup', function(){
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            });
            
            $(".itms").click(function(){
                
                var itemsId=$(this).attr("itemId");
                var itemsName=$(this).attr("name");
                var itemsPrice=$(this).attr("price");
                var isVatableItems=$(this).attr("isVatableItem");
                var itemsQty=1;
                if(itemsId!=''){
                    $(".paymentCat").val("0");
                    $('#cashReturn').val('0');
                    $('#cashOverallDisc').val('0');
                    $('#cashTotal').val('0');
                    
                    if($.inArray(itemsId, newArr) > -1){
                        var newQty=itemsQty;
                        var positionOfArrVal=newArr.indexOf(itemsId);
                        newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                        $("#qtyInpt_"+positionOfArrVal).val(newQty.toFixed(3));

                        var tempQty= $("#qtyInpt_"+positionOfArrVal).val();
                        var tempSp= $("#priceInpt_"+positionOfArrVal).val();

                        var tempTotal=(tempQty*tempSp);
                        $('#lineTtlInpt_'+positionOfArrVal).val(tempTotal.toFixed(2));
                        //var netTotal=$('input.lineTotalInpt').sumValues();
                        //$('#cashTotal').val(netTotal);
                        
                        if(isVatableItems==1){
                            var vat='<?php echo ($yourCompanyVat/100); ?>';
                        }else{
                            var vat=0;
                        }
                        var tempTotalVA=tempTotal+(tempTotal*vat);
                        $('#lineTtlInptVA_'+positionOfArrVal).val(tempTotalVA.toFixed(2));
                        
                        var netTotal=$('input.lineTotalInptVA').sumValues();
                        $('#cashTotal').val(netTotal.toFixed(2));

                    }else{
                        add(itemsId, itemsName, itemsPrice, isVatableItems, itemsQty);
                        newArr[sl]=itemsId;
                    }
                }
            });
            
            $('input#item_code').keypress(function(e) {
                if (e.which == '13') {
                    e.preventDefault();
                    if($('input#item_code').val()==""){
                        alertify.alert("Please enter correct item code !");
                        $("#item_code").focus();
                    }else{
                        $('input#item_code').focus().select();
                        $(".paymentCat").val("0");
                        $('#cashReturn').val('0');
                        $('#cashOverallDisc').val('0');
                        $('#cashTotal').val('0');

                        var itemsId=$("#itemCode_"+$('input#item_code').val()).attr("itemId");
                        var elemIdPosfix=$('input#item_code').val();
                        var itemsQty=1;
                        
                        if(itemsId===undefined){
                            var itemsId=$("#itemCode_"+$('input#item_code').val().substr(2,5)).attr("itemId");
                            var elemIdPosfix=$('input#item_code').val().substr(2,5);
                            
                            var itemsQty=(($('input#item_code').val().substr(7,5))/1000);
                            
                            itemsQty=parseFloat( ('0' + itemsQty).replace(/[^0-9-\.]/g, ''), 10 );
                            
                            if(itemsId===undefined){
                                alertify.alert("Please enter correct item code !");
                            }else{
                                addItemIfFound(itemsId, elemIdPosfix, itemsQty);
                            }
                        }else if(itemsId===null){
                            alertify.alert("Please enter correct item code !");
                        }else{
                            addItemIfFound(itemsId, elemIdPosfix, itemsQty);
                        }
                    }  
                }
            });
        });
        
        function addItemIfFound(itemsId, elemIdPosfix, itemsQty){
            var itemsName=$("#itemCode_"+elemIdPosfix).attr("name");
            var itemsPrice=$("#itemCode_"+elemIdPosfix).attr("price");
            var isVatableItems=$("#itemCode_"+elemIdPosfix).attr("isVatableItem");

            if($.inArray(itemsId, newArr) > -1){
                var newQty=itemsQty;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                
                $("#qtyInpt_"+positionOfArrVal).val(newQty.toFixed(3));

                var tempQty= $("#qtyInpt_"+positionOfArrVal).val();
                var tempSp= $("#priceInpt_"+positionOfArrVal).val();

                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+positionOfArrVal).val(tempTotal.toFixed(2));
                //var netTotal=$('input.lineTotalInpt').sumValues();
                //$('#cashTotal').val(netTotal);

                if(isVatableItems==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var tempTotalVA=tempTotal+(tempTotal*vat);
                $('#lineTtlInptVA_'+positionOfArrVal).val(tempTotalVA);

                var netTotal=$('input.lineTotalInptVA').sumValues();
                $('#cashTotal').val(netTotal.toFixed(2));

            }else{
                add(itemsId, itemsName, itemsPrice, isVatableItems, itemsQty);
                newArr[sl]=itemsId;
            }
        }
        
        //-----------------------------------------------------
        
        $("#tbl td input.rdelete").live("click", function () {
            $(".paymentCat").val("0");
            $('#cashReturn').val('0');
            $('#cashOverallDisc').val('0');
            var idCounter=$(this).attr("id");
            
            var netTotal=$('input.lineTotalInptVA').sumValues();
            grandTotal=netTotal-$('#lineTtlInptVA_'+idCounter).val();
            
            $("#cashTotal").val(grandTotal.toFixed(2));
            var srow = $(this).parent().parent();
            srow.remove();
            $("#tbl td.sno").each(function(index, element){                 
                $(element).text(index + 1); 
            });
            newArr[idCounter]=0;
        });
        
        
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
        
        
        function add(itemsId, itemsName, itemsPrice, isVatableItems, itemsQty){
            
            //itemsQty=(Math.round(itemsQty * 100)/100).toFixed(2);
            
            sl++;
            var slNumber=$('#tbl tr').length;
            
            var appendTxt = "<tr class='cartList'>"+
                "<input type='hidden' name='Pos[temp_item_id][]' value='"+itemsId+"'>"+
                "</td><td style='width: 10%;'>" +
                "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
                "</td><td style='text-align: left; padding-left:2px; width: 50%;'>" + 
                itemsName +
                "</td><td>" + 
                "<input id='priceInpt_"+sl+"' myAttr1='priceInpt_' myAttr2='"+sl+"' class='noWidthInput notEditable' type='text' name='Pos[temp_price][]' value='"+itemsPrice+"'>"+
                "</td><td>" + 
                "<input id='qtyInpt_"+sl+"' onClick='me("+sl+")' myAttr1='qtyInpt_' myAttr2='"+sl+"' class='noWidthInput' type='text' name='Pos[temp_qty][]' value='"+itemsQty.toFixed(3)+"'>"+
                "</td><td>" +
                "<input id='lineTtlInpt_"+sl+"' class='noWidthInput lineTotalInpt notEditable' type='text' value='0'>"+
                "<input id='lineTtlInptVA_"+sl+"' class='noWidthInput lineTotalInptVA notEditable' type='hidden' value='0'>"+
                "<input id='isVatable_"+sl+"' type='hidden' value='"+isVatableItems+"'>"+
                "</td></tr>";
            $("#tbl tr:last").after(appendTxt);
            
            $(".notEditable").focus(function(){
                $(this).blur();         
            });
            
            var tempQty= $("#qtyInpt_"+sl).val();
            var tempSp= $("#priceInpt_"+sl).val();
            
            var tempTotal=(tempQty*tempSp);
            
            $('#lineTtlInpt_'+sl).val(tempTotal.toFixed(2));
            //var netTotal=$('input.lineTotalInpt').sumValues();
            //$('#cashTotal').val(netTotal);
            
            if(isVatableItems==1){
                var vat='<?php echo ($yourCompanyVat/100); ?>';
            }else{
                var vat=0;
            }
            var tempTotalVA=tempTotal+(tempTotal*vat);
            $('#lineTtlInptVA_'+sl).val(tempTotalVA);
            
            var netTotal=$('input.lineTotalInptVA').sumValues();
            $('#cashTotal').val(netTotal.toFixed(2));
            
            calFnc(sl);
        }
        var tabularInputId;
        function me(id){
            tabularInputId=id;
            focusedElem="qtyInpt_"+id;
        }
        
        var focusedElem;
        $("input.numPadBtnInput").click(function(){
            focusedElem=$(this).attr("id");
        });
        
        $(".numPadBtn").click(function(e) {
            e.preventDefault();
            var numPadBtnVal=$(this).attr("attrVl");
            var focusedElemVal=$("#"+focusedElem);
            focusedElemVal.val(focusedElemVal.val() + numPadBtnVal + '');
            if(focusedElem=="cashOverallDisc"){
                //var grossTotal=$('input.lineTotalInpt').sumValues();
                var grossTotal=$('input.lineTotalInptVA').sumValues();
                
                var overallDiscount=$("#"+focusedElem).val();
                if($("#cashOverallDiscType").val()=='0'){
                    var netTotal=(grossTotal-overallDiscount);
                }else{
                    overallDiscount=overallDiscount/100;
                    var netTotal=(grossTotal-(grossTotal*overallDiscount));
                }
                
                $('#cashTotal').val(netTotal.toFixed(2));
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            }else{
                var tempQty= $("#qtyInpt_"+tabularInputId).val();
                var tempSp= $("#priceInpt_"+tabularInputId).val();

                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+tabularInputId).val(tempTotal.toFixed(2));
                //var netTotal=$('input.lineTotalInpt').sumValues();
                //$('#cashTotal').val(netTotal);
                
                var isVatableItemsTemp=$('#isVatable_'+tabularInputId).val();
                if(isVatableItemsTemp==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var tempTotalVA=tempTotal+(tempTotal*vat);
                $('#lineTtlInptVA_'+tabularInputId).val(tempTotalVA.toFixed(2));
                var netTotal=$('input.lineTotalInptVA').sumValues();
                
                var overallDiscount=$('#cashOverallDisc').val();
                if($("#cashOverallDiscType").val()=='0'){
                    var grossTotal=(netTotal-overallDiscount);
                }else{
                    overallDiscount=overallDiscount/100;
                    var grossTotal=(netTotal-(netTotal*overallDiscount));
                }
                
                $('#cashTotal').val(grossTotal.toFixed(2));
                
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            }
        });
            
        $(".ersButton").click(function(e) {
            e.preventDefault();
            var focusedElemVal=$("#"+focusedElem);
            $reduceDval=focusedElemVal.val().slice(0, -1);
            focusedElemVal.val($reduceDval);
            if(focusedElem=="cashOverallDisc"){
                //var grossTotal=$('input.lineTotalInpt').sumValues();
                var grossTotal=$('input.lineTotalInptVA').sumValues();
                
                var overallDiscount=$("#"+focusedElem).val();
                if($("#cashOverallDiscType").val()=='0'){
                    var netTotal=(grossTotal-overallDiscount);
                }else{
                    overallDiscount=overallDiscount/100;
                    var netTotal=(grossTotal-(grossTotal*overallDiscount));
                }
                
                $('#cashTotal').val(netTotal.toFixed(2));
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            }else{
                var tempQty= $("#qtyInpt_"+tabularInputId).val();
                var tempSp= $("#priceInpt_"+tabularInputId).val();

                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+tabularInputId).val(tempTotal.toFixed(2));
                //var netTotal=$('input.lineTotalInpt').sumValues();
                //$('#cashTotal').val(netTotal);
                
                var isVatableItemsTemp=$('#isVatable_'+tabularInputId).val();
                if(isVatableItemsTemp==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var tempTotalVA=tempTotal+(tempTotal*vat);
                $('#lineTtlInptVA_'+tabularInputId).val(tempTotalVA.toFixed(2));
                var netTotal=$('input.lineTotalInptVA').sumValues();
                
                var overallDiscount=$('#cashOverallDisc').val();
                if($("#cashOverallDiscType").val()=='0'){
                    var grossTotal=(netTotal-overallDiscount);
                }else{
                    overallDiscount=overallDiscount/100;
                    var grossTotal=(netTotal-(netTotal*overallDiscount));
                }
                
                $('#cashTotal').val(grossTotal.toFixed(2));
                
                var changeDue=$('input.paymentCat').sumValues()-$("#cashTotal").val();
                $('#cashReturn').val(changeDue.toFixed(2));
            }
            
        });
        
        function calFnc(count){ 
            $('#priceInpt_'+count).bind('click keyup', function() {
                var sellPrc=$('#priceInpt_'+count).val();
                var sellQnty=$('#qtyInpt_'+count).val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_'+count).val(total);
                //var netTotal=$('input.lineTotalInpt').sumValues();
                //$('#cashTotal').val(netTotal);
                $(".paymentCat").val("0");
                $('#cashReturn').val('0');
                $('#cashOverallDisc').val('0');
                
                var isVatableItems=$('#isVatable_'+count).val();
                if(isVatableItems==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var totalVA=total+(total*vat);
                $('#lineTtlInptVA_'+count).val(totalVA.toFixed(2));
                
                var netTotal=$('input.lineTotalInptVA').sumValues();
                $('#cashTotal').val(netTotal.toFixed(2));
            });
            $('#qtyInpt_'+count).bind('click keyup', function() {
                var sellPrc=$('#priceInpt_'+count).val();
                var sellQnty=$('#qtyInpt_'+count).val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_'+count).val(total.toFixed(2));
                //var netTotal=$('input.lineTotalInpt').sumValues();
                //$('#cashTotal').val(netTotal);
                $(".paymentCat").val("0");
                $('#cashReturn').val('0');
                $('#cashOverallDisc').val('0');
                
                var isVatableItems=$('#isVatable_'+count).val();
                if(isVatableItems==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var totalVA=total+(total*vat);
                $('#lineTtlInptVA_'+count).val(totalVA.toFixed(2));
                
                var netTotal=$('input.lineTotalInptVA').sumValues();
                $('#cashTotal').val(netTotal.toFixed(2));
            });          
            $('#discountInpt_'+count).bind('click keyup', function() {
                var sellPrc=$('#priceInpt_'+count).val();
                var sellQnty=$('#qtyInpt_'+count).val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_'+count).val(total.toFixed(2));
                var netTotal=$('input.lineTotalInpt').sumValues();
                $('#cashTotal').val(netTotal.toFixed(2));
                $(".paymentCat").val("0");
                $('#cashReturn').val('0');
                $('#cashOverallDisc').val('0');
                
                var isVatableItems=$('#isVatable_'+count).val();
                if(isVatableItems==1){
                    var vat='<?php echo ($yourCompanyVat/100); ?>';
                }else{
                    var vat=0;
                }
                var totalVA=total+(total*vat);
                $('#lineTtlInptVA_'+count).val(totalVA.toFixed(2));
                
                var netTotal=$('input.lineTotalInptVA').sumValues();
                $('#cashTotal').val(netTotal.toFixed(2));
            });       
        }
        $(".notEditable").focus(function(){
            $(this).blur();         
        });
        
        jQuery(document).bind('click keypress', function(e) {
            if(e.keyCode==33){ // PAGE UP BUTTON key code
                $("#cashOverallDisc").focus().select();       
            }
            if(e.keyCode==34){ // PAGE DWN BUTTON key code
                $("#cashPayment").focus().select();         
            }
            if(e.keyCode==35){ // END BUTTON key code
                $("#submitBtn").focus().click();
                
            }       
        });
    </script>
    <?php
} else {
    $this->redirect(array('voidUpdate'));
}
?>
<script type="text/javascript">
    function closeMe(){
        window.opener = self;
        window.close();
    }
</script>
