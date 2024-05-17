<?php
class AuthController extends controller{
    //private static $key = '123456'; //Application Key
    public function login() {
        $key = '123456'; //Application Key
        
        $users = new UsersController();

        $username = $_POST['username'];
        $passcode = $_POST['passcode'];

        if($users->userExists($username, $passcode)) {
            //Header Token
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Payload - Content
            $payload = [
                'nome' => $username,

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

    public static function checkAuth() {
        //pego dados da requisicao
        $http_header = apache_request_headers();

        if(isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            //acessando dados do cabecalho htttp
            $bearer = explode(' ', $http_header['Authorization']);
            //$bearer[0] -> 'bearer'
            //$bearer[1] -> 'token jwt'

            //divide o token em 3 partes, sempre que achar um '.' ele quebra em uma parte
            $token = explode('.', $bearer[1]);

            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

            //conferindo assinatura
            $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
            $valid = base64_encode($valid);

            if($sign === $valid) {
                // Decodificando o payload
                $decoded_payload = base64_decode($payload);
                $decoded_payload_array = json_decode($decoded_payload, true);

                // Retornando os dados do usuário autenticado
                print_r ($decoded_payload_array);

                return $decoded_payload_array;
            }
        }

        return false;
    }
}