<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'items-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Item' : 'Update Item'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'cat'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'cat', CHtml::listData(Cats::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cat'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cat_sub'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'cat_sub', CHtml::listData(CatsSub::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cat_sub'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'code'); ?></td>
                <td><?php echo $form->textField($model, 'code', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'code'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'desc'); ?></td>
                <td><?php echo $form->textField($model, 'desc', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'desc'); ?></td>
            </tr>
                <tr>
                <td><?php echo $form->labelEx($model, 'unit'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'unit', CHtml::listData(Units::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'unit'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'supplier_id'); ?></td>
            </tr>
            <tr>                     
                <td><?php echo $form->labelEx($model, 'pbrand'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'pbrand', CHtml::listData(PBrand::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>   
            </tr>
            <tr>                   
                <td></td>
                <td><?php echo $form->error($model, 'pbrand'); ?></td>  
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'pmodel'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'pmodel', CHtml::listData(PModel::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>  
                <td></td>
                <td><?php echo $form->error($model, 'pmodel'); ?></td>   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'country'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'country', CHtml::listData(Countries::model()->findAll(array('order' => 'country ASC')), 'id', 'country'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>  
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'country'); ?></td>  
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'product_type'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'product_type', Lookup::items('product_type'), array('prompt' => 'select'));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'product_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'grade'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'grade', CHtml::listData(Grades::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'grade'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'mfi'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'mfi', CHtml::listData(Mfis::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'mfi'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'warn_qty'); ?></td>
                <td><?php echo $form->textField($model, 'warn_qty'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'warn_qty'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_rawmat'); ?></td>
                <td><?php echo $form->checkBox($model, 'is_rawmat', array('style' => 'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_rawmat'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'vatable'); ?></td>
                <td><?php echo $form->checkBox($model, 'vatable', array('style' => 'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'vatable'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'unit_convertable'); ?></td>
                <td><?php echo $form->checkBox($model, 'unit_convertable', array('style' => 'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'unit_convertable'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMRCreateUpdateItem" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMRCreateUpdateItem").show();
    }
</script>
<?php $this->endWidget(); ?>
