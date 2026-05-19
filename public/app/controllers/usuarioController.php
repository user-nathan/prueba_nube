<?php
// app/controllers/usuarioController.php

// CORREGIDO: Ruta dinámica para cargar el modelo de usuario usando __DIR__
require_once __DIR__ . '/../models/usuario.php';

class usuarioController {
    
    public function mostrarPerfil() {
        // 1. Abrimos la sesión para comprobar quién es
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. verificamos si esta logueado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login");
            exit;
        }

        // 3. Como ya sabemos su ID por la sesión, le pedimos al modelo los datos completos de la BD
        $datosUsuario = usuario::obtenerPorId($_SESSION['usuario_id']);

        // 4. CORREGIDO: Cargamos la vista de forma absoluta usando el DOCUMENT_ROOT del servidor web
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/views/perfilVista.php';
    }

    public function actualizarPerfil() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login"); exit;
        }

        $id_usuario = $_SESSION['usuario_id'];
        $nuevo_nombre = $_POST['username'] ?? '';
        $nuevo_email = $_POST['email'] ?? '';

        // Hacemos el UPDATE directo en la base de datos
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE usuarios SET username = :username, email = :email WHERE id = :id");
        
        $stmt->execute([
            'username' => $nuevo_nombre,
            'email' => $nuevo_email,
            'id' => $id_usuario
        ]);

        // Actualizamos la sesión para que el nombre cambie en la barra de navegación arriba
        $_SESSION['usuario_nombre'] = $nuevo_nombre;

        // Volvemos a cargar el perfil para ver los cambios reflejados
        header("Location: /perfil");
        exit;
    }


}