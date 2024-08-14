<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\LoanProductModel;

class loanProductController extends Controller
{
    public function createLoanProduct(Request $request)
    {
        $loanProdModel = new LoanProductModel();
        $chamaId = Application::$app->session->get("user_chama");

        if ($request->getMethod() == "get") {

            return $this->render("createLoanProduct", [
                "model" => $loanProdModel,
            ], "dashboard");
        }

        $body = $request->getBody();
        $body["chama_id"] = $chamaId;
        $loanProdModel->loadData($body);

        if ($loanProdModel->validate()) {
            $newLoanProd = $loanProdModel->save($body);

            if ($newLoanProd) {
                Application::$app->session->setFlash("success", "Loan Product created!");
                Application::$app->response->redirect("/loan-products");
                exit;
            } else {
                Application::$app->session->setFlash("error", "Failed to create Loan Product");
                exit;
            }
        } else {
            return $this->render("createLoanProduct", [
                "model" => $loanProdModel,
            ], "dashboard");
        }
    }

    public function fetchChamaLoanProducts()
    {
        $loanProdModel = new LoanProductModel();
        $chamaId = Application::$app->session->get("user_chama");

        $loanProducts = $loanProdModel->findWhere(["chama_id" => $chamaId]);

        $loanProducts = array_map(function ($prod) {
            unset($prod['chama_id']);
            return $prod;
        }, $loanProducts);

        return $this->render("loanProducts", [
            "model" => $loanProdModel,
            "loanProducts" => $loanProducts
        ], "dashboard");
    }


    public function loanProductProfile(Request $request)
    {
        $loanProdModel = new LoanProductModel();
        $loanProdId = $_GET["id"];

        $loanProd = $loanProdModel->findOne(["id" => $loanProdId]);

        return $this->render("loanProductProfile", [
            "loanProd" => $loanProd
        ], "dashboard");
    }

    public function deactivateLoanProduct(Request $request)
    {
        $loanProdModel = new LoanProductModel();
        $loanProdId = $_GET["id"];

        $updateloanProd = $loanProdModel->updateOne(["id" => $loanProdId], ["status" => "inavtive"]);

        if ($updateloanProd) {
            Application::$app->session->setFlash("success", "Deactivation success");
            exit;
        } else {
            Application::$app->session->setFlash("error", "Deactivation not successfull!");
            Application::$app->response->setStatusCode(400);
            exit;
        }
    }
}
