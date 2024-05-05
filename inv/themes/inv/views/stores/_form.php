<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'stores-form',
            'action' => $this->createUrl('stores/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Store Info' : 'Update Store Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'store_name'); ?></td>
                <td><?php echo $form->textField($model, 'store_name', array('maxlength'=>255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'store_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'location'); ?></td>
                <td><?php echo $form->textField($model, 'location', array('maxlength'=>255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'location'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('stores/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#stores-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("stores-grid", {
		data: $(this).serialize()
	});
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#stores-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#stores-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ));
        ?>
    </fieldset>
    <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
    <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
</div>

<?php $this->endWidget(); ?>
