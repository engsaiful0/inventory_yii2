<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sell-delv-rtn-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"sell-delv-rtn-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('sell-delv-rtn-search-form').action='deleteall';
                document.getElementById('sell-delv-rtn-search-form').submit();
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
<fieldset style="float: left; width: 98%;">
    <legend>Print Challan Info</legend>
    <table>
        <tr>
            <td>
                <label>Challan No</label>
            </td>
            <td>
                <input type="text" name="challanNoForReport" id="challanNoForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('sellDelvRtn/challanNoPreview'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       $('#ajaxLoaderReport2').show();
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                                           $('#ajaxLoaderReport2').hide(); 
                    }",
                    'data' => array('sl_no' => 'js:jQuery("#challanNoForReport").val()')
                        ), array(
                    'href' => Yii::app()->createUrl('sellDelvRtn/challanNoPreview'),
                    'class' => 'additionalBtn'
                        )
                );
                ?>
                <span id="ajaxLoaderReport2" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            </td>
        </tr>
    </table>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Voucher Preview',
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
    <legend>Manage Sell Deliveries/Returns</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'sell-delv-rtn-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'sell-delv-rtn-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('so_no', 'sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            'so_no',
            array(
                'name' => 'customer_id',
                'value' => 'Customers::model()->customerName($data->customer_id)',
                'filter' => CHtml::listData(Customers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'bill',
                'value' => 'SellDelvRtn::model()->isBillCreated($data->bill)',
                'filter' => array(1 => "Created", 0 => "Not Created"),
            ),
            'sl_no',
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
            'd_date',
            'd_qty',
            'd_qty_kg',
            array(
                'name'=>'remarks1',
                'htmlOptions'=>array('style'=>'text-align: right;'),
            ),
            'r_date',
            'r_qty',
            'r_qty_kg',
            array(
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;'),
            ),
            'vehicle_type',
            'vehicle_no',
            array(
                'name' => 'return_by',
                'value' => 'Users::model()->fullNameOfThis($data->return_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'return_time',
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
                'header' => 'Options',
                'template' => '{return}{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'return' => array(
                        'label'=>'Return',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/return.ico',
                        'url' => 'Yii::app()->controller->createUrl("return",array("id"=>$data->id))',
                        'click' => "function( e ){
                                    e.preventDefault();
                                    $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                    updateDialog( $( this ).attr( 'href' ) );
                                    $( '#update-dialog' )
                                     .dialog( { title: 'Return Form' } )
                                     .dialog( 'open' ); }",
                    ),
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Info' } )
                              .dialog( 'open' ); }",
                    ),
                )
            ),
        )
    ));
    ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php $this->endWidget(); ?>
    <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Form',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1040,
        'resizable'=>false,
    ),
));
?>
<div class="update-dialog-content"></div>
<?php $this->endWidget(); ?>

<?php
$updateJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      $( '#update-dialog div.update-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          updateDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // Update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
        });
      }
      setTimeout( \"$( '#update-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('updateDialog', "
function updateDialog( url, act )
{
  var action = '';
  var form = $( '#update-dialog div.update-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$updateJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('updateDialogCreate', "
jQuery( function($){
    $( 'a.update-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#update-dialog' ).children( ':eq(0)' ).empty();
      updateDialog( $( this ).attr( 'href' ) );
      $( '#update-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>
</fieldset>

