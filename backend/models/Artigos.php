<?php
class Artigos extends model{

    //Criar Artigo
    public function createArtigo($titulo, $descricao, $link, $autor){
        $sql = "INSERT INTO tab_artigo 
        (titulo, descricao, link, autor)
            VALUES (:titulo, :descricao, :link, :autor)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':link', $link);
            $stmt->bindValue(':autor', $autor);

            $stmt->execute();
    }

    //Listar todos os artigos
	public function getAll(){
		$array = array();

		$sql = "SELECT *
		          FROM tab_artigo";

		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}	

		return $array;
	}

    //Listar Pelo Titulo dos artigos
    public function getTitulo($titulo) {
        $array = array();
        
        $titulo = '%'.$titulo.'%';
        
        $sql = "SELECT *
                FROM tab_artigo
                WHERE titulo LIKE :titulo";
        
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
    
        $autor = '%'.$autor.'%';
        
        $sql = "SELECT *
                FROM tab_artigo
                WHERE autor LIKE :autor";
       
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

        $sql = "DELETE FROM tab_artigo
            WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$artigo]);
    }

    //Excluir Todos o Artigos do Autor
    public function dropTodosArtigos($autor){

        $sql = "DELETE FROM tab_artigo
            WHERE autor = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$autor]);
    }

}