<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-mr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>
            <b>PR No:</b> <?php echo $model->sl_no; ?><br/>
            <b>Supplier:</b> <?php echo Suppliers::model()->supplierNameAddr($model->supplier_id); ?>
        </legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'showOn' => 'button',
                            'buttonText' => 'Date',
                            'buttonImageOnly' => true,
                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'float: left;
                                        margin-top: 6px;
                                        width: 61%;'
                        ),
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'narration'); ?></td>
                <td><?php echo $form->textField($model, 'narration', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'narration'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'received_type'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'received_type', Lookup::items("received_type"), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'received_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'bank_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'bank_id', CHtml::listData(Banks::model()->findAll(array('order' => 'bank_name ASC')), 'id', 'bank_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'bank_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cheque_no'); ?></td>
                <td><?php echo $form->textField($model, 'cheque_no', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cheque_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cheque_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'cheque_date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'showOn' => 'button',
                            'buttonText' => 'Date',
                            'buttonImageOnly' => true,
                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'float: left;
                                        margin-top: 6px;
                                        width: 61%;'
                        ),
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cheque_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'paid_amount'); ?></td>
                <td><?php echo $form->textField($model, 'paid_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'paid_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'discount'); ?></td>
                <td><?php echo $form->textField($model, 'discount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'discount'); ?></td>
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
