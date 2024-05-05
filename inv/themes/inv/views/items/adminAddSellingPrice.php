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
");
?>
<?php echo CHtml::link('Manage Selling Prices', array('/sellingPrice/admin'), array('class'=>'additionalBtn')); ?>
<fieldset style="float: left; width: 98%;">
    <legend>Add Costing Price</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'items-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('cat', 'cat_sub'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name' => 'cat',
                'value' => 'Cats::model()->nameOfThis($data->cat)',
                'filter' => CHtml::listData(Cats::model()->findAll(array("order"=>"name ASC")), "id", "name"),
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
            array(
                'name' => 'activeSellinglPrice',
                'value' => 'SellingPrice::model()->activeSellingPrice($data->id)',
                'filter' => '',
                'htmlOptions'=>array('style'=>'color: red;'),
            ),
            array(
                'header' => 'Options',
                'template' => '{costingPriceHistory}{addCostingPrice}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'costingPriceHistory' => array(
                         'label'=>'Selling Price History',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/history.ico',
                        'url' => 'Yii::app()->controller->createUrl("sellingPrice/priceHistory",array("item"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('items-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#ajaxLoaderView').hide();  
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('items-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                    ),
                     'addCostingPrice' => array(
                        'label' => 'Add Selling Price',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/price.ico',
                        'url' => 'Yii::app()->controller->createUrl("sellingPrice/addSellingPrice",array("item"=>$data->id))',
                        'click' => "function( e ){
                                e.preventDefault();
                                $( '#addSellPrice-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                addSellPriceDialog( $( this ).attr( 'href' ) );
                                $( '#addSellPrice-dialog' )
                                  .dialog( { title: 'Add Selling Price' } )
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
    'id' => 'viewDialog',
    'options' => array(
        'title' => 'Selling Price History',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addSellPrice-dialog',
    'options' => array(
        'title' => 'Add Selling Price',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="addSellPrice-dialog-content"></div>
<?php $this->endWidget(); ?>
<?php
$addSellPriceJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content' ).html( data.content );
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addSellPriceDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      setTimeout( \"$( '#addSellPrice-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('addSellPriceDialog', "
function addSellPriceDialog( url, act )
{
  var action = '';
  var form = $( '#addSellPrice-dialog div.addSellPrice-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addSellPriceJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addSellPriceDialogCreate', "
jQuery( function($){
    $( 'a.addSellPrice-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addSellPrice-dialog' ).children( ':eq(0)' ).empty();
      addSellPriceDialog( $( this ).attr( 'href' ) );
      $( '#addSellPrice-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>


