<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-order-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"purchase-order-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('purchase-order-search-form').action='deleteall';
                document.getElementById('purchase-order-search-form').submit();
        }
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Doubli Machin Production Input</legend>
    <table>
        <tr>
            <td>
                <label>Production Input No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('doubliMachinProductionInput/requisitionPreview'), array(
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
        'title' => 'Doubli Machin Production Input',
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
    <legend>Manage Doubli Machin Production Input</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'purchase-order-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-order-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            'sl_no',
            'ref_no',
            'subj',
            'input_date',
         array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"),
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'length',
            'width',
            'thickness',
            array(
                'name' => 'unit_of_distance',
                'value' => 'CHtml::encode(UnitDistance::model()->unit_of_distanceOfThis($data->unit_of_distance))',
                'filter' => CHtml::listData(UnitDistance::model()->findAll(array("order" => "unit_of_distance ASC")), "id", "unit_of_distance"),
            ),
            'qty',
            'qty_kg',
            array(
                'name' => 'created_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->created_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'created_time',
            array(
                'name' => 'updated_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->updated_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'updated_time',
            array
                (
                'header' => 'Options',
                'template' => '{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
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
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Info',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderUpdate" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div class="update-dialog-content">

</div>
<?php $this->endWidget(); ?>

<?php
$updateJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'beforeSend' => "function(){
        $('#ajaxLoaderUpdate').show();
}",
            'complete' => "function(){
        $('#ajaxLoaderUpdate').hide();
}",
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
        .dialog( { title: 'Update' } )
        .dialog( 'open' );
    });
});
");
?>
