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

    public static function checkAuth($printRetorno = true) {
        // Pega dados da requisição
        $http_header = apache_request_headers();
    
        if(isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            // Acessando dados do cabeçalho HTTP
            $bearer = explode(' ', $http_header['Authorization']);
            //$bearer[0] -> 'bearer'
            //$bearer[1] -> 'token jwt'
    
            // Divide o token em 3 partes, sempre que achar um '.' ele quebra em uma parte
            $token = explode('.', $bearer[1]);
    
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];
    
            // Conferindo assinatura
            $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
            $valid = base64_encode($valid);
    
            if($sign === $valid) {
                // Decodificando o payload
                $decoded_payload = base64_decode($payload);
                $decoded_payload_array = json_decode($decoded_payload, true);
    
                if($printRetorno) {
                    // Definindo o cabeçalho da resposta HTTP para JSON
                    header('Content-Type: application/json');
        
                    // Retornando os dados do usuário autenticado como JSON
                    echo json_encode($decoded_payload_array);
                }

                //retornando como php
                return $decoded_payload_array;
            }
        }
    
        if($printRetorno) {
            // Retorna uma resposta de erro em JSON se a autenticação falhar
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Unauthorized"));
        }

        return false;
    }
}