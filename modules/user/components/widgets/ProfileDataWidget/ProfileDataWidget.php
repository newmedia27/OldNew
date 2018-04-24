<?php

namespace app\modules\user\components\widgets\ProfileDataWidget;

use yii\base\Widget;
use app\modules\user\models\forms\ProfileForm;
use app\modules\user\components\repository\UserRepository;

class ProfileDataWidget extends Widget
{
    private $userRepository;

    public function __construct ($config = [], UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($config);
    }

    public function run ()
    {
        $user = $this->userRepository->findById(\Yii::$app->user->id);
        $profile = $this->userRepository->getProfile(\Yii::$app->user->id);
        $model = new ProfileForm;

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
            'profile' => $profile
        ]);
    }
}