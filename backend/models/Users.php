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
                WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':passcode', $passcode);
        $stmt->bindValue(':email', $email);
    
        $stmt->execute();
    }

    //Deletar Usuário    
    public function dropUsuario($id){
        $sql = "DELETE FROM tab_user WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    // Retornar dados do usuário pelo username
    public function getUserDataByUsername($username) {
        $sql = "SELECT * FROM tab_user WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return null;
    }
}