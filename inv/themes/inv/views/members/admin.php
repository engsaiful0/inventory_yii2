<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('members-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if ($model->isNewRecord) { ?>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php } else { ?>
    <?php echo $this->renderPartial('_form2', array('model' => $model)); ?>
<?php } ?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Members</legend>
    <?php
    
    $pointAdd = 0;
    $overAmount = 0;
    $eachPointAmount = 0;
    $usableAfterPoint=0;
    $activePointConf = MemberPointsConf::model()->findByAttributes(array('is_active' => MemberPointsConf::ACTIVE));
    if ($activePointConf) {
        $pointAdd = $activePointConf->point_add;
        $overAmount = $activePointConf->over_amount;
        $eachPointAmount = $activePointConf->each_point_amount;
        $usableAfterPoint=$activePointConf->usable_after_point;
        echo "<i>Active Points Configuration:</i><hr>";
        echo "<b>Points Add:</b> ".$pointAdd;
        echo " <b>Over Amount:</b> ".$overAmount;
        echo " <b>Amount for Each Point:</b> ".$eachPointAmount;
        echo " <b>Usable For Points (Each):</b> ".$usableAfterPoint;
        echo "<hr>";
    }else{
        echo "<div class='flash-error'>No active points configuration found !</div>";
    }
    
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'members-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'card_no',
            'name',
            'contact_no',
            'email',
            'address',
            'dob',
            'spouse',
            'available_point',
            array
                (
                'header' => 'Options',
                'htmlOptions'=>array('style'=>'width: 100px;'),
                'template' => '{point_add}{point_reduce}{history}{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'point_add' => array(
                        'label' => 'Add Points',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/receive.ico',
                        'url' => 'Yii::app()->controller->createUrl("addPoints",array("id"=>$data->id))',
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Add Points' } )
                              .dialog( 'open' ); }",
                    ),
                    'point_reduce' => array(
                        'label' => 'Reduce Points',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/delivery.ico',
                        'url' => 'Yii::app()->controller->createUrl("reducePoints",array("id"=>$data->id))',
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Reduce Points' } )
                              .dialog( 'open' ); }",
                    ),
                    'history' => array(
                        'label' => 'Points Transaction History',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/history.ico',
                        'url' => 'Yii::app()->controller->createUrl("pointsHistory",array("id"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('members-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('members-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                    ),
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update members Info' } )
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
        'title' => 'Point Added History',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Member Informations',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
<div class="update-dialog-content"></div>
<?php //$this->endWidget(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


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
      //setTimeout( \"$( '#update-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
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
