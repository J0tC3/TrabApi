<?php
class Artigos extends model{

    //Listar todos os artigos
	public function getAll(){
		$array = array();

		$sql = "SELECT *
		          FROM tab_artigos";

		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}	

		return $array;
	}

    //Listar Pelo Titulo dos artigos
    public function getTitulo($titulo) {
        $array = array();
        
        $sql = "SELECT *
         FROM tab_artigos WHERE titulo = :titulo";
        
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(':titulo', $titulo);
        
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }   
        
        return $array;
    }

    //Listar Por Autores dos artigos
    public function getAutor($autor) {
        $array = array();
    
        $sql = "SELECT *
         FROM tab_artigos WHERE autor = :autor";
       
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(':autor', $autor);
        
        $sql->execute();
    
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }   
    
        return $array;
    }

    //Excluir Artigo
    public function dropArtigo($artigo){

        $sql = "DELETE FROM tab_artigos
            WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$artigo]);
    }

    //Excluir Todos o Artigos do Autor
    public function dropTodosArtigos($autor){

        $sql = "DELETE FROM tab_artigos
            WHERE autor = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$autor]);
    }

}