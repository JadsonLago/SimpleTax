<?php
session_start();
require_once 'Registro.php';

$dados = [
    'id' => '',
    'data' => '',
    'descricao' => '',
    'quantidade' => '',
    'percentual' => '',
    'valor' => ''
];

$titulo = "Novo Registro";

if (!empty($_GET['id'])) {
    $dados = Registro::buscarPorId($_GET['id']);
    if ($dados) {
        $titulo = "Editar Registro";
    } else {
        $_SESSION['mensagem'] = "Registro não encontrado.";
        $_SESSION['tipo_mensagem'] = "warning";
        header("Location: registrosView.php");
        exit();
    }
}

// Recupera dados do formulário se houver erros de validação
if (isset($_SESSION['dados_form'])) {
    $dados = array_merge($dados, $_SESSION['dados_form']);
    unset($_SESSION['dados_form']);
}

$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1><?= $titulo ?></h1>
        
        <?php if (!empty($erros)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="registrosController.php" method="post">
            <input type="hidden" name="acao" value="salvar">
            <input type="hidden" name="id" value="<?= htmlspecialchars($dados['id']) ?>">
            

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" id="data" name="data" 
                            value="<?= htmlspecialchars($dados['data_registro'] ?? $dados['data']) ?>" required>
                    </div>
                </div>
                
                <div class="col">
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" 
                            value="<?= htmlspecialchars($dados['quantidade']) ?>" min="0" required>
                    </div>
                </div>
                
                <div class="col">
                    <div class="mb-3">
                        <label for="percentual" class="form-label">Percentual (%)</label>
                        <input type="number" class="form-control" id="percentual" name="percentual" 
                            value="<?= htmlspecialchars($dados['percentual']) ?>" min="0" max="100" step="0.01" required>
                    </div>
                </div>    
                </div>        
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" 
                       value="<?= htmlspecialchars($dados['descricao']) ?>" maxlength="255" required>
            </div>
            
            

            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" 
                       value="<?= htmlspecialchars($dados['valor']) ?>" step="0.01" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="registrosView.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>