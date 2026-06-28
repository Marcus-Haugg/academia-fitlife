<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../model/Plano.php';

class PlanoDao
{
    private $tabela = 'planos';
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->connection;
    }

    public function salvar(Plano $plano)
    {
        $sql  = "INSERT INTO $this->tabela (nome, descricao, preco_mensal, duracao_meses) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $plano->getNome(),
            $plano->getDescricao(),
            $plano->getPrecoMensal(),
            $plano->getDuracaoMeses(),
        ]);
    }

    public function listar()
    {
        $sql  = "SELECT * FROM $this->tabela ORDER BY nome";
        $stmt = $this->connection->query($sql);

        $planos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $planos[] = $this->rowParaPlano($row);
        }
        return $planos;
    }

    public function buscarPorId($id)
    {
        $sql  = "SELECT * FROM $this->tabela WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->rowParaPlano($row) : null;
    }

    public function atualizar(Plano $plano)
    {
        $sql  = "UPDATE $this->tabela SET nome=?, descricao=?, preco_mensal=?, duracao_meses=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $plano->getNome(),
            $plano->getDescricao(),
            $plano->getPrecoMensal(),
            $plano->getDuracaoMeses(),
            $plano->getId(),
        ]);
    }

    public function excluir($id)
    {
        $sql  = "DELETE FROM $this->tabela WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
    }

    private function rowParaPlano($row)
    {
        return new Plano(
            $row['nome'],
            $row['descricao'],
            $row['preco_mensal'],
            $row['duracao_meses'],
            $row['id']
        );
    }
}
