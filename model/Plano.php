<?php

// Model: representa a entidade Plano — só dados, sem lógica de banco
class Plano
{
    private $id;
    private $nome;
    private $descricao;
    private $precoMensal;
    private $duracaoMeses;

    // $id é opcional: não existe ao criar, só após buscar do banco
    public function __construct($nome, $descricao, $precoMensal, $duracaoMeses, $id = null)
    {
        $this->nome         = $nome;
        $this->descricao    = $descricao;
        $this->precoMensal  = $precoMensal;
        $this->duracaoMeses = $duracaoMeses;
        $this->id           = $id;
    }

    // Getters: permitem leitura dos atributos privados sem expor a escrita
    public function getId()           { return $this->id; }
    public function getNome()         { return $this->nome; }
    public function getDescricao()    { return $this->descricao; }
    public function getPrecoMensal()  { return $this->precoMensal; }
    public function getDuracaoMeses() { return $this->duracaoMeses; }
}
