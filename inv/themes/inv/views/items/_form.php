<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'items-form',
            'action' => $this->createUrl('items/create'),
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
                <td></td>
                <td>
                    <span class="red"></span>Required
                </td>
            </tr>
             <tr>
                <td></td>
                <td>
                    <span class="green"></span>Optional
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'store'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'store', CHtml::listData(Stores::model()->findAll(array('order' => 'store_name ASC')), 'id', 'store_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addUnit(); $('#dialogUnit').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogUnit',
                        'options' => array(
                            'title' => 'Add Unit',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addSupplier(){
<?php
echo CHtml::ajax(array(
    'url' => array('units/createUnitFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogUnit div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogUnit div.divForForm form').submit(addUnit);
                                        }
                                        else
                                        {
                                            $('#dialogUnit div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogUnit').dialog('close') \",1000);
                                            $('#Items_unit_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'store'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cat'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'cat', CHtml::listData(Cats::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addItemCat(); $('#dialogItemCat').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogItemCat',
                        'options' => array(
                            'title' => 'Add Category',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addItemCat(){
<?php
echo CHtml::ajax(array(
    'url' => array('cats/createCatFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogItemCat div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogItemCat div.divForForm form').submit(addItemCat);
                                        }
                                        else
                                        {
                                            $('#dialogItemCat div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogItemCat').dialog('close') \",1000);
                                            $('#Items_cat').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>    
                <td><span class="red"></span></td>
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addItemCatSub(); $('#dialogItemCatSub').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogItemCatSub',
                        'options' => array(
                            'title' => 'Add Sub-Category',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addItemCatSub(){
<?php
echo CHtml::ajax(array(
    'url' => array('catsSub/createCatSubFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogItemCatSub div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogItemCatSub div.divForForm form').submit(addItemCatSub);
                                        }
                                        else
                                        {
                                            $('#dialogItemCatSub div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogItemCatSub').dialog('close') \",1000);
                                            $('#Items_cat_sub').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>            
                <td><span class="green"></span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cat_sub'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'code'); ?></td>
                <td><?php echo $form->textField($model, 'code', array('maxlength' => 255)); ?><span class="heighlightSpan">Keep blank to auto generate. Code must be unique.</span></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'code'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?></td>     
                <td><span class="red"></span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'desc'); ?></td>
                <td><?php echo $form->textField($model, 'desc', array('maxlength' => 255)); ?></td>      
                <td><span class="red"></span></td>
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
                            $model, 'unit', CHtml::listData(Units::model()->findAll(array('order' => 'name_of_unit ASC')), 'id', 'name_of_unit'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addUnit(); $('#dialogUnit').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogUnit',
                        'options' => array(
                            'title' => 'Add Unit',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addSupplier(){
<?php
echo CHtml::ajax(array(
    'url' => array('units/createUnitFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogUnit div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogUnit div.divForForm form').submit(addUnit);
                                        }
                                        else
                                        {
                                            $('#dialogUnit div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogUnit').dialog('close') \",1000);
                                            $('#Items_unit_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addSupplier(); $('#dialogSupplier').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogSupplier',
                        'options' => array(
                            'title' => 'Add Supplier',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addSupplier(){
<?php
echo CHtml::ajax(array(
    'url' => array('suppliers/createSupplierFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogSupplier div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogSupplier div.divForForm form').submit(addSupplier);
                                        }
                                        else
                                        {
                                            $('#dialogSupplier div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogSupplier').dialog('close') \",1000);
                                            $('#Items_supplier_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addPBrand(); $('#dialogAddPBrand').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogAddPBrand',
                        'options' => array(
                            'title' => 'Add Brand',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addPBrand(){
<?php
echo CHtml::ajax(array(
    'url' => array('pBrand/createPBrandFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
    $('.ajaxLoaderFormLoad').show();
}",
    'complete' => "function(){
    $('.ajaxLoaderFormLoad').hide();
}",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogAddPBrand div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddPBrand div.divForForm form').submit(addPBrand);
                                        }
                                        else
                                        {
                                            $('#dialogAddPBrand div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddPBrand').dialog('close') \",1000);
                                            $('#Items_pbrand').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script>
                </td>   
                <td><span class="green"></span></td>
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addPModel(); $('#dialogAddPModel').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogAddPModel',
                        'options' => array(
                            'title' => 'Add Model',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addPModel(){
<?php
echo CHtml::ajax(array(
    'url' => array('pModel/createPModelFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
    $('.ajaxLoaderFormLoad').show();
}",
    'complete' => "function(){
    $('.ajaxLoaderFormLoad').hide();
}",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogAddPModel div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddPModel div.divForForm form').submit(addPModel);
                                        }
                                        else
                                        {
                                            $('#dialogAddPModel div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddPModel').dialog('close') \",1000);
                                            $('#Items_pmodel').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script>
                </td>
                <td><span class="green"></span></td>
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
                <td><span class="green"></span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'country'); ?></td>  
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'product_type'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'product_type', Lookup::items('product_type'), array('prompt'=>'select'));
                    ?>
                </td>          
                <td><span class="green"></span></td>
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addItemGrade(); $('#dialogItemGrade').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogItemGrade',
                        'options' => array(
                            'title' => 'Add Grade',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addItemGrade(){
<?php
echo CHtml::ajax(array(
    'url' => array('grades/createGradesFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogItemGrade div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogItemGrade div.divForForm form').submit(addItemGrade);
                                        }
                                        else
                                        {
                                            $('#dialogItemGrade div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogItemGrade').dialog('close') \",1000);
                                            $('#Items_grade').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>            
                <td><span class="green"></span></td>
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addItemMfi(); $('#dialogItemMfi').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogItemMfi',
                        'options' => array(
                            'title' => 'Add MFI',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addItemMfi(){
<?php
echo CHtml::ajax(array(
    'url' => array('mfis/createMfisFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogItemMfi div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogItemMfi div.divForForm form').submit(addItemMfi);
                                        }
                                        else
                                        {
                                            $('#dialogItemMfi div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogItemMfi').dialog('close') \",1000);
                                            $('#Items_mfi').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>            
                <td><span class="green"></span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'mfi'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'warn_qty'); ?></td>
                <td><?php echo $form->textField($model, 'warn_qty'); ?></td>        
                <td><span class="green"></span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'warn_qty'); ?></td>
            </tr>
        </table>
    </fieldset>
    <div style="float: left; width: 100%;"><input class="addRight" title="Add" type="button" value="" onclick="AddNew()" /></div>
    <fieldset style="width: 1320px; float: left; overflow: scroll; height: 330px;" class="someStyle">
        <legend>Added List</legend>
        <table id="tbl" class="prodAddedTab">
            <tr>
                <th style="width: 10px;">SL</th>
                <th>Store</th>
                <th>Category</th>
                <th>Sub-Category</th>
                <th>Code</th>
                <th>Name</th>
                <th>Specification</th>
                <th>Unit</th>
                <th>Supplier</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Country</th>
                <th>Product Type</th>
                <th>Grade</th>
                <th>MFI</th>
                <th>Warn Qty</th>
                <th>isRatMat.</th>
                <th>isVATable</th>
                <th>isUnitConv.</th>
                <th style="width: 32px;">Remove</th>
            </tr>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('items/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        errCodeArr.length=0;
                        errNameArr.length=0;
                        errUnitArr.length=0;
                        $("#tbl tr.cartList").remove();
                        sl=0;
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#items-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("items-grid", {
                                data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#items-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#items-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    if($("#tbl tr").length<=1){
                        alertify.alert("Please add items first!");
                        return false;
                    }else{
                        
                        for(var i=1; i<($("#tbl tr").length); i++){
                            if($("#Items_name_"+i).val()==""){
                                $("#Items_name_"+i).css("border-color","red");
                                errNameArr[i]="err_exist";
                            }else{
                                $("#Items_name_"+i).css("border-color","#aaa");
                                errNameArr[i]="";
                            }
                            if($("#Items_unit_"+i).val()==""){
                                $("#Items_unit_"+i).css("border-color","red");
                                errUnitArr[i]="err_exist";
                            }else{
                                $("#Items_unit_"+i).css("border-color","#aaa");
                                errUnitArr[i]="";
                            }
                        }
                        if($.inArray("err_exist", errCodeArr)>-1){
                            alertify.alert("There is an empty field on item code column !");
                            return false;
                        }else if($.inArray("err_exist", errNameArr)>-1){
                            alertify.alert("There is an empty field on item name column !");
                            return false;
                        }else if($.inArray("err_exist", errUnitArr)>-1){
                            alertify.alert("There is an empty field on unit column !");
                            return false;
                        }else{
                            $("#ajaxLoader").show();
                        }
                    }
             }'
        ));
        ?>
    </fieldset>
    <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
    <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">  
    var sl=0;
    var errCodeArr=new Array();
    var errNameArr=new Array();
    var errUnitArr=new Array();
    $("#tbl td input.rdelete").live("click", function () {
        var idCounter=$(this).attr("id");
        var srow = $(this).parent().parent();
        srow.remove();
        $("#tbl td.sno").each(function(index, element){                 
            $(element).text(index + 1); 
        });
        errCodeArr[idCounter]="";
        errNameArr[idCounter]="";
        errUnitArr[idCounter]="";
    }); 
    
    function AddNew() {
        if($("#Items_cat").val()==""){
            alertify.alert("Please select a category first !");
        }else{
            add();
        }        
    } 
    
    function add(){
        sl++;
        var slNumber=$('#tbl tr').length;
            
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='Items[store][]' id='Items_store_"+sl+"' value='"+$("#Items_store").val()+"'>"+
            "<input type='hidden' name='Items[cat][]' id='Items_cat_"+sl+"' value='"+$("#Items_cat").val()+"'>"+
            "<input type='hidden' name='Items[cat_sub][]' id='Items_cat_sub_"+sl+"' value='"+$("#Items_cat_sub").val()+"'>"+
            "<input type='hidden' name='Items[supplier_id][]' id='Items_supplier_id_"+sl+"' value='"+$("#Items_supplier_id").val()+"'>"+
            "<input type='hidden' name='Items[unit][]' id='Items_unit_"+sl+"' value='"+$("#Items_unit").val()+"'>"+
            "<input type='hidden' name='Items[pbrand][]' id='Items_pbrand_"+sl+"' value='"+$("#Items_pbrand").val()+"'>"+
            "<input type='hidden' name='Items[pmodel][]' id='Items_pmodel_"+sl+"' value='"+$("#Items_pmodel").val()+"'>"+
            "<input type='hidden' name='Items[country][]' id='Items_country_"+sl+"' value='"+$("#Items_country").val()+"'>"+
            "<input type='hidden' name='Items[product_type][]' id='Items_product_type_"+sl+"' value='"+$("#Items_product_type").val()+"'>"+
            "<input type='hidden' name='Items[grade][]' id='Items_grade_"+sl+"' value='"+$("#Items_grade").val()+"'>"+
            "<input type='hidden' name='Items[mfi][]' id='Items_mfi_"+sl+"' value='"+$("#Items_mfi").val()+"'>"+
            "<td class='sno' style='border-right: 1px solid #999;'>"+
            slNumber +
              "</td><td>" + 
               $("#Items_store option:selected").text() +
            "</td><td style='text-align: left;'>" + 
            
            $("#Items_cat option:selected").text() +
            "</td><td>" + 
            $("#Items_cat_sub option:selected").text() +
            "</td><td>" + 
            "<input type='text' name='Items[code][]' id='Items_code_"+sl+"' value='"+$("#Items_code").val()+"'>"+
            "</td><td>" + 
            "<input type='text' name='Items[name][]' id='Items_name_"+sl+"' value='"+$("#Items_name").val()+"'>"+
            "</td><td>" + 
            "<input type='text' name='Items[desc][]' id='Items_desc_"+sl+"' value='"+$("#Items_desc").val()+"'>"+
            "</td><td>" +
           $("#Items_unit option:selected").text() +
            "</td><td>" +
            $("#Items_supplier_id option:selected").text() +
            "</td><td>" + 
            $("#Items_pbrand option:selected").text() +
            "</td><td>" +
            $("#Items_pmodel option:selected").text() +
            "</td><td>" +
            $("#Items_country option:selected").text() +
            "</td><td>" +
            $("#Items_product_type option:selected").text() +
            "</td><td>" +
            $("#Items_grade option:selected").text() +
            "</td><td>" +
            $("#Items_mfi option:selected").text() +
            "</td><td>" +
            "<input type='text' name='Items[warn_qty][]' id='Items_warn_qty_"+sl+"' value='"+$("#Items_warn_qty").val()+"'>"+
            "</td><td>" +
            "<input type='checkbox' name='Items[is_rawmat][]' id='Items_is_rawmat_"+sl+"'>"+
            "</td><td>" +
            "<input type='checkbox' name='Items[vatable][]' id='Items_is_vatable_"+sl+"'>"+
            "</td><td>" +
            "<input type='checkbox' name='Items[unit_convertable][]' id='Items_unit_convertable_"+sl+"'>"+
            "</td><td>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt);
    }
</script>
