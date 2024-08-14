<?php

namespace app\models;

use app\core\Application;

class ForgotPasswordModel extends Model
{
    public string $email = '';
    public string $newPassword = '';
    public string $confirmPassword = '';


    public function tableName(): string
    {
        return 'users';
    }


    public function attributes(): array
    {
        return [
            "email",
            "newPassword",
            "confirmPassword"
        ];
    }

    public function labels(): array
    {
        return [
            "email" => "Email",
            "newPassword" => "New Password",
            "confirmPassword" => "Confirm Password",
        ];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'newPassword' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 4]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'newPassword'], [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 4]],
        ];
    }

    public function changePassword()
    {
        $user = new UserModel;

        $user->findOne(["email" => $this->email]);

        if (!$user) {
            Application::$app->session->setFlash("error", "Email not found!");
            return false;
        }
        // var_dump($user);
        $lastPassword = password_verify($user->password, $this->newPassword);
        var_dump(!$lastPassword);

        if ($lastPassword) {
            Application::$app->session->setFlash("error", "New password is invalid!");
            Application::$app->session->setFlash("error", "Same as previous password!");
            return false;
        }

        $updatePassword = $user->updateOne(["email" => $this->email], ["password" => password_hash($this->newPassword, PASSWORD_DEFAULT)]);

        if ($updatePassword) {
            // Application::$app->session->setFlash("success", "Password changed successfully!");
            // Application::$app->response->redirect('/user-accounts');
            return true;
        }
    }
}
