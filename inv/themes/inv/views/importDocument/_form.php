<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'import-document-form',
            'action' => $this->createUrl('importDocument/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Create New Import Document' : 'Update These Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'lc_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'lc_id', CHtml::listData(MasterLc::model()->findAllWithoutCreated(), 'id', 'lc_no'), array(
                        'prompt' => 'Select',
                                'style'=>'width: 150px;',
                                 'ajax' => array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('masterLc/detailsOfThisLc'),
                                    'success' => 'function(data) {
                                                    $("#lcDetails").html(data.lcDetails);
                                             }',
                                    'data' => array(
                                        'lcId' => 'js:jQuery("#ImportDocument_lc_id").val()',
                                    ),
                                    'beforeSend' => 'function(){
                                                document.getElementById("ImportDocument_lc_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                    'complete' => 'function(){
                                                document.getElementById("ImportDocument_lc_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                            }',
                                ),
                    ));
                    ?>
                </td> 
                <td><?php echo $form->labelEx($model, 'pi_no'); ?></td>
                <td><?php echo $form->textField($model, 'pi_no', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'pi_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfigPiDate = array(
                        'model' => $model, //Model object
                        'attribute' => 'pi_date', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                        'options' => array(
//                        'ampm' => true,
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                        ) // jquery plugin options
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfigPiDate);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'lc_id'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'pi_no'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'pi_date'); ?></td>
            </tr>
            <tr>
                <td colspan="6">
                    <div id="lcDetails" style="float: left; min-height: 20px; width: 100%; padding-top: 20px;">
                        
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('importDocument/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#import-document-form")[0].reset();
                        $("#lcDetails").html("");
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("import-document-grid", {
                                data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#import-document-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#import-document-form #"+key+"_em_").show();
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
