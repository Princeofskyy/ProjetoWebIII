<?php

class Cliente
{
    private $db;
    private $table_name = "clientes"; // nome da tabela

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Método para ler registros com filtro e ordenação
    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];
        if ($search) {
            $conditions[] = "(nome LIKE :search OR email LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        if ($order_by === 'nome') {
            $query .= " ORDER BY nome";
        } elseif ($order_by === 'sexo') {
            $query .= " ORDER BY sexo";
        }
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    // Método para registrar um novo cliente
    public function registrar($nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $senha)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, fone, email, endereco, cep, bairro, cidade, complemento, senha) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $hashed_password]);
        return $stmt;
    }

    // Método para fazer login
    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cliente && password_verify($senha, $cliente['senha'])) {
            return $cliente;
        }
        return false;
    }

    // Método para criar um novo cliente (similar ao registrar)
    public function criar($nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $senha)
    {
        return $this->registrar($nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $senha);
    }

    // Método para ler um cliente por ID
    public function lerPorId($id_cliente)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_cliente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar os dados de um cliente
    public function atualizar($id_cliente, $nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ?, endereco = ?, cep = ?, bairro = ?, cidade = ?, complemento = ? WHERE id_cliente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $id_cliente]);
        return $stmt;
    }

    // Método para deletar um cliente
    public function deletar($id_cliente)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_cliente]);
        return $stmt;
    }

    // Gera código de verificação para recuperar a senha
    public function gerarCodigoVerificacao($email)
    {
        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $query = "UPDATE " . $this->table_name . " SET codigo_verificacao = ? WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$codigo, $email]);
        return ($stmt->rowCount() > 0) ? $codigo : false;
    }

    // Verifica se o código de verificação é válido
    public function verificarCodigo($codigo)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE codigo_verificacao = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Redefine a senha do usuário e remove o código de verificação
    public function redefinirSenha($codigo, $senha)
    {
        $query = "UPDATE " . $this->table_name . " SET senha = ?, codigo_verificacao = NULL WHERE codigo_verificacao = ?";
        $stmt = $this->db->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$hashed_password, $codigo]);
        return $stmt->rowCount() > 0;
    }
}
?>
