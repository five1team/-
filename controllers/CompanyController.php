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
use yii\web\UploadedFile;
use frontend\models\UploadForm;

class CompanyController extends Controller{
    
    public $layout=false;
    public function init(){
    
    $this->enableCsrfValidation = false;
  }
   
    //公司设置
    public function actionSet_com(){

        $model = new UploadForm();  
        return $this->render('set_com',['model'=>$model]);

    }
     
    //公司
     public function actionCompany(){


        return $this->render('company');

    }

    //公司信息中心
     public function actionCompany_center(){
        $session = Yii::$app->session;
        $com_name = $session->get('com_name'); 

        return $this->render('company_center',['com_name'=>$com_name]);

    }
      
    //公司信息中心
     public function actionCompany_create(){
        $session = Yii::$app->session;
        $com_name = $session->get('com_name'); 
        $sql = "select * from tr_job_edu";
        //教育
        $data = yii::$app->db->createCommand($sql)->queryAll();
        $sql = "select * from tr_job_property";
        //工作性质
        $res = yii::$app->db->createCommand($sql)->queryAll();
        $sql = "select * from tr_monery";
        //工资
        $arr = yii::$app->db->createCommand($sql)->queryAll();
        $sql = "select * from tr_experience";
        //工作经验
        $arrs = yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('company_create',['com_name'=>$com_name,'data'=>$data,'res'=>$res,'arr'=>$arr,'arrs'=>$arrs]);

    }

   //公司发布职位
    public function actionCompany_add_do(){
       $session = Yii::$app->session;
       $com_name = $session->get('com_name');
       $com_id = $session->get('com_id');
       $data = yii::$app->request->post();
       $job_name = $data['job_name'];
      
       $position_name = $data['position_name'];
       
       $job_num = $data['job_num'];
       
       $issue_time = time($data['issue_time']);
       $min_monery = $data['min_monery'];
       $max_monery = $data['max_monery'];
       $job_vearlimit = $data['job_vearlimit'];
       $job_property = $data['job_property'];
       $job_addr = $data['job_addr'];
       $job_edu = $data['job_edu'];
       $job_describ = $data['job_describ'];
       $email = $data['email'];

       $arr = array(
          'com_id'=>$com_id,
          'job_name'=>$job_name,
          'position_name'=>$position_name,
          'job_num'=>$job_num,
          'job_property'=>$job_property,
          'issue_time'=>$issue_time,
          'job_addr'=>$job_addr,
          'min_monery'=>$min_monery,
          'max_monery'=>$max_monery,
          'job_vearlimit'=>$job_vearlimit,
          'job_edu'=>$job_edu,
          'job_describ'=>$job_describ,
          'email'=>$email,
        );

       $res = yii::$app->db->createCommand()->insert('tr_release_position',$arr)->execute();

       if ($res){ 
           echo "<script>alert('职位发布成功');</script>";
           $this->redirect(array('company/myhome'));
       }else{
           echo "<script>alert('职位发布失败');</script>";
          $this->redirect(array('company/myhome')); 

       } 

    }






   //公司信息添加
      public function actionCompany_info_add(){
        $session = Yii::$app->session;
        $model = new UploadForm(); 
        $a = $model->business_licence = UploadedFile::getInstance($model, 'business_licence');
        
            if ($model->upload()) {
              $img = 'uploads/'.time('Y-m-d H:i:s').$a;
    
          }
     
     //接受所有数据
        $data = yii::$app->request->post();
        $com_name = $data['com_name'];
        $phone = $data['phone'];
        $linkman = $data['linkman'];
        $linkman_sex = $data['linkman_sex'];
        $tel = $data['tel'];
        $com_area = $data['com_area'];
        $postal_address = $data['postal_address'];
        $com_size = $data['com_size'];
        $com_property = $data['com_property'];
        $com_intro = $data['com_intro'];
        //判断公司名称
        if ($com_name == ''){
             
           echo "<script>alert('企业名称不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }


       
        //判断电话名称
        if ($phone == ''){
             
           echo "<script>alert('联系电话不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }

        //正则表达式
          $preg = '/^\d{11}$/';

          //进行正则匹配  
           if (!preg_match($preg,$phone)){
           
           echo "<script>alert('联系电话格式不正确');</script>";
             return $this->render('set_com',['model'=>$model]); 
         }


        //判断联系人
        if ($linkman == ''){
             
           echo "<script>alert('联系人不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }

       


        //固定电话
        if ($tel == ''){
             
           echo "<script>alert('固定电话不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }

        //正则表达式
          $preg = '/^\d{11}$/';

          //进行正则匹配  
           if (!preg_match($preg,$tel)){
           
           echo "<script>alert('固定电话格式不正确');</script>";
             return $this->render('set_com',['model'=>$model]); 
         }



        //企业地址
        if ($com_area == ''){
             
           echo "<script>alert('企业地址不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }


        //通讯地址
        if ($postal_address == ''){
             
           echo "<script>alert('通讯地址不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }





        //企业简介
        if ($com_intro == ''){
             
           echo "<script>alert('企业简介不能为空');</script>";
           return $this->render('set_com',['model'=>$model]);
        }
        
        $com_id = $session->get('com_id');
        $arr = array(
             'com_id'=>$com_id,
             'com_name'=>$com_name,
             'com_area'=>$com_area,
             'com_size'=>$com_size,
             'com_property'=>$com_property,
             'linkman'=>$linkman,
             'linkman_sex'=>$linkman_sex,
             'tel'=>$tel,
             'phone'=>$phone,
             'postal_address'=>$postal_address,
             'com_intro'=>$com_intro,
             'business_licence'=>$img,
            );         
        $res = yii::$app->db->createCommand()->insert('tr_com_base',$arr)->execute();
        
        if ($res){
               $session->set('com_name');
               echo "<script>alert('添加成功');</script>";
               return $this->render('company_create');
        }else{
               echo "<script>alert('添加失败');</script>";
               return $this->render('set_com',['model'=>$model]); 
        }


     }

    


  
        


       //已通知面试简历

     public function actionFace(){
        $arr = yii::$app->request->get();
        $face = 1;
        $resume_id = $arr['id'];
        $data = array(
            'face'=>$face,
          );
        $where = "resume_id = '$resume_id'";
        $res = yii::$app->db->createCommand()->update('tr_resume',$data,$where)->execute();
        $this->redirect(array('company/notice'));

    }
       //已通知面试简历
    public function actionNotice(){
       $sql = "select * from tr_resume where face = 1 and suitable = 0";
      
       $res = yii::$app->db->createCommand($sql)->queryAll();
       
       return $this->render('notice',['res'=>$res]);
    }
    
      //待处理简历

     public function actionTreated(){
        $session = Yii::$app->session;        
        $com_id = $session['com_id'];
        $sql = "select * from tr_per_apply where com_id in ('$com_id')";
        $res = yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $key => $value) {
         $user_id[] = $value['user_id'];

        }
        $user_id = implode(',', $user_id); 
        $sql1 = "select * from tr_user_info where user_id in ($user_id)";
        $res1 = yii::$app->db->createCommand($sql1)->queryAll();
         foreach ($res1 as $key => $value) {
         $tel[] = $value['tel'];

        }
        $tel = implode(',', $tel);

        $sql2 = "select * from tr_resume where tel in ($tel) and face = 0 and suitable = 0";
        $res2 = yii::$app->db->createCommand($sql2)->queryAll();

      /*  if (empty($res2)){
            return $this->render('treated',['res2'=>$res2]);
        }
          foreach ($res2 as $key => $value) {
         $edu_id[] = $value['hight_eduction'];

        }
        $edu_id = implode(',', $edu_id);
        $sqls = "select * from tr_job_edu where edu_id in ('$edu_id')";
        $rss = yii::$app->db->createCommand($sqls)->queryAll(); 
         foreach ($rss as $key => $value) {
         $edu_name[] = $value['edu_name'];

        }
        $edu_name = implode(',', $edu_name);
         
         foreach ($res2 as $key => $value) {
         $resume_id[] = $value['resume_id'];

        }
        $resume_id = implode(',', $resume_id);
        
        $sql3 = "select * from tr_per_job where resume_id in ($resume_id)";
        $res3 = yii::$app->db->createCommand($sql3)->queryAll();        
        $resume_id1 = $res3['0']['resume_id'];
        $sql4 = "select * from tr_per_work where resume_id = '$resume_id1'";
        $res4 = yii::$app->db->createCommand($sql4)->queryAll();*/
        return $this->render('treated',['res2'=>$res2]);

    }


   //隐藏简历
        public function actionDelete(){
         $suitable = 2;
         $data = yii::$app->request->get();
         $resume_id = $data['id'];
         $arr = array(
             'suitable'=>$suitable,
         );
         $where = "resume_id = '$resume_id'";
         $res = yii::$app->db->createCommand()->update('tr_resume',$arr,$where)->execute();
         if ($res){
             $this->redirect(array('company/haverefuseresumes'));
         }          

    } 



   //不合适简历

     public function actionHaverefuseresumes(){
        $suitable = 2;
        $sql = "select * from tr_resume where suitable = 2";
        $res = yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('haverefuseresumes',['res'=>$res]);

    }

   //有效职位

     public function actionCompany_positions(){
        $sql = "select * from tr_release_position where status = 0";
        $data = yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('company_positions',['data'=>$data]);

    }


    //无效职位

     public function actionCompany_position(){
     

        return $this->render('company_position');

    }

    //我的公司

      public function actionMyhome(){
         $session = Yii::$app->session;
         $com_name = $session->get('com_name');  
         $sql = "select * from tr_com_base where com_name = '$com_name'";
         $data = yii::$app->db->createCommand($sql)->queryAll();
         
         return $this->render('myhome',['com_name'=>$com_name,'data'=>$data]);

      }





  }