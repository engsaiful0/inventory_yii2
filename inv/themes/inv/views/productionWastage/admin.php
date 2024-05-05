<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('production-wastage-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"production-wastage-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('production-wastage-search-form').action='deleteall';
                document.getElementById('production-wastage-search-form').submit();
        }
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Production Wastages</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'production-wastage-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'production-wastage-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('production_input_no'),
        'filter' => $model,
        'selectableRows' => 2,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(  
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            'date',
            'production_input_no',
            'wastage_qty',
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
                'template' => '{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Wastage Info' } )
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
        'title' => 'Update Wastage Info',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
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

