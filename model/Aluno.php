<?php

class Aluno
{
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $dataNascimento;
    private $dataMatricula;
    private $planoId;
    private $planoNome;
    private $cep;
    private $rua;
    private $bairro;
    private $cidade;

    public function __construct($nome, $email, $telefone, $dataNascimento, $dataMatricula, $planoId = null, $id = null, $planoNome = null, $cep = null, $rua = null, $bairro = null, $cidade = null)
    {
        $this->nome           = $nome;
        $this->email          = $email;
        $this->telefone       = $telefone;
        $this->dataNascimento = $dataNascimento;
        $this->dataMatricula  = $dataMatricula;
        $this->planoId        = $planoId;
        $this->id             = $id;
        $this->planoNome      = $planoNome;
        $this->cep            = $cep;
        $this->rua            = $rua;
        $this->bairro         = $bairro;
        $this->cidade         = $cidade;
    }

    public function getId()             { return $this->id; }
    public function getNome()           { return $this->nome; }
    public function getEmail()          { return $this->email; }
    public function getTelefone()       { return $this->telefone; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getDataMatricula()  { return $this->dataMatricula; }
    public function getPlanoId()        { return $this->planoId; }
    public function getPlanoNome()      { return $this->planoNome; }
    public function getCep()            { return $this->cep; }
    public function getRua()            { return $this->rua; }
    public function getBairro()         { return $this->bairro; }
    public function getCidade()         { return $this->cidade; }
}
