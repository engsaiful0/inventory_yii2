<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'master-lc-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Create New Master LC' : 'Update These Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'id DESC')), 'id', 'company_name'), array(
                                'prompt' => 'Select',
                                'id'=>'MasterLc_supplier_id2',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('masterLc/verifiedImportPurchaseOrder'),
                                    'success' => 'function(data) {
                                                    $("#MasterLc_po_no2").val(data.verifiedImportPurchaseOrder);
                                    }',
                                    'data' => array(
                                        'supplierId' => 'js:jQuery("#MasterLc_supplier_id2").val()',
                                    ),
                                    'beforeSend' => 'function(){
                                                document.getElementById("MasterLc_po_no2").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 1px";   
                                             }',
                                    'complete' => 'function(){
                                                document.getElementById("MasterLc_po_no2").style.background="#FFFFFF"; 
                                            }',
                                ),
                    ));
                    ?>
                </td> 
                <td><?php echo $form->labelEx($model, 'lc_no'); ?></td>
                <td><?php echo $form->textField($model, 'lc_no', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'lc_amount'); ?></td>
                <td><?php echo $form->textField($model, 'lc_amount'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'supplier_id'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'lc_no'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'lc_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'shipment_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model, //Model object
                        'attribute' => 'shipment_date', //attribute name
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
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>
                <td><?php echo $form->labelEx($model, 'expire_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                        'model' => $model, //Model object
                        'attribute' => 'expire_date', //attribute name
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
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
                </td>
                <td><?php echo $form->labelEx($model, 'lc_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig3 = array(
                        'model' => $model, //Model object
                        'attribute' => 'lc_date', //attribute name
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
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig3);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'shipment_date'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'expire_date'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'lc_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'shipment_from'); ?></td>
                <td><?php echo $form->textField($model, 'shipment_from', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'shipment_to'); ?></td>
                <td><?php echo $form->textField($model, 'shipment_to', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'hs_code'); ?></td>
                <td><?php echo $form->textField($model, 'hs_code', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'shipment_from'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'shipment_to'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'hs_code'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'insurance_company'); ?></td>
                <td><?php echo $form->textField($model, 'insurance_company', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'agent'); ?></td>
                <td><?php echo $form->textField($model, 'agent', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'c_f_agent'); ?></td>
                <td><?php echo $form->textField($model, 'c_f_agent', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'insurance_company'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'agent'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'c_f_agent'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'transport_agency'); ?></td>
                <td><?php echo $form->textField($model, 'transport_agency', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'lc_amended'); ?></td>
                <td><?php echo $form->textField($model, 'lc_amended', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'last_date_of_shipment'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfigLdoShp = array(
                        'model' => $model, //Model object
                        'attribute' => 'last_date_of_shipment', //attribute name
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
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfigLdoShp);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'transport_agency'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'lc_amended'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'last_date_of_shipment'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'lc_tenor_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'lc_tenor_id', CHtml::listData(Tenors::model()->findAll(array('order' => 'id ASC')), 'id', 'title'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
                <td><?php echo $form->labelEx($model, 'export_lc_no'); ?></td>
                <td><?php echo $form->textField($model, 'export_lc_no', array('maxlength' => 255)); ?></td>
                <td><?php echo $form->labelEx($model, 'bank_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'bank_id', CHtml::listData(Banks::model()->findAll(array('order' => 'id DESC')), 'id', 'bank_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'lc_tenor_id'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'export_lc_no'); ?></td>
                <td></td>
                <td><?php echo $form->error($model, 'bank_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks'); ?></td>
                <td colspan="5"><?php echo $form->textField($model, 'remarks', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="5"><?php echo $form->error($model, 'remarks'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'po_no'); ?></td>
                <td colspan="5"><?php echo $form->textField($model, 'po_no', array('style'=>'font-weight: bold; height: 25px;', 'id'=>'MasterLc_po_no2')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="5"><?php echo $form->error($model, 'po_no'); ?></td>
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
