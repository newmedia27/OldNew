<?php

namespace app\modules\user\components\repository;

use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use yii\base\Exception;

class UserRepository
{

    /**
     * @param $id
     * @return static
     */
    public function findById ($id)
    {
        return User::find()->where(['id' => $id])->one();
    }

    /**
     * @param array $params
     * @return array|User|null
     */
    public function findByParams (array $params)
    {
        return User::find()->where($params)->one();
    }

    /**
     * @param $id
     * @return array|UserProfile|null
     */
    public function getProfile ($id)
    {
        return UserProfile::find()->where(['user_id' => $id])->one();
    }

    /**
     * @param $model
     * @return User
     * @throws Exception
     */
    public function saveUser ($model)
    {
        if (!$model->save(false)) {
            throw new Exception('Can`t save user');
        }

        return $model;
    }

    /**
     * @param $model
     * @throws Exception
     */
    public function saveProfile ($model)
    {
        if (!$model->save(false)) {
            throw new Exception('Can`t save users profile');
        }
    }

    /**
     * @param $idUser
     * @param $path
     * @throws Exception
     */
    public function updateAvatar ($idUser, $path)
    {
        UserProfile::updateAll(['avatar_path' => $path], "user_id = $idUser");
    }

    /**
     * @return array|\app\modules\user\models\User[]
     */
    public function findAll ()
    {
        return User::find()->all();
    }

    /**
     * @param $role
     * @return array|\app\modules\user\models\User[]
     */
    public function findUsersByRole ($role)
    {
        return User::find()->joinWith(['roles' => function ($query) use ($role) {
            $query->andwhere(['auth_assignment.item_name' => $role]);
        }])->all();
    }
}