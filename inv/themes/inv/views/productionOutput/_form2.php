<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'production-output-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Production Output Info</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model,
                        'attribute' => 'date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'time'); ?></td>
                <td>
                    <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig2 = array(
                            'model' => $model,
                            'attribute' => 'time',
                            'mode' => 'time',
                            'language' => 'en-AU',
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                        ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'time'); ?></td>
            </tr>
            <tr>
                    <td><?php echo $form->labelEx($model, 'category'); ?></td>
                    <td>
                        <?php
                            echo $form->dropDownList(
                                    $model, 'category', CHtml::listData(Cats::model()->findAll(array("order"=>"name ASC")), 'id', 'name'), array(
                                        'prompt' => 'Select',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'dataType' => 'json',
                                            'url' => CController::createUrl('items/itemsOfThisCat'),
                                            'success' => 'function(data) {
                                                    $("#ProductionOutput_item").html(data.items);
                                             }',
                                            'data' => array(
                                                'catId' => 'js:jQuery("#ProductionOutput_category").val()',
                                            ),
                                            'beforeSend' => 'function(){
                                                document.getElementById("ProductionOutput_item").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                            'complete' => 'function(){
                                                document.getElementById("ProductionOutput_item").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                            }',
                                        ),
                            ));
                        ?>
                    </td>
             </tr>
             <tr>
                 <td><?php echo $form->labelEx($model, 'item'); ?></td>
                    <td>
                        <?php
                            echo $form->dropDownList(
                                    $model, 'item', CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), 'id', 'nameWithDesc'), array(
                                        'prompt' => 'Select',
                            ));
                        ?>
                    </td>
                </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'qty'); ?></td>
                <td><?php echo $form->textField($model, 'qty'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'qty'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'qty_kg'); ?></td>
                <td><?php echo $form->textField($model, 'qty_kg'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'qty_kg'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
