<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-procurement-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Procurement</legend>
    <table>
        <tr>
            <td>
                <label>Procurement No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('purchaseProcurement/procurementPreview'), array(
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
                    'href' => Yii::app()->createUrl('purchaseProcurement/procurementPreview'),
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
        'title' => 'Purchase Procurement Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<fieldset style="float: left; width: 98%;">
    <legend>Purchase Procurements</legend>
    <?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
    <?php
        echo CHtml::link('Make purchase order for the selected items', "", // the link for open the dialog
                array(
            'class' => 'additionalBtn',
            'onclick' => "{transferAll();}"));
        ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'purchase-procurement-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-procurement-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'selectableRows' => 2,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            array(
                'name' => 'is_ordered',
                'value' => 'PurchaseOrder::model()->isOrdered($data->is_ordered)',
                'filter' => array(1 => "Order Completed", 0 => "Order Not Compledted"),
            ),
            'sl_no',
            'date',
            array(
                'name' => 'store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'supplier_id',
                'value' => 'Suppliers::model()->supplierName($data->supplier_id)',
                'filter' => CHtml::listData(Suppliers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'order_type',
                'value' => 'Lookup::item("order_type", $data->order_type)',
                'filter' => Lookup::items("order_type"),
            ),
            array(
                'name' => 'order_sub_type',
                'value' => 'Lookup::item("order_sub_type", $data->order_sub_type)',
                'filter' => Lookup::items("order_sub_type"),
            ),
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), "id", "nameWithDesc"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            array(
                'name' => 'department',
                'value' => 'Departments::model()->nameOfThis($data->department)',
                'filter' => CHtml::listData(Departments::model()->findAll(array('order'=>'department_name ASC')), 'id', 'department_name'),
            ),
            'qty',
               array(
                'name' => 'name_of_unit',
                'value' => 'Units::model()->name_of_unitOfThis($data->name_of_unit)',
                'filter' => CHtml::listData(Units::model()->findAll(array('order'=>'name_of_unit ASC')), 'id', 'name_of_unit'),
            ),
            'cost',
            array(
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;')
            ),
            array(
                'name' => 'id',
                'header' => 'Remaining Qty for PO',
                'value' => '($data->qty-PurchaseOrder::model()->totalPOQtyForThis($data->id))',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTransferSelected',
    'options' => array(
        'title' => 'Purchase Order Form',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function transferAll(){
        
        var atLeastOneIsChecked = $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one item to create PO');
        }else{
            var selectedArr = new Array();
                
            $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').each(function() { //loop through each checkbox
                if(this.checked){
                    //alert($(this).val());
                    selectedArr.push($(this).val());
                }
            });
                
            $('#dialogTransferSelected').dialog('destroy'); 
            $('#dialogTransferSelected').dialog({ autoOpen: false, resizable: false, title: 'Purchase Order', width: 'auto', modal: true }); 
            $('#dialogTransferSelected').dialog('open');
<?php
echo CHtml::ajax(array(
    'url' => array('purchaseOrder/createFromSelected'),
    'data' => "js:{'selectedArr':''+selectedArr+''}",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $.fn.yiiGridView.update('purchase-procurement-grid', {
                                data: $(this).serialize()
                            });
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                }",
));
?>;
        }
                
        
        return false; 
    } 
    
    function transferAllAgain(){
        var atLeastOneIsChecked = $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one item to create PO');
        }else{
            var dataString = '';
                            
<?php
echo CHtml::ajax(array(
    'url' => array('purchaseOrder/createFromSelected'),
    'data' => "js:dataString+$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $.fn.yiiGridView.update('purchase-procurement-grid', {
                                data: $(this).serialize()
                            });
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                                                    }",
));
?>;
        } 
        return false; 
    } 
           
</script> 
