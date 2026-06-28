<?php
require_once __DIR__ . '/../../controller/AlunoController.php';

$controller = new AlunoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->editar();
}

$id    = (int) ($_GET['id'] ?? 0);
$aluno = $controller->buscarPorId($id);

if (!$aluno) {
    header('Location: lista.php?msg=erro');
    exit;
}

$planos = $controller->listarPlanos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno - Academia FitLife</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; color: #333; }
        header { background-color: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.3rem; }
        header h1 span { color: #e94560; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        nav a:hover { color: #e94560; }
        main { max-width: 700px; margin: 30px auto; padding: 0 20px; }
        h2 { color: #1a1a2e; }
        form { background: white; padding: 25px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        label { display: block; font-weight: bold; margin-top: 15px; margin-bottom: 5px; font-size: 0.9rem; }
        input, textarea, select { width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #e94560; }
        .linha { display: flex; gap: 15px; }
        .linha div { flex: 1; }
        .secao { border-top: 1px solid #eee; margin-top: 20px; padding-top: 5px; }
        .secao-titulo { font-size: 0.8rem; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        button { background-color: #e94560; color: white; border: none; padding: 10px 22px; border-radius: 4px; cursor: pointer; font-size: 0.9rem; margin-top: 20px; }
        button:hover { background-color: #c73652; }
        a.btn-cancelar { display: inline-block; padding: 10px 22px; background-color: #888; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-top: 20px; margin-left: 10px; }
        a.btn-cancelar:hover { background-color: #666; }
        footer { text-align: center; padding: 20px; color: #999; font-size: 0.85rem; margin-top: 40px; }
        #cep-status { font-size: 0.8rem; color: #999; margin-top: 4px; min-height: 18px; }
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
    <h2>Editar Aluno</h2>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $aluno->getId() ?>">

        <label for="nome">Nome Completo *</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($aluno->getNome()) ?>" required>

        <div class="linha">
            <div>
                <label for="email">E-mail *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($aluno->getEmail()) ?>" required>
            </div>
            <div>
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($aluno->getTelefone() ?? '') ?>">
            </div>
        </div>

        <div class="linha">
            <div>
                <label for="data_nascimento">Data de Nascimento *</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $aluno->getDataNascimento() ?>" required>
            </div>
            <div>
                <label for="data_matricula">Data de Matricula *</label>
                <input type="date" id="data_matricula" name="data_matricula" value="<?= $aluno->getDataMatricula() ?>" required>
            </div>
        </div>

        <label for="plano_id">Plano</label>
        <select id="plano_id" name="plano_id">
            <option value="">-- Sem plano --</option>
            <?php foreach ($planos as $plano): ?>
                <option value="<?= $plano->getId() ?>" <?= $aluno->getPlanoId() == $plano->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($plano->getNome()) ?> — R$ <?= number_format((float)$plano->getPrecoMensal(), 2, ',', '.') ?>/mes
                </option>
            <?php endforeach; ?>
        </select>

        <div class="secao">
            <p class="secao-titulo">Endereco (opcional)</p>

            <div class="linha">
                <div style="flex: 0 0 160px;">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="<?= htmlspecialchars($aluno->getCep() ?? '') ?>" placeholder="00000-000" maxlength="9">
                    <div id="cep-status"></div>
                </div>
                <div>
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($aluno->getCidade() ?? '') ?>" placeholder="Preenchido pelo CEP">
                </div>
            </div>

            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($aluno->getBairro() ?? '') ?>" placeholder="Preenchido pelo CEP">

            <label for="rua">Rua</label>
            <input type="text" id="rua" name="rua" value="<?= htmlspecialchars($aluno->getRua() ?? '') ?>" placeholder="Preenchido pelo CEP">
        </div>

        <button type="submit">Salvar Alteracoes</button>
        <a href="lista.php" class="btn-cancelar">Cancelar</a>

    </form>
</main>

<footer>
    <p>Academia FitLife &copy; <?= date('Y') ?></p>
</footer>

<script>
document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');
    const status = document.getElementById('cep-status');

    if (cep.length !== 8) {
        status.textContent = '';
        return;
    }

    status.textContent = 'Buscando...';
    status.style.color = '#999';

    fetch('https://viacep.com.br/ws/' + cep + '/json/')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.erro) {
                status.textContent = 'CEP nao encontrado.';
                status.style.color = '#e74c3c';
                return;
            }
            document.getElementById('rua').value    = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro     || '';
            document.getElementById('cidade').value = data.localidade || '';
            status.textContent = 'Endereco preenchido!';
            status.style.color = '#2ecc71';
        })
        .catch(function () {
            status.textContent = 'Erro ao consultar CEP.';
            status.style.color = '#e74c3c';
        });
});
</script>

</body>
</html>
