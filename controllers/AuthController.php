<?php

class AuthController
{
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data['login'] == 'admin' && $data['password'] == 'testpassword') {
            $_SESSION['authenticated'] = true;

            return json_encode(['message' => 'success', 'code' => 200]);
        }

        http_response_code(500);
        return json_encode(['message' => 'fail', 'code' => '500']);
    }

    public function logout()
    {
        unset($_SESSION['authenticated']);

        return json_encode(['message' => 'success', 'code' => 200]);
    }
}