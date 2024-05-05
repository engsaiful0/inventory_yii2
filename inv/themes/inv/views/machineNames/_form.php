<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'machine-names-form',
            'action' => $this->createUrl('machineNames/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add Machine' : 'Update Machine'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'ip_address'); ?></td>
                <td><?php echo $form->textField($model, 'ip_address', array('maxlength'=>255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ip_address'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'machine_name'); ?></td>
                <td><?php echo $form->textField($model, 'machine_name', array('maxlength'=>255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'machine_name'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="float: left; display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('machineNames/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#machine-names-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("machine-names-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#machine-names-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#machine-names-form #"+key+"_em_").show();
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