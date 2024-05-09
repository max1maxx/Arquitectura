<?php
/*
 * ----------------------------------------------------------------------------
 * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
 * Todos los derechos reservados. Ninguna parte de este software puede ser 
 * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
 * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
 * sistema de almacenamiento y recuperación de información, sin el permiso 
 * previo por escrito del autor.
 * ----------------------------------------------------------------------------
 */

// Archivo de enviroment
require_once 'enviroment.php';

SESSION_START();

// Iniciamos Clase Conectar
class Conectar
{
    protected $dbh;

    // Funcion Protegida de la cadena de Conexion
    protected function Conexion()
    {
        try {
            $conectar = $this->dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            return $conectar;

        } catch (Exception $e) {
            // En Caso hubiera un error en la cadena de conexion
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Para impedir que tengamos problemas con las ñ o tildes
    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    // Ruta principal del proyecto
    public static function ruta()
    {
        return RUTA;
    }
}
