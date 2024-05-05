<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-order-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"sale-order-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('sale-order-search-form').action='deleteall';
                document.getElementById('sale-order-search-form').submit();
        }
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Sale Order</legend>
    <table>
        <tr>
            <td>
                <label>SO No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('saleOrder/soPreview'), array(
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
                    'href' => Yii::app()->createUrl('saleOrder/soPreview'),
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
        'title' => 'Sale Order Preview',
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
    <legend>Manage Sale Orders</legend>
    <?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'sale-order-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'sale-order-grid',
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
            'sl_no',
            'issue_date',
            'expected_d_date',
            array(
                'name' => 'store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'customer_id',
                'value' => 'Customers::model()->customerName($data->customer_id)',
                'filter' => CHtml::listData(Customers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'order_type2',
                'value' => 'Lookup::item("order_type2", $data->order_type2)',
                'filter' => Lookup::items("order_type2"),
            ),
            'pi_no',
            'pi_date',
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), "id", "nameWithDesc"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'qty',
            array(
                'name' => 'conv_unit',
                'value' => 'Items::model()->convertedUnitText($data->conv_unit, $data->item, $data->qty)',
                'filter' => array('1'=>'SFT', '2'=>'RFT', '3'=>'CFT', '4'=>'SQM'),
            ),
            'price',
            array(
                'name' => 'sales_by',
                'value' => 'Employees::model()->fullName($data->sales_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            array(
                'name' => 'created_by',
                'value' => 'Users::model()->fullNameOfThis($data->created_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'created_time',
            array(
                'name' => 'updated_by',
                'value' => 'Users::model()->fullNameOfThis($data->updated_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'updated_time',
            array(
                'name' => 'id',
                'header' => 'Total Delivered Qty',
                'value' => 'SellDelvRtn::model()->availableQtyOfThisSellOrderId($data->id)',
                'filter' => '',
            ),
            array(
                'name' => 'is_stopped',
                'value' => 'SaleOrder::model()->isStopped($data->is_stopped, $data->id)',
                'filter' => array('0'=>'No', '1'=>'Yes'),
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Edit',
                'value' => 'SaleOrder::model()->update($data->sl_no)',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Delete',
                'value' => 'SaleOrder::model()->delete($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
    $data = SaleOrder::model()->findAll();
    
    if($data){
        foreach ($data as $d):
            $id=$d->id;
            echo '<script type="text/javascript">';
            echo 'function start' . $id . '(){';
            echo CHtml::ajax(array(
                'url' => array('saleOrder/start', 'id' => $id),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                    $('.ajaxLoader').show();
                }",
                'complete' => "function(){
                    $('.ajaxLoader').hide();
                }",
                'success' => "function(data){
                    $.fn.yiiGridView.update('sale-order-grid');
                }",
            ));
            echo ';';
            echo 'return false;';
            echo '}';
            
            echo 'function stop' . $id . '(){';
            echo CHtml::ajax(array(
                'url' => array('saleOrder/stop', 'id' => $id),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                    $('.ajaxLoader').show();
                }",
                'complete' => "function(){
                    $('.ajaxLoader').hide();
                }",
                'success' => "function(data){
                    $.fn.yiiGridView.update('sale-order-grid');
                }",
            ));
            echo ';';
            echo 'return false;';
            echo '}';
            
            echo '</script>';
        endforeach;
    }
    ?>

