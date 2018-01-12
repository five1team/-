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
     
      //企业登陆
      public function actionAdd_login(){
       $session = Yii::$app->session;
       $data = yii::$app->request->post();
       $com_user_name = $data['com_user_name'];
       $password = $data['password'];
       $password = md5($password);
       if (empty($com_user_name and $password)){
          echo "<script>alert('用户名或密码不能为空')</script>";
          return $this->render('login');     

       }else{
          $sql = "select * from tr_com_login where com_user_name = '$com_user_name' and password = '$password'";
          $res = yii::$app->db->createCommand($sql)->queryOne();
        
          if ($res){
            $sql = "select * from tr_com_base where tel = '$com_user_name'";
            $arr = yii::$app->db->createCommand($sql)->queryOne();
            $com_name = $arr['com_name'];
            $com_id = $arr['com_id'];
            $session->set('com_name',$com_name);
            $session->Set('com_id',$com_id);
            $this->redirect(array('company/myhome')); 

          }else{
            echo "<script>alert('用户名或密码错误')</script>";
            return $this->render('login');  
             
          }

       }
    }
   


   //公司注册
     public function actionAdd(){
        $session = Yii::$app->session;    
        $data = yii::$app->request->post();
        $com_user_name = $data['com_user_name'];
        $new_password = $data['password'];
        
        if ($com_user_name == '' and $new_password == ''){
             
           echo "<script>alert('用户名或密码不能为空');</script>"; 
           return $this->render('register');
        }
              $sql = "select * from tr_com_login where com_user_name = '$com_user_name'";


        $res1 = yii::$app->db->createCommand($sql)->queryOne(); 
        $com_id = $res1['com_id'];
        if ($res1){
           echo "<script>alert('用户名已存在')</script>";
           return $this->render('register');


        }
       $password = md5($new_password);
      $arr = array(
         'com_user_name'=>$com_user_name,
         'password'=>$password
        );
        $insert = Yii::$app->db->createCommand()->insert('tr_com_login',$arr)->execute();
        
       if($insert){
 
        $sql = "select * from tr_com_login where com_user_name = '$com_user_name'";

        $res2 = yii::$app->db->createCommand($sql)->queryOne(); 
        $com_id = $res2['com_id'];
           $session->set('com_id',$com_id);
           echo "<script>alert('注册成功')</script>";
           $this->redirect(array('index/login'));
        }
        else{
           echo "<script>alert('注册失败')</script>";
           return $this->render('register');
      }
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


