<?php
$apiUrl = 'https://6a4198a81ff1d27becc19c02.mockapi.io/avisos';
$json   = @file_get_contents($apiUrl);
$avisos = ($json !== false) ? json_decode($json, true) : [];
if (!is_array($avisos)) $avisos = [];

// Mais recentes primeiro
usort($avisos, function ($a, $b) { return (int)$b['id'] - (int)$a['id']; });

$mensagens = [
    'cadastrado' => ['texto' => 'Aviso publicado com sucesso!', 'cor' => '#2ecc71'],
    'erro'       => ['texto' => 'Ocorreu um erro. Tente novamente.', 'cor' => '#e74c3c'],
];
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Avisos - Academia FitLife</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; color: #333; }
        header { background-color: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.3rem; }
        header h1 span { color: #e94560; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        nav a:hover { color: #e94560; }
        main { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        h2 { color: #1a1a2e; }
        .alerta { padding: 12px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; color: white; }
        .badge-api { display: inline-block; background: #8e44ad; color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 3px; margin-left: 8px; vertical-align: middle; }
        a.btn-novo { display: inline-block; padding: 9px 18px; background-color: #e94560; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-bottom: 20px; }
        a.btn-novo:hover { background-color: #c73652; }
        .aviso-card { background: white; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px 25px; margin-bottom: 15px; border-left: 4px solid #8e44ad; }
        .aviso-card h3 { margin: 0 0 8px 0; color: #1a1a2e; font-size: 1rem; }
        .aviso-card p { margin: 0 0 10px 0; font-size: 0.9rem; color: #555; line-height: 1.5; }
        .aviso-meta { font-size: 0.8rem; color: #999; }
        p.vazio { color: #888; font-style: italic; }
        .erro-api { background: #fdecea; border-left: 4px solid #e74c3c; padding: 12px 18px; border-radius: 4px; color: #c0392b; font-size: 0.9rem; }
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
    <h2>Mural de Avisos <span class="badge-api">MockAPI</span></h2>

    <?php if (isset($mensagens[$msg])): ?>
        <div class="alerta" style="background: <?= $mensagens[$msg]['cor'] ?>;">
            <?= $mensagens[$msg]['texto'] ?>
        </div>
    <?php endif; ?>

    <?php if ($json === false): ?>
        <div class="erro-api">Nao foi possivel conectar ao servidor de avisos. Verifique sua conexao.</div>
    <?php elseif (count($avisos) === 0): ?>
        <a href="cadastra.php" class="btn-novo">+ Novo Aviso</a>
        <p class="vazio">Nenhum aviso publicado ainda.</p>
    <?php else: ?>
        <a href="cadastra.php" class="btn-novo">+ Novo Aviso</a>
        <?php foreach ($avisos as $aviso): ?>
            <div class="aviso-card">
                <h3><?= htmlspecialchars($aviso['titulo'] ?? '') ?></h3>
                <p><?= nl2br(htmlspecialchars($aviso['mensagem'] ?? '')) ?></p>
                <span class="aviso-meta"><?= htmlspecialchars($aviso['data'] ?? '') ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
