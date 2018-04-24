<?php

namespace app\modules\feedback\controllers;

use app\components\EmailSender;
use app\components\FileSaver;
use app\models\CmsFiles;
use app\models\Languages;
use app\modules\feedback\components\services\FeedbackService;
use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackForm;
use app\modules\feedback\models\UploadForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `feedback` module
 */
class FeedbackController extends Controller
{
    private $request;
    private $feedbackService;

    public function __construct($id, $module, array $config = [], FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        $this->request = Yii::$app->request;
        return parent::beforeAction($action);
    }

    public function actionFeedback() {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException('The requested page is not found');

        $lang = explode('/', $_SERVER['HTTP_REFERER'])[3];
        if ($lang == 'ua' || $lang == 'en')
            Languages::setCurrent($lang);

        $model = new FeedbackForm();
        $file = new UploadForm;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return $this->renderAjax('feedback', [
            'model' => $model,
            'file' => $file
        ]);
    }

    public function actionFeedbackSubmit () {

        $lang = explode('/', $_SERVER['HTTP_REFERER'])[3];
        if ($lang == 'ua' || $lang == 'en')
            Languages::setCurrent($lang);

        $model = new Feedback();
        $file = new UploadForm();

        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException('The requested page is not found');

        if ($model->load(Yii::$app->request->post(), '')) {

               $model->type = 'feedback';

            if ($model->save()) {

                $uploaded_file = UploadedFile::getInstances($file, 'files');

                $file_saver = new FileSaver($uploaded_file, $model->type, $model->id);

                if ($file_saver->uploadFile()) {
                    $files = ArrayHelper::map(CmsFiles::find()->where(['id_obj' => $model->id])->asArray()->all(), 'id', 'path');

                    $text = $model->type == 'contact' ? "Здравствуйте!<br>
                            Вам поступил запрос на обратную связь" : "Здравствуйте!<br>
                            Вам поступил новый отзыв";
                    $text .= "<br>От пользователя: $model->name<br>
                          Номер телефона: $model->phone<br>";
                    $text .= !empty($model->email) ? "Электронный адрес: $model->email<br>" : '';
                    $text .= !empty($model->comments) ? "Текст отзыва: $model->comments<br>" : '';
//                    $sender = new EmailSender(['email' => 'test@mai.com', 'text' => $text, 'view' => 'confirm', 'subject' => $subject, 'files' => $files]);
//                    $sender->sendMail();


                    if ($model->type == 'spivpratsia') {
//                        $sender = new EmailSender(['email' => $model->email, 'text' => $text, 'view' => 'confirm', 'subject' => 'Заявка прийнята', 'files' => $files]);
//                        $sender->sendMail();
                        return $this->renderAjax('success_spivpratsia');
                    }

                    return $this->renderAjax('success');
                }
            }
        }

        return $this->renderAjax('feedback', [
            'model' => $model,
        ]);
    }


    public function actionValidate()
    {
        $model = new FeedbackForm();
        $post = Yii::$app->request->post();
        $type = $post['FeedbackForm']['type'];

        if (Yii::$app->request->isAjax && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->scenario = $type;
            return ActiveForm::validate($model);
        }
        throw new NotFoundHttpException('The requested page is not found');
    }

    public function actionCreate()
    {
        $model = new FeedbackForm();

        $post = Yii::$app->request->post();
        $type = $post['FeedbackForm']['type'];
        $model->scenario = $type;

        if (Yii::$app->request->isAjax && $model->load($post) && $model->validate()
        ) {
            if ($this->feedbackService->addFeedback($post['FeedbackForm'])) {
                return $this->renderAjax("success_$type");
            };
        }
        return $this->renderAjax("not_success", [
            'model' => $model
        ]);
    }
}
