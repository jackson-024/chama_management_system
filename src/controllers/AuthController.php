<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\LoginModel;
use app\models\UserModel;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->registerMiddleware(new AuthMiddleware(['']));
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
                Application::$app->response->redirect('/');
                exit;
            } else {
                return $this->render("login", [
                    'model' => $user
                ], "main");
            }

            // return $this->render("login", [
            //     'model' => $user
            // ]);
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
