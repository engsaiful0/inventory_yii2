<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'countries-form',
            'action' => $this->createUrl('countries/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Country' : 'Update Country'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'iso2'); ?></td>
                <td><?php echo $form->textField($model, 'iso2', array('maxlength'=>2)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'iso2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'iso3'); ?></td>
                <td><?php echo $form->textField($model, 'iso3', array('maxlength'=>3)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'iso3'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'country'); ?></td>
                <td><?php echo $form->textField($model, 'country', array('maxlength'=>64)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'country'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('countries/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#countries-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("countries-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#countries-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#countries-form #"+key+"_em_").show();
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
