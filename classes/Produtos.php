<?php

class Produto
{
    private $db;
    private $table_name = "produtos"; // nome da tabela

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Método para listar produtos com filtro e ordenação
    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];
        
        if ($search) {
            $conditions[] = "(nome LIKE :search OR descricao LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        
        if ($order_by === 'nome') {
            $query .= " ORDER BY nome";
        } elseif ($order_by === 'preco') {
            $query .= " ORDER BY preco";
        }
        
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    // Método para adicionar um novo produto
    public function adicionar($nome, $preco, $descricao, $imagem)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nome, $preco, $descricao, $imagem]);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Erro ao adicionar produto: " . $e->getMessage());
        }
    }

    // Método para ler um produto por ID
    public function lerPorId($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id_produto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao ler produto por ID: " . $e->getMessage());
        }
    }

    // Método para atualizar um produto
    public function atualizar($id, $nome, $preco, $descricao, $imagem = null)
    {
        try {
            if ($imagem) {
                $query = "UPDATE " . $this->table_name . " SET nome = ?, preco = ?, descricao = ?, imagem = ? WHERE id_produto = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$nome, $preco, $descricao, $imagem, $id]);
            } else {
                $query = "UPDATE " . $this->table_name . " SET nome = ?, preco = ?, descricao = ? WHERE id_produto = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$nome, $preco, $descricao, $id]);
            }
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    // Método para deletar um produto
    public function deletar($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_produto = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar produto: " . $e->getMessage());
        }
    }
}
?>
