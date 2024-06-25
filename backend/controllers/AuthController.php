<?php
class AuthController extends controller{
    //private static $key = '123456'; //Application Key
    public function login() {
        // Captura o corpo da requisição
        $inputJSON = file_get_contents('php://input');
        
        // Verifica se há dados no corpo da requisição
        if (!$inputJSON) {
            output_header(false, 'Dados de entrada não encontrados');
            return;
        }
    
        // Decodifica os dados JSON para um array associativo
        $input = json_decode($inputJSON, true);
    
        // Verifica se os campos 'username' e 'passcode' foram enviados
        if (!isset($input['username']) || !isset($input['passcode'])) {
            output_header(false, 'Parâmetros "username" e "passcode" são obrigatórios');
            return;
        }
    
        $username = $input['username'];
        $passcode = $input['passcode'];
    
        $key = '123456'; // Application Key
    
        $users = new UsersController();
    
        if ($users->userExists($username, $passcode)) {
            // Header Token
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
    
            // Payload - Conteúdo
            $payload = [
                'nome' => $username
            ];
    
            // JSON
            $header = json_encode($header);
            $payload = json_encode($payload);
    
            // Base64
            $header = base64_encode($header);
            $payload = base64_encode($payload);
    
            // Sign
            $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
            $sign = base64_encode($sign);
    
            // Token
            $token = $header . '.' . $payload . '.' . $sign;
    
            echo $token;
        } else {
            output_header(false, 'Usuário ou senha inválidos');
        }
    }    

    public static function checkAuth($printRetorno = true) {
        // Pega dados da requisição
        $http_header = apache_request_headers();
    
        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            // Acessando dados do cabeçalho HTTP
            $bearer = explode(' ', $http_header['Authorization']);
            
            if (count($bearer) === 2 && $bearer[0] === 'Bearer') {
                $token = $bearer[1];
    
                // Divide o token em 3 partes, sempre que achar um '.' ele quebra em uma parte
                $token_parts = explode('.', $token);
    
                if (count($token_parts) === 3) {
                    $header = $token_parts[0];
                    $payload = $token_parts[1];
                    $sign = $token_parts[2];
    
                    // Conferindo assinatura
                    $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
                    $valid = base64_encode($valid);
    
                    if ($sign === $valid) {
                        // Decodificando o payload
                        $decoded_payload = base64_decode($payload);
                        $decoded_payload_array = json_decode($decoded_payload, true);
    
                        if ($printRetorno) {
                            // Definindo o cabeçalho da resposta HTTP para JSON
                            header('Content-Type: application/json');
    
                            // Retornando os dados do usuário autenticado como JSON
                            echo json_encode($decoded_payload_array);
                        }
    
                        // Retornando como array PHP
                        return $decoded_payload_array;
                    }
                }
            }
        }
    
        if ($printRetorno) {
            // Retorna uma resposta de erro em JSON se a autenticação falhar
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Token Inválido"));
        }
    
        return false;
    }
}