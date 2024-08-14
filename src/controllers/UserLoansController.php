<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\ChamaWalletModel;
use app\models\LoanProductModel;
use app\models\UserLoansModel;
use app\models\UserWalletModel;

class UserLoansController extends Controller
{
    public function fetchChamaLoans()
    {
        $chamaId = Application::$app->session->get("user_chama");
        $userLoansModel = new UserLoansModel();

        $loans = $userLoansModel->findWhere(["chama_id" => $chamaId]);


        return $this->render("loans", [
            "loans" => $loans,
        ], "dashboard");
    }

    public function fetchUserLoans()
    {
        $userId = Application::$app->user->{"id"};
        $userLoansModel = new UserLoansModel();
        $loans = $userLoansModel->findWhere(["user_id" => $userId]);
        $loanId = $_GET["id"];

        if ($loanId) {
            // fetch one loan by id
            $loan = $userLoansModel->findOne(["id" => $loanId]);
            return $this->render("userLoanProfile", [
                "model" => $userLoansModel,
                "loan" => $loan,
            ], "dashboard");
        }

        // ignore password
        $loans = array_map(function ($loan) {
            unset($loan['user_id']);
            unset($loan['loan_prod_id']);
            unset($loan['chama_id']);
            return $loan;
        }, $loans);

        return $this->render("userLoans", [
            "loans" => $loans,
        ], "dashboard");
    }

    public function createLoan(Request $request)
    {
        $userId = Application::$app->user->{"id"};
        $chamaId = Application::$app->session->get("user_chama");

        $loanProdsModel = new LoanProductModel();
        $userLoansModel = new UserLoansModel();
        $chamaWalletModel =  new ChamaWalletModel();
        $userWalletModel =  new UserWalletModel();

        $body = $request->getBody();

        if ($request->getMethod() == "get") {
            $loanProducts = $loanProdsModel->findWhere(["chama_id" => $chamaId]);

            return $this->render("createLoan", [
                "model" => $userLoansModel,
                "loanProducts" => $loanProducts
            ], "dashboard");
        }


        if ($request->getMethod() == "post") {
            $body = $request->getBody();

            // check for defaulted loans
            $defaultedLoans = $userLoansModel->findWhere(["chama_id" => $chamaId, "user_id" => $userId, "loan_status" => "defaulted"]);

            if ($defaultedLoans) {
                Application::$app->session->setFlash("error", "Finish Paying defaulted loan");
                exit;
            }

            // fetch submitted loan product details
            $loanProd = $loanProdsModel->findOne(["id" => $body["loan_prod_id"]]);
            $interval = strval($loanProd->{'loan_repayment_period'});
            $dueDate = date('Y-m-d', strtotime("+$interval days"));

            // check if amount is more than loan product maximum amount
            if ($body["amount"] > $loanProd->{"max_amount"}) {
                Application::$app->session->setFlash("error", "Loan max amount exceeded");
                exit;
            }


            // check if member has money in user wallet
            $userWalletRecords = $userWalletModel->findWhere(["user_id" => $userId, "chama_id" => $chamaId]);
            $lastUWRecord = end($userWalletRecords);

            if ($lastUWRecord["balance"] < $body["amount"]) {
                Application::$app->session->setFlash("error", "Top up your wallet");
                Application::$app->response->redirect("/create-loan");
                exit;
            }

            // check if chama has money from chama_wallet
            $chamaRecords = $chamaWalletModel->findWhere(["chama_id" => $chamaId]);
            $lastCWRecord = end($chamaRecords);

            if ($lastCWRecord["balance"] < $body["amount"]) {
                Application::$app->session->setFlash("error", "Top up chama wallet");
                Application::$app->response->redirect("/create-loan");
                exit;
            }

            // generate loan details
            $userLoansModel->user_id = $userId;
            $userLoansModel->chama_id = $chamaId;
            $userLoansModel->loan_prod_id = $body["loan_prod_id"];
            $userLoansModel->amount = $body["amount"];
            $userLoansModel->repayable_amount = ($body["amount"] * ($loanProd->{"loan_interest_rate"} / 100)) + $body["amount"];
            $userLoansModel->loan_repayment_period = $loanProd->{"loan_repayment_period"};
            $userLoansModel->due_date = $dueDate;
            $userLoansModel->loan_status = "active";

            $newLoan = $userLoansModel->save();

            // debit chama wallet
            $chamaWalletModel->chama_id = $chamaId;
            $chamaWalletModel->debit = $body["amount"];
            $chamaWalletModel->credit = 0;
            $chamaWalletModel->balance = $lastCWRecord["balance"] - $body["amount"];

            $newCWRecord = $chamaWalletModel->save();

            // credit user wallet
            $userWalletRecords = $userWalletModel->findWhere(["user_id" => $userId, "chama_id" => $chamaId]);
            $lastUWRecord = end($userWalletRecords);
            $newUserBal = $lastUWRecord["balance"] + $body["amount"];

            $userWalletModel->user_id = $userId;
            $userWalletModel->chama_id = $chamaId;
            $userWalletModel->debit = 0;
            $userWalletModel->credit = $body["amount"];
            $userWalletModel->balance = $newUserBal;

            $newUWRecord = $userWalletModel->save();

            if ($newLoan && $newCWRecord && $newUWRecord) {
                Application::$app->session->setFlash("success", "Loan submitted succesfully!");
                Application::$app->response->redirect("/create-loan");
                exit;
            }
        }
    }

    public function repayLoan()
    {
        $userId = Application::$app->session->get("user_id");
        $chamaId = Application::$app->session->get("chama_id");
        $loanId = $_GET["id"];
    }
}
