<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\ForgotPasswordModel;
use app\models\LoginModel;
use app\models\UserAccountsModel;
use app\models\UserModel;

class AuthController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $user = new ForgotPasswordModel();

        if ($request->getMethod() === "get") {
            return $this->render("forgotPassword", [
                'model' => $user
            ], "main");
        }

        if ($request->getMethod() === "post") {
            $body = $request->getBody();
            $user->loadData($body); // I have to load data into the forget password model

            if ($user->validate() && $user->changePassword()) {
                Application::$app->session->setFlash("success", "Password changed successfully!");
                Application::$app->response->redirect('/login');
                exit;
            } else {
                Application::$app->session->setFlash("success", "Password change not successfull!");
                return $this->render("forgotPassword", [
                    'model' => $user
                ], "main");
            }
        }
    }

    public function getUserAccounts()
    {
        $userModel = new UserAccountsModel();

        $userAccountsStmt = $userModel->prepare('
            select ua.*, u.userName, c.name, r.role
            from user_accounts ua
            left join users u on u.id = ua.user_id
            left join chamas c on c.id = ua.chama_id
            left join roles r on r.id = ua.role_id
            where ua.user_id = :user_id
        ');

        $userAccountsStmt->bindValue(
            ":user_id",
            Application::$app->user->{"id"}
        );

        $userAccountsStmt->execute();
        $userAccounts = $userAccountsStmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render("userAccounts", [
            'model' => $userAccounts,
            'userAccounts' => $userAccounts
        ], "main");
    }

    // function that enables role based login
    public function loginUserAcc(Request $request)
    {
        $userAccm = new UserAccountsModel;

        $userAccRole = $request->getBody();

        $userAcc = $userAccm->findOne(["user_id" => Application::$app->user->{"id"}, "role_id" =>  $userAccRole["role_id"]]);

        Application::$app->session->set("user_role", $userAccRole["role_id"]);
        Application::$app->session->set("user_chama", $userAcc->{"chama_id"});

        Application::$app->response->redirect('/');
    }


    public function createUserAcc(Request $request)
    {
        $body = $request->getBody();

        $userModel = new UserAccountsModel();
        $userModel->loadData($body);
        $userModel->save();

        if ($body["role_id"] == 1) {
            $user = new UserModel();
            $user->updateOne(["id" => $body["user_id"]], ["status" => "active"]);
        }

        return Application::$app->response->setStatusCode(200);
    }

    public function nominate(Request $request)
    {
        $userModel = new UserAccountsModel();

        $chamaId = Application::$app->session->get("user_chama");

        $userModel = new UserAccountsModel();

        $userAccountsStmt = $userModel->prepare('
            select ua.*, u.userName, c.name, r.role
            from user_accounts ua
            left join users u on u.id = ua.user_id
            left join chamas c on c.id = ua.chama_id
            left join roles r on r.id = ua.role_id
            where ua.chama_id = :chama_id
        ');

        $userAccountsStmt->bindValue(
            ":chama_id",
            $chamaId
        );

        $userAccountsStmt->execute();

        $userAccs = $userAccountsStmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($request->getMethod() == "get") {
            return $this->render("nominate", [
                "model" => $userModel,
                "userAccs" => $userAccs,
            ], "dashboard");
        }

        $body = $request->getBody();

        $userModel->loadData($body);

        if ($userModel->validate()) {
            // update user account where user_id and chama_id matches
            $updateUserAcc = $userModel->updateOne(["user_id" => $body["user_id"], "chama_id" => $chamaId], ["role_id" => $body["role_id"]]);

            if ($updateUserAcc) {
                Application::$app->session->setFlash("success", "User nominated succesffuly");
                Application::$app->response->redirect("/nominate");
                exit;
            }
        }

        return $this->render("nominate", [
            "model" => $userModel,
            "userAccs" => $userAccs,
        ], "dashboard");
    }



    public function handleLogin(Request $request)
    {
        $user = new LoginModel;

        if ($request->getMethod() === "get") {
            return $this->render("login", [
                'model' => $user
            ], "main");
        }

        if ($request->getMethod() === "post") {
            $body = $request->getBody();

            $user->loadData($body);

            if ($user->validate() && $user->login()) {
                Application::$app->session->setFlash("success", "Login successful");
                Application::$app->response->redirect('/user-accounts');
                return true;
            } else {
                return $this->render("login", [
                    'model' => $user
                ], "main");
            }
        }
    }

    public function handleRegistration(Request $request)
    {
        $user = new UserModel(); //instance of user model

        if ($request->getMethod() === "get") {
            return $this->render("register", [
                'model' => $user
            ], "main");
        }

        if ($request->getMethod() === "post") {
            $body = $request->getBody();

            $user->loadData($body);

            if ($user->validate() && $user->register()) {
                Application::$app->session->setFlash("success", "Registration successful");
                Application::$app->response->redirect('/landing');
                exit;
            } else {
                return $this->render("register", [
                    'model' => $user
                ], "main");
            }
        }

        // return $this->render("register", [
        //     'model' => $user
        // ]);
    }

    public function logout()
    {
        Application::$app->logout();
        Application::$app->response->redirect("/login");
    }
}
