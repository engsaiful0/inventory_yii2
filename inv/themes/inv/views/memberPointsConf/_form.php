<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'member-points-conf-form',
            'action' => $this->createUrl('memberPointsConf/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Points Configuration' : 'Update Informations'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'point_add_after_amount'); ?></td>
                <td><?php echo $form->textField($model, 'point_add_after_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'point_add_after_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'point_add'); ?></td>
                <td><?php echo $form->textField($model, 'point_add'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'point_add'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'over_amount'); ?></td>
                <td><?php echo $form->textField($model, 'over_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'over_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'each_point_amount'); ?></td>
                <td><?php echo $form->textField($model, 'each_point_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'each_point_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'usable_after_point'); ?></td>
                <td><?php echo $form->textField($model, 'usable_after_point'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'usable_after_point'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'start_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $startDate = array(
                        'model' => $model,
                        'attribute' => 'start_date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $startDate);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'start_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'end_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $endDate = array(
                        'model' => $model,
                        'attribute' => 'end_date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $endDate);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'end_date'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('memberPointsConf/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#member-points-conf-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("member-points-conf-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#member-points-conf-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#member-points-conf-form #"+key+"_em_").show();
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
