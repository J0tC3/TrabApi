<?php
class AuthController extends controller{
    //private static $key = '123456'; //Application Key
    public function login() {
        $key = '123456'; //Application Key
        
        $users = new UsersController();

        $username = $_POST['username'];
        $password = $_POST['password'];

        if($users->userExists($username, $password)) {
            //Header Token
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Payload - Content
            $payload = [
                'username' => 'Rafael Capoani',
                'senha' => '123',
            ];

            //JSON
            $header = json_encode($header);
            $payload = json_encode($payload);

            //Base 64
            $header = base64_encode($header);
            $payload = base64_encode($payload);

            //Sign
            $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
            $sign = base64_encode($sign);

            //Token
            $token = $header . '.' . $payload . '.' . $sign;

            echo $token;
        }
    }

}