<?php
require_once 'controller/AlunoController.php';
require_once 'controller/PlanoController.php';

$alunoCtrl   = new AlunoController();
$planoCtrl   = new PlanoController();
$totalAlunos = count($alunoCtrl->listar());
$totalPlanos = count($planoCtrl->listar());

$jsonAvisos = @file_get_contents('https://6a4198a81ff1d27becc19c02.mockapi.io/avisos');
$avisos     = ($jsonAvisos !== false) ? json_decode($jsonAvisos, true) : [];
if (!is_array($avisos)) $avisos = [];
usort($avisos, function ($a, $b) { return (int)$b['id'] - (int)$a['id']; });
$avisos = array_slice($avisos, 0, 3);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Academia FitLife</title>
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
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2 { color: #1a1a2e; }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: white;
            padding: 20px 30px;
            border-left: 4px solid #e94560;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .stat-box p { margin: 0; font-size: 0.85rem; color: #666; }
        .stat-box strong { font-size: 2rem; color: #1a1a2e; display: block; }

        .links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .links a {
            background: white;
            padding: 20px;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            border-left: 4px solid #e94560;
        }

        .links a:hover { background: #fafafa; }
        .links a h3 { margin: 0 0 6px 0; color: #1a1a2e; }
        .links a p { margin: 0; font-size: 0.85rem; color: #666; }

        .avisos-section { margin-top: 35px; }
        .avisos-section h3 { color: #1a1a2e; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .badge-api { background: #8e44ad; color: white; font-size: 0.7rem; padding: 2px 8px; border-radius: 3px; font-weight: normal; }
        .aviso-card { background: white; border-radius: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); padding: 16px 20px; margin-bottom: 12px; border-left: 4px solid #8e44ad; }
        .aviso-card h4 { margin: 0 0 6px 0; color: #1a1a2e; font-size: 0.95rem; }
        .aviso-card p  { margin: 0 0 8px 0; font-size: 0.85rem; color: #555; line-height: 1.5; }
        .aviso-meta  { font-size: 0.78rem; color: #999; }
        .ver-todos { display: inline-block; font-size: 0.85rem; color: #8e44ad; text-decoration: none; margin-top: 5px; }
        .ver-todos:hover { text-decoration: underline; }
        .avisos-vazio { color: #aaa; font-style: italic; font-size: 0.9rem; }

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
        <a href="index.php">Inicio</a>
        <a href="view/alunos/cadastra.php">Cadastrar Aluno</a>
        <a href="view/alunos/lista.php">Listar Alunos</a>
        <a href="view/planos/cadastra.php">Cadastrar Plano</a>
        <a href="view/planos/lista.php">Listar Planos</a>
        <a href="view/avisos/cadastra.php">Cadastrar Aviso</a>
        <a href="view/avisos/lista.php">Listar Avisos</a>
    </nav>
</header>

<main>
    <h2>Bem-vindo ao Sistema de Gestao</h2>

    <div class="stats">
        <div class="stat-box">
            <strong><?= $totalAlunos ?></strong>
            <p>Alunos cadastrados</p>
        </div>
        <div class="stat-box">
            <strong><?= $totalPlanos ?></strong>
            <p>Planos disponiveis</p>
        </div>
    </div>

    <div class="links">
        <a href="view/alunos/cadastra.php">
            <h3>Cadastrar Aluno</h3>
            <p>Adicionar novo aluno ao sistema</p>
        </a>
        <a href="view/alunos/lista.php">
            <h3>Listar Alunos</h3>
            <p>Ver todos os alunos cadastrados</p>
        </a>
        <a href="view/planos/cadastra.php">
            <h3>Cadastrar Plano</h3>
            <p>Criar um novo plano de academia</p>
        </a>
        <a href="view/planos/lista.php">
            <h3>Listar Planos</h3>
            <p>Ver todos os planos disponiveis</p>
        </a>
    </div>

    <div class="avisos-section">
        <h3>Avisos Recentes <span class="badge-api">MockAPI</span></h3>

        <?php if (empty($avisos)): ?>
            <p class="avisos-vazio">Nenhum aviso publicado ainda.</p>
        <?php else: ?>
            <?php foreach ($avisos as $aviso): ?>
                <div class="aviso-card">
                    <h4><?= htmlspecialchars($aviso['titulo'] ?? '') ?></h4>
                    <p><?= nl2br(htmlspecialchars($aviso['mensagem'] ?? '')) ?></p>
                    <span class="aviso-meta"><?= htmlspecialchars($aviso['data'] ?? '') ?></span>
                </div>
            <?php endforeach; ?>
            <a href="view/avisos/lista.php" class="ver-todos">Ver todos os avisos →</a>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
