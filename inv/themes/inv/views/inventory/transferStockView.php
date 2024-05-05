<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <td>
                    <div class="ajaxLoaderFormLoadPurchReq" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                </td>
                <td colspan="15" style="padding: 10px;">
                    <?php
                    echo CHtml::link('Transfer the stock for the selected items', "", // the link for open the dialog
                            array(
                        'class' => 'additionalBtn',
                        'onclick' => "{transferAll();}"));
                    ?>
                </td>
            </tr>
            <tr>
                <th style="width: 10px;">
                    <input id="selectall" type="checkbox"/>
                </th>
                <th style="width: 20px;">SL</th>
                <th>Category</th>
                <th>Code</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Country</th>
                <th>Product Type</th>
                <th>Grade</th>
                <th>MFI</th>
                <th>isRawMaterial</th>
                <th>Warning Qty</th>
                <th>Stock Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $i = 1;
                foreach ($data as $dt):
                    $availableStock = ($dt->sumStockIn - $dt->sumStockOut);
                    $costingPrice = $dt->costing_price;
                    if ($availableStock > 0) {
                        $d = Items::model()->findByPk($dt->item);
                        if ($d) {
                            ?>
                            <tr class='
                            <?php
                            if ($i % 2 == 0)
                                echo "even";
                            else
                                echo "odd";
                            ?>
                                '>
                                <td>
                                    <input 
                                        id="<?php echo $d->id; ?>" 
                                        attrStore="<?php echo $store; ?>" 
                                        attrProd="<?php echo $d->id; ?>" 
                                        attrProdAvStck="<?php echo $availableStock; ?>" 
                                        attrProdCost="<?php echo $costingPrice; ?>" 
                                        class="chckbxitms" type="checkbox"/>
                                </td>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align: left;"><?php echo Cats::model()->nameOfThis($d->cat); ?></td>
                                <td><?php echo $d->code; ?></td>
                                <td style="background-color: tan;"><label title="Click to select" class="labelForCheckBox" id="labelForCheckBox_<?php echo $d->id; ?>" for="<?php echo $d->id; ?>"><?php echo $d->name; ?></label></td>
                                <td><?php echo $d->unit; ?></td>
                                <td><?php echo $d->desc; ?></td>
                                <td><?php echo PBrand::model()->nameOfThis($d->pbrand); ?></td>
                                <td><?php echo PModel::model()->nameOfThis($d->pmodel); ?></td>
                                <td><?php echo Countries::model()->nameOfThis($d->country); ?></td>
                                <td><?php echo Lookup::item("product_type", $d->product_type); ?></td>
                                <td><?php echo $d->grade; ?></td>
                                <td><?php echo $d->mfi; ?></td>
                                <td><?php echo Items::model()->isRawmat($d->is_rawmat); ?></td>
                                <td><?php echo $d->warn_qty; ?></td>
                                <td><?php echo $availableStock; ?></td>
                            </tr>
                            <?php
                        }
                    }
                endforeach;
            }else {
                ?>
                <tr>
                    <td colspan="16">
                        <div class="flash-error">No result found !</div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTransferSelected',
    'options' => array(
        'title' => 'Transfer Stock',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div class="divForForm">

</div>

<?php $this->endWidget(); ?>
<style>
    label.labelForCheckBox{
        float: left; 
        width: 100%;
        color: #000000;
        height: 100%;
    }
    label.labelForCheckBox:hover{
        color: red;
    }
</style>
<script type="text/javascript">
    $('#selectall').click(function () {
        $('.chckbxitms').prop('checked', this.checked);
        $('.chckbxitms').each(function() { //loop through each checkbox
            if(this.checked){
                var thisId=$(this).attr("id");
                $("#labelForCheckBox_"+thisId).css("color","red");
            }else{
                var thisId=$(this).attr("id");
                $("#labelForCheckBox_"+thisId).css("color","#000000");
            }
        });
    });

    $('.chckbxitms').change(function () {
        if(this.checked){
            var thisId=$(this).attr("id");
            $("#labelForCheckBox_"+thisId).css("color","red");
        }else{
            var thisId=$(this).attr("id");
            $("#labelForCheckBox_"+thisId).css("color","#000000");
        }
        var check = ($('.chckbxitms').filter(":checked").length == $('.chckbxitms').length);
        $('#selectall').prop("checked", check);
    });
    function transferAll(){
        if(jQuery('input[type=checkbox]:checked').length==0){
            alertify.alert("Please select at least one item!");
        }else{
            var attrStoreArr = new Array();
            var attrProdArr = new Array();
            var attrProdAvStckArr = new Array();
            var attrProdCostArr=new Array();
                
            $('.chckbxitms').each(function() { //loop through each checkbox
                if(this.checked){
                    //alert($(this).attr("attrAVS"));
                    attrStoreArr.push($(this).attr("attrStore"));
                    attrProdArr.push($(this).attr("attrProd"));
                    attrProdAvStckArr.push($(this).attr("attrProdAvStck"));
                    attrProdCostArr.push($(this).attr("attrProdCost"));
                }
            });
                
            $('#dialogTransferSelected').dialog('destroy'); 
            $('#dialogTransferSelected').dialog({ autoOpen: false, resizable: false, title: 'Stock Transfer', width: 'auto', modal: true }); 
            $('#dialogTransferSelected').dialog('open');
<?php
echo CHtml::ajax(array(
    'url' => array('inventory/transferStockCreate'),
    'data' => "js:{'attrProdArr':''+attrProdArr+'', 'attrStoreArr':''+attrStoreArr+'', 'attrProdAvStckArr':''+attrProdAvStckArr+'', 'attrProdCostArr':''+attrProdCostArr+''}",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else if(data.status=='notTransfered')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                        else
                        {
                            $('#resultDiv').html('');
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            setTimeout(\"$('#dialogTransferSelected').dialog('close') \",1000);
                        }
                                                }",
));
?>;
        }
                
        
        return false; 
    } 
    
    function transferAllAgain(){
        if(jQuery('input[type=checkbox]:checked').length==0){
            alertify.alert("Please select at least one item!");
        }else{
            var dataString = '';
                            
<?php
echo CHtml::ajax(array(
    'url' => array('inventory/transferStockCreate'),
    'data' => "js:dataString+$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else if(data.status=='notTransfered')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                        else
                        {
                            $('#resultDiv').html('');
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            setTimeout(\"$('#dialogTransferSelected').dialog('close') \",1000);
                        }
                                                                                    }",
));
?>;
        } 
        return false; 
    } 
           
</script> 