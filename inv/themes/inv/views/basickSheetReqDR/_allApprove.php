<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'basick-sheet-req-dr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Approve Form</legend>
        <table class="checkoutTab">
            <?php if($reqInfo){ ?>
            <tr>
                <td style="text-align: right;"><label>Req No</label></td>
                <td><div class="receivedByDiv"><?php echo end($reqInfoMain)->sl_no; ?></div></td>
                <td style="text-align: right;"><label>Req Date</label></td>
                <td><div class="receivedByDiv"><?php echo end($reqInfoMain)->req_date; ?></div></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Req. from</label></td>
                <td><div class="receivedByDiv"><?php echo Stores::model()->storeNameAndAddr(end($reqInfoMain)->from_store); ?></div></td>
                <td style="text-align: right;"><label>Req. to</label></td>
                <td><div class="receivedByDiv"><?php echo Stores::model()->storeNameAndAddr(end($reqInfoMain)->store); ?></div></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Department</label></td>
                <td><div class="receivedByDiv"><?php echo Departments::model()->nameOfThis(end($reqInfoMain)->department); ?></div></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Item</th>
                <th>Stock Qty (Main Inventory)</th>
                <th>Stock Qty (Temporary Inventory)</th>
                <th>Requisition Qty</th>
                <th>Delivered Qty</th>
            </tr>
            <?php $i = 0;
            foreach ($reqInfo as $soi): ?>
                <?php
                echo $form->hiddenField($model, 'id[]', array('value' => $soi->id));
                echo $form->hiddenField($model, 'req_id[]', array('value' => $soi->req_id));
                $rInfo = BasickSheetRequisition::model()->findByPk($soi->req_id);
                $itemInfo = Items::model()->findByPk($rInfo->item);
                if ($itemInfo) {
                    $itemName = $itemInfo->name;
                    $itemUnit = $itemInfo->unit;
                    $itemDesc = $itemInfo->desc;
                } else {
                    $itemName = "<font color='red'>Removed!</font>";
                    $itemUnit = "";
                    $itemDesc = "";
                }
                $stockQtyMainInventory=Inventory::model()->presentStockOfThisItem($rInfo->item, $rInfo->store);
                $stockQtyStoreInventory=  StoreInventory::model()->presentStockOfThisItem($rInfo->item, $rInfo->store);
                ?>
                <tr>
                    <td style="text-align: left;"><?php echo $itemName . " (" . $itemUnit . ")- " . $itemDesc; ?></td>
                    <td style="text-align: center;"><?php echo $stockQtyMainInventory; ?></td>
                    <td style="text-align: center;"><?php echo $stockQtyStoreInventory; ?></td>
                    <td style="text-align: center;"><?php echo $rInfo->qty; ?></td>
                    <td style="text-align: center;"><?php echo $soi->d_qty; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
                <?php }else{ ?>
                <tr>
                    <td colspan="3">All items approved already !</td>
                </tr>
                <?php } ?>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Approve', array('id' => 'rcvBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#rcvBtn").click(function(){
            $("#ajaxLoaderMR").show();
        });
    })
</script>
<?php $this->endWidget(); ?>
