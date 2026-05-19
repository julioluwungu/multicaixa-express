<?php

class Pagamento
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function criar($usuario, $servico, $referencia, $valor)
    {
        $sql = "INSERT INTO pagamentos (id_usuario, servico, referencia, valor)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$usuario, $servico, $referencia, $valor]);
    }
}