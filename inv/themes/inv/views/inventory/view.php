<script>
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
</script>