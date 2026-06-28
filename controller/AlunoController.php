<?php

require_once __DIR__ . '/../dao/AlunoDao.php';
require_once __DIR__ . '/../dao/PlanoDao.php';
require_once __DIR__ . '/../model/Aluno.php';

class AlunoController
{
    public function salvar()
    {
        $aluno = $this->alunoDoPost();
        $dao   = new AlunoDao();
        $dao->salvar($aluno);
        header('Location: lista.php?msg=cadastrado');
        exit;
    }

    public function editar()
    {
        $id    = (int) $_POST['id'];
        $aluno = $this->alunoDoPost($id);
        $dao   = new AlunoDao();
        $dao->atualizar($aluno);
        header('Location: lista.php?msg=editado');
        exit;
    }

    public function excluir()
    {
        $id  = (int) $_POST['id'];
        $dao = new AlunoDao();
        $dao->excluir($id);
        header('Location: lista.php?msg=excluido');
        exit;
    }

    public function buscarPorId($id)
    {
        $dao = new AlunoDao();
        return $dao->buscarPorId($id);
    }

    public function listar()
    {
        $dao = new AlunoDao();
        return $dao->listar();
    }

    public function listarPlanos()
    {
        $dao = new PlanoDao();
        return $dao->listar();
    }

    private function alunoDoPost($id = null)
    {
        return new Aluno(
            $_POST['nome'],
            $_POST['email'],
            $_POST['telefone']       ?? '',
            $_POST['data_nascimento'],
            $_POST['data_matricula'],
            !empty($_POST['plano_id']) ? (int) $_POST['plano_id'] : null,
            $id,
            null,
            $_POST['cep']    ?? null,
            $_POST['rua']    ?? null,
            $_POST['bairro'] ?? null,
            $_POST['cidade'] ?? null,
        );
    }
}
