<?php
class Conexao
{
    private static $instancia;

    public static function getConexao()
    {
        if (!isset(self::$instancia)) {
            try {
                self::$instancia = new PDO('mysql:host=localhost;dbname=registros_db', 'root', '');
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instancia->exec("SET NAMES utf8");
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }
}
?>