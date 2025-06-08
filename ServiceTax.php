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
    public static function icmsNormal($valor, $percentual)
    {   
        $icmsNormal = round(($valor*$percentual)/100,2);
        return (float) $icmsNormal;
    }

  
    
}


?>