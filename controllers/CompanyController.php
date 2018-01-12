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


class CompanyController extends Controller{
    
    public $layout=false;
    public function init(){
    
    $this->enableCsrfValidation = false;
  }
   
    //公司设置
    public function actionSet_com(){


        return $this->render('set_com');

    }
     
    //公司
     public function actionCompany(){


        return $this->render('company');

    }

    //公司信息中心
     public function actionCompany_center(){


        return $this->render('company_center');

    }

    //公司信息中心
     public function actionCompany_create(){


        return $this->render('company_create');

    }

   //自动过滤简历

     public function actionAutofilterresumes(){


        return $this->render('autofilterresumes');

    }
  
        

   //待定简历

     public function actionCaninterviewresumes(){


        return $this->render('caninterviewresumes');

    }
       //已通知面试简历

     public function actionNotice(){


        return $this->render('notice');

    }
          //待处理简历

     public function actionTreated(){


        return $this->render('treated');

    }







   //不合适简历

     public function actionHaverefuseresumes(){


        return $this->render('haverefuseresumes');

    }

   //有效职位

     public function actionCompany_positions(){


        return $this->render('company_positions');

    }


  }