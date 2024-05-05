<?php
if ($cats) {
    foreach ($cats as $cts) {
        ?>
        <div class="posItemCats categories soundBtn" id="cat_<?php echo $cts->id; ?>">
            <span class="prodTitle">
                <?php
                $catName = $cts->name;
                echo $catName;
                ?>
            </span>
        </div>
        <?php
        $condition = "cat=" . $cts->id;
        if ($supplier_id != "")
            $condition.=" AND supplier_id=" . $supplier_id;
        if ($pbrand != "")
            $condition.=" AND pbrand=" . $pbrand;
        if ($pmodel != "")
            $condition.=" AND pmodel=" . $pmodel;
        if ($country != "")
            $condition.=" AND country=" . $country;
        if ($grade != "")
            $condition.=" AND grade=" . $grade;
        if ($mfi != "")
            $condition.=" AND mfi=" . $mfi;
        if ($product_type != "")
            $condition.=" AND product_type=" . $product_type;
        $condition.=" GROUP BY cat_sub ORDER BY cat_sub ASC";
        $subCats = Items::model()->findAll($condition);
        if ($subCats) {
            ?>
            <div class="subCatsOfThisCat" id="subCat_cat_<?php echo $cts->id; ?>" style="display: none;">
                <?php
                foreach ($subCats as $subCat) {
                    if ($subCat->cat_sub != "") {
                        ?>
                        <div class="posItemCats subCategories soundBtn" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>">
                            <span class="prodTitle">
                                <?php
                                $subCatName = CatsSub::model()->nameOfThis($subCat->cat_sub);
                                echo $subCatName;
                                ?>
                            </span>
                        </div>
                        <?php
                        $condition2 = "cat=" . $cts->id . " AND cat_sub=" . $subCat->cat_sub;
                        if ($supplier_id != "")
                            $condition2.=" AND supplier_id=" . $supplier_id;
                        if ($pbrand != "")
                            $condition2.=" AND pbrand=" . $pbrand;
                        if ($pmodel != "")
                            $condition2.=" AND pmodel=" . $pmodel;
                        if ($country != "")
                            $condition2.=" AND country=" . $country;
                        if ($grade != "")
                            $condition2.=" AND grade=" . $grade;
                        if ($mfi != "")
                            $condition2.=" AND mfi=" . $mfi;
                        if ($product_type != "")
                            $condition2.=" AND product_type=" . $product_type;
                        $condition2.=" ORDER BY name ASC";
                        $items = Items::model()->findAll($condition2);
                        if ($items) {
                            ?>
                            <div class="items" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>_item" style="display: none;">
                                <?php
                                foreach ($items as $itms) {
                                    $id = $itms->id;
                                    $cat = $catName;
                                    $catSub = $subCatName;
                                    $name = $itms->name;
                                    $code = $itms->code;
                                    $desc = $itms->desc;
                                    $unit = $itms->unit;
                                    $isVatable = $itms->vatable;

                                    $item = $name . " (" . $code . ")";
                                    if ($catSub != "")
                                        $item.="- " . $catSub;
                                    $item.="- " . $cat;
                                    if ($desc != "")
                                        $item.="- " . $desc;
                                    if ($unit != "")
                                        $item.="- " . $unit;
                                    ?>
                                    <div class="posItemCats itms soundBtn" id="<?php echo $id; ?>" name="<?php echo $item; ?>">
                                        <span class="prodTitle">
                                            <?php echo $item; ?>
                                        </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    } else {
                        $condition3 = "cat=" . $cts->id . " AND cat_sub is NULL";
                        if ($supplier_id != "")
                            $condition3.=" AND supplier_id=" . $supplier_id;
                        if ($pbrand != "")
                            $condition3.=" AND pbrand=" . $pbrand;
                        if ($pmodel != "")
                            $condition3.=" AND pmodel=" . $pmodel;
                        if ($country != "")
                            $condition3.=" AND country=" . $country;
                        if ($grade != "")
                            $condition3.=" AND grade=" . $grade;
                        if ($mfi != "")
                            $condition3.=" AND mfi=" . $mfi;
                        if ($product_type != "")
                            $condition3.=" AND product_type=" . $product_type;
                        $condition3.=" ORDER BY name ASC";
                        $items = Items::model()->findAll($condition3);
                        if ($items) {
                            ?>
                            <div class="items itemsWithNoSubCat" id="cat_<?php echo $cts->id; ?>_subCat_no_item" style="display: none;">
                                <?php
                                foreach ($items as $itms) {
                                    $id = $itms->id;
                                    $cat = $catName;
                                    $catSub = "";
                                    $name = $itms->name;
                                    $code = $itms->code;
                                    $desc = $itms->desc;
                                    $unit = $itms->unit;
                                    $isVatable = $itms->vatable;

                                    $item = $name . " (" . $code . ")";
                                    if ($catSub != "")
                                        $item.="- " . $catSub;
                                    $item.="- " . $cat;
                                    if ($desc != "")
                                        $item.="- " . $desc;
                                    if ($unit != "")
                                        $item.="- " . $unit;
                                    ?>
                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $item; ?>">
                                        <span class="prodTitle">
                                            <?php echo $item; ?>
                                        </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
            <?php
        }
    }
} else {
    echo "<div class='flash-error'>No items found for these searching criteria !</div>";
}
?>

<script>
    $(document).ready(function(){
        ion.sound({
            sounds: [
                {name: "beep"}
            ],
            path: "<?php echo Yii::app()->theme->baseUrl; ?>/sounds/",
            preload: true,
            volume: 1.0
        });

        $(".soundBtn").click(function(){
            ion.sound.play("beep");
        });
        
        $(".categories").click(function(){
            var thisCatId=$(this).attr("id");
            $(".categories").hide();
            $(".subCategories").show();
            $("#subCat_"+thisCatId).show();
            $("#"+thisCatId+"_subCat_no_item").show();
        });
        $(".subCategories").click(function(){
            var thisSubCatId=$(this).attr("id");
            $(".subCategories").hide();
            $(".itemsWithNoSubCat").hide();
            $("#"+thisSubCatId+"_item").show();
        });
        $(".main_menuBtn").click(function(){
            $(".categories").show();
            $(".subCatsOfThisCat").hide();
            $(".items").hide();
        });

        $(".resetBtn").click(function(){
            $(".categories").show();
            $(".subCatsOfThisCat").hide();
            $(".items").hide();
            newArr.length=0;
            $("#tbl tr.cartList").remove();
            sl=0;
            $("#inventory-form")[0].reset();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            
            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#qtyInpt_"+positionOfArrVal).val(newQty);
            }else{
                add(itemsId, itemsName);
                newArr[sl]=itemsId;
            }
        });
    })
    
    //-----------------------------------------------------
    
    $("#tbl td input.rdelete").live("click", function () {
        var idCounter=$(this).attr("id");
        var srow = $(this).parent().parent();
        srow.remove();
        $("#tbl td.sno").each(function(index, element){                 
            $(element).text(index + 1); 
        });
        newArr[idCounter]=0;
        errQtyArr[idCounter]="";
        errPriceArr[idCounter]="";
    });
    
    function add(itemsId, itemsName){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='Inventory[item][]' value='"+itemsId+"'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
            "</td><td>" +
            "<input style='text-align: center;' id='qtyInpt_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='Inventory[stock_in][]' value='1'>"+
            "</td><td>" +
            "<input style='text-align: center;' id='priceInpt_"+sl+"' type='text' name='Inventory[costing_price][]'>"+
            "</td><td style='text-align: center;'>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt);
    }
    
</script>
