<?php
require_once __DIR__ . '/../../controller/PlanoController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new PlanoController();
    $controller->salvar();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Plano - Academia FitLife</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            color: #333;
        }

        header {
            background-color: #1a1a2e;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.3rem;
        }

        header h1 span { color: #e94560; }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 0.9rem;
        }

        nav a:hover { color: #e94560; }

        main {
            max-width: 700px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2 { color: #1a1a2e; }

        form {
            background: white;
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #e94560;
        }

        .linha {
            display: flex;
            gap: 15px;
        }

        .linha div { flex: 1; }

        button {
            background-color: #e94560;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 20px;
        }

        button:hover { background-color: #c73652; }

        a.btn-cancelar {
            display: inline-block;
            padding: 10px 22px;
            background-color: #888;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            margin-top: 20px;
            margin-left: 10px;
        }

        a.btn-cancelar:hover { background-color: #666; }

        footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 0.85rem;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>FitLife <span>Academia</span></h1>
    <nav>
        <a href="../../index.php">Inicio</a>
        <a href="../alunos/cadastra.php">Cadastrar Aluno</a>
        <a href="../alunos/lista.php">Listar Alunos</a>
        <a href="../planos/cadastra.php">Cadastrar Plano</a>
        <a href="../planos/lista.php">Listar Planos</a>
        <a href="../avisos/cadastra.php">Cadastrar Aviso</a>
        <a href="../avisos/lista.php">Listar Avisos</a>
    </nav>
</header>

<main>
    <h2>Cadastro de Plano</h2>

    <form action="" method="POST">

        <label for="nome">Nome do Plano</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Plano Mensal" required>

        <label for="descricao">Descricao</label>
        <textarea id="descricao" name="descricao" rows="3" placeholder="Descreva os beneficios do plano..."></textarea>

        <div class="linha">
            <div>
                <label for="preco_mensal">Preco Mensal (R$)</label>
                <input type="number" id="preco_mensal" name="preco_mensal" placeholder="0.00" step="0.01" min="0.01" required>
            </div>
            <div>
                <label for="duracao_meses">Duracao (meses)</label>
                <input type="number" id="duracao_meses" name="duracao_meses" value="1" min="1" max="24" required>
            </div>
        </div>

        <button type="submit">Cadastrar</button>
        <a href="lista.php" class="btn-cancelar">Cancelar</a>

    </form>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
