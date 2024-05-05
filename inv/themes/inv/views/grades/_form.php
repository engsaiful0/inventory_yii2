<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'grades-form',
            'action' => $this->createUrl('grades/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Grade' : 'Update Grade'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'name'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('grades/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#grades-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("grades-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#grades-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#grades-form #"+key+"_em_").show();
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
