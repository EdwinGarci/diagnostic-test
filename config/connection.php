<?php
/* Inicializando la sesion del usuario */
session_start();

/* Iniciamos Clase */
class Connect
{
    protected $dbh;

    /* Funcion Protegida de la cadena de Conexion */
    protected function getConnection()
    {
        try {
            /* Cadena de Conexion*/
            $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=diagnostic-test", "root", "");
            return $conectar;
        } catch (Exception $e) {
            /* En Caso hubiera un error en la cadena de conexion */
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /* Para impedir que tengamos problemas con las ñ o tildes */
    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    /* Ruta principal del proyecto */
    public static function getBaseUrl()
    {
        return "http://localhost/diagnostic-test/";
    }
}
