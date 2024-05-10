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
    public function createUsuario($nome, $sexo, $bibliografia, $email) {
        $sql = "INSERT INTO tab_usuarios 
            (nome, sexo, bibliografia, email)
                VALUES (:nome, :sexo, :bibliografia, :email)";
        $stmt = $this->db->prepare($sql);
    
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':sexo', $sexo);
        $stmt->bindValue(':bibliografia', $bibliografia);
        $stmt->bindValue(':email', $email);
    
        $stmt->execute();
    }

    //Editar Informação do Usuário    
    public function alterUsuario($id, $nome, $sexo, $bibliografia, $email) {
        $sql = "UPDATE tab_usuarios 
                SET nome = :nome, sexo = :sexo, bibliografia = :bibliografia, email = :email 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':sexo', $sexo);
        $stmt->bindValue(':bibliografia', $bibliografia);
        $stmt->bindValue(':email', $email);
    
        $stmt->execute();
    }

    //Deletar Usuário    
    public function dropUsuario($id){
        $sql = "DELETE FROM tab_usuarios
        WHERE id = ?";
    
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$id]);
    }
}