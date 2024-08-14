<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\JoinModel;
use app\models\UserAccountsModel;
use app\models\UserModel;

class UserController extends Controller
{
    public function users(Request $request)
    {
        $user = new UserModel;
        $userAccModel = new UserAccountsModel;

        if (Application::$app->session->get("user_role") !== "admin") {
            // fetch user accounts according to logged in user chama from session
            $chamaId = Application::$app->session->get("user_chama");
            // $userAccs = $userAccModel->findOne(["chama_id" => $chamaId]);

            $userAccStmt = $userAccModel->prepare('
                select u.*, r.role as role
                from user_accounts ua
                inner join users u on u.id = ua.user_id
                inner join roles r on r.id = ua.role_id
                where ua.chama_id = :chama_id
            ');
            $userAccStmt->bindValue(
                ":chama_id",
                $chamaId
            );
            $userAccStmt->execute();
            $userAccs = $userAccStmt->fetchAll(\PDO::FETCH_ASSOC);

            // ignore password
            $userAccs = array_map(function ($userAccs) {
                unset($userAccs['password']);
                return $userAccs;
            }, $userAccs);

            if ($request->getMethod() === "get") {
                return $this->render(
                    "users",
                    [
                        "model" => $user,
                        "users" => $userAccs
                    ],
                    "dashboard"
                );
            }
            return $userAccs;
        }

        // display all users if admin
        $users =  $user->findAll();

        // ignore password
        $users = array_map(function ($user) {
            unset($user['password']);
            return $user;
        }, $users);

        if ($request->getMethod() === "get") {
            return $this->render("users", [
                "model" => $user,
                "users" => $users
            ], "dashboard");
        }
        return $users;
    }

    public function userProfile()
    {
        $userModel = new UserModel();
        $joinModel = new JoinModel();

        $userId =  $_GET['id'];

        $user = $userModel->findOne(["id" => $userId]);

        return $this->render("userProfile", [
            "model" => $userModel,
            "user" => $user,
        ], "dashboard");
    }

    public function userDeactivate(Request $request)
    {
        $userModel = new UserModel();
        $userId = $_GET["id"];

        $updateUser = $userModel->updateOne(["id" => $userId], ["status" => "inactive"]);

        if ($updateUser) {
            Application::$app->session->setFlash("success", "User deactivated successfully!");
            exit;
        } else {
            Application::$app->session->setFlash("error", "Failed to deactivate user!");
            exit;
        }
    }

    public function userActivate(Request $request)
    {
        $userModel = new UserModel();
        $userId = $_GET["id"];

        $updateUser = $userModel->updateOne(["id" => $userId], ["status" => "active"]);

        if ($updateUser) {
            Application::$app->session->setFlash("success", "User activated successfully!");
            exit;
        } else {
            Application::$app->session->setFlash("error", "Failed to activate user!");
            exit;
        }
    }
}
