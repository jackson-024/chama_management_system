<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\AllocateModel;
use app\models\ChamaWalletModel;
use app\models\ContributeModel;
use app\models\UserWalletModel;

class ContributeController extends Controller
{
    public function creditContributions($userId, $chamaId, $debit = 0, $credit, $balance)
    {
        $contributeModel = new ContributeModel();

        $contributeModel->user_id = $userId;
        $contributeModel->chama_id = $chamaId;
        $contributeModel->debit = $debit;
        $contributeModel->credit = $credit;
        $contributeModel->balance = $balance;

        $newCont = $contributeModel->save();

        return true;

        if (!$newCont) {
            return false;
        }
    }

    public function creditChamaWallet($chamaId, $debit = 0, $credit, $balance)
    {
        $contributeModel = new ChamaWalletModel();

        $contributeModel->chama_id = $chamaId;
        $contributeModel->debit = $debit;
        $contributeModel->credit = $credit;
        $contributeModel->balance = $balance;

        $newCont = $contributeModel->save();

        return true;

        if (!$newCont) {
            return false;
        }
    }

    public function debitChamaWallet($chamaId, $debit, $credit = 0, $balance)
    {
        $contributeModel = new ChamaWalletModel();

        $contributeModel->chama_id = $chamaId;
        $contributeModel->debit = $debit;
        $contributeModel->credit = $credit;
        $contributeModel->balance = $balance;

        $newCont = $contributeModel->save();

        return true;

        if (!$newCont) {
            return false;
        }
    }

    public function creditUserWallet($userId, $chamaId, $debit, $credit, $balance)
    {
        $contributeModel = new UserWalletModel();

        $contributeModel->user_id = $userId;
        $contributeModel->chama_id = $chamaId;
        $contributeModel->debit = $debit;
        $contributeModel->credit = $credit;
        $contributeModel->balance = $balance;

        $newCont = $contributeModel->save();

        return true;

        if (!$newCont) {
            return false;
        }
    }

    public function addContribution(Request $request)
    {
        $contributeModel = new ContributeModel();
        $userWalletModel = new UserWalletModel();
        $chamaWallet = new ChamaWalletModel();

        $amount = $request->getBody();

        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        if ($request->getMethod() == "get") {
            return $this->render("contribute", [
                "model" => $contributeModel
            ], "dashboard");
        }

        if ($request->getMethod() == "post") {
            // check for last contribution
            $contributions = $contributeModel->findWhere(["chama_id" => $chamaId]);
            $lastContribution = end($contributions);

            if ($lastContribution) {
                $prevBalance = $lastContribution["balance"];
                $newBalance = $prevBalance + $amount["credit"];

                $newCont = $this->creditContributions($userId, $chamaId, $debit = 0, $amount["credit"], $newBalance);

                // update user wallet
                // check for previous update
                $userRecords = $userWalletModel->findWhere(["user_id" => $userId]);

                if (!$userRecords) {
                    $newUWUpdate = $this->creditUserWallet($userId, $chamaId, $debit = 0, $amount["credit"], $amount["credit"]);
                }

                $lastUserWalletRecord = end($userRecords);
                $prevUWBalance = $lastUserWalletRecord["balance"];
                $newUWBalance = $prevUWBalance + $amount["credit"];

                $newUWUpdate = $this->creditUserWallet($userId, $chamaId, $debit = 0, $amount["credit"], $newUWBalance);

                // update chama_wallet
                // check previous update
                $chamaRecords = $chamaWallet->findWhere(["chama_id" => $chamaId]);
                if (!$chamaRecords) {
                    $newChamaWRecord = $this->creditChamaWallet($chamaId, $debit = 0, $amount["credit"], $amount["credit"]);
                }

                $lastChamaRecord = end($chamaRecords);

                $prevChamaBal = $lastChamaRecord["balance"];
                $newChamaBal = $prevChamaBal + $amount["credit"];

                $newChamaWRecord = $this->creditChamaWallet($chamaId, $debit = 0, $amount["credit"], $newChamaBal);


                if ($newUWUpdate && $newChamaWRecord) {
                    Application::$app->session->setFlash("success", "Contribution successfull!");
                    Application::$app->response->redirect("/contribute");
                    exit;
                } else {
                    Application::$app->session->setFlash("error", "Contribution failedyy!");
                    Application::$app->response->redirect("/contribute");
                    exit;
                }
            }

            // credit contributions and user_wallet table as first time user
            $newCont = $this->creditContributions($userId, $chamaId, $debit = 0, $amount["credit"], $amount["credit"]);
            $updateChamaWallet = $this->creditChamaWallet($chamaId, $debit = 0, $amount["credit"], $amount["credit"]);
            $updateUserWallet = $this->creditUserWallet($userId, $chamaId, $debit = 0, $amount["credit"], $amount["credit"]);

            if ($newCont && $updateUserWallet && $updateChamaWallet) {
                Application::$app->session->setFlash("success", "Contribution successfull!");
                Application::$app->response->redirect("/contribute");
                exit;
            } else {
                Application::$app->session->setFlash("error", "Contribution failed!ggg");
                Application::$app->response->redirect("/contribute");
                exit;
            }
        }
    }


    public function fetchMemberContributions(Request $request)
    {
        $userWalletModel = new UserWalletModel();

        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        // check for start date and end date from request url
        $startDate = $_GET["start_date"];
        $endDate = $_GET["end_date"];

        if ($startDate && $endDate) {
            $userContributionsStmt = $userWalletModel->prepare('
                select * from user_wallet where
                created_at >= :startDate and created_at <= DATE_ADD(:endDate, INTERVAL 1 DAY)
                and user_id = :userId
                and chama_id = :chamaId
            ');
            $userContributionsStmt->bindValue(":startDate", $startDate);
            $userContributionsStmt->bindValue(":endDate", $endDate);
            $userContributionsStmt->bindValue(":userId", $userId);
            $userContributionsStmt->bindValue(":chamaId", $chamaId);

            $userContributionsStmt->execute();

            $userContributions = $userContributionsStmt->fetchAll(\PDO::FETCH_ASSOC);

            return $this->render("memberContributions", ["userContributions" => $userContributions], "dashboard");
        }

        $userContributions = $userWalletModel->findWhere(["user_id" => $userId]);

        return $this->render("memberContributions", ["userContributions" => $userContributions], "dashboard");
    }

    public function fetchContributions()
    {
        $contModel = new ContributeModel();

        $chamaId = Application::$app->session->get("user_chama");


        // check for start date and end date from request url
        $startDate = $_GET["start_date"];
        $endDate = $_GET["end_date"];

        if ($startDate && $endDate) {
            $userContributionsStmt = $contModel->prepare('
                select * from contributions where created_at >= :startDate and created_at <= DATE_ADD(:endDate, INTERVAL 1 DAY) and chama_id = :chama_id
            ');
            $userContributionsStmt->bindValue(":startDate", $startDate);
            $userContributionsStmt->bindValue(":endDate", $endDate);
            $userContributionsStmt->bindValue(":chama_id", $chamaId);

            $userContributionsStmt->execute();

            $userContributions = $userContributionsStmt->fetchAll(\PDO::FETCH_ASSOC);

            return $this->render("memberContributions", ["userContributions" => $userContributions], "dashboard");
        }

        $chamaRecords = $contModel->findWhere(["chama_id" => $chamaId]);

        return $this->render("contributions", ["chamaRecords" => $chamaRecords], "dashboard");
    }

    public function allocate(Request $request)
    {
        $chamaId = Application::$app->session->get("user_chama");
        $userId = $_GET["id"];
        $body = $request->getBody();

        $allocModel = new AllocateModel();
        $chamaWalletModel = new ChamaWalletModel();
        $userWalletModel = new UserWalletModel();

        $allocModel->loadData($body);

        if ($request->getMethod() == "get") {
            return $this->render("allocate", [
                "model" => $allocModel
            ], "dashboard");
        }

        if ($allocModel->validate()) {

            $allocModel->user_id = $userId;
            $allocModel->chama_id = $chamaId;
            $allocModel->amount = $body["amount"];

            $userAlloc = $allocModel->save();

            // debit chama wallet with amount
            $chamaRecords = $chamaWalletModel->findWhere(["chama_id" => $chamaId]);
            $lastCWRecord = end($chamaRecords);

            if ($lastCWRecord["balance"] <= $body["amount"]) {
                Application::$app->session->setFlash("error", "Insufficient funds");
            }
            $newChamaWalletBalance = $lastCWRecord["balance"] - $body["amount"];

            $updateChamaWallet = $this->debitChamaWallet($chamaId, $body["amount"], 0, $newChamaWalletBalance);

            // credit user wallet with amount
            $userRecords = $userWalletModel->findWhere(["user_id" => $userId]);
            $lastUWRecord = end($userRecords);
            $newUWBal = $lastUWRecord["balance"] + $body["amount"];

            if ($userAlloc && $updateChamaWallet  && $newUWBal) {
                Application::$app->session->setFlash("success", "Allocation success");
                Application::$app->response->redirect("/allocate?id=$userId");
                exit;
            }
        }
        return $this->render("allocate", [
            "model" => $allocModel
        ], "dashboard");
    }


    public function walletWithdraw(Request $request)
    {
        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        $body = $request->getBody();

        $userWalletModel = new UserWalletModel();
        $chamaWalletModel = new ChamaWalletModel();

        if ($request->getMethod() == "get") {
            return $this->render("withdraw", [
                "model" => $userWalletModel
            ], "dashboard");
        }

        // fetch last record from each table
        $userRecords = $userWalletModel->findWhere(["user_id" => $userId, "chama_id" => $chamaId]);
        $lastUWRecord = end($userRecords);

        $chamaRecords = $chamaWalletModel->findWhere(["chama_id" => $chamaId]);
        $lastCWRecord = end($chamaRecords);

        // check if chama wallet has enough money
        if ($lastUWRecord["balance"] < $body["amount"]) {
            Application::$app->session->setFlash("error", "Not enough money in your wallet");
            Application::$app->response->setStatusCode(400);
            exit;
        }

        // debit user wallet 
        $userWalletModel->user_id = $userId;
        $userWalletModel->chama_id = $chamaId;
        $userWalletModel->debit = $body["amount"];
        $userWalletModel->credit = 0;
        $userWalletModel->balance = $lastUWRecord["balance"] - $body["amount"];

        $updateUW = $userWalletModel->save();

        // debit chama wallet
        $updateCWallet = $this->debitChamaWallet($chamaId, $body["amount"], 0, $lastCWRecord["balance"] - $body["amount"]);


        if ($updateUW && $updateCWallet) {
            Application::$app->session->setFlash("success", "Withdraw successfull!");
            Application::$app->response->redirect("/withdraw");
            exit;
        }
    }
}
