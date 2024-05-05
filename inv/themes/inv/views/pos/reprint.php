<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/pos/css/pos.css" type="text/css" media="screen" />
<div id="statusMsg"></div>
<fieldset style="margin: 5% auto 0; width: 360px;">
    <legend>Print POS Invoice</legend>
    <table>
        <tr>
            <td style="text-align: right;">Invoice No</td>
            <td>
                <input type="text" name="soForReport" id="soForReport" class="numPadBtnInput"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('pos/soReportOfThis'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       document.getElementById('soForReport').style.background='url(" . Yii::app()->theme->baseUrl . "/images/ajax-loader.gif) no-repeat #FFFFFF 95% 5px';   
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                        document.getElementById('soForReport').style.background='#FFFFFF'; 
                    }",
                    'data' => array(
                        'so' => 'js:jQuery("#soForReport").val()'
                    )
                        ), array(
                    'href' => Yii::app()->createUrl('pos/soReportOfThis'),
                    'class' => 'findBtn',
                    'style' => 'padding: 10px 12px; float: left;',
                        )
                );
                ?>
            </td>    
        </tr>
    </table>
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
            <td><input type="button" class="main_menuBtn soundBtn" value="CLOSE" onclick="closeMe();"/></td>
        </tr>
        <style>
            .numPadBtnInput{
                height: 40px;
            }
            input.numPadBtn[type="button"]{
                padding: 20px 24px;
            }
            input.ersButton[type="button"]{
                padding: 20px 24px;
            }
            input.main_menuBtn[type="button"]{
                padding: 20px 0px;
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
            table tr td {
                padding: 1px;
            }
        </style>
        <script type="text/javascript">
            function closeMe(){
                window.opener = self;
                window.close();
            }
            $(document).ready(function(){
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
                    var oldVal=focusedElemVal.val();
                    $reduceDval=focusedElemVal.val().slice(0, -1);
                    focusedElemVal.val($reduceDval);
                }); 
            });
        </script>
    </table>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'POS Invoice Preview',
        'autoOpen' => false,
        'modal' => true,
        'resizable' => false,
        'position' => 'top',
        'width'=>'306px',
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<style>
    .ui-widget-header .ui-icon {
/*        float: right;
        background: url("<?php //echo Yii::app()->theme->baseUrl; ?>/css/pos/images/close.png") center transparent no-repeat;
        width: 32px;
        height: 32px;*/
    }
    .ui-dialog .ui-dialog-titlebar-close{
/*        margin: -18px -5px 0px;*/
    }
</style>
