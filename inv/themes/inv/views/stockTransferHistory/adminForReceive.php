<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stock-transfer-history-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Receive Sent Stock (Main Inventory)</legend>
    <?php
    echo CHtml::link('Receive Stock', "", // the link for open the dialog
            array(
        'class' => 'additionalBtn',
        'onclick' => "{transferAll();}"));
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'stock-transfer-history-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'stock-transfer-history-grid',
        'dataProvider' => $model->searchForReceive(),
        'mergeColumns' => array('id'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"),
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'send_date',
            array(
                'name' => 'from_store',
                'value' => 'Stores::model()->storeName($data->from_store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            'send_qty',
            'rcv_date',
            array(
                'name' => 'to_store',
                'value' => 'Stores::model()->storeName($data->to_store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            'rcv_qty',
            array(
                'name' => 'rcv_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->rcv_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'rcv_time',
        )
    ));
    ?>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTransferSelected',
        'options' => array(
            'title' => 'Receive Stock',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1030,
            'resizable' => false,
        ),
    ));
    ?>
    <div class="divForForm"></div>
    <?php $this->endWidget(); ?>

    <script>
        function transferAll(){
            var atLeastOneIsChecked = $('input[name=\"stock-transfer-history-grid_c0[]\"]:checked').length > 0;
                   
            if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one item to receive');
            }else{
                var attrIds = new Array();
                
                $('input[name=\"stock-transfer-history-grid_c0[]\"]:checked').each(function() { //loop through each checkbox
                    attrIds.push($(this).val());
                });
            
                $('#dialogTransferSelected').dialog('destroy'); 
                $('#dialogTransferSelected').dialog({ autoOpen: false, resizable: false, title: 'Send Stock', width: 'auto', modal: true }); 
                $('#dialogTransferSelected').dialog('open');
<?php
echo CHtml::ajax(array(
    'url' => array('stockTransferHistory/receiveStock'),
    'data' => "js:{'attrIds':''+attrIds+''}",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                $('.ajaxLoaderFormLoadPurchReq').show();
            }",
    'complete' => "function(){
                $('.ajaxLoaderFormLoadPurchReq').hide();
            }",
    'success' => "function(data){
                if (data.status == 'failure'){
                    $('#dialogTransferSelected div.divForForm').html(data.content);
                    $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                }else{
                    $('#dialogTransferSelected div.divForForm').html(data.content);
                    setTimeout(\"$('#dialogTransferSelected').dialog('close') \",1000);
                    $.fn.yiiGridView.update('stock-transfer-history-grid', {
                        data: $(this).serialize()
                    });
                }
                                        }",
));
?>;
        }
                
        
        return false; 
    } 
    
    function transferAllAgain(){
        var atLeastOneIsChecked = $('input[name=\"stock-transfer-history-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
            alertify.alert('Please select atleast one item to receive');
        }else{
            var dataString = '';
                            
<?php
echo CHtml::ajax(array(
    'url' => array('stockTransferHistory/receiveStock'),
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
                if (data.status == 'failure'){
                    $('#dialogTransferSelected div.divForForm').html(data.content);
                    $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                }else{
                    $('#dialogTransferSelected div.divForForm').html(data.content);
                    setTimeout(\"$('#dialogTransferSelected').dialog('close') \",1000);
                    $.fn.yiiGridView.update('stock-transfer-history-grid', {
                        data: $(this).serialize()
                    });
                }
                                                                            }",
));
?>;
        } 
        return false; 
    } 
           
    </script> 
</fieldset>
