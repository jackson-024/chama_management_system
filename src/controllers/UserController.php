<?php

namespace app\controllers;

use app\models\JoinModel;
use app\models\UserModel;

class UserController extends Controller
{
    public function users()
    {
        return $this->render("users", [], "dashboard");
    }

    public function userProfile()
    {
        $userModel = new UserModel();
        $joinModel = new JoinModel();

        $userId =  $_GET['id'];

        $user = $userModel->findOne(["userName" => $userId]);
        $request = $joinModel->findOne(["user_id" => $user->{"id"}]);

        return $this->render("userProfile", [
            "model" => $userModel,
            "user" => $user,
            "request" => $request
        ], "dashboard");
    }
}
