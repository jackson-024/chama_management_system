<?php

// 
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\AuthController;
use app\controllers\ChamaController;
use app\controllers\ContributeController;
use app\controllers\Controller;
use app\controllers\FinesController;
use app\controllers\loanProductController;
use app\controllers\MeetingsController;
use app\controllers\RoleController;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\controllers\UserLoansController;
use app\core\Application;
use app\models\ContributeModel;
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

$app->router->get('/', [SiteController::class, 'landingPage']);
$app->router->get('/users', [UserController::class, 'users']);

$app->router->get('/login', [AuthController::class, 'handleLogin']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);

$app->router->post('/login-user-account', [AuthController::class, 'loginUserAcc']);

$app->router->post('/create-user-account', [AuthController::class, 'createUserAcc']);

$app->router->get('/user-accounts', [AuthController::class, 'getUserAccounts']);
$app->router->post('/user-accounts', [AuthController::class, 'loginUserAcc']);

$app->router->get('/user-profile', [UserController::class, 'userProfile']);
$app->router->get('/user-deactivate', [UserController::class, 'userDeactivate']);
$app->router->get('/user-activate', [UserController::class, 'userActivate']);

$app->router->get('/register', [AuthController::class, 'handleRegistration']);
$app->router->post('/register', [AuthController::class, 'handleRegistration']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$app->router->post('/forgot-password', [AuthController::class, 'forgotPassword']);

$app->router->post('/add-role', [RoleController::class, 'addRole']);

$app->router->get('/settings', [SiteController::class, 'settings']);
$app->router->get('/landing', [ChamaController::class, 'landing']);

$app->router->get('/join-chama', [ChamaController::class, 'joinChama']);
$app->router->post('/join-chama', [ChamaController::class, 'joinChama']);

$app->router->get('/join-chama-approve', [ChamaController::class, 'approveChamaJoin']);
$app->router->get('/join-chama-reject', [ChamaController::class, 'rejectChamaJoin']);

$app->router->get('/join-requests', [ChamaController::class, 'joinRequests']);

$app->router->get('/create-chama', [ChamaController::class, 'createChama']);
$app->router->post('/create-chama', [ChamaController::class, 'createChama']);

$app->router->get('/chamas', [ChamaController::class, 'showChamas']);
$app->router->get('/chama-profile', [ChamaController::class, 'chamaProfile']);
$app->router->get('/chama-approve', [ChamaController::class, 'approveChama']);
$app->router->get('/chama-reject', [ChamaController::class, 'rejectChama']);

$app->router->get('/contribute', [ContributeController::class, 'addContribution']);
$app->router->post('/contribute', [ContributeController::class, 'addContribution']);

$app->router->get('/contributions', [ContributeController::class, 'fetchContributions']);
$app->router->post('/contributions', [ContributeController::class, 'fetchContributions']);

$app->router->get('/member-contributions', [ContributeController::class, 'fetchMemberContributions']);
$app->router->post('/member-contributions', [ContributeController::class, 'fetchMemberContributions']);

$app->router->get('/nominate', [AuthController::class, 'nominate']);
$app->router->post('/nominate', [AuthController::class, 'nominate']);

$app->router->get('/allocate', [ContributeController::class, 'allocate']);
$app->router->post('/allocate', [ContributeController::class, 'allocate']);

$app->router->get('/loan-products', [loanProductController::class, 'fetchChamaLoanProducts']);
$app->router->post('/loan-products', [loanProductController::class, 'fetchChamaLoanProducts']);

$app->router->get('/loan-product-profile', [loanProductController::class, 'loanProductProfile']);

$app->router->get('/deactivate-loan-product', [loanProductController::class, 'deactivateLoanProduct']);

$app->router->get('/create-loan-product', [loanProductController::class, 'createLoanProduct']);
$app->router->post('/create-loan-product', [loanProductController::class, 'createLoanProduct']);

$app->router->get('/loans', [UserLoansController::class, 'fetchChamaLoans']);
$app->router->get('/my-loans', [UserLoansController::class, 'fetchUserLoans']);

$app->router->get('/create-loan', [UserLoansController::class, 'createLoan']);
$app->router->post('/create-loan', [UserLoansController::class, 'createLoan']);

$app->router->get('/chama-wallet', [ChamaController::class, 'chamaWallet']);

$app->router->get('/withdraw', [ContributeController::class, 'walletWithdraw']);
$app->router->post('/withdraw', [ContributeController::class, 'walletWithdraw']);

$app->router->get('/meetings', [MeetingsController::class, 'fetchMeetings']);

$app->router->get('/create-meeting', [MeetingsController::class, 'createMeeting']);
$app->router->post('/create-meeting', [MeetingsController::class, 'createMeeting']);

$app->router->get('/fines', [FinesController::class, 'fetchChamaFines']);
$app->router->get('/fine-profile', [FinesController::class, 'fetchFine']);
$app->router->get('/member-fines', [FinesController::class, 'fetchUserFines']);

$app->router->get('/create-fine', [FinesController::class, 'createFine']);
$app->router->post('/create-fine', [FinesController::class, 'createFine']);

$app->router->get('/pay-fine', [FinesController::class, 'payFine']);
$app->router->post('/pay-fine', [FinesController::class, 'payFine']);

$app->run();
