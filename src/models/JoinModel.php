<?php

namespace app\models;

use app\core\Application;

class JoinModel extends DbModel
{
    public string $user_id = '';
    public string $chama_id = '';
    public string $join_status = 'pending';

    public function tableName(): string
    {
        return 'join_request';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "user_id",
            "chama_id",
            "join_status",
        ];
    }

    public function labels(): array
    {
        return [];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'chama_id' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }

    public function create()
    {
        $this->user_id = Application::$app->user->{"id"};

        $user = new JoinModel();
        $userFound = $user->findOne(['user_id' => $this->user_id]);

        if ($userFound && $userFound->{"join_status"} == "pending") {
            Application::$app->session->setFlash("error", "Pending request, await approval!");
            Application::$app->response->redirect('/login');
            exit;
        } elseif ($userFound && $userFound->{"chama_id"} == $this->chama_id && $userFound->{"join_status"} == "rejected") {
            Application::$app->session->setFlash("error", "Choice rejected choose another!");
            Application::$app->response->redirect('/join-chama');
            exit;
        }

        return parent::save();
    }
}
