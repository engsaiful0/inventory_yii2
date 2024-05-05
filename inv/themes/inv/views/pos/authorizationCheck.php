<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'pos-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<style>
    .firstPosWrapper{
        margin: 1% auto;
        width: 50%;
    }
    .homeDiv{
        box-shadow: 0px 0px 4px teal;
        border: 1px solid tan;
        border-radius:6px;
        float: left;
        width: 80%;
        padding: 0px 8px;
    }
    .homeDivSec{
        float: left;
        width: 100%;
        margin: 4px 0px;
    }
    .posTitle{
        background: linear-gradient(to bottom, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f1da36',GradientType=0 ); /* IE6-9 */
        float: left;
        width: 100%;
        text-align: center;
        font-size: 22px;
        text-shadow:1px 1px 0px #FFFFFF;
        font-weight: bold;
        padding: 3% 0px;
        border-radius:6px;
    }
    .homeBtn{
        background: linear-gradient(to bottom, #ffd65e 0%,#febf04 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd65e', endColorstr='#febf04',GradientType=0 ); /* IE6-9 */
        border:1px solid #000000;
        border-radius:6px;
        display:inline-block;
        color:#000000;
        font-size:16px;
        font-weight: bold;
        text-decoration:none;
        text-shadow:1px 1px 0px #FFFFFF;
        float: left;
        width: 100%;
        height: 70px;
        margin: unset;
        padding: unset;
    }
    .homeBtn:active{
        position:relative;
        top:1px;
    }
    .homeBtn2{
        height: 100px;
    }
    input.numPadBtn[type="button"], input.ersButton[type="button"], input.ersButtonAll[type="button"]{
        float: left;
        padding: 20px 30px;
        width: 100%;
    }
</style>
<div class="firstPosWrapper">
    <div class="homeDiv">
        <div class="homeDivSec">
            <span class="posTitle">
                Authorization <div id="ajaxLoader" style="display: none;"><img width="100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-bar.gif" /></div>
            </span>
        </div>
        <div class="homeDivSec">
            <table>
                <tr>
                    <td colspan="2">
                        <?php if (Yii::app()->user->hasFlash('error')): ?>
                            <?php echo "<div class='flash-error'>" . Yii::app()->user->getFlash('error') . '</div>'; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'pin_code', array('style' => 'float: left; font-size: 23px; width: 40px;')); ?></td>
                    <td><?php echo $form->passwordField($model, 'pin_code', array('maxlength' => 255, 'style' => 'width: 99%; height: 100px; font-size: 100px;', 'class' => 'numPadBtnInput')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'pin_code'); ?></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <table class="numPadTab numPadTab2">
                            <tr>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn1" attrVl="1" value="1"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn2" attrVl="2" value="2"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn3" attrVl="3" value="3"/></td>
                            </tr>
                            <tr>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn4" attrVl="4" value="4"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn5" attrVl="5" value="5"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn6" attrVl="6" value="6"/></td>
                            </tr>
                            <tr>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn7" attrVl="7" value="7"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn8" attrVl="8" value="8"/></td>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn9" attrVl="9" value="9"/></td>
                            </tr>
                            <tr>
                                <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn0" attrVl="0" value="0"/></td>
                                <td><input type="button" class="ersButton soundBtn" id="numPadBtnClr" attrVl="c" value="X"/></td>
                                <td><input type="button" class="ersButtonAll soundBtn" id="numPadBtnClrAll" attrVl="ca" value="CA"/></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo CHtml::submitButton('Enter', array('class' => 'homeBtn homeBtn2', 'style' => 'margin-left: unset;', 'onclick'=>'$("#ajaxLoader").show();')); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    var focusedElem;
    $("input.numPadBtnInput").click(function(){
        focusedElem=$(this).attr("id");
    });
    
    $(".numPadBtn").click(function(e) {
        e.preventDefault();
        var numPadBtnVal=$(this).attr("attrVl");
        var focusedElemVal=$("#"+focusedElem);
        focusedElemVal.val(focusedElemVal.val() + numPadBtnVal + '');
    });
        
    $(".ersButton").click(function(e) {
        e.preventDefault();
        var focusedElemVal=$("#"+focusedElem);
        $reduceDval=focusedElemVal.val().slice(0, -1);
        focusedElemVal.val($reduceDval);
    });
    $(".ersButtonAll").click(function(e) {
        e.preventDefault();
        var focusedElemVal=$("#"+focusedElem);
        focusedElemVal.val("");
    });
</script>
<?php $this->endWidget(); ?>