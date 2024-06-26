<?php
class Artigos extends model{

    //Criar Artigo
    public function createArtigo($titulo, $descricao, $link, $autor, $email){
        // Insere o artigo no banco de dados
        $sql = "INSERT INTO tab_artigo 
        (titulo, autor, emailAutor, link, descricao)
            VALUES (:titulo, :autor, :email, :link, :descricao)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':link', $link);
        $stmt->bindValue(':autor', $autor);
        $stmt->bindValue(':email', $email);

        $stmt->execute();
    }

    public function editarArtigo($id, $titulo, $descricao, $link, $autor) {
        // Atualiza os detalhes do artigo no banco de dados
        $sql = "UPDATE tab_artigo
                SET titulo = :titulo, descricao = :descricao, link = :link
                WHERE id = :id AND autor = :autor";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':link', $link);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':autor', $autor);
        
        $stmt->execute();
    }

    public function editarAutorEmailAutor($oldAutor, $oldEmailAutor, $newAutor, $newEmailAutor) {
        // Atualiza o autor e emailAutor de todos os artigos que possuem o autor e emailAutor igual aos passados por parâmetros
        $sql = "UPDATE tab_artigo
                SET autor = :newAutor, emailAutor = :newEmailAutor
                WHERE autor = :oldAutor AND emailAutor = :oldEmailAutor";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':newAutor', $newAutor);
        $stmt->bindValue(':newEmailAutor', $newEmailAutor);
        $stmt->bindValue(':oldAutor', $oldAutor);
        $stmt->bindValue(':oldEmailAutor', $oldEmailAutor);
        
        $stmt->execute();
    }

    //Listar Pelo Titulo e Autor dos artigos
    public function getTituloAutor($titulo, $autor, $limit, $offset) {
        $array = array();
    
        $autor = '%' . $autor . '%';
        $titulo = '%' . $titulo . '%';
        
        $sql = "SELECT *
                FROM tab_artigo
                WHERE titulo LIKE :titulo AND autor LIKE :autor";
        
        // Adiciona cláusula LIMIT e OFFSET se limit for fornecido
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':autor', $autor);
    
        // Define os valores de limite e deslocamento se limit for fornecido
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        }
        
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }   
        
        return $array;
    }

    //Listar Por Autores dos artigos
    public function getAutor($autor) {
        $array = array();
        
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
    public function excluirArtigo($artigo, $username) {
        $sql = "DELETE FROM tab_artigo
                WHERE id = ? AND autor = ?";
        
        $stmt = $this->db->prepare($sql);
        
        // Execute a consulta com os parâmetros $artigo e $username
        $stmt->execute([$artigo, $username]);
    }

    //Excluir Todos o Artigos do Autor
    public function dropTodosArtigos($autor){

        $sql = "DELETE FROM tab_artigo
            WHERE autor = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([$autor]);
    }

    public function artigoExiste($id, $username) {
        $sql = "SELECT COUNT(*) FROM tab_artigo WHERE id = ? AND autor = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $username]);
        
        // Retorna true se o artigo existe, false caso contrário
        return $stmt->fetchColumn() > 0;
    }
}