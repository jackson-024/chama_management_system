<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\AuthController;
use app\controllers\ChamaController;
use app\controllers\Controller;
use app\controllers\RoleController;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\core\Application;
use app\models\UserModel;

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'userClass' => UserModel::class
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/hello', "hello");

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/users', [UserController::class, 'users']);

$app->router->get('/login', [AuthController::class, 'handleLogin']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/register', [AuthController::class, 'handleRegistration']);
$app->router->post('/register', [AuthController::class, 'handleRegistration']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->post('/add-role', [RoleController::class, 'addRole']);

$app->router->get('/settings', [SiteController::class, 'settings']);
$app->router->get('/landing', [ChamaController::class, 'landing']);

$app->router->get('/join-chama', [ChamaController::class, 'joinChama']);
$app->router->post('/join-chama', [ChamaController::class, 'joinChama']);

$app->router->get('/join-requests', [ChamaController::class, 'joinRequests']);

$app->router->get('/create-chama', [ChamaController::class, 'createChama']);
$app->router->post('/create-chama', [ChamaController::class, 'createChama']);

$app->router->get('/chamas', [ChamaController::class, 'showChamas']);
$app->router->get('/chama-profile', [ChamaController::class, 'chamaProfile']);
$app->router->get('/chama-approve', [ChamaController::class, 'approveChama']);
$app->router->get('/chama-reject', [ChamaController::class, 'rejectChama']);

$app->router->get('/user-profile', [UserController::class, 'userProfile']);

$app->run();
