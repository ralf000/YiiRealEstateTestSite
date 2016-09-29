<?php

namespace app\modules\main\controllers;

use yii\web\Controller;
use \frontend\components\Common;
use yii\db\Query;

class DefaultController extends Controller
{
    
//    public function behaviors() {
////        кешируем главную страницу
//        return [
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['index'],
//                'lastModified' => function ($action, $params){
//                    $q = new Query();
//                    return $q->from('advert')->max('updated_at');
//                },
//                ]
//        ];
//    }
    
    
    //    public  $layout = 'bootstrap';//можно назначить шаблон так для всех страниц
    public function actionIndex()
    {
        $this->layout = 'bootstrap';//а можно назначить шаблон только для action index
        
        $query = new Query();
        $query_advert = $query->from('advert')->orderBy('idadvert desc');
        $command = $query_advert->limit(5);
        $result_general = $command->all();
        $result_general =  \Yii::$app->common->priceFormat($result_general);
        $count_general = $command->count();

        $featured = $query_advert->limit(15)->all();
        
        $featured = \Yii::$app->common->priceFormat($featured);
        $recommend_query  = $query_advert->where("recommend= 1")->limit(5);
        $recommend = $recommend_query->all();
        $recommend_count = $recommend_query->count();

        return $this->render('index',[
            'result_general' => $result_general,
            'count_general' => $count_general,
            'featured' => $featured,
            'recommend' => $recommend,
            'recommend_count' => $recommend_count

        ]);
    }
    
    public function actionService(){
        $locator = \Yii::$app->locator;
        $cache = $locator->cache;
        
        $cache->set('test',1);
        print $cache->get('test');
    }
    
    public function actionEvent(){
        $component = new Common();
        $component->on(Common::EVENT_NOTIFY, [$component, 'notifyAdmin']);
        $component->sendMail('test@domain.com','test','test','testText');
    }
    
    public function actionLoginData(){
        echo "<pre>";
//        print_r(\Yii::$app->user->identity->что угодно);//получаем любую инфу о пользователе
    }
}
