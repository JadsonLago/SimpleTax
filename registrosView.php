<?php
session_start();
require_once 'Registro.php';

$registros = Registro::listarTodos();
$total = Registro::listarTotalValor();
$total_imposto = Registro::listarTotalImposto();


$mensagem = $_SESSION['mensagem'] ?? '';
$tipoMensagem = $_SESSION['tipo_mensagem'] ?? '';
unset($_SESSION['mensagem']);
unset($_SESSION['tipo_mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Lista de Registros</h1>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $tipoMensagem ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>
        
        <a href="registrosForm.php" class="btn btn-success mb-3">Novo Registro</a>
        <h1>Total: <?=print_r($total);?></h1>
        <h1>Total Imposto: <?=print_r($total_imposto);?></h1>    
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Percentual</th>
                    <th>Valor</th>
                    <th>Imposto</th>
                    <th>Valor Fatura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?= htmlspecialchars($registro['id']) ?></td>
                        <td><?= htmlspecialchars($registro['data_registro']) ?></td>
                        <td><?= htmlspecialchars($registro['descricao']) ?></td>
                        <td><?= htmlspecialchars($registro['quantidade']) ?></td>
                        <td><?= htmlspecialchars($registro['percentual']) ?>%</td>
                        <td><?= htmlspecialchars($registro['valor']) ?></td>
                        <td><?= htmlspecialchars($registro['imposto'])?></td>
                        <td><?= htmlspecialchars($registro['valor_fatura']) ?></td>
                        <td>
                            <a href="registrosForm.php?id=<?= $registro['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="registrosController.php?acao=excluir&id=<?= $registro['id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
       <?php
        $DateAndTime = date('d/m/Y', time());  
        echo "Consulta em: $DateAndTime.";
        ?>
    </div>
</body>
</html>