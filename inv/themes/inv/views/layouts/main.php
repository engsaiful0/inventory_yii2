<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/menuIcons.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/layout.css" type="text/css" media="screen" />

        <!-- Beginning of compulsory code below  for menu-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/menu/css/dropdown.linear.columnar.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/menu/css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
        <!-- / END -->

        <!-- Alertify CSS -->

        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/alertify/alertify.core.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/alertify/alertify.default.css" type="text/css" media="screen" />

        <!-- END -->
        
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gridview/styles.css" type="text/css" media="screen" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.gif" />
        <?php
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/alertify/alertify.js');
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/ion.sound.js');
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-barcode.js');
        ?>
    </head>
    <body>    
        <?php echo $content; ?>
    </body>
</html>