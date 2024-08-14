<?php

namespace app\core;

use app\controllers\Controller;
use app\models\DbModel;
use app\models\UserAccountsModel;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Render $render;
    public ?Controller $controller;
    public Database $db;
    public Session $session;
    public ?DbModel $user;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->userClass = $config['userClass'];
        $this->session = new Session();
        $this->controller = new Controller();
        $this->render = new Render();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response, $this->render);

        // initialize the database connection
        $this->db = new Database($config['db']);

        // get user model instance
        $userInstance = new $this->userClass();
        $userAcc = new UserAccountsModel();

        $primaryValue = $this->session->get('user'); // get primary key from session | check if exists

        if ($primaryValue) {
            $primaryKey = $userInstance->primaryKey();
            $this->user = $userInstance->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {

        echo $this->router->resolve();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    // assign user_id to session
    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $userId = $user->$primaryKey;
        $this->session->set("user", $userId);

        return true;
    }

    public function logout()
    {
        $this->session->remove("user");
        $this->session->remove("user_role");
        $this->session->remove("user_chama");
        self::$app->user = null;
    }

    public function isGuest()
    {
        return !self::$app->user;
    }
}
