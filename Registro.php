<?php
require_once("Conexao.php");
class Registro
{
    private $id;
    private $data;
    private $descricao;
    private $quantidade;
    private $percentual;
    private $valor;
    private $imposto;
    private $valor_fatura;

    // Getters e Setters
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }
    public function getPercentual()
    {
        return $this->percentual;
    }
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function getImposto()
    {
        return $this->imposto;
    }
    public function setImposto($imposto)
    {
        $this->imposto = $imposto;
    }

    public function getValorFatura()
    {
        return $this->valor_fatura;
    }
    public function setValorFatura($valor_fatura)
    {
        $this->valor_fatura = $valor_fatura;
    }

    // Métodos CRUD
    public static function listarTodos()
    {   
        $sql = "SELECT * FROM registros ORDER BY data_registro DESC";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTotalValor(): float
    {   
        $sql = "SELECT SUM(valor) as valor_total from registros";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->execute();
        // Retorna apenas o valor numérico (sem o array)
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)$resultado['valor_total']; //(float)$resultado['valor_total'] para garantir tipo numérico
    }

    public static function listarTotalImposto(): float
    {   
        $sql = "SELECT SUM(imposto) as total_imposto from registros";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->execute();
        // Retorna apenas o valor numérico (sem o array)
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)$resultado['total_imposto']; //(float)$resultado['valor_total'] para garantir tipo numérico
    }

    public function salvar()
    {
        if (empty($this->id)) {
            $sql = "INSERT INTO registros (data_registro, descricao, quantidade, percentual, valor, imposto, valor_fatura) VALUES (:data, :descricao, :quantidade, :percentual, :valor, :imposto, :valor_fatura)";
        } else {
            $sql = "UPDATE registros SET 
                    data_registro = :data, 
                    descricao = :descricao, 
                    quantidade = :quantidade, 
                    percentual = :percentual,
                    valor = :valor,
                    imposto = :imposto, 
                    valor_fatura = :valor_fatura
                    WHERE id = :id";
        }

        $stmt = Conexao::getConexao()->prepare($sql);

        $stmt->bindValue(':data', $this->data);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->bindValue(':quantidade', $this->quantidade);
        $stmt->bindValue(':percentual', $this->percentual);       
        $stmt->bindValue(':valor', $this->valor);
        $stmt->bindValue(':imposto', (float)$this->imposto);        
        $stmt->bindValue(':valor_fatura', $this->valor_fatura);

        if (!empty($this->id)) {
            $stmt->bindValue(':id', $this->id);
        }

        return $stmt->execute();
    }

    public static function buscarPorId($id)
    {
        $sql = "SELECT * FROM registros WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function excluir($id)
    {
        $sql = "DELETE FROM registros WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Validação dos dados
    public function validar()
    {
        $erros = [];

        // Validar data
        if (empty($this->data)) {
            $erros[] = "Data é obrigatória";
        } else {
            $dataObj = DateTime::createFromFormat('Y-m-d', $this->data);
            if (!$dataObj || $dataObj->format('Y-m-d') !== $this->data) {
                $erros[] = "Data inválida. Use o formato AAAA-MM-DD";
            }
        }

        // Validar descrição
        if (empty($this->descricao)) {
            $erros[] = "Descrição é obrigatória";
        } else if (strlen($this->descricao) > 255) {
            $erros[] = "Descrição deve ter no máximo 255 caracteres";
        }

        // Validar quantidade
        if (!is_numeric($this->quantidade) || $this->quantidade < 0) {
            $erros[] = "Quantidade deve ser um número positivo";
        }

        // Validar percentual
        if (!is_numeric($this->percentual) || $this->percentual < 0 || $this->percentual > 100) {
            $erros[] = "Percentual deve ser um número entre 0 e 100";
        }

        // Validar valor
        if (!is_numeric($this->valor) || $this->valor < 0) {
            $erros[] = "O valor deve ser um número válido";
        }

        return $erros;
    }
}
?>