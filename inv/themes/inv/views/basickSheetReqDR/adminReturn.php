<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('basic-sheet-req-dr-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"basic-sheet-req-dr-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('basic-sheet-req-dr-search-form').action='deleteall';
                document.getElementById('basic-sheet-req-dr-search-form').submit();
        }
});
");
?>
<?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<fieldset style="float: left; width: 98%;">
    <legend>Return Store Requisition Deliveries</legend>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'basic-sheet-req-dr-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'basic-sheet-sheet-req-dr-grid',
        'dataProvider' => $model->searchReturn(),
        'mergeColumns' => array('req_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        //'selectableRows' => 2,
        'columns' => array(
//            array(
//                'value' => '$data->id',
//                'class' => 'CCheckBoxColumn',
//            ),
            'req_no',
            array(
                'name' => 'req_id',
                'value' => 'BasickSheetRequisition::model()->itemOfThis($data->req_id)',
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'd_date',
            'd_qty',
            array(
                'name' => 'is_approved',
                'value' => 'StoreReqDR::model()->isApproved($data->is_approved)',
                'filter' => array(1 => "Approved", 0 => "Pending"),
            ),
            array(
                'name' => 'approved_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->approved_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'approved_time',
            'r_date',
            'r_qty',
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
                'header' => 'Options',
                'template' => '{return}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'return' => array(
                        'label' => 'Return',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/return.ico',
                        'url' => 'Yii::app()->controller->createUrl("BasickSheetReqDR/return",array("id"=>$data->id))',
                        'click' => "function( e ){
                                    e.preventDefault();
                                    $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                    updateDialog( $( this ).attr( 'href' ) );
                                    $( '#update-dialog' )
                                     .dialog( { title: 'Return Form' } )
                                     .dialog( 'open' ); }",
                    ),
                )
            ),
        )
    ));
    ?>

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
