<?php
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = trim($_POST['titulo']   ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($titulo && $mensagem) {
        $payload = json_encode([
            'titulo'   => $titulo,
            'mensagem' => $mensagem,
            'data'     => date('d/m/Y H:i'),
        ]);

        $ctx  = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\nAccept: application/json\r\n",
                'content' => $payload,
            ]
        ]);
        $resp = @file_get_contents('https://6a4198a81ff1d27becc19c02.mockapi.io/avisos', false, $ctx);

        if ($resp !== false) {
            header('Location: lista.php?msg=cadastrado');
            exit;
        }
        $erro = 'Erro ao comunicar com a API. Tente novamente.';
    } else {
        $erro = 'Preencha todos os campos obrigatorios.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aviso - Academia FitLife</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; color: #333; }
        header { background-color: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.3rem; }
        header h1 span { color: #e94560; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        nav a:hover { color: #e94560; }
        main { max-width: 700px; margin: 30px auto; padding: 0 20px; }
        h2 { color: #1a1a2e; }
        .alerta-erro { background: #e74c3c; color: white; padding: 12px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; }
        form { background: white; padding: 25px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        label { display: block; font-weight: bold; margin-top: 15px; margin-bottom: 5px; font-size: 0.9rem; }
        input, textarea { width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; box-sizing: border-box; }
        input:focus, textarea:focus { outline: none; border-color: #e94560; }
        .badge-api { display: inline-block; background: #8e44ad; color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 3px; margin-left: 8px; vertical-align: middle; }
        button { background-color: #e94560; color: white; border: none; padding: 10px 22px; border-radius: 4px; cursor: pointer; font-size: 0.9rem; margin-top: 20px; }
        button:hover { background-color: #c73652; }
        a.btn-cancelar { display: inline-block; padding: 10px 22px; background-color: #888; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-top: 20px; margin-left: 10px; }
        a.btn-cancelar:hover { background-color: #666; }
        footer { text-align: center; padding: 20px; color: #999; font-size: 0.85rem; margin-top: 40px; }
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
    <h2>Cadastro de Aviso <span class="badge-api">MockAPI</span></h2>

    <?php if ($erro): ?>
        <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form action="" method="POST">

        <label for="titulo">Titulo *</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ex: Alteracao de horario" required>

        <label for="mensagem">Mensagem *</label>
        <textarea id="mensagem" name="mensagem" rows="5" placeholder="Escreva o aviso aqui..." required></textarea>

        <button type="submit">Publicar Aviso</button>
        <a href="lista.php" class="btn-cancelar">Cancelar</a>

    </form>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
