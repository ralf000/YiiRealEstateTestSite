<?

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Advert;
use common\models\Search\AdvertSearch;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AdvertController extends AuthController{

//    public function behaviors(){
//
//     return ArrayHelper::merge(parent::behaviors(), [
////         включаем авторизацию по http заголовкам
//         'authenticator' => [
//             'class' => HttpBasicAuth::className(),
//             'auth'=>function ($username, $password) {//в этой анонимной функции проверяем пароль приходящий из формы
//                 $model = User::findOne(['username' => $username]);
//                 if($model->validatePassword($password)){
//                     return $model;
//                 }
////                 в результате при авторизации появляется форма для авторизации самого браузера
//             }
//         ],
//     ]);
//    }

    public function actionIndex(){

        Yii::$app->view->title = "Advert Manager";
        $search = new AdvertSearch;
        $dataProvider = $search->search(Yii::$app->request->queryParams);

        return $this->render("index", ['dataProvider' => $dataProvider]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Advert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}