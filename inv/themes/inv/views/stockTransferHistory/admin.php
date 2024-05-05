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
    <legend>Stock Transfer History Between Stores (Main Inventory)</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'stock-transfer-history-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('id'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
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

