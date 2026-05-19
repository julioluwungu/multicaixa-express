<?php

class Transacao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function criar($origem, $destino, $valor, $descricao)
    {
        $sql = "INSERT INTO transacoes (id_origem, id_destino, valor, descricao)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$origem, $destino, $valor, $descricao]);
    }

    public function extrato($id)
    {
        $sql = "
            SELECT * FROM transacoes
            WHERE id_origem = ? OR id_destino = ?
            ORDER BY criado_em DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id, $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}