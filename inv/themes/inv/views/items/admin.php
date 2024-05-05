<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('items-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('items-search-form').action='deleteall';
                document.getElementById('items-search-form').submit();
        }
});
$('.setUnitConvertable-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to set unit convertable');
        }else if(window.confirm('Are you sure you want to set unit convertable to the selected records ?')){
                document.getElementById('items-search-form').action='setUnitConvertable';
                document.getElementById('items-search-form').submit();
        }
});
$('.undoUnitConvertable-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to undo');
        }else if(window.confirm('Are you sure you want to undo the selected records ?')){
                document.getElementById('items-search-form').action='undoUnitConvertable';
                document.getElementById('items-search-form').submit();
        }
});
$('.setVatable-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to set VATable');
        }else if(window.confirm('Are you sure you want to set VATable to the selected records ?')){
                document.getElementById('items-search-form').action='setVatable';
                document.getElementById('items-search-form').submit();
        }
});
$('.undoVatable-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to undo');
        }else if(window.confirm('Are you sure you want to undo the selected records ?')){
                document.getElementById('items-search-form').action='undoVatable';
                document.getElementById('items-search-form').submit();
        }
});
$('.setAsRawMat-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to set as Raw Material');
        }else if(window.confirm('Are you sure you want to set as Raw Material to the selected records ?')){
                document.getElementById('items-search-form').action='setAsRawMat';
                document.getElementById('items-search-form').submit();
        }
});
$('.undoAsRawMat-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"items-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to undo');
        }else if(window.confirm('Are you sure you want to undo the selected records ?')){
                document.getElementById('items-search-form').action='undoAsRawMat';
                document.getElementById('items-search-form').submit();
        }
});
");
?>
<?php if ($model->isNewRecord) { ?>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php } else { ?>
    <?php echo $this->renderPartial('_form2', array('model' => $model)); ?>
<?php } ?>
<?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage items</legend>
    <?php echo CHtml::button('Set VATable', array('name' => 'setVatable', 'class' => 'setVatable-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoVatable', 'class' => 'undoVatable-button')); ?>
    <?php echo CHtml::button('Set As Raw Mat', array('name' => 'setAsRawMat', 'class' => 'setAsRawMat-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoAsRawMat', 'class' => 'undoAsRawMat-button')); ?>
    <?php echo CHtml::button('Set Unit Convertable', array('name' => 'setUnitConvertable', 'class' => 'setUnitConvertable-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoUnitConvertable', 'class' => 'undoUnitConvertable-button')); ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'items-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'items-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('cat', 'cat_sub'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            array(
                'name' => 'cat',
                'value' => 'Cats::model()->nameOfThis($data->cat)',
                'filter' => CHtml::listData(Cats::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            array(
                'name' => 'cat_sub',
                'value' => 'CatsSub::model()->nameOfThis($data->cat_sub)',
                'filter' => CHtml::listData(CatsSub::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            'code',
            'name',
            'desc',
            'unit',
            array(
                'name' => 'supplier_id',
                'value' => 'Suppliers::model()->supplierName($data->supplier_id)',
                'filter' => CHtml::listData(Suppliers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'pbrand',
                'value' => 'Pbrand::model()->nameOfThis($data->pbrand)',
                'filter' => CHtml::listData(Pbrand::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            array(
                'name' => 'pmodel',
                'value' => 'Pmodel::model()->nameOfThis($data->pmodel)',
                'filter' => CHtml::listData(Pmodel::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            array(
                'name' => 'country',
                'value' => 'Countries::model()->nameOfThis($data->country)',
                'filter' => CHtml::listData(Countries::model()->findAll(array("order" => "country ASC")), "id", "country"),
            ),
            array(
                'name' => 'product_type',
                'value' => 'Lookup::item("product_type", $data->product_type)',
                'filter' => Lookup::items("product_type"),
            ),
            array(
                'name' => 'grade',
                'value' => 'Grades::model()->nameOfThis($data->grade)',
                'filter' => CHtml::listData(Grades::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            array(
                'name' => 'mfi',
                'value' => 'Mfis::model()->nameOfThis($data->mfi)',
                'filter' => CHtml::listData(Mfis::model()->findAll(array("order" => "name ASC")), "id", "name"),
            ),
            'warn_qty',
            array(
                'name' => 'is_rawmat',
                'value' => 'Items::model()->isRawmat($data->is_rawmat)',
                'filter' => array(1 => "Raw Materials", 0 => "Not Raw Materials"),
            ),
            array(
                'name' => 'vatable',
                'value' => 'Items::model()->isVatable($data->vatable)',
                'filter' => array(1 => "VATable", 0 => "Not VATable"),
            ),
            array(
                'name' => 'unit_convertable',
                'value' => 'Items::model()->isUnitConvertable($data->unit_convertable)',
                'filter'=>array(1 => "Yes", 0 => "No"),
            ),
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
              .dialog( { title: 'Update Item' } )
              .dialog( 'open' ); }",
                    ),
                )
            ),
        )
    ));
    ?>
    <?php echo CHtml::button('Set VATable', array('name' => 'setVatable', 'class' => 'setVatable-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoVatable', 'class' => 'undoVatable-button')); ?>
    <?php echo CHtml::button('Set As Raw Mat', array('name' => 'setAsRawMat', 'class' => 'setAsRawMat-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoAsRawMat', 'class' => 'undoAsRawMat-button')); ?>
    <?php echo CHtml::button('Set Unit Convertable', array('name' => 'setUnitConvertable', 'class' => 'setUnitConvertable-button')); ?>
    <?php echo CHtml::button('Undo', array('name' => 'undoUnitConvertable', 'class' => 'undoUnitConvertable-button')); ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'update-dialog',
        'options' => array(
            'title' => 'Update Item',
            'autoOpen' => false,
            'modal' => true,
            'width' => 'auto',
            'resizable' => false,
        ),
    ));
    ?>
    <div class="update-dialog-content"></div>
    <?php $this->endWidget(); ?>

    <?php $this->endWidget(); ?>
</fieldset>

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
