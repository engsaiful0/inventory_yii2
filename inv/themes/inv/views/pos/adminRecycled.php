<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="statusMsg"></div>

<fieldset style="float: left; width: 98%;">
    <legend>Print POS Invoice</legend>
    <table>
        <tr>
            <td>
               Invoice No
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td style="vertical-align: middle;"><div id="ajaxLoaderReport" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div></td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('pos/soReportOfThisNonPosUser'), array(
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
                    'data' => array(
                        'so' => 'js:jQuery("#soForReport").val()'
                    )
                        ), array(
                    'href' => Yii::app()->createUrl('pos/soReportOfThis'),
                    'class' => 'additionalBtn'
                        )
                );
                ?>
            </td>          
        </tr>
    </table>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'POS Invoice Preview',
        'autoOpen' => false,
        'modal' => true,
        'resizable' => false,
        'position'=>'top',
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<style>
    .ui-widget-header .ui-icon {
        float: right;
        background: url("<?php echo Yii::app()->theme->baseUrl; ?>/css/pos/images/close.png") center transparent no-repeat;
        width: 32px;
        height: 32px;
    }
    .ui-dialog .ui-dialog-titlebar-close{
        margin: -18px -5px 0px;
    }
</style>
<fieldset style="float: left; width: 98%;">
    <legend>Restore Recycled POS Transactions</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'pos-grid',
        'dataProvider' => $model->searchRecycled(),
        'mergeColumns' => array('inv_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name'=>'is_void',
                'value'=>'Pos::model()->isVoid($data->is_void)',
                'filter'=>array(1 => "VOID", 0 => "ESTABLISHED"),
            ),
            array(
                'name' => 'inv_no',
                'value' => '$data->inv_no',
            ),
            'date',
            'time',
            array(
                'name' => 'store_id',
                'value' => 'Stores::model()->storeName($data->store_id)',
                'filter' => CHtml::listData(Stores::model()->findAll(), 'id', 'store_name'),
            ),
           array(
                'name' => 'item_id',
                'value' => 'Items::model()->item($data->item_id)',
                'filter' => CHtml::listData(Items::model()->findAll(), 'id', 'name'),
               'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'price',
            'qty',
            array(
                'name'=>'inv_no',
                'header'=>'Overall Discount',
                'value'=>'Pos::model()->overallDiscount($data->overall_discount, $data->discount_type)',
                'filter'=>'',
            ),
            array(
              'name'=>'machine_id',  
              'value'=>'CHtml::encode(MachineNames::model()->nameOfThis($data->machine_id))',
              'filter' => CHtml::listData(MachineNames::model()->findAll(), 'id', 'machineNameWitIp'),
            ),
            array(
                'name' => 'inv_no',
                'header' => 'Undo',
                'value' => 'Pos::model()->tempDeleteUndo($data->inv_no)',
                'filter' => '',
            ),
            array(
                'name' => 'inv_no',
                'header' => 'Delete Permanently',
                'value' => 'Pos::model()->deletePermanently($data->inv_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>
