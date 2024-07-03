<?php

namespace app\controllers;

class SiteController extends Controller
{


    public function home()
    {
        return $this->render("home", [], "dashboard");
    }

    public function users()
    {
        return $this->render("users", [], "dashboard");
    }

    public function settings()
    {

        return $this->render("settings", [], "dashboard");
    }
}
