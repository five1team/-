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


class PersonalController extends Controller{
    
    public $layout=false;
    public function init(){
    
    $this->enableCsrfValidation = false;
  }

    //个人简历  
    public function actionResume(){

      return $this->render('resume');
    } 

  
    //个人设置
    public function actionSetup(){

      return $this->render('Setup');
    } 
 
    //个人收藏
    public function actionCollect(){

      return $this->render('collect');
    } 

    //我的简历
    public function actionResume1(){

      return $this->render('resume1');
    } 

 
   //创建我的简历1
    public function actionResumes1(){

      return $this->render('resumes1');
    } 



   //创建我的简历2
    public function actionResumes2(){

      return $this->render('resumes2');
    } 

   //创建我的简历3
    public function actionResumes3(){

      return $this->render('resumes3');
    } 

   //我的申请记录
    public function actionNotices(){

      return $this->render('notices');
    } 

   //我的个人信息
    public function actionResets(){

      return $this->render('resets');
    } 

   //个人投递记录  

    public function actionResume_list(){

       return $this->render('resume_list');
 

    }
 
   //求职意向
    public function actionIntention(){

       return $this->render('intention');
 

    }

 } 