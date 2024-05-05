<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'units-form',
            'action' => $this->createUrl('unitDistance/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Unit Of Distance' : 'Update Unit Of Distance'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'unit_of_distance'); ?></td>
                <td><?php echo $form->textField($model, 'unit_of_distance', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'unit_of_distance'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('unitDistance/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#units-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("units-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#units-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#units-form #"+key+"_em_").show();
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
