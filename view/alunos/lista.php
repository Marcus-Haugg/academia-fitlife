<?php
require_once __DIR__ . '/../../controller/AlunoController.php';

$controller = new AlunoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
    $controller->excluir();
}

$alunos = $controller->listar();

$mensagens = [
    'cadastrado' => ['texto' => 'Aluno cadastrado com sucesso!', 'cor' => '#2ecc71'],
    'editado'    => ['texto' => 'Aluno atualizado com sucesso!', 'cor' => '#3498db'],
    'excluido'   => ['texto' => 'Aluno removido com sucesso.',   'cor' => '#e67e22'],
    'erro'       => ['texto' => 'Ocorreu um erro. Tente novamente.', 'cor' => '#e74c3c'],
];
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alunos - Academia FitLife</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; color: #333; }
        header { background-color: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.3rem; }
        header h1 span { color: #e94560; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        nav a:hover { color: #e94560; }
        main { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        h2 { color: #1a1a2e; }
        .alerta { padding: 12px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; color: white; }
        a.btn-novo { display: inline-block; padding: 9px 18px; background-color: #e94560; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-bottom: 20px; }
        a.btn-novo:hover { background-color: #c73652; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 6px; overflow: hidden; }
        thead { background-color: #1a1a2e; color: white; }
        th, td { padding: 11px 14px; text-align: left; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f9f9f9; }
        p.vazio { color: #888; font-style: italic; }
        .acoes { display: flex; gap: 6px; }
        a.btn-editar, button.btn-excluir { padding: 5px 12px; border-radius: 3px; font-size: 0.8rem; cursor: pointer; border: none; text-decoration: none; display: inline-block; }
        a.btn-editar  { background: #3498db; color: white; }
        a.btn-editar:hover { background: #2980b9; }
        button.btn-excluir { background: #e74c3c; color: white; }
        button.btn-excluir:hover { background: #c0392b; }
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
    <h2>Alunos Cadastrados</h2>

    <?php if (isset($mensagens[$msg])): ?>
        <div class="alerta" style="background: <?= $mensagens[$msg]['cor'] ?>;">
            <?= $mensagens[$msg]['texto'] ?>
        </div>
    <?php endif; ?>

    <a href="cadastra.php" class="btn-novo">+ Novo Aluno</a>

    <?php if (count($alunos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Nascimento</th>
                    <th>Matricula</th>
                    <th>Plano</th>
                    <th>Cidade</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= $aluno->getId() ?></td>
                        <td><?= htmlspecialchars($aluno->getNome()) ?></td>
                        <td><?= htmlspecialchars($aluno->getEmail()) ?></td>
                        <td><?= htmlspecialchars($aluno->getTelefone() ?: '—') ?></td>
                        <td><?= $aluno->getDataNascimento() ? date('d/m/Y', strtotime($aluno->getDataNascimento())) : '—' ?></td>
                        <td><?= $aluno->getDataMatricula()  ? date('d/m/Y', strtotime($aluno->getDataMatricula()))  : '—' ?></td>
                        <td><?= htmlspecialchars($aluno->getPlanoNome() ?: 'Sem plano') ?></td>
                        <td><?= htmlspecialchars($aluno->getCidade() ?: '—') ?></td>
                        <td>
                            <div class="acoes">
                                <a href="edita.php?id=<?= $aluno->getId() ?>" class="btn-editar">Editar</a>
                                <form method="POST" action="" onsubmit="return confirm('Confirmar exclusao do aluno <?= htmlspecialchars(addslashes($aluno->getNome())) ?>?')">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id"   value="<?= $aluno->getId() ?>">
                                    <button type="submit" class="btn-excluir">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="vazio">Nenhum aluno cadastrado ainda.</p>
    <?php endif; ?>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
