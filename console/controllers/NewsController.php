<?

namespace console\controllers;

use common\models\Subscribe;
use yii\console\Controller;
use yii\helpers\Console;

class NewsController extends Controller{

    public function actionIndex(){
        $query = Subscribe::find();
        $countQuery = clone $query;
        $count = $countQuery->count();
        $model = $query->all();
        //строим в консоли прогресс бар
        //имитируем рассылку подписчикам
        //запускается из папки с сайтом через yii news
        Console::startProgress(0, $count);
        $i = 1;
         foreach ($model as $r) {
                usleep(1000);
                 print "Send Email: ".$r['email']."\n";
                 Console::updateProgress($i, $count);
             $i++;
             }
         Console::endProgress();

        return 0;
    }

    public function actionAdd(array $ar){

        print_r($ar);
    }
}