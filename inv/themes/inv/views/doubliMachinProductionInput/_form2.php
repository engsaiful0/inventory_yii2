<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'sale-order-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Information</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'ref_no'); ?></td>
                <td><?php echo $form->textField($model, 'ref_no', array('maxlength'=>255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php //echo $form->error($model, 'ref_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'subj'); ?></td>
                <td><?php echo $form->textField($model, 'subj', array('maxlength'=>255)); ?></td>            
            </tr>
            
            <tr>
                <td></td>
                <td><?php //echo $form->error($model, 'subj'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'input_date'); ?></td>
                <td>
                    <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'input_date',
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
                <td><?php //echo $form->error($model, 'input_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'item'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'item', CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), 'id', 'nameWithDesc'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'length'); ?></td>
                <td><?php echo $form->textField($model, 'length'); ?></td>            
            </tr>
               <tr>
                <td><?php echo $form->labelEx($model, 'width'); ?></td>
                <td><?php echo $form->textField($model, 'width'); ?></td>            
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'thickness'); ?></td>
                <td><?php echo $form->textField($model, 'thickness'); ?></td>            
            </tr>
                  <tr>
                <td><?php echo $form->labelEx($model, 'unit_of_distance'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'unit_of_distance', CHtml::listData(UnitDistance::model()->findAll(array("order" => "unit_of_distance ASC")), 'id', 'unit_of_distance'), array(
                        'prompt' => 'Select Unit',
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
                <td><?php //echo $form->error($model, 'qty'); ?></td>
            </tr>
              <tr>
                <td><?php echo $form->labelEx($model, 'qty_kg'); ?></td>
                <td><?php echo $form->textField($model, 'qty_kg'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php //echo $form->error($model, 'qty_kg'); ?></td>
            </tr>
            <tr>
                <td ><?php echo $form->labelEx($model, 'approved_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'approved_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'doubli_producton_input_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'doubli_producton_input_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
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
