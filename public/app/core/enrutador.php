<?php
// app/core/enrutador.php

// se encarga de registrar las rutas (las páginas de la web) y despachar la peticion al controlador correcto


class Enrutador {
    protected $rutas = [];

    public function get($url, $controladorYMetodo) {
        $this->rutas['GET'][$url] = $controladorYMetodo;
    }

    public function post($url, $controladorYMetodo) {
        $this->rutas['POST'][$url] = $controladorYMetodo;
    }

    public function despachar() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $metodo = $_SERVER['REQUEST_METHOD'];

        if (isset($this->rutas[$metodo][$url])) {
            list($controlador, $metodoAccion) = explode('@', $this->rutas[$metodo][$url]);

            // Creamos la ruta dinámica real basada en la ubicación de este archivo core/ en el servidor
            $rutaControlador = __DIR__ . "/../controllers/$controlador.php";

            // Busca el archivo respetando las mayúsculas usando la ruta absoluta corregida
            if (file_exists($rutaControlador)) {
                require_once $rutaControlador;
                $instanciaControlador = new $controlador();
                $instanciaControlador->$metodoAccion();
            } else {
                http_response_code(500);
                echo "Error Interno: El archivo '$rutaControlador' no existe.";
            }
        } else {
            http_response_code(404);
            echo "<h1>404 - Página no encontrada</h1>";
        }
    }
}