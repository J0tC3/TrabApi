<?php
class Users extends model{

	public function getAll(){
		$array = array();

		$sql = "SELECT *
		          FROM tab_user";

		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}	

		return $array;
	}

    public function Keypass($username){
        $sql = "SELECT passcode FROM tab_user
        WHERE username LIKE :username";
            
            $stmt->bindValue(':username', $username);

            if($stml->rowCount() > 0){
                $array = $stml->fetchAll(\PDO::FETCH_ASSOC);
            }	
    
            return $array;
    }

    //Criar novo Usuário
    public function criarUsuario($username, $passcode, $email) {
        $sql = "INSERT INTO tab_user
            (username, passcode, email)
                VALUES (:username, :passcode, :email)";
        $stmt = $this->db->prepare($sql);
    
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':passcode', $passcode);
    
        $stmt->execute();
    }

    //Editar Informação do Usuário    
    public function alterUsuario($id, $username, $passcode, $email) {
        $sql = "UPDATE tab_user
                SET username = :username, passcode = :passcode, email = :email 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':passcode', $passcode);
        $stmt->bindValue(':email', $email);
    
        $stmt->execute();
    }

    public function InfoUser($username) {

        $sql = "SELECT * FROM tab_user
                WHERE username LIKE :username";
                
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':username', $username);

        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }   
        
        return $array;
    }

    //Deletar Usuário    
    public function dropUsuario($id){
        $sql = "DELETE FROM tab_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}