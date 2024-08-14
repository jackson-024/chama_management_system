<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\FinesModel;
use app\models\UserAccountsModel;

class FinesController extends Controller
{
    public function fetchFine(Request $request)
    {
        $fineId = $_GET["id"];

        $finesModel = new FinesModel();

        $fine = $finesModel->findOne(["id" => $fineId]);

        return $this->render("fineProfile", [
            "fine" => $fine
        ], "dashboard");
    }

    public function fetchUserFines()
    {
        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        $finesModel = new FinesModel();

        $fines = $finesModel->findWhere(["user_id" => $userId, "chama_id" => $chamaId]);

        return $this->render("userFines", [
            "fines" => $fines
        ], "dashboard");
    }

    public function fetchChamaFines()
    {
        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        $finesModel = new FinesModel();

        $finesStmt = $finesModel->prepare('
            select f.* , u.userName as user_id
            from fines f
            left join users u on u.id = f.user_id
            where f.chama_id = :chamaId
        ');
        $finesStmt->bindValue(":chamaId", $chamaId);
        $finesStmt->execute();
        $fines = $finesStmt->fetchAll(\PDO::FETCH_ASSOC);

        // $fines = $finesModel->findWhere(["chama_id" => $chamaId]);

        $fines = array_map(function ($fine) {
            unset($fine['chama_id']);
            return $fine;
        }, $fines);

        return $this->render("fines", [
            "fines" => $fines
        ], "dashboard");
    }

    public function createFine(Request $request)
    {
        $body = $request->getBody();

        $finesModel = new FinesModel();

        $userModel = new UserAccountsModel();

        $chamaId = Application::$app->session->get("user_chama");

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
            return $this->render("createFine", [
                "model" => $finesModel,
                "userAccs" => $userAccs
            ], "dashboard");
        }

        $finesModel->user_id = $body["user_id"];
        $finesModel->chama_id = $chamaId;
        $finesModel->amount = $body["amount"];
        $finesModel->reason = $body["reason"];
        $finesModel->status = "not_cleared";


        // create fine
        if ($finesModel->validate()) {
            $newFine = $finesModel->save();

            if ($newFine) {
                Application::$app->session->setFlash("success", "Fine created Successfully!");
                Application::$app->response->redirect("create-fine");
                exit;
            } else {
                Application::$app->session->setFlash("error", "Fine not created Successfully!");
                Application::$app->response->redirect("create-fine");
                exit;
            }
        }
    }

    public function payFine(Request $request)
    {
        $fineId = $_GET["id"];
        $fineModel = new FinesModel();
        $body = $request->getBody();

        $amountPaid = $body["amount"];

        if ($request->getMethod() == "get") {
            return $this->render("payFine", [
                "model" => $fineModel
            ], "dashboard");
        }

        $fine = $fineModel->findOne(["id" => $fineId]);

        // check if amount is paid in full
        if ($amountPaid >= $fine->amount) {
            // update fine on fine records to cleared
            $updateFine = $fineModel->updateOne(["id" => $fineId], ["status" => "cleared"]);

            if ($updateFine) {
                Application::$app->session->setFlash("success", "Fine cleared sucessfully");
                Application::$app->response->redirect("fine-profile?id=" . $fineId);
                exit;
            }
        } else {
            Application::$app->session->setFlash("error", "Amount paid is less than the fine amount");
            Application::$app->response->redirect("pay-fine?id=" . $fineId);
            exit;
        }
    }
}
