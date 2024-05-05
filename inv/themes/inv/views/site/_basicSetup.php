<div class="filterDiv">
    <ul>
        <li>
            <label>Start Date</label>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig1 = array(
                'name' => 'startDate',
                'mode' => 'date',
                'language' => 'en-AU',
                'options' => array(
                    'changeMonth' => 'true',
                    'changeYear' => 'true',
                    'dateFormat' => 'yy-mm-dd',
                ),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
            ?>
        </li>
        <li>
            <label>End Date</label>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig2 = array(
                'name' => 'endDate',
                'mode' => 'date',
                'language' => 'en-AU',
                'options' => array(
                    'changeMonth' => 'true',
                    'changeYear' => 'true',
                    'dateFormat' => 'yy-mm-dd',
                ),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
            ?>
        </li>
        <li>
            <?php
            echo CHtml::ajaxLink(
                    "Liabilities", Yii::app()->createUrl('dashBoardReport/liabilitiesPreview'), array(
                'type' => 'POST',
                'beforeSend' => "function(){
                       $('#ajaxLoader').show();
                     }",
                'success' => "function( data ){
                        $('#liabilities').html(data);                                                               
                    }",
                'complete' => "function(){
                        $('#ajaxLoader').hide(); 
                    }",
                'data' => array(
                    'startDate' => 'js:jQuery("#startDate").val()',
                    'endDate' => 'js:jQuery("#endDate").val()'
                )
                    ), array(
                'href' => Yii::app()->createUrl('inventory/liabilitiesPreview'),
                'class' => 'additionalBtn'
                    )
            );
            ?>
            <?php
            echo CHtml::ajaxLink(
                    "Purchase", Yii::app()->createUrl('dashBoardReport/purchasePreview'), array(
                'type' => 'POST',
                'beforeSend' => "function(){
                       $('#ajaxLoader').show();
                     }",
                'success' => "function( data ){
                        $('#purchase').html(data);                                                               
                    }",
                'complete' => "function(){
                        $('#ajaxLoader').hide(); 
                    }",
                'data' => array(
                    'startDate' => 'js:jQuery("#startDate").val()',
                    'endDate' => 'js:jQuery("#endDate").val()'
                )
                    ), array(
                'href' => Yii::app()->createUrl('dashBoardReport/purchasePreview'),
                'class' => 'additionalBtn'
                    )
            );
            ?>
            <?php
            echo CHtml::ajaxLink(
                    "Sales", Yii::app()->createUrl('dashBoardReport/salesPreview'), array(
                'type' => 'POST',
                'beforeSend' => "function(){
                       $('#ajaxLoader').show();
                     }",
                'success' => "function( data ){
                        $('#sales').html(data);                                                               
                    }",
                'complete' => "function(){
                        $('#ajaxLoader').hide(); 
                    }",
                'data' => array(
                    'startDate' => 'js:jQuery("#startDate").val()',
                    'endDate' => 'js:jQuery("#endDate").val()'
                )
                    ), array(
                'href' => Yii::app()->createUrl('dashBoardReport/salesPreview'),
                'class' => 'additionalBtn'
                    )
            );
            ?>
            <?php
            echo CHTml::link("Graph", Yii::app()->createUrl('dashBoardReport/liabilitiesGraphPreview'), array(
                'class' => 'additionalBtn',
                'target'=>'_blank'
                    ));
            ?>
        </li>
        <li>
            <span class="heighlightSpan">If the given date range is empty, results will be generated over whole transactions.</span>
        </li>
        <li>
            <div id="ajaxLoader" style="display: none;"><img width="100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-bar.gif" /></div>
        </li>
    </ul>
</div>
<div id="liabilities"></div>
<div id="purchase"></div>
<div id="sales"></div>
<style>
    .filterDiv{
        float: left;
        height: 200px;
    }
    .sec{
        background-color: #666666;
        border-radius: 16px 16px 0 0;
        box-shadow: -1px -3px 3px gold;
        float: left;
        margin-bottom: 25px;
        margin-left: 20px;
        padding: 10px;
        width: 96%;
    }
    .filterDiv ul{
        list-style: none;
    }
    .filterDiv ul li{
        margin-bottom: 10px;
    }
    .title{
         color: cornsilk;
        float: left;
        font-style: italic;
        font-weight: bold;
        padding: 10px;
        text-shadow: 0px 0px 1px #000000;
    }
    .remove{
        float: right;
    }
    a.additionalBtn {
        -moz-box-shadow:inset 0px -3px 7px 0px #29bbff;
        -webkit-box-shadow:inset 0px -3px 7px 0px #29bbff;
        box-shadow:inset 0px -3px 7px 0px #29bbff;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #2dabf9), color-stop(1, #0688fa));
        background:-moz-linear-gradient(top, #2dabf9 5%, #0688fa 100%);
        background:-webkit-linear-gradient(top, #2dabf9 5%, #0688fa 100%);
        background:-o-linear-gradient(top, #2dabf9 5%, #0688fa 100%);
        background:-ms-linear-gradient(top, #2dabf9 5%, #0688fa 100%);
        background:linear-gradient(to bottom, #2dabf9 5%, #0688fa 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#2dabf9', endColorstr='#0688fa',GradientType=0);
        background-color:#2dabf9;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;
        border:1px solid #0b0e07;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:12px;
        padding:6px 20px;
        text-decoration:none;
        text-shadow:0px 1px 0px #263666;
    }
    a.additionalBtn:active { 
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0688fa), color-stop(1, #2dabf9));
        background:-moz-linear-gradient(top, #0688fa 5%, #2dabf9 100%);
        background:-webkit-linear-gradient(top, #0688fa 5%, #2dabf9 100%);
        background:-o-linear-gradient(top, #0688fa 5%, #2dabf9 100%);
        background:-ms-linear-gradient(top, #0688fa 5%, #2dabf9 100%);
        background:linear-gradient(to bottom, #0688fa 5%, #2dabf9 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0688fa', endColorstr='#2dabf9',GradientType=0);
        background-color:#0688fa;
    }
    a.additionalBtn:hover { 
        position:relative;
        top:1px;
    }
    table.dashBoardTab{
        float: left;
        width: 100%;
        border: 1px solid #979797;
        border-collapse: collapse;
        background-color: #FFFFFF;
    }
    table.dashBoardTab tr{
        border: 1px solid #979797;
    }
    table.dashBoardTab tr th, 
    table.dashBoardTab tr td{
        border: 1px solid #979797;
        text-align: center;
        padding: 6px;
    }
    table.dashBoardTab tr th.titleTh{
        background-color: #e6e6e6; 
        color: red;
    }
</style>