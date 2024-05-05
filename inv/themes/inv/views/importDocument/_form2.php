<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'import-document-form',
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
                            $model, 'lc_id', CHtml::listData(MasterLc::model()->findAll(array('order' => 'id DESC')), 'id', 'lc_no'), array(
                        'prompt' => 'Select',
                                'id'=>'ImportDocument_lc_id2',
                                'style'=>'width: 150px;',
                                 'ajax' => array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('masterLc/detailsOfThisLc'),
                                    'success' => 'function(data) {
                                                    $("#lcDetails2").html(data.lcDetails);
                                             }',
                                    'data' => array(
                                        'lcId' => 'js:jQuery("#ImportDocument_lc_id2").val()',
                                    ),
                                    'beforeSend' => 'function(){
                                                document.getElementById("ImportDocument_lc_id2").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                    'complete' => 'function(){
                                                document.getElementById("ImportDocument_lc_id2").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
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
                    <div id="lcDetails2" style="float: left; min-height: 20px; width: 100%;">
                        <?php MasterLc::model()->lcDetails($model->lc_id); ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>

<?php $this->endWidget(); ?>