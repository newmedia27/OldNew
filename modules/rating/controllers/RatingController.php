<?php

namespace app\modules\rating\controllers;

use yii\web\Controller;

/**
 * Rating controller for the `rating` module
 */
class RatingController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
