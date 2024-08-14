<?php

namespace app\models;

use app\core\Application;

class ChamaModel extends DbModel
{
    public ?string $id = null;
    public string $name = '';
    public string $description = '';
    public string $contribution_period = '';
    public string $contribution_amount = '';
    public string $flow = '';
    public string $chairperson_id = '';
    public string $status = 'pending';
    public string $location = '';

    public function tableName(): string
    {
        return 'chamas';
    }

    public function primaryKey(): string
    {
        return 'id = null';
    }

    public function attributes(): array
    {
        return [
            "name",
            "description",
            "contribution_period",
            "contribution_amount",
            "flow",
            "chairperson_id",
            "status",
            "location"
        ];
    }

    public function labels(): array
    {
        return [
            "name" => "Name",
            "description" => "Description",
            "contribution_period" => "Coontribution Period",
            "contribution_amount" => "Coontribution Amount",
            "flow" => "Flow",
            "location" => "Location",
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'description' => [self::RULE_REQUIRED],
            'contribution_period' => [self::RULE_REQUIRED],
            'contribution_amount' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'flow' => [self::RULE_REQUIRED],
            'location' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function create()
    {
        $this->chairperson_id = Application::$app->user->{"id"};

        // check if user has pending chama created
        $chama = ChamaModel::findOne(['chairperson_id' => Application::$app->user->{"id"}]);
        // $userAcc = new UserAccountsModel();
        // $userAcc->user_id = Application::$app->user->{"id"};
        // $userAcc->chama_id = $this->id;
        // $userAcc->role_id = 2;

        if ($chama && $chama->{"status"} == "pending") {
            Application::$app->session->setFlash("error", "Pending request, await approval!");
            Application::$app->response->redirect('/create-chama');
            exit;
        }
        return parent::save();
    }
}
