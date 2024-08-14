<?php

namespace app\controllers;

use app\core\Application;
use app\models\ChamaModel;
use app\models\ChamaWalletModel;
use app\models\ContributeModel;
use app\models\FinesModel;
use app\models\JoinModel;
use app\models\MeetingsModel;
use app\models\UserAccountsModel;
use app\models\UserLoansModel;
use app\models\UserWalletModel;

class SiteController extends Controller
{
    public function home()
    {

        $initChama = new ChamaModel();

        $userRole = Application::$app->session->get("user_role");
        $chamaId = Application::$app->session->get("user_chama");
        $userId = Application::$app->user->{"id"};
        $userAccModel = new UserAccountsModel();
        $joinRequests = new JoinModel();
        $userWalletModel = new UserWalletModel();
        $chamaContributions = new ChamaWalletModel();
        $meetingsModel = new MeetingsModel();

        $chama = $initChama->findOne(["id" => $chamaId]);

        $userAccountsStmt = $userAccModel->prepare('
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

        $chamaUsers = $userAccountsStmt->fetchAll(\PDO::FETCH_ASSOC);

        $joinReqs = $joinRequests->findWhere(["chama_id" => $chamaId, "join_status" => "pending"]);

        // fetch user contributed amount
        $userWRecords = $userWalletModel->findWhere(["user_id" => $userId]);
        $lastUWRecord = end($userWRecords);

        // fetch chama contribution balance
        $chamaContRecords = $chamaContributions->findWhere(["chama_id" => $chamaId]);
        $lastChamaRecord = end($chamaContRecords);

        $today = date('Y-m-d');
        $meetings = $meetingsModel->findWhere(["chama_id" => $chamaId, "date" => $today]);
        // $meetings = $meetingsModel->findWhere(["chama_id" => $chamaId]);

        // fetch loans
        $userLoansModel = new UserLoansModel();
        $chamaLoans = $userLoansModel->findWhere(["chama_id" => $chamaId]);

        // fetch fines
        $finesModel = new FinesModel();
        $fines = $finesModel->findWhere(["chama_id" => $chamaId, "status" => "not_cleared"]);


        if ($userRole == 1) {
            return $this->render("home", [], "dashboard");
        } elseif ($userRole == 2) {
            return $this->render("chairmanDashboard", [
                "users" => $chamaUsers,
                "joinReqs" => $joinReqs,
                "chama" => $chama,
                "lastChamaRecord" => $lastChamaRecord,
                "meetings" => $meetings,
                "lastUWRecord" => $lastUWRecord,
                "chamaLoans" => $chamaLoans,
                "fines" => $fines,
            ], "dashboard");
        } elseif ($userRole == 3) {
            return $this->render("treasurerDashboard", [
                "users" => $chamaUsers,
                "joinReqs" => $joinReqs,
                "chama" => $chama,
                "lastChamaRecord" => $lastChamaRecord,
                "meetings" => $meetings,
                "lastUWRecord" => $lastUWRecord,
                "chamaLoans" => $chamaLoans,
                "fines" => $fines,
            ], "dashboard");
        } elseif ($userRole == 4) {
            return $this->render("secretaryDashboard", [
                "users" => $chamaUsers,
                "chama" => $chama,
                "lastChamaRecord" => $lastChamaRecord,
                "meetings" => $meetings,
                "lastUWRecord" => $lastUWRecord,
                "chamaLoans" => $chamaLoans,
                "fines" => $fines,
            ], "dashboard");
        } elseif ($userRole == 5) {
            return $this->render("memberDashboard", [
                "lastUWRecord" => $lastUWRecord,
                "lastChamaRecord" => $lastChamaRecord,
                "meetings" => $meetings

            ], "dashboard");
        }

        return $this->render("home", [], "dashboard");
    }

    public function settings()
    {

        return $this->render("settings", [], "dashboard");
    }
}
