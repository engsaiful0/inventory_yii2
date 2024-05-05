<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
?>
<div class="loginDiv">
    <span class="logoWrapper"><span class="logo"></span></span>
    <span class="ribbon"><?php echo Yii::app()->name; ?></span>
    <fieldset style="margin-top: 30px;">
        <div class="formelement">
            <table style="float: left; width: 100%;">
                <tr>
                    <td><label><?php echo $form->labelEx($model, 'username'); ?></label></td>
                    <td><?php echo $form->textField($model, 'username', array('class' => 'numPadBtnInput')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'username'); ?></td>
                </tr>
                <tr>
                    <td><label><?php echo $form->labelEx($model, 'password'); ?></label></td>
                    <td><?php echo $form->passwordField($model, 'password', array('class' => 'numPadBtnInput')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'password'); ?></td>
                </tr>
            </table>
        </div>
    </fieldset>
    <fieldset class="tblFooters">
        <table>
            <tr>
                <td><input type="button" class="closeWindowBtn" value="CLOSE" onclick="closeMe();"/></td>
                <td><?php echo CHtml::submitButton('Login', array("style"=>"float: left;")); ?></td>
            </tr>
        </table>
        <script type="text/javascript">
            function closeMe(){ 
                //about:config
                //allow_scripts_to_close_windows
                if(confirm("Are you sure you want to close ?")){
                    window.opener = self;
                    window.close();
                }
            
            }
        </script>
    </fieldset>
    <span class="requirement">Recommended: Mozila Firefox Version 41.0.2</span>
</div>
<div class="mykbWrp">
    <div class="mykbWrpInnr">
        <div class="mykbbtnswrpr">
            <input type="button" id="" class="kbtns numPadBtn" attrval1="1" attrval2="q" value="q"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="2" attrval2="w" value="w"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="3" attrval2="e" value="e"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="4" attrval2="r" value="r"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="5" attrval2="t" value="t"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="6" attrval2="y" value="y"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="7" attrval2="u" value="u"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="8" attrval2="i" value="i"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="9" attrval2="o" value="o"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="0" attrval2="p" value="p"/>
        </div>
        <div class="mykbbtnswrpr">
            <input type="button" id="" class="kbtns numPadBtn" attrval1="@" attrval2="a" value="a"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="#" attrval2="s" value="s"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="$" attrval2="d" value="d"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="%" attrval2="f" value="f"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="&" attrval2="g" value="g"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="-" attrval2="h" value="h"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="+" attrval2="j" value="j"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="(" attrval2="k" value="k"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1=")" attrval2="l" value="l"/>
        </div>
        <div class="mykbbtnswrpr">
            <input type="button" id="capsLockBtn" class="kbtns" attr1="lowercase" attrval1="caps lock" attrval2="caps lock" value="caps lock"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="*" attrval2="z" value="z"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="''" attrval2="x" value="x"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="'" attrval2="c" value="c"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1=":" attrval2="v" value="v"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1=";" attrval2="b" value="b"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="!" attrval2="n" value="n"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="?" attrval2="m" value="m"/>
            <input type="button" id="backspaceBtn" class="kbtns" attrval1="backspace" attrval2="backspace" value="backspace"/>
        </div>
        <div class="mykbbtnswrpr">
            <input type="button" id="altBtn" class="kbtns" attr1="alphabatic" attrval1="abc" attrval2="?123" value="?123"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="_" attrval2="," value=","/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="[" attrval2="{" value="{"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="]" attrval2="}" value="}"/>
            <input type="button" id="" class="kbtns numPadBtn" attrval1="." attrval2="." value="."/>
            <input type="button" id="closeBtn" class="kbtns" attrval1="close" attrval2="close" value="close"/>
        </div>
    </div>
</div>
<style>
    .mykbWrp{
        margin: 0 auto;

    }
    .mykbWrpInnr{
        float: left;
        width: 100%;
        display: none;
    }
    .mykbbtnswrpr{
        float: left;
        width: 100%;
        text-align: center;
    }
    .mykbbtnswrpr input[type="button"]{
        padding:2px 15px;
        font-size: 20px;
        font-weight: bolder;
        margin-bottom: 4px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("#capsLockBtn").click(function(){
            if($(this).attr("attr1")=="lowercase"){
                $(this).attr("attr1", "uppercase");
                $(".mykbbtnswrpr input").each(function(){
                    var oldVal=$(this).val();
                    var newVal=oldVal.toUpperCase();
                    $(this).val(newVal);
                });
            }else{
                $(this).attr("attr1", "lowercase");
                $(".mykbbtnswrpr input").each(function(){
                    var oldVal=$(this).val();
                    var newVal=oldVal.toLowerCase();
                    $(this).val(newVal);
                });
            }
        });
        $("#altBtn").click(function(){
            if($(this).attr("attr1")=="alphabatic"){
                $(this).attr("attr1", "numeric");
                $(".mykbbtnswrpr input").each(function(){
                    $(this).val($(this).attr("attrval1"));
                });
            }else{
                $(this).attr("attr1", "alphabatic");
                $(".mykbbtnswrpr input").each(function(){
                    $(this).val($(this).attr("attrval2"));
                });
            }
        });
        $("#closeBtn").click(function(){
            $(".mykbWrpInnr").slideUp(100);
        });
        $("input.numPadBtnInput").click(function(){
            focusedElem=$(this).attr("id");
            $(".mykbWrpInnr").slideDown(100);
        });
        $(".numPadBtn").click(function(e) {
            e.preventDefault();
            var numPadBtnVal=$(this).val();
            var focusedElemVal=$("#"+focusedElem);
            focusedElemVal.val(focusedElemVal.val() + numPadBtnVal + '');
        });

        $("#backspaceBtn").click(function(e) {
            e.preventDefault();
            var focusedElemVal=$("#"+focusedElem);
            var oldVal=focusedElemVal.val();
            $reduceDval=focusedElemVal.val().slice(0, -1);
            focusedElemVal.val($reduceDval);
        }); 
    });
</script>
<?php $this->endWidget(); ?>
<style>
    .loginDiv {
        margin: 6% auto 0;
        text-align: left;
        width: 30em;
    }
    img {
        left: 35.5%;
        opacity: 0.65;
        position: absolute;
        top: 4%;
        z-index: -2000;
    }
    .requirement{
        color: #FF0000; float: left; text-align: center; width: 100%;
    }
    input[type="text"],input[type="password"]{
        width:220px;
        font-size:20px;
    }
    input[type="submit"], input[type="submit"]:hover,input[type="submit"]:focus,input[type="submit"]:active{
        padding: 20px;
        font-size:16px;
        font-weight: bold;
        text-decoration:none;
        text-shadow:1px 1px 1px #000000;
        color: #FFFFFF;
        box-shadow:inset 0px 1px 0px 0px #54a3f7;
        background:linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
        background-color:#007dc1;
        border:1px solid #000000;
    }
    input[type="button"].closeWindowBtn{
        padding: 20px;
        box-shadow:inset 0px 1px 0px 0px #f29c93;
        background:linear-gradient(to bottom, #fe1a00 5%, #ce0100 100%);
        background-color:#fe1a00;
        border:1px solid #000000;
        border-radius:6px;
        display:inline-block;
        color:#ffffff;
        font-size:16px;
        font-weight: bold;
        text-decoration:none;
        text-shadow:1px 1px 1px #000000;
    }
</style>