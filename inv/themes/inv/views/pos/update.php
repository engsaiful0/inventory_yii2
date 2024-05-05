<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/pos/css/pos.css" type="text/css" media="screen" />
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 25%;">
    <legend>Search Invoice For Edit</legend>
    <div class="search-form" style="float: left; width: 100%;">
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
    </div>
</fieldset>

<fieldset style="float: left; width: 70%;">
    <legend>POS Transactions</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'pos-grid',
        //'ajaxUpdate' => false,
        'dataProvider' => $model->searchVoid(),
        'mergeColumns' => array('inv_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name' => 'inv_no',
                'value' => '$data->inv_no',
                'filter' => '',
            ),
            array(
                'name' => 'inv_no',
                'header' => 'Date/Time',
                'value' => '$data->date." / ".$data->time',
                'filter' => '',
            ),
            array(
                'name' => 'inv_no',
                'header' => 'Edit',
                'value' => 'Pos::model()->updatePos($data->inv_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>
