<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }else{
            $this->redirect(Yii::app()->createUrl('site/dashBoard'));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'column1';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->createUrl('site/dashBoard'));
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }
    
    public function actionDashBoard() {
        if (!Yii::app()->user->isGuest) {
            $currDate = date('Y-m-d', time());
            $memberPointsData = MemberPointsConf::model()->findALl();
            if ($memberPointsData) {
                foreach ($memberPointsData as $mpd):
                    if ($mpd->end_date <= $currDate) {
                        MemberPointsConf::model()->updateAll(array('is_active' => MemberPointsConf::INACTIVE), 'id=:id', array(':id' => $mpd->id));
                    }
                endforeach;
            }
            $userInfo=Users::model()->findByPk(Yii::app()->user->getId());
            if($userInfo->is_pos_user==1){
                $this->layout = 'column1';
                $this->redirect(Yii::app()->createUrl('pos/authorizationCheck'));
            }
            else{
                $this->layout = 'column2';
                $this->render('dashBoard');
            }
        } else {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}