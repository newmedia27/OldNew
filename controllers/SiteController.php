<?php

namespace app\controllers;

use app\components\helpers\TransHelper;
use app\models\CmsFiles;
use app\models\CmsFilesThumb;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopPrices;
use app\modules\shop\models\ShopProdJoinCat;
use app\modules\shop\models\ShopProducts;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use Imagine\Image\Box;
use yii\imagine\Image;
use yii\web\HttpException;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionDeleteFiles($id)
    {
        if (is_numeric($id) && $_GET['key'] == 'r5DEvFvvHyTd54j2Cm5Dl4dfr') {

            $model = CmsFiles::findOne($id);

            if ($model !== NULL) {
                if (!empty($model->path) && file_exists($_SERVER['DOCUMENT_ROOT'] . $model->path))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $model->path);
                if (!empty($model->path_thumb) && file_exists($_SERVER['DOCUMENT_ROOT'] . $model->path_thumb))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $model->path_thumb);
                $model->delete();
                $model = CmsFilesThumb::find()->where(["id_file=" => $id])->one();
                foreach ($model as $v)
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $v->path))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $v->path);
                $model = CmsFilesThumb::deleteAll("id_file=" . $id);

                echo '1';
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    return $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
            }
        } else
            throw new HttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUploadFiles()
    {

        if (is_numeric($_GET['id']) && $_GET['key'] == 'r5DEvFvvHyTd54j2Cm5Dl4dfr') {

            $model = $model = CmsFiles::findOne($_GET['id']);

            $ext = explode('.', $model->name);
            $ext = $ext[count($ext) - 1];

            $dir = '/web/uploads/' . $model->type . '/' . date("Y-m-d", time());

            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . $dir);
                chmod($_SERVER['DOCUMENT_ROOT'] . $dir, 0777);
            }

            $name = time() . rand(100, 10000000);

            if (in_array(strtolower($ext), ["jpg", "png", "gif", "bmp", "jpeg"])) {


                $name_thumb = $name . '_thumb.' . $ext;
                $path_thumb = $dir . '/' . $name_thumb;

                $image = Image::getImagine()->open($_SERVER['DOCUMENT_ROOT'] . $model->path);
                $size = $image->getSize();

                //GET SIZES FOR OBJECT
                $sizes = Yii::$app->db->createCommand('SELECT * FROM  `cms_files_thumb_size` where type="' . $model->type . '"')->query()->readAll();
                foreach ($sizes as $v) {

                    $dir1 = '/web/uploads/' . $model->type . '/' . $v['width'] . '-' . $v['height'] . '/' . date("Y-m-d", time());

                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $dir1)) {
                        mkdir($_SERVER['DOCUMENT_ROOT'] . $dir1, 0777, true);
                        chmod($_SERVER['DOCUMENT_ROOT'] . $dir1, 0777);
                    }

                    $image = Image::getImagine()->open($_SERVER['DOCUMENT_ROOT'] . $model->path);

                    $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();

                    if ($ratio > 1) {
                        $width = $v['width'];
                        $height = $image->getSize()->getHeight() * (($v['width'] * 100) / $image->getSize()->getWidth()) / 100;
                        $box = new Box($width, $height);
                        $image->resize($box)->save($_SERVER['DOCUMENT_ROOT'] . $dir1 . '/' . $name . '.' . $ext);
                    } else {
                        $height = $v['width'];
                        $width = $image->getSize()->getWidth() * (($v['width'] * 100) / $image->getSize()->getHeight()) / 100;
                        $box = new Box($width, $height);
                        $image->resize($box)->save($_SERVER['DOCUMENT_ROOT'] . $dir1 . '/' . $name . '.' . $ext);
                    }


                    Yii::$app->db->createCommand()->insert('cms_files_thumb', [
                        'path' => $dir1 . '/' . $name . '.' . $ext,
                        'size' => $v['id'],
                        'id_file' => $model->id,
                    ])->execute();
                }

                if ($size->getWidth() > 2048 || $size->getHeight() > 2048) {

                    $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();

                    if ($ratio > 1) {
                        $width = 2048;
                        $height = 2048 / $ratio;
                        $box = new Box($width, $height);
                        $image->resize($box);
                    } else {
                        $width = 2048 * $ratio;
                        $height = 2048;
                        $box = new Box($width, $height);
                        $image->resize($box);
                    }
                    $image->save($_SERVER['DOCUMENT_ROOT'] . $model->path);
                }

                if ($size->getWidth() > 300 || $size->getHeight() > 300) {

                    $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();

                    if ($ratio > 1) {
                        $width = 300;
                        $height = 300 / $ratio;
                        $box = new Box($width, $height);
                        $image->resize($box)->save($_SERVER['DOCUMENT_ROOT'] . $dir . '/' . $name . '.' . $ext);
                    } else {
                        $width = 300 * $ratio;
                        $height = 300;
                        $box = new Box($width, $height);
                        $image->resize($box)->save($_SERVER['DOCUMENT_ROOT'] . $dir . '/' . $name . '.' . $ext);
                    }

                    $image->save($_SERVER['DOCUMENT_ROOT'] . $path_thumb);
                    $model->path_thumb = $path_thumb;
                    $model->save();
                }
            }

            echo 'ok';

            Yii::$app->end();
        } else echo 'error';
    }

    static public function UploadThumb($model, $mydir = 'temp', $varname)
    {

        if (!empty($_FILES)) {

            $ext = pathinfo($_FILES[$varname]['name']['img'], PATHINFO_EXTENSION);

            $name = $varname . '_' . $model->id . '.png';
            $name2 = $varname . '_' . $model->id . '_500.png';


            if (in_array(strtolower($ext), ["jpg", "png", "gif", "bmp", "jpeg"])) {

                $dir = '/web/uploads/' . $mydir . '/' . date('Y-m-d');

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $dir, 0777, true);
                    chmod($_SERVER['DOCUMENT_ROOT'] . $dir, 0777);
                }

                $path = $dir . '/' . $name;

                if (move_uploaded_file($_FILES[$varname]["tmp_name"]['img'], $_SERVER['DOCUMENT_ROOT'] . $path)) {

                    $image = Image::getImagine()->open($_SERVER['DOCUMENT_ROOT'] . $path);
                    $image->resize(new Box(300, 300));
                    $image->save($_SERVER['DOCUMENT_ROOT'] . $path);
                    $model->img_thumb = $path;

                    $image = Image::getImagine()->open($_SERVER['DOCUMENT_ROOT'] . $path);
                    $image->resize(new Box(300, 300));
                    $path = $dir . '/' . $name2;
                    $image->save($_SERVER['DOCUMENT_ROOT'] . $path);

                    $model->img = $path;
                    $model->save();
                }
            }
        }
    }

    public function actionGetImgThumb($id)
    {

        $img_thumb = Yii::$app->db->createCommand('SELECT path_thumb FROM cms_files where code="' . $id . '"')->queryScalar();

        $file = $_SERVER['DOCUMENT_ROOT'] . $img_thumb;

        if (file_exists($file)) {

            header('Content-Type: image/png');

            if (file_exists($file))
                echo file_get_contents($file);
            else
                echo file_get_contents($file);
        }
        Yii::$app->end();
    }

    public function actionXml()
    {
        actionXmlParse();

    }

    public function actionXmlcat()
    {
            ini_set("memory_limit", "-1");
set_time_limit(0);
        saveCat();
        echo 'Готово!!';
    }
}

function actionXmlParse()
{

    $xmlfile = $_SERVER['DOCUMENT_ROOT'] . '/xml/offers.xml';
    $xml = simplexml_load_file($xmlfile);

    foreach ($xml->children() as $key) {

        foreach ($key->Предложения->Предложение as $key1) {
            $prod = ShopProducts::find()->where(['id_1c' => $key1->Ид->__toString()])->one();

            if ($prod) {
                if ($key1->Цены->Цена->ЦенаЗаЕдиницу->__toString() != $prod->price) {
                    savePrice($prod, $key1);
                }
                if (intval($key1->Количество->__toString(),10) != $prod->quantity) {
                    $prod->quantity = intval($key1->Количество->__toString(),10);
                    if (!$prod->save()) {
                        var_dump($prod->getErrors());
                    }
                }
            } else {

                $prod = new ShopProducts();
                $prod->id_1c = $key1->Ид->__toString();
                if ($key1->Артикул->__toString() != '') {
                    $prod->article = $key1->Артикул->__toString();
                } else {
                    $prod->article = '0';
                }

                $prod->prior = 0;
                $prod->id_price = 0;
                $prod->quantity = intval($key1->Количество->__toString(),10);
                $prod->alias = TransHelper::str2url($key1->Наименование->__toString());
                $prod->name_ru = $key1->Наименование->__toString();
                $prod->name_ua = $key1->Наименование->__toString();

                if ($prod->save()) {
                    savePrice($prod, $key1);
                    var_dump($prod->id);
                    echo '<br>';

                } else {
                    var_dump($prod->getErrors());
                }
            }
        }
    }
}

function savePrice($prod, $key1)
{
    $price = new ShopPrices();
    $price->id_prod = $prod->id;
    $price->price = $key1->Цены->Цена->ЦенаЗаЕдиницу->__toString();

    switch ($key1->Цены->Цена->Валюта->__toString()) {
        case 'EUR': {
            $price->currency = 'euro';
            break;
        }
        case 'UAH': {
            $price->currency = 'uah';
            break;
        }
        case 'USD': {
            $price->currency = 'usd';
            break;
        }
    }

    if ($price->save()) {
        $prod->id_price = $price->id;
        if (!$prod->save()) {

            echo var_dump($prod->getErrors());
        }
    } else {
        echo var_dump($price->getErrors());
    }
}

function createProd($key1)
{
    if (isset($key1->Наименование)){
        $prod = new ShopProducts();

        $prod->id_1c = $key1->Ид->__toString();
        if ($key1->Артикул->__toString() != '') {
            $prod->article = $key1->Артикул->__toString();
        } else {
            $prod->article = '0';
        }

        $prod->prior = 0;
        $prod->id_price = 0;
        $prod->quantity = intval($key1->Количество->__toString(),10);
        $prod->alias = TransHelper::str2url($key1->Наименование->__toString());
        $prod->name_ru = $key1->Наименование->__toString();
        $prod->name_ua = $key1->Наименование->__toString();

        if ($prod->save()){
            return $prod;
        }else{
            var_dump($prod->getErrors());
        }
    }
    return null;
}

function createCat($prod, $key1)
{
    $group = $key1->Группы;

    $cat = ShopCategory::find()->where(['like','id_1c', $group->Ид->__toString()])->one();

    if ($cat) {
        $categ= ShopProdJoinCat::findOne(['id_cat'=>$cat->id,'id_prod'=>$prod->id]);
        if(!$categ){
            $categ = new ShopProdJoinCat();
            $categ->id_cat = $cat->id;
            $categ->id_prod = $prod->id;

            if (!$categ->save()) {
                var_dump($categ->getErrors());
            };
        }
    }else{
        $categ= ShopProdJoinCat::findOne(['id_cat'=>23,'id_prod'=>$prod->id]);
        if(!$categ){
            $cat = new ShopProdJoinCat();
            $cat->id_cat = 23;
            $cat->id_prod = $prod->id;
            if (!$cat->save()) {
                var_dump($cat->getErrors());
            };
        }
    }
}

function saveCat()
{
    $xmlfile = $_SERVER['DOCUMENT_ROOT'] . '/xml/import.xml';
    $xml = simplexml_load_file($xmlfile);
    $key = $xml->children()[1];

    foreach ($key->Товары->Товар as $key1) {
        $prod = ShopProducts::find()->where(['id_1c' => $key1->Ид->__toString()])->one();
        if (!$prod) {
            $prod = createProd($key1);
        }

        if ($prod){
            createCat($prod, $key1);
        }
    }
}