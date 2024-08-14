<?php

namespace app\models;

use app\core\Application;

class LoginModel extends DbModel
{
    public string $email = '';
    public string $password  = '';


    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "email",
            "password",
        ];
    }

    public function labels(): array
    {
        return [
            "email" => "Email",
            "password" => "Password",
        ];
    }


    // function to provide registration rules
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 4]],
        ];
    }

    public function login()
    {
        $user = new UserModel();
        $userFound = $user->findOne(['email' => $this->email]);

        // if user not found throw error
        if (!$userFound) {
            // I can add an error on form element
            // $this->addErrorMessage('email', 'User does not exist with this email');

            // Add error message on session
            Application::$app->session->setFlash("error", "User does not exist with this email");
            return false;
        }

        if (!password_verify($this->password, $userFound->password)) {
            $this->addErrorMessage('password', 'Password is incorrect');
            return false;
        }

        // if ($userFound->role_id === 1) {
        //     Application::$app->session->setFlash("success", "Login successful");
        //     Application::$app->response->redirect('/');
        //     return Application::$app->login($userFound);
        // } elseif ($userFound->chama_id === null) {
        //     Application::$app->login($userFound);
        //     Application::$app->session->setFlash("success", "Login successful");
        //     Application::$app->response->redirect('/landing');
        //     exit;
        // }

        if ($userFound->status == "pending") {
            Application::$app->session->setFlash("error", "Pending approval");
            return false;
        }

        return Application::$app->login($userFound);
    }
}
