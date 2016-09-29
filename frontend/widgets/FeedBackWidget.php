<?php

 namespace frontend\widgets;

 use common\models\FeedBack;
 use yii\base\Widget;

 class FeedBackWidget extends Widget {

     public function run() {
//         $data = ['name', 'email', 'text'];
//         $model = new \yii\base\DynamicModel($data);
         
         $model = new FeedBack;

         if (\Yii::$app->request->isPost) {
             if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                 \Yii::$app->common->sendMail('Subject Advert', $model->text);
             }
         }

         $current_user = ['username' => '', 'email' => ''];

         if (!\Yii::$app->user->isGuest) {
             $current_user = [
                 'username' => \Yii::$app->user->identity->username,
                 'email'    => \Yii::$app->user->identity->email,
             ];
         }

         return $this->render('feedback', [
             'current_user' => $current_user,
             'model'        => $model,
         ]);
     }

 }
 