<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('store-requisition-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Store Requisition</legend>
    <table>
        <tr>
            <td>
                <label>Requisition No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('storeRequisition/requisitionPreview'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       $('#ajaxLoaderReport').show();
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                                           $('#ajaxLoaderReport').hide(); 
                    }",
                    'data' => array('sl_no' => 'js:jQuery("#soForReport").val()')
                        ), array(
                    'href' => Yii::app()->createUrl('storeRequisition/requisitionPreview'),
                    'class' => 'additionalBtn'
                        )
                );
                ?>
                <span id="ajaxLoaderReport" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            </td>
        </tr>
    </table>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Store Requisition Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
?>
<fieldset style="float: left; width: 98%;">
    <legend>Make Purchase Requisition From Store Requisition</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'store-requisition-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'sl_no',
            'req_date',
            array(
                'name' => 'department',
                'value' => 'Departments::model()->nameOfThis($data->department)',
                'filter' => CHtml::listData(Departments::model()->findAll(array('order'=>'department_name ASC')), 'id', 'department_name'),
            ),
            array(
                'name' => 'req_by',
                'value' => 'Employees::model()->fullName($data->req_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            array(
                'name' => 'from_store',
                'value' => 'Stores::model()->storeName($data->from_store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), "id", "nameWithDesc"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'qty',
            array(
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;')
            ),
            array(
                'name' => 'id',
                'header' => 'Remaining Sendable Qty',
                'value' => '($data->qty-StoreReqDR::model()->availableQtyOfThisReqId($data->id))',
                'filter' => '',
            ),
//            array(
//                'name'=>'id',
//                'header'=>'Stock Qty (Temp)',
//                'value'=>'StoreInventory::model()->presentStockOfThisItem($data->item, $data->store)',
//                'filter'=>'',
//            ),
//            array(
//                'name'=>'id',
//                'header'=>'Stock Qty (Main)',
//                'value'=>'Inventory::model()->presentStockOfThisItem($data->item, $data->store)',
//                'filter'=>'',
//            ),
            array(
                'name' => 'sl_no',
                'header' => 'Create',
                'value' => 'StoreReqDR::model()->createPRAll($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php
    $condition = "req_date!='0000-00-00' GROUP BY sl_no";
    $poData = StoreRequisition::model()->findAll(array('condition' => $condition,), 'id');
    if($poData){
        foreach ($poData as $pod):
            $totalReceivedQty = StoreReqDR::model()->availableQtyOfThisReqId($pod->id);
                //$remaining_receive_qty = ($pod->qty - $totalReceivedQty);
                //if ($remaining_receive_qty > 0) {
            $sl_no = $pod->sl_no;
            echo '<script type="text/javascript">';
            echo 'function allDelivery' . $sl_no . '(){';
            echo CHtml::ajax(array(
                'url' => array('purchaseRequisition/reqFromStoreReq', 'sl_no' => $sl_no),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                    $('.ajaxLoaderViewDeliveryAll').show();
                }",
                'complete' => "function(){
                    $('.ajaxLoaderViewDeliveryAll').hide();
                }",
                'success' => "function(data){
                    if (data.status == 'failure'){
                        $.fn.yiiGridView.update('store-requisition-grid');
                        $('#deliveryAll-dialog div.deliveryAll-dialog-content').html(data.content);
                        $('#deliveryAll-dialog div.deliveryAll-dialog-content form').submit(allDelivery" . $sl_no . ");
                    }else{
                        $.fn.yiiGridView.update('store-requisition-grid');
                        $('#deliveryAll-dialog div.deliveryAll-dialog-content').html(data.content);
                        //setTimeout(\"$('#deliveryAll-dialog').dialog('close') \",1000);
                    }
                }",
            ));
            echo ';';
            echo 'return false;';
            echo '}';
            echo '</script>';
                //}
        endforeach;
    }
    ?>
    <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'deliveryAll-dialog',
    'options' => array(
        'title' => 'Create Purchase Requisition',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1240,
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderViewDeliveryAll" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>

<div class="deliveryAll-dialog-content"></div>
<?php $this->endWidget(); ?>
</fieldset>
