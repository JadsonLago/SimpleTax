<?php
require_once 'Conexao.php';
require_once 'Registro.php';
require_once 'ServiceTax.php';

// Iniciar sessão para mensagens de erro/sucesso
session_start();

$acao = $_POST['acao'] ?? $_GET['acao'] ?? 'listar';

try {
    switch ($acao) {
        case 'salvar':
            $registro = new Registro();
            
            if (!empty($_POST['id'])) {
                $registro->setId($_POST['id']);
            }
            
            $registro->setData($_POST['data']);
            $registro->setDescricao($_POST['descricao']);
            $registro->setQuantidade($_POST['quantidade']);
            $registro->setPercentual($_POST['percentual']);
            $registro->setValor($_POST['valor']);

            $imposto = new ServiceTax();
            $valor = $_POST['valor'];

            $imposto ->icmsNormal( $imposto->setValor((float)$_POST['valor']), $imposto->setPercentual((float)$_POST['percentual']));
            $valor_fatura =4515.2;
            $registro->setImposto($imposto);
            $registro->setValorFatura($valor_fatura);
            var_dump($imposto);
                  
            $erros = $registro->validar();

            if (empty($erros)) {
                if ($registro->salvar()) {
                    $_SESSION['mensagem'] = "Registro salvo com sucesso!";
                    $_SESSION['tipo_mensagem'] = "success";
                } else {
                    $_SESSION['mensagem'] = "Erro ao salvar registro.";
                    $_SESSION['tipo_mensagem'] = "danger";
                }
                header("Location: registrosView.php");
                exit();
            } else {
                $_SESSION['erros'] = $erros;
                $_SESSION['dados_form'] = $_POST;
                header("Location: registrosForm.php" . (!empty($_POST['id']) ? "?id=" . $_POST['id'] : ""));
                exit();
            }
            

        case 'excluir':
            if (!empty($_GET['id'])) {
                if (Registro::excluir($_GET['id'])) {
                    $_SESSION['mensagem'] = "Registro excluído com sucesso!";
                    $_SESSION['tipo_mensagem'] = "success";
                } else {
                    $_SESSION['mensagem'] = "Erro ao excluir registro.";
                    $_SESSION['tipo_mensagem'] = "danger";
                }
            }
            header("Location: registrosView.php");
            exit();
            

        case 'listar':
        default:
            $registros = Registro::listarTodos();
            include 'registrosView.php';
            break;
    }
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
    header("Location: registrosView.php");
    exit();
}
?>