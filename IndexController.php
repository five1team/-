<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;


class IndexController extends Controller{
    
    public $layout=false;
    public $defaultRoute = 'index';
     public function init(){
    
    $this->enableCsrfValidation = false;
  }   

    //首页
    public function actionIndex(){

    	return $this->render('index');
    }

    
    //登录 
     public function actionLogin(){

     	return $this->render('login');
     }  



     //注册                
     public function actionRegister(){

     	return $this->render('register');
     } 
   
    //重置密码1
     public function actionReset1(){

     	return $this->render('reset1');
     } 
      
     //重置密码2
     public function actionReset2(){

     	return $this->render('reset2');
     } 
       
     //重置密码3
     public function actionReset3(){

     	return $this->render('reset3');
     } 
} 


