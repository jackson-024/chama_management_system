<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\ChamaModel;
use app\models\JoinModel;
use app\models\UserModel;
use PDO;

class ChamaController extends Controller
{
    public function __construct()
    {
        // $this->setLayout("main");
    }

    public function landing()
    {
        return $this->render("landing", [], "main");
    }

    public function createChama(Request $request)
    {
        $chama = new ChamaModel;

        if ($request->getMethod() === "get") {
            return $this->render("createChama", [
                "model" => $chama
            ], "main");
        }

        if ($request->getMethod() === "post") {
            $body = $request->getBody();
            $chama->loadData($body);

            if ($chama->validate() && $chama->create()) {
                Application::$app->session->setFlash("success", "Chama created! Await approval.");
                Application::$app->response->redirect('/');
                exit;
            } else {
                return $this->render("createChama", [
                    "model" => $chama
                ], "dashboard");
            }
        }
    }

    public function joinChama(Request $request)
    {
        $joinModel = new JoinModel();
        $chamaModel = new ChamaModel();
        $chamas = $chamaModel->findAll();

        if ($request->getMethod() === "get") {
            return $this->render("joinChama", [
                "model" => $joinModel,
                "chamas" => $chamas
            ], "main");
        }

        if ($request->getMethod() === "post") {
            $body = $request->getBody();
            $joinModel->loadData($body);

            if ($joinModel->validate() && $joinModel->create()) {
                Application::$app->session->setFlash("success", "Request sent, Await approval!");
                Application::$app->response->redirect('/login');
                exit;
            } else {
                Application::$app->session->setFlash("error", "An error occured, try again!");
                // Application::$app->response->redirect('/login');
                return $this->render("joinChama", [
                    "model" => $joinModel,
                    "chamas" => $chamas
                ], "main");
            }
        }
    }

    // function to display chamas
    public function showChamas()
    {
        $chamaModel = new ChamaModel();
        // $chamas = $chamaModel->findAll();
        $chamasStmt = $chamaModel->prepare(
            '
            SELECT c.*, u.userName as chairperson_id FROM chamas c INNER JOIN users u ON c.chairperson_id = u.id
        '
        );
        $chamasStmt->execute();
        $chamas = $chamasStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($chamas) > 0) {
            return $this->render("chamas", [
                "model" => $chamaModel,
                "chamas" => $chamas
            ], "dashboard");
        }
    }

    public function chamaProfile()
    {
        $chamaModel = new ChamaModel();
        $chamaId =  $_GET['id'];
        $chama = $chamaModel->findOne(["id" => $chamaId]);

        return $this->render("chamaProfile", [
            "model" => $chamaModel,
            "chama" => $chama
        ], "dashboard");
    }

    public function approveChama()
    {
        $chamaModel = new ChamaModel();
        $chamaId =  $_GET['id'];
        $chama = $chamaModel->findOne(["id" => $chamaId]);

        // update the chama to approved or declined
        $updateChama = $chamaModel->updateOne(["id" => $chamaId], ["status" => "active"]);

        // update users table to add chama_id and role
        $user = new UserModel();
        $userId = Application::$app->user->{"id"};
        $updateUser = $user->updateOne(["id" => $userId], ["role_id" => 2]);


        if ($updateChama && $updateUser) {
            Application::$app->session->setFlash("success", "Approval succesfull!");
            Application::$app->response->redirect("/chama-profile?id=$chamaId");
            exit;
        }

        return $this->render("chamaProfile", [
            "model" => $chamaModel,
            "chama" => $chama
        ], "dashboard");
    }

    public function rejectChama()
    {
        $chamaModel = new ChamaModel();
        $chamaId =  $_GET['id'];
        $chama = $chamaModel->findOne(["id" => $chamaId]);

        // update the chama to approved or declined
        $updateChama = $chamaModel->updateOne(["id" => $chamaId], ["status" => "inactive"]);

        if ($updateChama) {
            Application::$app->session->setFlash("success", "Reject succesfull!");
            Application::$app->response->redirect("/chama-profile?id=$chamaId");
            exit;
        }

        return $this->render("chamaProfile", [
            "model" => $chamaModel,
            "chama" => $chama
        ], "dashboard");
    }
}
