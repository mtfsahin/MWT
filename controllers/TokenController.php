<?php
// controllers/TokenController.php
require_once __DIR__ . '/../models/TokenModel.php';

class TokenController {
    private $model;

    public function __construct() {
        $this->model = new TokenModel();
    }

    /**
     * Handle the incoming req
     * A token is generated and validate
     * The result tothe view for display
     */
    public function handleRequest() {

        if (!empty($_POST['userid'])) {
            $userId = $_POST['userid'];
            $token = $this->model->generateToken($userId);
            $isValid = $this->model->validateToken($token);
        } else {
            $this->clearTokenCookie();
            $token = null;
            $isValid = null;
        }
        include __DIR__ . '/../views/tokenView.php';
    }

    private function clearTokenCookie() {
        if (isset($_COOKIE['mwt_token'])) {
            unset($_COOKIE['mwt_token']);
            setcookie('mwt_token', '', time() - 3600, '/');
        }
    }
}
?>
