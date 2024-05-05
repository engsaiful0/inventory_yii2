<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-requisition-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gridview/styles.css" type="text/css" media="screen" />
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'purchase-requisition-form',
            'action' => Yii::app()->createUrl('/purchaseRequisition/reqFromSOView'),
        ));
?>
<fieldset>
    <legend>Search Conditions</legend>
    <div class="grid-view" style="float: left; width: 100%;">
        <table class="items">
            <tr>
                <td><?php echo $form->labelEx($model, 'store'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'cat'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'pbrand'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'pmodel'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'country'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'product_type'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'grade'); ?></td>
                <td><?php echo $form->labelEx($itemsModel, 'mfi'); ?></td>
            </tr>
            <tr>
            <tr>             
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'cat', CHtml::listData(Cats::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td> 
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'pbrand', CHtml::listData(PBrand::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>  
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'pmodel', CHtml::listData(PModel::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'country', CHtml::listData(Countries::model()->findAll(array('order' => 'country ASC')), 'id', 'country'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td> 
                <td>
                    <?php
                    echo $form->dropDownList($itemsModel, 'product_type', Lookup::items('product_type'), array('prompt' => 'select'));
                    ?>
                </td> 
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'grade', CHtml::listData(Grades::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td> 
                <td>
                    <?php
                    echo $form->dropDownList(
                            $itemsModel, 'mfi', CHtml::listData(Mfis::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td> 
            </tr>  

            <tr style="border: none;">
                <td colspan="8" style="text-align: left; border: none;">
                    <?php
                    echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('purchaseRequisition/reqFromSOView', 'render' => true)), array(
                        'dataType' => 'json',
                        'type' => 'post',
                        'success' => 'function(data) {
                            $("#ajaxLoader").hide(); 
                            $("#resultDiv").html(data.content);
                        }',
                        'beforeSend' => 'function(){     
                            if($("#PurchaseRequisition_store").val()==""){
                                alertify.alert("Please select a store !");
                                return false;
                            }else{
                                $("#ajaxLoader").show();
                            }
                 }',
                    ));
                    ?>
                </td>
            </tr>
        </table>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
<fieldset style="float: left; width: 98%;">
    <legend>Items <span style=" float: right; margin-left: 8px;"><div id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div><span></legend>
    <div id="resultDiv">

    </div>
</fieldset>
