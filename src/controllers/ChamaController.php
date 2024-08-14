<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\ChamaModel;
use app\models\ChamaWalletModel;
use app\models\JoinModel;
use app\models\UserAccountsModel;
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
                Application::$app->response->redirect('/login');
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

        return $this->render("chamas", [
            "model" => $chamaModel,
            "chamas" => $chamas
        ], "dashboard");
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
        $chamaModel = new ChamaModel(); // create an instance of a chama

        $chamaId =  $_GET['id']; // get id param from url

        $chama = $chamaModel->findOne(["id" => $chamaId]); //find chama with chamaId

        // update the chama to approved or declined
        $updateChama = $chamaModel->updateOne(["id" => $chamaId], ["status" => "active"]);

        // update users table to add chama_id and role
        $user = new UserModel();
        $userAcc = new UserAccountsModel(); // instance of user accounts model

        // check if user exists in chama with same role
        // user cannot have same role twice
        $sameRole = $userAcc->findOne(["user_id" => $chama->{"chairperson_id"}, "role_id" => $role_id = 2, "chama_id" => $chama->{"id"}]);

        // create new user account
        $userAcc->user_id = $chama->{"chairperson_id"};
        $userAcc->chama_id = $chama->{"id"};
        $userAcc->role_id = 2;
        $newAcc = $userAcc->save();

        $userId = $chama->{"chairperson_id"};
        $updateUser = $user->updateOne(["id" => $userId], ["status" => "active"]);

        if ($updateChama && $newAcc && $updateUser) {
            Application::$app->session->setFlash("success", "Approval succesfull!");
            Application::$app->response->redirect("/chama-profile?id=$chamaId");
            exit;
        }

        // return $this->render("chamaProfile", [
        //     "model" => $chamaModel,
        //     "chama" => $chama
        // ], "dashboard");
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

        // return $this->render("chamaProfile", [
        //     "model" => $chamaModel,
        //     "chama" => $chama
        // ], "dashboard");
    }

    // function to display join requests
    public function joinRequests()
    {
        $joinModel = new JoinModel();
        $chama_id = Application::$app->session->get("user_chama");

        // create a prepared inner join statement to fetch all join requests
        // and join on users and chama table
        $joinStmt = $joinModel->prepare(
            '
            SELECT j.id, c.name as chama_id, u.userName, j.join_status, j.created_at, j.updated_at
            FROM join_request j
            INNER JOIN users u ON j.user_id = u.id
            INNER JOIN chamas c ON j.chama_id = c.id
            WHERE j.chama_id = :chama_id
        '
        );
        $joinStmt->bindValue(":chama_id", $chama_id);
        $joinStmt->execute();

        // fetch data then return as an array
        $requests = $joinStmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->render("joinRequests", [
            "model" => $joinModel,
            "requests" => $requests
        ], "dashboard");
    }


    public function approveChamaJoin()
    {
        $joinModel = new JoinModel();
        $userModel = new UserModel();
        $userAcc = new UserAccountsModel();

        $requests = $this->joinRequests();

        // get joinId and userId from request
        $joinId = $_GET['id'];

        // get user join request from join requests table
        $join = $joinModel->findOne(["id" => $joinId]);

        // check if user has same membership in chama
        $existUserAcc = $userAcc->findOne(["user_id" => $join->{"user_id"}, "chama_id" => $join->{"chama_id"}, "role_id" => 5]);

        if ($existUserAcc) {
            Application::$app->response->setStatusCode(400);
            // Application::$app->response->redirect("/join-requests");
            Application::$app->session->setFlash("error", "User account already exists");


            return $this->render("joinRequests", [
                "model" => $joinModel,
                "requests" => $requests
            ], "dashboard");
        }

        $updateJoin = $joinModel->updateOne(["id" => $joinId], ["join_status" => "accepted"]); // update join request 

        $updateUser =  $userModel->updateOne(["id" => $join->{"user_id"}], ["status" => "active"]);  // update user status

        // create user account
        $userAcc->user_id = $join->{"user_id"};
        $userAcc->chama_id = $join->{"chama_id"};
        $userAcc->role_id = 5;
        $newAcc = $userAcc->save();

        if ($updateJoin && $updateUser && $newAcc) {
            Application::$app->session->setFlash("success", "Join request approved successfully!");
            Application::$app->response->redirect("/join-requests");
            exit;
        }
    }

    public function rejectChamaJoin()
    {
        $joinModel = new JoinModel();
        $joinId =  $_GET['id'];

        // update the request to approved or declined
        $updateJoinReq = $joinModel->updateOne(["id" => $joinId], ["join_status" => "rejected"]);

        if ($updateJoinReq) {
            Application::$app->session->setFlash("success", "Reject succesfull!");
            Application::$app->response->redirect("/chama-profile?id=$joinId");
            exit;
        }
    }

    public function chamaWallet()
    {
        $chamaId = Application::$app->session->get("user_chama");

        $chamaWalletModel = new ChamaWalletModel();

        $chamaRecords = $chamaWalletModel->findWhere(["chama_id" => $chamaId]);

        return $this->render("chamaWallet", [
            "chamaRecords" => $chamaRecords
        ], "dashboard");
    }
}
