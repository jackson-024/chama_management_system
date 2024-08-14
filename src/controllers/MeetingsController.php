<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\MeetingsModel;

class MeetingsController extends Controller
{
    public function createMeeting(Request $request)
    {
        $body = $request->getBody();
        $chamaId = Application::$app->session->get("user_chama");
        $meetingModel = new MeetingsModel();

        if ($request->getMethod() == "get") {
            return $this->render("createMeeting", [
                "model" => $meetingModel
            ], "dashboard");
        }

        $body["chama_id"] = $chamaId;
        $meetingModel->loadData($body);

        if ($meetingModel->validate()) {
            $newMeeting = $meetingModel->save();

            if ($newMeeting) {
                Application::$app->session->setFlash("success", "Meeting Scheduled!");
                Application::$app->response->redirect("/create-meeting");
                exit;
            }
        }
    }

    public function fetchMeetings()
    {
        $chamaId = Application::$app->session->get("user_chama");
        $meetingModel = new MeetingsModel();
        $meetings = $meetingModel->findWhere(["chama_id" => $chamaId]);


        $meetings = array_map(function ($meeting) {
            unset($meeting['chama_id']);
            return $meeting;
        }, $meetings);


        return $this->render("meetings", [
            "model" => $meetingModel,
            "meetings" => $meetings
        ], "dashboard");
    }
}
