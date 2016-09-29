<?php

 namespace app\modules\main\controllers;

use common\models\Advert;
use common\models\LoginForm;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\Marker;
use frontend\components\Common;
use frontend\filters\FilterAdvert;
use frontend\models\ContactForm;
use frontend\models\SignupForm;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use const YII_ENV_TEST;

 class MainController extends Controller {

     public $layout = 'inner';
     public $_view;

     public function behaviors() {
         return [
             [
                 'only'  => ['view-advert'],
                 'class' => FilterAdvert::className(),
             ]
         ];
     }

     public function actions() {
//        здесь задаем имя action
         return [
             'captcha' => [
                 'class'           => 'yii\captcha\CaptchaAction',
                 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
             ],
             'page' => [
                'class' => 'yii\web\ViewAction',//класс отвечает за генерацию статичной страницы
                'layout' => 'inner',
            ],
         ];
     }
     
     public function actionFind(){

        $this->layout = 'sell';

        $request = \Yii::$app->request;
        return $this->render("find", ['request' => $request]);

    }
    
         public function actionFindResult($propert='',$price='',$apartment = ''){

        $query = Advert::find();
//        в данном случае использовать filterWhere удобнее чем просто Where так как если значение будет пустое то строка просто не будет использоваться
        $query->filterWhere(['like', 'address', $propert])
            ->orFilterWhere(['like', 'description', $propert])
            ->andFilterWhere(['type' => $apartment]);

        if($price){
            $prices = explode("-",$price);

            if(isset($prices[0]) && isset($prices[1])) {
                $query->andWhere(['between', 'price', $prices[0], $prices[1]]);
            }
            else{
                $query->andWhere(['>=', 'price', $prices[0]]);
            }
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);

        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        if(empty($model)){
            return "Ничего не найдено";
        }elseif(empty ($propert) && empty ($price) && empty ($apartment)){
            return "Введите данные для поиска";
        }

        $request = \Yii::$app->request;
        return $this->renderAjax("findresult", ['model' => $model, 'pages' => $pages, 'request' => $request]);

    }


         public function actionIndex() {
         return $this->render('index');
     }

     public function actionLogin() {
         $model = new LoginForm();
         if ($model->load(Yii::$app->request->post()) && $model->login()) {
             $this->goBack(); //возвращаемся на предыдущую страницу
         }
         return $this->render('login', ['model' => $model]);
     }

     /**
      * Logs out the current user.
      *
      * @return mixed
      */
     public function actionLogout() {
         Yii::$app->user->logout();

         return $this->goHome(); //возвращаемся на домашнюю страницу
     }

     public function actionRegister() {

         $model = new SignupForm();
         //указываем нужный сценарий из модели
//        $model->scenario = 'short_register';
         if ($model->load(Yii::$app->request->post()) && $model->signup()) {

             Yii::$app->session->setFlash('success', 'register Success'); //flash сообщение, отображается один раз, аргументы - ключ, само сообщени, отображается во вьшке или в шаблоне
         }
         return $this->render('register', ['model' => $model]);
     }

     public function actionContact() {

         $model = new ContactForm();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             $body = "<div>Body: <b> $model->body</b></div>";
             $body .= "<div>Email. <b> $model->email</b></div>";
             Yii::$app->common->sendMail($model->subject, $body);
             echo "Успешная отправка сообщения!";
             exit;
         }
         return $this->render('contact', ['model' => $model]);
     }

     public function actionViewAdvert($id) {
         $model        = Advert::findOne($id);
         $model->price = number_format($model->price);

//        $data = ['name', 'email', 'text'];
//        $model_feedback = new DynamicModel($data);//динамическая модель, чтобы не создавать новый файл модели, ей передается массив полей для валидации
//        $model_feedback->addRule('name','required');
//        $model_feedback->addRule('email','required');
//        $model_feedback->addRule('text','required');
//        $model_feedback->addRule('email','email');
//        if(Yii::$app->request->isPost) {
//            if ($model_feedback->load(Yii::$app->request->post()) && $model_feedback->validate()){
//
//                Yii::$app->common->sendMail('Subject Advert',$model_feedback->text);
//            }
//        }

         $user   = $model->user;
         $images = Common::getImageAdvert($model, false);

//        $current_user = ['email' => '', 'username' => ''];
//
//        if(!Yii::$app->user->isGuest){
//
//            $current_user['email'] = Yii::$app->user->identity->email;
//            $current_user['username'] = Yii::$app->user->identity->username;
//
//        }

         $coords = str_replace(['(', ')'], '', $model->location);
         $coords = explode(',', $coords);
         
         $coord = new LatLng(['lat' => $coords[0], 'lng' => $coords[1]]);
         $map   = new Map([
             'center' => $coord,
             'zoom'   => 16,
         ]);

         $marker = new Marker([
             'position' => $coord,
             'title'    => Common::getTitleAdvert($model),
         ]);

         $map->addOverlay($marker);


         return $this->render('view_advert', [
                     'model'          => $model,
//                     'model_feedback' => $model_feedback,
                     'user'           => $user,
                     'images'         => $images,
//                     'current_user'   => $current_user,
                     'map'            => $map
         ]);
     }

 }
 