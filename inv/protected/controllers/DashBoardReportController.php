<?php

class DashBoardReportController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions() {
        return '';
    }
    
    public function actionLiabilitiesGraphPreview(){
        $this->render('_liabilitiesGraphPreview');
    }


    public function actionLiabilitiesPreview() {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        echo $this->renderPartial('_liabilitiesPreview', array('startDate' => $startDate, 'endDate' => $endDate), true, true);
        Yii::app()->end();
    }
    
    public function actionPurchasePreview() {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        echo $this->renderPartial('_purchasePreview', array('startDate' => $startDate, 'endDate' => $endDate), true, true);
        Yii::app()->end();
    }
    
    public function actionSalesPreview() {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        echo $this->renderPartial('_salesPreview', array('startDate' => $startDate, 'endDate' => $endDate), true, true);
        Yii::app()->end();
    }

}
