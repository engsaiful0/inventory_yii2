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
        $condition = "cat=".$cts->id;
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
                        $condition2 = "cat=".$cts->id." AND cat_sub=".$subCat->cat_sub;
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
                                    ?>
                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $subCatName; ?> - <?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
                                        <span class="prodTitle">
                                            <?php echo $itms->name; ?><br/>
                                            <span class="colorSpan">(<?php echo $itms->desc; ?>)</span>
                                        </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    } else {
                        $condition3 = "cat=".$cts->id." AND cat_sub is NULL";
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
                                    ?>
                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
                                        <span class="prodTitle">
                                            <?php echo $itms->name; ?><br/>
                                            <span class="colorSpan">(<?php echo $itms->desc; ?>)</span>
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
    function loadingDivDisplay(e){
        $("#ajaxLoaderMR").show();
    }
    function closeMe(){
        window.opener = self;
        window.close();
    }
        
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
            $("#production-output-form")[0].reset();
        });
                
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            $("#ProductionOutput_item").val(itemsId);
            $("#ProductionOutput_qty").val(1);
        });
    })
</script>
