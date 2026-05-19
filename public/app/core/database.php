<?php
// app/core/Database.php

class Database {
    private static $connection = null;

    public static function connect() {
        // si ya existe la conexión, no la duplica
        if (self::$connection === null) {
            
            // CONFIGURACIÓN DE CONEXIÓN CORREGIDA PARA RAILWAY
            $host    = 'centerbeam.proxy.rlwy.net'; // Servidor externo de Railway
            $port    = '32462';                     // El puerto aleatorio que te dio Railway
            $db      = 'railway';                   // El nombre real de la base de datos en Railway
            $user    = 'root';                      // El usuario por defecto
            $pass    = 'QipfANvegHFOFnWFGGujmElEnioMsUaN';       // Tu contraseña real de la nube
            $charset = 'utf8mb4';

            // configuración de PDO
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
                PDO::ATTR_EMULATE_PREPARES   => false,                  
            ];

            // Añadimos obligatoriamente el ";port=" a la cadena DSN para que conecte por el puerto correcto
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

            try {
                // Creamos la conexión y la guardamos 
                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // manejo de errores 
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        // Devolvemos la conexión limpia
        return self::$connection;
    }
}