<?php

require_once __DIR__ . '/../../BE/Controller/adm/cidadeC.php';

$controller = new CidadeController();

/* CREATE */
if (isset($_POST['create'])) {
    $controller->store($_POST);
    header("Location: index.php");
    exit;
}

/* UPDATE */
if (isset($_POST['update'])) {
    $controller->update($_POST);
    header("Location: index.php");
    exit;
}

/* DELETE */
if (isset($_GET['delete'])) {
    $controller->delete($_GET['delete']);
    header("Location: index.php");
    exit;
}

/* EDIT */
$cidadeEdit = null;

if (isset($_GET['edit'])) {
    $cidadeEdit = $controller->edit($_GET['edit']);
}

/* LIST */
$cidades = $controller->index();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrar Cidades</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { background: #f5f5f5; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        input { margin: 5px 0; padding: 8px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 20px; margin: 10px 5px 10px 0; cursor: pointer; }
        button[name="create"], button[name="update"] { background: #4CAF50; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn-edit { background: #2196F3; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-delete { background: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-delete:hover { background: #da190b; }
    </style>
</head>
<body>

<h1>Administrar Cidades</h1>

<h2><?= isset($cidadeEdit) && $cidadeEdit ? 'Editar Cidade' : 'Criar Nova Cidade' ?></h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $cidadeEdit['id'] ?? '' ?>">
    
    <label>Nome da Cidade:</label>
    <input type="text" name="nome" value="<?= $cidadeEdit['nome'] ?? '' ?>" required>
    
    <label>População:</label>
    <input type="number" name="populacao" value="<?= $cidadeEdit['populacao_quant'] ?? '' ?>">
    
    <label>Perfil Etário:</label>
    <input type="text" name="perfil_etario" value="<?= $cidadeEdit['perfil_etario'] ?? '' ?>">
    
    <label>Perfil Econômico:</label>
    <input type="text" name="perfil_economico" value="<?= $cidadeEdit['perfil_economico'] ?? '' ?>">
    
    <label>Comércio Alimentação:</label>
    <input type="text" name="alimentacao" value="<?= $cidadeEdit['comercio_alimentacao'] ?? '' ?>">2
    
    <label>Comércio Moda:</label>
    <input type="text" name="moda" value="<?= $cidadeEdit['comercio_moda'] ?? '' ?>">
    
    <label>Comércio Tecnologia:</label>
    <input type="text" name="tecnologia" value="<?= $cidadeEdit['comercio_tecnologia'] ?? '' ?>">
    
    <label>Comércio Varejo:</label>
    <input type="text" name="varejo" value="<?= $cidadeEdit['comercio_varejo'] ?? '' ?>">
    
    <label>Comércio Serviços:</label>
    <input type="text" name="servicos" value="<?= $cidadeEdit['comercio_servicos'] ?? '' ?>">
    
    <label>Comércio Turismo:</label>
    <input type="text" name="turismo" value="<?= $cidadeEdit['comercio_turismo'] ?? '' ?>">
    
    
    
    <div>
        <?php if (isset($cidadeEdit) && $cidadeEdit): ?>
            <button type="submit" name="update">Atualizar Cidade</button>
            <a href="index.php" style="padding: 10px 20px; background: #808080; color: white; text-decoration: none; border-radius: 3px;">Cancelar</a>
        <?php else: ?>
            <button type="submit" name="create">Criar Cidade</button>
        <?php endif; ?>
    </div>
</form>

<h2>Cidades Cadastradas</h2>

<?php if (!empty($cidades)): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>População</th>
            <th>Perfil Etário</th>
            <th>Perfil Econômico</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cidades as $cidade): ?>
        <tr>
            <td><?= htmlspecialchars($cidade['id']) ?></td>
            <td><?= htmlspecialchars($cidade['nome']) ?></td>
            <td><?= htmlspecialchars($cidade['populacao_quant']) ?></td>
            <td><?= htmlspecialchars($cidade['perfil_etario']) ?></td>
            <td><?= htmlspecialchars($cidade['perfil_economico']) ?></td>
            <td>
                <a href="?edit=<?= $cidade['id'] ?>" class="btn-edit">Editar</a>
                <a href="?delete=<?= $cidade['id'] ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Nenhuma cidade cadastrada. <a href="?">Criar a primeira</a></p>
<?php endif; ?>

</body>
</html>