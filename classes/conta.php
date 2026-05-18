<?php

class Conta
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function atualizarSaldo($id, $valor)
    {
        $sql = "UPDATE usuarios SET saldo = saldo + ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$valor, $id]);
    }

    public function obterSaldo($id)
    {
        $sql = "SELECT saldo FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchColumn();
    }
}