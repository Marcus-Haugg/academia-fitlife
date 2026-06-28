<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../model/Aluno.php';

class AlunoDao
{
    private $tabela = 'alunos';
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->connection;
    }

    public function salvar(Aluno $aluno)
    {
        $sql  = "INSERT INTO $this->tabela (nome, email, telefone, data_nascimento, data_matricula, plano_id, cep, rua, bairro, cidade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $aluno->getNome(),
            $aluno->getEmail(),
            $aluno->getTelefone(),
            $aluno->getDataNascimento(),
            $aluno->getDataMatricula(),
            $aluno->getPlanoId(),
            $aluno->getCep() ?: null,
            $aluno->getRua() ?: null,
            $aluno->getBairro() ?: null,
            $aluno->getCidade() ?: null,
        ]);
    }

    public function listar()
    {
        $sql  = "SELECT a.*, p.nome AS plano_nome
                 FROM alunos a
                 LEFT JOIN planos p ON a.plano_id = p.id
                 ORDER BY a.nome";
        $stmt = $this->connection->query($sql);

        $alunos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $alunos[] = $this->rowParaAluno($row);
        }
        return $alunos;
    }

    public function buscarPorId($id)
    {
        $sql  = "SELECT a.*, p.nome AS plano_nome
                 FROM alunos a
                 LEFT JOIN planos p ON a.plano_id = p.id
                 WHERE a.id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->rowParaAluno($row) : null;
    }

    public function atualizar(Aluno $aluno)
    {
        $sql  = "UPDATE $this->tabela SET nome=?, email=?, telefone=?, data_nascimento=?, data_matricula=?, plano_id=?, cep=?, rua=?, bairro=?, cidade=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $aluno->getNome(),
            $aluno->getEmail(),
            $aluno->getTelefone(),
            $aluno->getDataNascimento(),
            $aluno->getDataMatricula(),
            $aluno->getPlanoId(),
            $aluno->getCep() ?: null,
            $aluno->getRua() ?: null,
            $aluno->getBairro() ?: null,
            $aluno->getCidade() ?: null,
            $aluno->getId(),
        ]);
    }

    public function excluir($id)
    {
        $sql  = "DELETE FROM $this->tabela WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
    }

    private function rowParaAluno($row)
    {
        return new Aluno(
            $row['nome'],
            $row['email'],
            $row['telefone'],
            $row['data_nascimento'],
            $row['data_matricula'],
            $row['plano_id'],
            $row['id'],
            $row['plano_nome'] ?? null,
            $row['cep']        ?? null,
            $row['rua']        ?? null,
            $row['bairro']     ?? null,
            $row['cidade']     ?? null,
        );
    }
}
