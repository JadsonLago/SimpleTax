<?php

class ServiceTax
{
    private $percentual;
    private $valor;

    // Getters e Setters
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

    // Métodos ICMS Próprio
    public function icmsNormal():float
    {   
        if ($this->percentual <= 0 || $this->valor <= 0) {
            throw new Exception("Percentual e valor devem ser maiores que zero.");
        }
        return round(($this->valor * $this->percentual) / 100,2);
    }

  
    
}


?>