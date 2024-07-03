<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\RoleModel;
use app\models\UserModel;

class RoleController extends Controller
{
    public function addRole(Request $request)
    {

        $role = new RoleModel();

        $body = $request->getBody();

        $role->loadData($body);

        if ($role->validate() && $role->save()) {

            return "Role Saved successfully";
        }
    }
}
