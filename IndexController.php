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
    public $layout=true;
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

     public function actionReset()
     {
        $data = Yii::$app->request->post();
        $tel = $data['tel'];
        $yzm = rand(1000,9999);
        $sql = "SELECT * FROM tr_user_login  where tel = ".$tel;
        $data = Yii::$app->db->createCommand($sql)->queryOne();
        $user_id = $data['user_id'];
        $sql = "select * from tr_yzm where  tel = ".$tel;
        $userInfo = Yii::$app->db->createCommand($sql)->queryOne();
        // var_dump($data);die;
        if ($userInfo){//数据存在
            $serverTime = $userInfo['time'];
            $yxq = 60;
            if (($serverTime + $yxq) < time()){//数据过期了
                $where = 'uid = '.$user_id;
                $res = Yii::$app->db->createCommand()->delete('tr_yzm',$where)->execute();

                $yzm = rand(100000, 999999);
                $c = [
                    'uid' => $user_id,
                    'tel' => $tel,
                    'yzm' => $yzm,
                    'time' => time()
                ];
                $res = Yii::$app->db->createCommand()->insert('tr_yzm',$c)->execute();
                $this->sendUrl($tel, $yzm);
                echo "success";
            } 
            else {//数据没过期
                 echo ($yxq + $serverTime) - time();
            }
        } else {//数据不存在
            $yzm = rand(100000, 999999);
            $d = [
                'uid' => $user_id,
                'TEL' => $tel,
                'yzm' => $yzm,
                'time' => time()
            ];
            Yii::$app->db->createCommand()->insert('tr_yzm',$d)->execute();
            $this->sendUrl($tel, $yzm);
            echo 'success';
        }

     }
     public function sendUrl($tel, $yzm)
     {
         $url = "http://api.k780.com/?app=sms.send&tempid=51281&param=usernm%3Dadmin%26code%3D$yzm&phone=$tel&appkey=30377&sign=f2643856b50aae7c2c3037b06a1bbd41";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
     }
     public function actionYzzz()
     {
         $session = Yii::$app->session;
         $data = Yii::$app->request->post();
         $tel = $data['tel'];
         $yzmm = $data['yzmm'];
         $sql = "SELECT * FROM tr_yzm  where tel = ".$data['tel'];
         $userInfo = Yii::$app->db->createCommand($sql)->queryOne();
         $time = $userInfo['time'];
        $yxq  = 60;
        if($userInfo['yzm'] == $yzmm){
            if(($time + $yxq) < time()){//过期
                echo 'GQ';
            }else{
                $session->set('tel', $tel);
                echo 'OK';
                
            }
        }else{
            echo 'NO';
        }
     }
     public function actionUp_pwd()
     {
         $session = Yii::$app->session;
         $data = Yii::$app->request->post();
         $tel = $session['tel'];
         $new_password = $data['password'];
         $password = md5($new_password);
         $arr = array(
            'password'=>$password,
            );
         $where = "tel = '$tel'";
         $res = yii::$app->db->createCommand()->update('tr_user_login',$arr,$where)->execute();
         if ($res){
             echo "<script>alert('修改成功')</script>"; 
             return $this->render('reset3');
         }else{
              echo "<script>alert('修改失败')</script>"; 
             return $this->render('reset2');           
         }
         
     }

} 