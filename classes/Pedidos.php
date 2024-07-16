<?php

class Pedido {
    private $id_pedido;
    private $id_cliente;
    private $id_produto;
    private $quantidade;
    private $preco_final;
    private $observacao_pedido;
    private $endereco_entrega; 
    private $data_pedido;
    private $status_pedido;
    private $pagamento_pedido;

  
    public function __construct($id_cliente, $id_produto, $quantidade, $preco_final, $observacao_pedido, $endereco_entrega, $data_pedido, $status_pedido, $pagamento_pedido) {
        $this->id_cliente = $id_cliente;
        $this->id_produto = $id_produto;
        $this->quantidade = $quantidade;
        $this->preco_final = $preco_final;
        $this->observacao_pedido = $observacao_pedido;
        $this->endereco_entrega = $endereco_entrega; 
        $this->data_pedido = $data_pedido;
        $this->status_pedido = $status_pedido;
        $this->pagamento_pedido = $pagamento_pedido;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function getIdProduto() {
        return $this->id_produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getPrecoFinal() {
        return $this->preco_final;
    }

    public function getObservacaoPedido() {
        return $this->observacao_pedido;
    }

    public function getEnderecoEntrega() {
        return $this->endereco_entrega;
    }

    public function getDataPedido() {
        return $this->data_pedido;
    }

    public function getStatusPedido() {
        return $this->status_pedido;
    }

    public function getPagamentoPedido() {
        return $this->pagamento_pedido;
    }

    public static function criarPedido($conn, $pedido) {
        $sql = "INSERT INTO pedidos (id_cliente, id_produto, quantidade, preco_final, observacao_pedido, endereco_entrega, data_pedido, status_pedido, pagamento_pedido) 
                VALUES (:id_cliente, :id_produto, :quantidade, :preco_final, :observacao_pedido, :endereco_entrega, :data_pedido, :status_pedido, :pagamento_pedido)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id_cliente', $pedido->getIdCliente());
        $stmt->bindValue(':id_produto', $pedido->getIdProduto());
        $stmt->bindValue(':quantidade', $pedido->getQuantidade());
        $stmt->bindValue(':preco_final', $pedido->getPrecoFinal());
        $stmt->bindValue(':observacao_pedido', $pedido->getObservacaoPedido());
        $stmt->bindValue(':endereco_entrega', $pedido->getEnderecoEntrega());
        $stmt->bindValue(':data_pedido', $pedido->getDataPedido());
        $stmt->bindValue(':status_pedido', $pedido->getStatusPedido());
        $stmt->bindValue(':pagamento_pedido', $pedido->getPagamentoPedido());

       
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
