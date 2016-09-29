<?php

 namespace frontend\components;

 use yii\base\Component;
 use yii\helpers\Url;
 use yii\helpers\BaseFileHelper;

 class Common extends Component {

     const EVENT_NOTIFY = 'notify_admin';

     public function sendMail($subject, $text, $emailFrom = 'ralf000@yandex.ru', $nameFrom = 'Advert') {
         if (\Yii::$app->mail->compose()
                         ->setFrom(['ralf000@yandex.ru' => 'Advert'])
                         ->setTo([$emailFrom => $nameFrom])
                         ->setSubject($subject)
                         ->setHtmlBody($text)
                         ->send()) {
             $this->trigger(self::EVENT_NOTIFY);
             return true;
         }
     }

     public function notifyAdmin($event) {
         echo 'Notify Admin';
     }

     public static function getTitleAdvert($data) {
         return $data['bedroom'] . ' Bed Rooms and ' . $data['kitchen'] . ' Kitchen Room Apartment on Sale';
     }

     public static function getImageAdvert($data,$general = true,$original = false){

        $image = [];
        $base = '/';
        if($general){

            $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/small_'.$data['general_image'];
        }
        else{
            $path = \Yii::getAlias("@frontend/web/uploads/adverts/".$data['idadvert']);
            $files = BaseFileHelper::findFiles($path);

            foreach($files as $file){
                if (strstr($file, "small_") && !strstr($file, "general")) {
                    $image[] = $base . 'uploads/adverts/' . $data['idadvert'] . '/' . basename($file);
                }
            }
        }

        return $image;
    }

     
     public function substr($text, $start=0, $end=100) {
         return mb_substr($text, $start, $end);
     }
     
     public static function getType($row){
        return ($row['sold']) ? 'Sold' : 'New';
    }
    
    public function priceFormat(array $data) {
        $i = 0;
        foreach ($data as $item){
            $item['price'] = number_format($item['price']);
            $data[$i]['price'] = $item['price'];
            $i++;
        }
        return $data;
    }
    
    public static function getUrlAdvert($row) {
        
        return Url::to(['/main/main/view-advert', 'id' => $row['idadvert']]);
    }

 }
 