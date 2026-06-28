<?php

require_once __DIR__ . '/../dao/PlanoDao.php';
require_once __DIR__ . '/../model/Plano.php';

class PlanoController
{
    public function salvar()
    {
        $plano = $this->planoDoPost();
        $dao   = new PlanoDao();
        $dao->salvar($plano);
        header('Location: lista.php?msg=cadastrado');
        exit;
    }

    public function editar()
    {
        $id    = (int) $_POST['id'];
        $plano = $this->planoDoPost($id);
        $dao   = new PlanoDao();
        $dao->atualizar($plano);
        header('Location: lista.php?msg=editado');
        exit;
    }

    public function excluir()
    {
        $id  = (int) $_POST['id'];
        $dao = new PlanoDao();
        $dao->excluir($id);
        header('Location: lista.php?msg=excluido');
        exit;
    }

    public function buscarPorId($id)
    {
        $dao = new PlanoDao();
        return $dao->buscarPorId($id);
    }

    public function listar()
    {
        $dao = new PlanoDao();
        return $dao->listar();
    }

    private function planoDoPost($id = null)
    {
        return new Plano(
            $_POST['nome'],
            $_POST['descricao']   ?? '',
            (float) str_replace(',', '.', $_POST['preco_mensal']),
            (int) $_POST['duracao_meses'],
            $id
        );
    }
}
