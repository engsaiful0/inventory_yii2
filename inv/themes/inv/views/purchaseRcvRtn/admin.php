<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-rcv-rtn-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"purchase-rcv-rtn-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('purchase-rcv-rtn-search-form').action='deleteall';
                document.getElementById('purchase-rcv-rtn-search-form').submit();
        }
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Purchase Order</legend>
    <table>
        <tr>
            <td>
                <label>PO No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('purchaseOrder/requisitionPreview'), array(
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
                    'href' => Yii::app()->createUrl('purchaseOrder/requisitionPreview'),
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
<?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Purchase Receives/Returns</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'purchase-rcv-rtn-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-rcv-rtn-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('po_id', 'challan_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            array(
                'name' => 'po_id',
                'value' => 'PurchaseOrder::model()->poNoOfThis($data->po_id)',
            ),
            'challan_no',
            array(
                'name' => 'supplier_id',
                'value' => 'Suppliers::model()->supplierName($data->supplier_id)',
                'filter' => CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'po_id',
                'header' => 'Item',
                'value' => 'PurchaseOrder::model()->itemOfThis($data->po_id)',
                'filter' => '',
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'rcv_date',
            'noOfReceivedSack',
            'weightPerSack',
            'rcv_qty',
              array(
                'name' => 'name_of_unit',
                'value' => 'Units::model()->name_of_unitOfThis($data->name_of_unit)',
                'filter' => CHtml::listData(Units::model()->findAll(array('order'=>'name_of_unit ASC')), 'id', 'name_of_unit'),
            ),
            array(
                'name' => 'remarks_for_rcv',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            'cost',
            'rtn_date',
            'rtn_qty',
              array(
                'name' => 'return_unit',
                'value' => 'Units::model()->name_of_unitOfThis($data->return_unit)',
                'filter' => CHtml::listData(Units::model()->findAll(array('order'=>'name_of_unit ASC')), 'id', 'name_of_unit'),
            ),
            
            array(
                'name' => 'remarks',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'return_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->return_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'return_time',
            array(
                'name' => 'created_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->created_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'created_time',
            array(
                'name' => 'updated_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->updated_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'updated_time',
            array(
                'header' => 'Options',
                'template' => '{return}{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'return' => array(
                        'label' => 'Return',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/return.ico',
                        'url' => 'Yii::app()->controller->createUrl("purchaseRcvRtn/return",array("id"=>$data->id))',
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
            'resizable' => false,
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
