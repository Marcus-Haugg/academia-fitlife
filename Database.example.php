<?php

// Copie este arquivo como Database.php e preencha com suas credenciais
// Ou use o .env (recomendado): copie .env.example como .env e ajuste os valores
class Database
{
    public $connection;

    public function __construct()
    {
        $env  = parse_ini_file(__DIR__ . '/.env');
        $host = $env['DB_HOST'];
        $port = $env['DB_PORT'];
        $db   = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$db";

        $this->connection = new PDO($dsn, $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
